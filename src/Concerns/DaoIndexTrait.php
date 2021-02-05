<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project elasticsearch-proxy-pool
 * @create Created on 2020/10/30 下午4:44
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;


use Nashgao\Elasticsearch\QueryBuilder\Annotation\Acknowledged;
use Elasticsearch\Namespaces\IndicesNamespace;
use Nashgao\Elasticsearch\QueryBuilder\Elasticsearch;

/**
 * @property Elasticsearch $model
 */
trait DaoIndexTrait
{
    /**
     * check if an index exists
     * @param string $index
     * @param string $indices
     * @return bool
     */
    public function existsIndex(string $index, string $indices = IndicesNamespace::class): bool
    {
        return $this->model->exists(['index' => $index], $indices);
    }

    /**
     * create index and mapping
     * @Acknowledged()
     * @param string $index
     * @param string $indices
     * @return bool|array
     */
    public function createIndex(string $index, string $indices = IndicesNamespace::class)
    {
        return $this->model->create(['index' => $index],$indices);
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $indices
     * @return bool|array
     */
    public function createIndexWithMapping(string $index, string $indices = IndicesNamespace::class)
    {
        return false;
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $indices
     * @return bool|array
     */
    public function deleteIndex(string $index, string $indices = IndicesNamespace::class)
    {
        return $this->model->delete(['index' => $index],$indices);
    }
}