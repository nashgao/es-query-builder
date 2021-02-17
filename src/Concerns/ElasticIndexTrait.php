<?php

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
     * @param string|null $index
     * @return bool
     */
    public function existsIndex(string $index = null): bool
    {
        return $this->model->exists(['index' => $this->model->index ?? $index], IndicesNamespace::class);
    }

    /**
     * create index and mapping
     * @Acknowledged()
     * @param string|null $index
     * @return bool|array
     */
    public function createIndex(string $index = null)
    {
        return $this->model->create(['index' => $this->model->index ?? $index], IndicesNamespace::class);
    }

    /**
     * @Acknowledged()
     * @param string|null $index
     * @param string $namespace
     * @return bool|array
     */
    public function createIndexWithMapping(string $index = null, string $namespace = IndicesNamespace::class)
    {
        return false;
    }

    /**
     * @Acknowledged()
     * @param string|null $index
     * @return bool|array
     */
    public function deleteIndex(string $index = null)
    {
        return $this->model->delete(['index' => $this->model->index ?? $index], IndicesNamespace::class);
    }
}
