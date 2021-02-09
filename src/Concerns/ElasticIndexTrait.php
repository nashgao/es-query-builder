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
     * @param string $index
     * @return bool
     */
    public function existsIndex(string $index): bool
    {
        return $this->model->exists(['index' => $index], IndicesNamespace::class);
    }

    /**
     * create index and mapping
     * @Acknowledged()
     * @param string $index
     * @return bool|array
     */
    public function createIndex(string $index)
    {
        return $this->model->create(['index' => $index], IndicesNamespace::class);
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $namespace
     * @return bool|array
     */
    public function createIndexWithMapping(string $index, string $namespace = IndicesNamespace::class)
    {
        return false;
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @return bool|array
     */
    public function deleteIndex(string $index)
    {
        return $this->model->delete(['index' => $index], IndicesNamespace::class);
    }
}
