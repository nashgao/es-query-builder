<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project composer
 * @create Created on 2021/2/5 下午1:52
 * @author Nash Gao
 */

declare(strict_types=1);



namespace Nashgao\Elasticsearch\QueryBuilder;


use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\RingPHP\PoolHandler;
use Nashgao\Elasticsearch\QueryBuilder\Exception\ElasticsearchException;
use Swoole\Coroutine;

/**
 * @method array search(array $param):array search
 *
 * @method array index (array $param) single document indexing
 * @method array get(array $param) get specific document
 * @method array create(array $param,string $indices) indices -> create index/mapping
 * @method array update(array $param) update document
 * @method array delete(array $param, string $indices = '') indices -> delete index
 * @method bool exists(array $param, string $indices) indices -> check if an index exists
 * @method bool existsAlias(array $param, string $indices) indices -> check if an alias exists
 * @method bool existsSource(array $param) indices -> check if document exists
 * @method array getSettings(array $param, string $indices) indices -> get index setting
 * @method array getMapping(array $param, string $indices) indices -> get index mapping
 * @method array getFieldMapping(array $param, string $indices)
 * @method array bulk(array $data) bulk operations
 * @method array updateAliases(array $param,string $indices)
 * @method array deleteAlias(array $param,string $indices)
 *
 * @method array getPipeline(array $param, string $indices) ingest -> get current pipeline
 * @method array putPipeline(array $param, string $indices) ingest -> create pipeline
 * @method array simulate(array $param, string $indices) ingest -> simulate a pipeline
 *
 * @method array reindex(array $param)
 *
 * cat api
 * @method array indices(array $param,string $indices)
 * @method count(array $param,string $indices)
 * @method aliases(array $param, string $indices)
 */
abstract class Elasticsearch
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @Inject()
     * @var ConfigInterface
     */
    protected ConfigInterface $config;

    /**
     * @var string
     */
    public string $connection = 'default';


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
        $configurations = $this->config->get($this->connection);

        $builder = ClientBuilder::create();
        if (Coroutine::getCid() > 0) {
            $handler = make(PoolHandler::class, [
                'option' => [
                    'max_connections' => $configurations['max_con'],
                ],
            ]);
            $builder->setHandler($handler);
        }

        $config = $this->config->get($this->connection);
        $this->client = $builder->setHosts([
            join(":", $config['endpoint'], $config['port'])
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
     * @param string name
     * @param mixed arguments
     * @return array|mixed
     */
    public function __call(string $name, $arguments): array
    {
        return ( function () use ( $name, $arguments ) {
            // if the argument has more than 1 element, which means the elasticsearch client needs the indices to execute
            return count ($arguments) < 2 ? (function () use ($name, $arguments){
                return $this->client->$name(...$arguments);
            })() : ( function () use ($name, $arguments){
                if (array_key_exists($arguments[1],static::$namespaces)) {
                    if ( empty($arguments[1]) ) {
                        // which means the namespace is empty, coz some of the methods have same name but diff namespaces
                        return $this->client->$name(...$arguments[0]);
                    }

                    return (static::$namespaces[$arguments[1]] !== \Elasticsearch\Namespaces\IngestNamespace::class) ?
                        $this->client->{static::$namespaces[$arguments[1]]}()->$name($arguments[0]) : // execute indices namespace
                        $this->client->{static::$namespaces[$arguments[1]]}()->$name([$arguments[0]]); // execute ingest namespace
                }else {
                    throw new ElasticsearchException('invalid namespace');
                }
            })();
        })();
    }
}