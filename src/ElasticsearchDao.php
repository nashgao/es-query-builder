<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder;

use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticAliasTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticCatTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticDocumentTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticIndexTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticMappingTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticSettingTrait;
use Psr\Container\ContainerInterface;

class ElasticsearchDao
{
    use ElasticAliasTrait;
    use ElasticCatTrait;
    use ElasticDocumentTrait;
    use ElasticIndexTrait;
    use ElasticMappingTrait;
    use ElasticSettingTrait;

    /**
     * @var ElasticsearchModel
     */
    protected ElasticsearchModel $model;

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    public function __construct(ElasticsearchModel $model, ContainerInterface $container)
    {
        $this->model = $model;
        $this->container = $container;
    }
}
