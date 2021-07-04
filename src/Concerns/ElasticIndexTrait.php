<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;

use Elasticsearch\Namespaces\IndicesNamespace;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\Acknowledged;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticIndexTrait
{
    /**
     * check if an index exists.
     */
    public function existsIndex(string $index = null): bool
    {
        return $this->model->exists(['index' => $this->model->index ?? $index], IndicesNamespace::class);
    }

    /**
     * create index and mapping.
     * @Acknowledged
     * @return array|bool
     */
    public function createIndex(string $index = null)
    {
        return $this->model->create(['index' => $this->model->index ?? $index], IndicesNamespace::class);
    }

    /**
     * @Acknowledged
     * @return array|bool
     */
    public function createIndexWithMapping(string $index = null, string $namespace = IndicesNamespace::class)
    {
        return false;
    }

    /**
     * @Acknowledged
     * @return array|bool
     */
    public function deleteIndex(string $index = null)
    {
        return $this->model->delete(['index' => $this->model->index ?? $index], IndicesNamespace::class);
    }
}
