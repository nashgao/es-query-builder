<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Guzzle\RingPHP\PoolHandler;
use Nashgao\Elasticsearch\QueryBuilder\Exception\ElasticsearchException;
use Swoole\Coroutine;

/**
 * default namespace
 * @method array search(array $param):array search
 * @method array index (array $param) single document indexing
 * @method array get(array $param) get specific document
 * @method array update(array $param) update document
 * @method bool existsSource(array $param) indices -> check if document exists
 * @method array bulk(array $data) bulk operations
 * @method array reindex(array $param)
 *
 * delete method under default namespace and indices namespace
 * @method array delete(array $param, string $indices = '') indices -> delete index
 *
 * indices namespace api
 * @method array create(array $param,string $indices) indices -> create index/mapping
 * @method bool exists(array $param, string $indices) indices -> check if an index exists
 * @method array getMapping(array $param, string $indices) indices -> get index mapping
 * @method array getFieldMapping(array $param, string $indices)
 * @method array getSettings(array $param, string $indices) indices -> get index setting
 * @method array updateAliases(array $param,string $indices)
 * @method array deleteAlias(array $param,string $indices)
 * @method bool existsAlias(array $param, string $indices) indices -> check if an alias exists
 *
 * ingest namespace api
 * @method array getPipeline(array $param, string $indices) ingest -> get current pipeline
 * @method array putPipeline(array $param, string $indices) ingest -> create pipeline
 * @method array deletePipeline(array $param, string $indices) ingest -> delete pipeline
 * @method array simulate(array $param, string $indices) ingest -> simulate a pipeline
 *
 * cat namespace api
 * @method array indices(array $param,string $indices)
 * @method array count(array $param,string $indices)
 * @method array aliases(array $param, string $indices)
 */
class ElasticsearchModel
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var ConfigInterface
     */
    protected ConfigInterface $config;

    /**
     * @var string
     */
    public string $connection = 'default';

    /**
     * @var string
     */
    public string $publish = 'elasticsearch';

    /**
     * @var string
     */
    public string $index;

    /**
     * @var array
     */
    public array $configurations;

    /**
     * @var array
     */
    protected static array $namespaces = [
        \Elasticsearch\Namespaces\IndicesNamespace::class => 'indices',
        \Elasticsearch\Namespaces\NodesNamespace::class => 'nodes',
        \Elasticsearch\Namespaces\ClusterNamespace::class => 'cluster',
        \Elasticsearch\Namespaces\SnapshotNamespace::class => 'snapshot',
        \Elasticsearch\Namespaces\CatNamespace::class => 'cat',
        \Elasticsearch\Namespaces\IngestNamespace::class => 'ingest'
    ];

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->configurations = $this->config->get(join('.', [$this->publish,$this->connection]));

        $builder = ClientBuilder::create();
        if (Coroutine::getCid() > 0) {
            $handler = make(PoolHandler::class, [
                'option' => [
                    'max_connections' => $this->configurations['max_con'],
                ],
            ]);
            $builder->setHandler($handler);
        }

        // set up index if it exists
        if (array_key_exists('index', $this->configurations) and isset($this->configurations['index']) and is_string($this->configurations['index'])) {
            $this->index = $this->configurations['index'];
        }

        $this->client = $builder->setHosts([
            join(":", [$this->configurations['endpoint'], $this->configurations['port']])
        ])->build();
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * map the function method
     * @param string $name
     * @param mixed $arguments
     * @return mixed
     */
    public function __call(string $name, mixed $arguments): mixed
    {
        return (function () use ($name, $arguments) {
            // if the argument has more than 1 element, which means the elasticsearch client needs the indices to execute
            return count($arguments) < 2 ? (function () use ($name, $arguments) {
                return $this->client->$name(...$arguments);
            })() : (function () use ($name, $arguments) {
                if (array_key_exists($arguments[1], static::$namespaces)) {
//                    if ( empty($arguments[1]) ) {
//                        // which means the namespace is empty, coz some of the methods have same name but diff namespaces
//                        return $this->client->$name(...$arguments[0]);
//                    }

                    return (static::$namespaces[$arguments[1]] !== \Elasticsearch\Namespaces\IngestNamespace::class) ?
                        $this->client->{static::$namespaces[$arguments[1]]}()->$name($arguments[0]) : // execute indices namespace
                        $this->client->{static::$namespaces[$arguments[1]]}()->$name([$arguments[0]]); // execute ingest namespace
                } else {
                    throw new ElasticsearchException('invalid namespace');
                }
            })();
        })();
    }
}
