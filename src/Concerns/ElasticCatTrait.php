<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;

use Elasticsearch\Namespaces\CatNamespace;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticCatTrait
{
    /**
     * if the param is empty ,then it's cat for all indexes
     * @param string $index
     * @param string $namespace
     * @return array
     */
    public function catIndex(string $index, string $namespace = CatNamespace::class):array
    {
        return $this->model->indices(['index' => $index], $namespace);
    }

    /**
     * @return array
     */
    public function catIndices(): array
    {
        return $this->model->indices([], CatNamespace::class);
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return array
     */
    public function catAlias(string $name, string $namespace = CatNamespace::class):array
    {
        return $this->model->aliases(['name' => $name], $namespace);
    }

    /**
     * @return array
     */
    public function catAliases(): array
    {
        return $this->model->aliases([], CatNamespace::class);
    }

    /**
     * @param string $index
     * @param string $namespace
     * @return array
     */
    public function catCount(string $index, string $namespace = CatNamespace::class): array
    {
        return $this->model->count(['index' => $index], $namespace);
    }
}
