<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform

 * @create Created on 2020/10/30 下午4:50
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;

use Elasticsearch\Namespaces\IngestNamespace;
use Nashgao\Elasticsearch\QueryBuilder\Elasticsearch;

/**
 * @property Elasticsearch $model
 */
class ElasticPipelineTrait
{
    /**
     * @param array $parameters
     * @param string $indices
     * @return array
     */
    public function getPipeline(array $parameters, string $indices = IngestNamespace::class): array
    {
        return $this->model->getPipeline($parameters,$indices);
    }

    /**
     * rename a field of an elasticsearch index
     * @param array $parameters
     * @param string $indices
     * @return array
     */
    public function putPipeline(array $parameters, string $indices = IngestNamespace::class): array
    {
        return $this->model->putPipeline($parameters, $indices);
    }

    /**
     * @param array $parameters
     * @param string $indices
     * @return array
     */
    public function simulatePipeline(array $parameters, string $indices = IngestNamespace::class): array
    {
        return $this->model->simulate($parameters, $indices);
    }
}