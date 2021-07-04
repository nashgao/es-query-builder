<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;

use Elasticsearch\Namespaces\IndicesNamespace;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\Acknowledged;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticAliasTrait
{
    public function existsAlias(string $name, string $index = null, string $namespace = IndicesNamespace::class): bool
    {
        $query = [
            'name' => $name,
            'index' => $this->model->index ?? $index,
        ];

        return $this->model->existsAlias($query, $namespace);
    }

    /**
     * @Acknowledged
     * @return array|bool
     */
    public function updateAliases(string $alias, string $index = null, string $namespace = IndicesNamespace::class)
    {
        $param['body'] = [
            'actions' => [
                'add' => [
                    'index' => $this->model->index ?? $index,
                    'alias' => $alias,
                ],
            ],
        ];
        return $this->model->updateAliases($param, $namespace);
    }

    /**
     * @Acknowledged
     * @return array|bool
     */
    public function deleteAlias(string $name, string $index = null, string $namespace = IndicesNamespace::class)
    {
        $query = [
            'name' => $name,
            'index' => $this->model->index ?? $index,
        ];

        return $this->model->deleteAlias($query, $namespace);
    }
}
