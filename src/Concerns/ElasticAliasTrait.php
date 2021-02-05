<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform

 * @create Created on 2020/10/30 下午4:43
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
trait ElasticAliasTrait
{
    /**
     * @param string $index
     * @param string|null $name
     * @param string $indices
     * @return bool
     */
    public function existsAlias(string $index, string $name, string $indices = IndicesNamespace::class):bool
    {
        $query = [
            'index' => $index,
            'name' => $name
        ];

        return $this->model->existsAlias($query,$indices);
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $alias
     * @param string $indices
     * @return array|bool
     */
    public function updateAliases(string $index, string $alias, string $indices = IndicesNamespace::class)
    {
        $param['body'] = [
            'actions' => [
                'add' => [
                    'index' => $index,
                    'alias' => $alias
                ]
            ]
        ];
        return $this->model->updateAliases($param,$indices);
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $name
     * @param string $indices
     * @return array|bool
     */
    public function deleteAlias(string $index, string $name, string $indices = IndicesNamespace::class)
    {
        $query = [
            'index' => $index,
            'name' => $name
        ];
        
        return $this->model->deleteAlias($query,$indices);
    }

}

