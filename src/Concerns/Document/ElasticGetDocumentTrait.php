<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Concerns\Document;

use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeGet;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticSearchBean;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticGetDocumentTrait
{
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
}
