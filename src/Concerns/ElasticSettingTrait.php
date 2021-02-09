<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;

use Elasticsearch\Namespaces\IndicesNamespace;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticSettingTrait
{
    /**
     * @param string $index
     * @param string|null $name
     * @param string $namespace
     * @return array
     */
    public function getSetting(string $index, string $name = null, string $namespace = IndicesNamespace::class):array
    {
        $query = ['index' => $index];
        if (isset($name)) {
            $query['name'] = $name;
        }
        return $this->model->getSettings($query, $namespace);
    }
}
