<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform

 * @create Created on 2020/10/30 下午4:45
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;


use Elasticsearch\Namespaces\CatNamespace;
use Nashgao\Elasticsearch\QueryBuilder\Elasticsearch;

/**
 * @property Elasticsearch $model
 */
trait ElasticCatTrait
{
    /**
     * if the param is empty ,then it's cat for all indexes
     * @param string $index
     * @param string $indices
     * @return array
     */
    public function catIndices(string $index, string $indices = CatNamespace::class):array
    {
        return $this->model->indices(['index' => $index], $indices);
    }

    /**
     * @param string $name
     * @param string $indices
     * @return array
     */
    public function catAlias(string $name, string $indices = CatNamespace::class):array
    {
        return $this->model->aliases(['name' => $name],$indices);
    }

}