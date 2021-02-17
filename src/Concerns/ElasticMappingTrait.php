<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;

use Elasticsearch\Namespaces\IndicesNamespace;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticMappingTrait
{
    /**
     * @param string|null $index
     * @param string $namespace
     * @return array
     */
    public function getMapping(string $index = null, string $namespace = IndicesNamespace::class):array
    {
        return $this->model->getMapping(['index' => $this->model->index ?? $index], $namespace);
    }

    /**
     * @param string $field
     * @param string|null $index
     * @param string $namespace
     * @return array
     */
    public function getFieldMapping(string $field, string $index = null, string $namespace = IndicesNamespace::class):array
    {
        $query['field'] = $field;
        if (isset($index)) {
            $query['index'] = $index;
        }
        return $this->model->getFieldMapping($query, $namespace);
    }
}
