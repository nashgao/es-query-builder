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
     * if the param is empty ,then it's cat for all indexes.
     */
    public function catIndex(string $index = null, string $namespace = CatNamespace::class): array
    {
        return $this->model->indices(['index' => $this->model->index ?? $index], $namespace);
    }

    public function catIndices(): array
    {
        return $this->model->indices([], CatNamespace::class);
    }

    public function catAlias(string $name, string $namespace = CatNamespace::class): array
    {
        return $this->model->aliases(['name' => $name], $namespace);
    }

    public function catAliases(): array
    {
        return $this->model->aliases([], CatNamespace::class);
    }

    public function catCount(string $index = null, string $namespace = CatNamespace::class): array
    {
        return $this->model->count(['index' => $this->model->index ?? $index], $namespace);
    }
}
