<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project elasticsearch-proxy-pool
 * @create Created on 2020/10/30 下午4:45
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;


use Elasticsearch\Namespaces\IndicesNamespace;
use Nashgao\Elasticsearch\QueryBuilder\Elasticsearch;

/**
 * @property Elasticsearch $model
 */
trait DaoMappingTrait
{
    /**
     * @param string $index
     * @param string $indices
     * @return array
     */
    public function getMapping(string $index, string $indices = IndicesNamespace::class):array
    {
        return $this->model->getMapping(['index' => $index],$indices);
    }

    /**
     * @param string $field
     * @param string|null $index
     * @param string $indices
     * @return array
     */
    public function getFieldMapping(string $field, string $index = null, string $indices = IndicesNamespace::class):array
    {
        $query['field'] = $field;
        if (isset($index))
            $query['index'] = $index;
        return $this->model->getFieldMapping($query,$indices);
    }


}