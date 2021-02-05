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
trait DaoSettingTrait
{
    /**
     * @param string $index
     * @param string|null $name
     * @param string $indices
     * @return array
     */
    public function getSetting(string $index, string $name = null, string $indices = IndicesNamespace::class):array
    {
        $query = ['index' => $index];
        if (isset($name))
            $query['name'] = $name;
        return $this->model->getSettings($query, $indices);
    }

}