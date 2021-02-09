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
     * @param string $index
     * @param string|null $name
     * @param string $namespace
     * @return bool
     */
    public function existsAlias(string $index, string $name, string $namespace = IndicesNamespace::class):bool
    {
        $query = [
            'index' => $index,
            'name' => $name
        ];

        return $this->model->existsAlias($query, $namespace);
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $alias
     * @param string $namespace
     * @return array|bool
     */
    public function updateAliases(string $index, string $alias, string $namespace = IndicesNamespace::class)
    {
        $param['body'] = [
            'actions' => [
                'add' => [
                    'index' => $index,
                    'alias' => $alias
                ]
            ]
        ];
        return $this->model->updateAliases($param, $namespace);
    }

    /**
     * @Acknowledged()
     * @param string $index
     * @param string $name
     * @param string $namespace
     * @return array|bool
     */
    public function deleteAlias(string $index, string $name, string $namespace = IndicesNamespace::class)
    {
        $query = [
            'index' => $index,
            'name' => $name
        ];
        
        return $this->model->deleteAlias($query, $namespace);
    }
}
