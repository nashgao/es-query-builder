<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform

 * @create Created on 2020/10/30 下午4:44
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;


use Nashgao\Elasticsearch\QueryBuilder\Annotation\Acknowledged;
use Elasticsearch\Namespaces\IndicesNamespace;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticIndexTrait
{
    /**
     * check if an index exists
     * @param string $index
     * @param string $namespace
     * @return bool
     */
    public function existsIndex(string $index, string $namespace = IndicesNamespace::class): bool
    {
        return $this->model->exists(['index' => $index], $namespace);
    }

    /**
     * create index and mapping
     * @Acknowledged()
     * @param string $index
     * @param string $namespace
     * @return bool|array
     */
    public function createIndex(string $index, string $namespace = IndicesNamespace::class)
    {
        return $this->model->create(['index' => $index], $namespace);
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $namespace
     * @return bool|array
     */
    public function createIndexWithMapping(string $index, string $namespace = IndicesNamespace::class)
    {
        return false;
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $namespace
     * @return bool|array
     */
    public function deleteIndex(string $index, string $namespace = IndicesNamespace::class)
    {
        return $this->model->delete(['index' => $index], $namespace);
    }
}