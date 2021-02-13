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
trait ElasticUpdateDocumentTrait
{
    /**
     * @NormalizeWrite()
     * @param ElasticSearchBean $bean
     * @return array
     */
    public function updateDocument(ElasticSearchBean $bean): array
    {
        $parameters = [
            'index' => $bean->index,
            'id' => $bean->id,
            'body' => [
                'doc' => arrayFilterNullValue(filterBean($bean, ['index', 'alias', 'id']))
            ]
        ];

        return $this->model->update($parameters);
    }


    /**
     * @param array $beans
     * @return array
     */
    public function bulkUpdateDocument(array $beans):array
    {
        $bulkContainer = [];
        foreach ($beans as $bean) {
            if (! $bean instanceof ElasticSearchBean) {
                continue;
            }

            $bulkContainer['body'][] = [
                Bulk::UPDATE => [
                    '_index' => $bean->index,
                    '_id' => $bean->id
                ]
            ];

            $bulkContainer['body'][] = [
                'doc' => filterElasticBean($bean)
            ];
        }

        if (! empty($bulkContainer['body'])) {
            return $this->model->bulk($bulkContainer);
        }

        return [];
    }
}
