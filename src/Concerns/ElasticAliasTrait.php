<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;

use Nashgao\Elasticsearch\QueryBuilder\Annotation\Acknowledged;
use Elasticsearch\Namespaces\IndicesNamespace;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticAliasTrait
{
    /**
     * @param string $name
     * @param string|null $index
     * @param string $namespace
     * @return bool
     */
    public function existsAlias(string $name, string $index = null, string $namespace = IndicesNamespace::class):bool
    {
        $query = [
            'name' => $name,
            'index' => $this->model->index ?? $index,
        ];

        return $this->model->existsAlias($query, $namespace);
    }

    /**
     * @Acknowledged()
     * @param string $alias
     * @param string|null $index
     * @param string $namespace
     * @return array|bool
     */
    public function updateAliases(string $alias, string $index = null, string $namespace = IndicesNamespace::class)
    {
        $param['body'] = [
            'actions' => [
                'add' => [
                    'index' => $this->model->index ?? $index,
                    'alias' => $alias
                ]
            ]
        ];
        return $this->model->updateAliases($param, $namespace);
    }

    /**
     * @Acknowledged()
     * @param string $name
     * @param string|null $index
     * @param string $namespace
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
