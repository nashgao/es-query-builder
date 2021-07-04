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
    public function getPipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->getPipeline($parameters, $namespace);
    }

    /**
     * rename a field of an elasticsearch index.
     */
    public function putPipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->putPipeline($parameters, $namespace);
    }

    public function deletePipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->deletePipeline($parameters, $namespace);
    }

    public function simulatePipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->simulate($parameters, $namespace);
    }
}
