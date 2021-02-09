<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project composer
 * @create Created on 2021/2/5 下午6:34
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder;


use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticAliasTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticCatTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticDocumentTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticIndexTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticMappingTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\ElasticSettingTrait;
use Psr\Container\ContainerInterface;

abstract class ElasticsearchDao
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