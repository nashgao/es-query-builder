<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder;

use Elasticsearch\Namespaces\CatNamespace;
use Elasticsearch\Namespaces\IndicesNamespace;
use Elasticsearch\Namespaces\IngestNamespace;
use Hyperf\Utils\ApplicationContext;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\Acknowledged;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeGet;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeWrite;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticSearchBean;
use Nashgao\Elasticsearch\QueryBuilder\Constant\Bulk;
use Psr\Container\ContainerInterface;

class ElasticsearchDao
{
    protected ElasticsearchModel $model;

    protected ContainerInterface $container;

    public function __construct(ElasticsearchModel $model)
    {
        $this->model = $model;
        $this->container = ApplicationContext::getContainer();
    }

    public function existsDocument(ElasticSearchBean $bean): bool
    {
        return $this->model->existsSource([
            'index' => $bean->index ?? $this->model->index ?? $bean->alias,
            'id' => $bean->id,
        ]);
    }

    /**
     * @NormalizeGet
     */
    public function getDocument(ElasticSearchBean $bean): array
    {
        $parameters = [
            'index' => $bean->index ?? $this->model->index ?? $bean->alias,
            'id' => $bean->id,
        ];

        return $this->model->get($parameters);
    }

    /**
     * @NormalizeGet
     */
    public function getMultiDocuments(ElasticSearchBean $bean): array
    {
        $parameters = [
            'index' => $bean->index ?? $this->model->index ?? $bean->alias,
            'body' => [
                'size' => $this->model->configurations['max_doc'],
                'query' => [
                    'match_all' => new \stdClass(),
                ],
            ],
        ];

        return $this->model->search($parameters);
    }

    /**
     * @NormalizeWrite
     */
    public function insertDocument(ElasticSearchBean $bean): array
    {
        $parameters = [
            'index' => $bean->index ?? $this->model->index ?? $bean->alias,
            'id' => $bean->id,
            'body' => filterElasticBean($bean),
        ];

        return $this->model->index($parameters);
    }

    public function bulkInsertDocument(array $beans): array
    {
        $bulkContainer = [];
        foreach ($beans as $bean) {
            if (! $bean instanceof ElasticSearchBean) {
                continue;
            }

            $bulkContainer['body'][] = [
                Bulk::INDEX => [
                    '_index' => $bean->index ?? $this->model->index,
                    '_id' => $bean->id,
                ],
            ];

            $bulkContainer['body'][] = filterElasticBean($bean);
        }

        if (! empty($bulkContainer['body'])) {
            return $this->model->bulk($bulkContainer);
        }

        return [];
    }

    /**
     * @NormalizeWrite
     */
    public function updateDocument(ElasticSearchBean $bean): array
    {
        $parameters = [
            'index' => $bean->index ?? $this->model->index,
            'id' => $bean->id,
            'body' => [
                'doc' => arrayFilterNullValue(filterBean($bean, ['index', 'alias', 'id'])),
            ],
        ];

        return $this->model->update($parameters);
    }

    public function bulkUpdateDocument(array $beans): array
    {
        $bulkContainer = [];
        foreach ($beans as $bean) {
            if (! $bean instanceof ElasticSearchBean) {
                continue;
            }

            $bulkContainer['body'][] = [
                Bulk::UPDATE => [
                    '_index' => $bean->index ?? $this->model->index,
                    '_id' => $bean->id,
                ],
            ];

            $bulkContainer['body'][] = [
                'doc' => filterElasticBean($bean),
            ];
        }

        if (! empty($bulkContainer['body'])) {
            return $this->model->bulk($bulkContainer);
        }

        return [];
    }

    /**
     * @NormalizeWrite
     * @return array|bool
     */
    public function deleteDocument(ElasticSearchBean $bean): bool | array
    {
        return $this->model->delete([
            'index' => $bean->index ?? $this->model->index ?? $bean->alias,
            'id' => $bean->id,
        ]);
    }

    public function bulkDeleteDocument(array $beans): array
    {
        $bulkContainer = [];
        foreach ($beans as $bean) {
            if (! $bean instanceof ElasticSearchBean) {
                continue;
            }

            $bulkContainer['body'][] = [
                Bulk::DELETE => [
                    '_index' => $bean->index ?? $this->model->index ?? $bean->alias,
                    '_id' => $bean->id,
                ],
            ];
        }

        if (! empty($bulkContainer['body'])) {
            return $this->model->bulk($bulkContainer);
        }

        return [];
    }

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
    public function updateAliases(string $alias, string $index = null, string $namespace = IndicesNamespace::class): bool | array
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
    public function deleteAlias(string $name, string $index = null, string $namespace = IndicesNamespace::class): bool | array
    {
        $query = [
            'name' => $name,
            'index' => $this->model->index ?? $index,
        ];

        return $this->model->deleteAlias($query, $namespace);
    }

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
    public function createIndex(string $index = null): bool | array
    {
        return $this->model->create(['index' => $this->model->index ?? $index], IndicesNamespace::class);
    }

    /**
     * @todo: complete function
     * @Acknowledged
     * @return array|bool
     */
    public function createIndexWithMapping(string $index = null, string $namespace = IndicesNamespace::class): bool | array
    {
        return false;
    }

    /**
     * @Acknowledged
     * @return array|bool
     */
    public function deleteIndex(string $index = null): bool | array
    {
        return $this->model->delete(['index' => $this->model->index ?? $index], IndicesNamespace::class);
    }

    public function getMapping(string $index = null, string $namespace = IndicesNamespace::class): array
    {
        return $this->model->getMapping(['index' => $this->model->index ?? $index], $namespace);
    }

    public function getFieldMapping(string $field, string $index = null, string $namespace = IndicesNamespace::class): array
    {
        $query['field'] = $field;
        if (isset($index)) {
            $query['index'] = $index;
        }
        return $this->model->getFieldMapping($query, $namespace);
    }

    public function getSetting(string $index = null, string $name = null, string $namespace = IndicesNamespace::class): array
    {
        $query = ['index' => $this->model->index ?? $index];
        if (isset($name)) {
            $query['name'] = $name;
        }
        return $this->model->getSettings($query, $namespace);
    }

    public function getPipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->getPipeline($parameters, $namespace);
    }

    /**
     * rename a field of an elasticsearch index.
     */
    public function putPipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->putPipeline($parameters, $namespace);
    }

    public function deletePipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->deletePipeline($parameters, $namespace);
    }

    public function simulatePipeline(array $parameters, string $namespace = IngestNamespace::class): array
    {
        return $this->model->simulate($parameters, $namespace);
    }
}
