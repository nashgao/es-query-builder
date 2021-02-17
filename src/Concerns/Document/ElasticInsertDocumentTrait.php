<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns\Document;

use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeWrite;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticSearchBean;
use Nashgao\Elasticsearch\QueryBuilder\Constant\Bulk;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticInsertDocumentTrait
{
    /**
     * @NormalizeWrite()
     * @param ElasticSearchBean $bean
     * @return array
     */
    public function insertDocument(ElasticSearchBean $bean): array
    {
        $parameters = [
            'index' => $bean->index ?? $this->model->index ?? $bean->alias,
            'id' => $bean->id,
            'body' => filterElasticBean($bean)
        ];

        return $this->model->index($parameters);
    }


    /**
     * @param array $beans
     * @return array
     */
    public function bulkInsertDocument(array $beans):array
    {
        $bulkContainer = [];
        foreach ($beans as $bean) {
            if (! $bean instanceof ElasticSearchBean) {
                continue;
            }

            $bulkContainer['body'][] = [
                Bulk::INDEX => [
                    '_index' => $bean->index ?? $this->model->index,
                    '_id' => $bean->id
                ]
            ];

            $bulkContainer['body'][] = filterElasticBean($bean);
        }

        if (! empty($bulkContainer['body'])) {
            return $this->model->bulk($bulkContainer);
        }

        return [];
    }
}
