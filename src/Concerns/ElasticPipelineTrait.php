<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;

use Elasticsearch\Namespaces\IngestNamespace;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
class ElasticPipelineTrait
{
    /**
     * @param array $parameters
     * @param string $namespace
     * @return array
     */
    public function getPipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->getPipeline($parameters, $namespace);
    }

    /**
     * rename a field of an elasticsearch index
     * @param array $parameters
     * @param string $namespace
     * @return array
     */
    public function putPipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->putPipeline($parameters, $namespace);
    }

    /**
     * @param array $parameters
     * @param string $namespace
     * @return array
     */
    public function deletePipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->deletePipeline($parameters, $namespace);
    }

    /**
     * @param array $parameters
     * @param string $namespace
     * @return array
     */
    public function simulatePipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->simulate($parameters, $namespace);
    }
}
