<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns\Document;

use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeWrite;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticBean;
use Nashgao\Elasticsearch\QueryBuilder\Constant\Bulk;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticDeleteDocumentTrait
{
    /**
     * @NormalizeWrite()
     * @param ElasticBean $bean
     * @return array|bool
     */
    public function deleteDocument(ElasticBean $bean)
    {
        return $this->model->delete([
            'index' => $bean->index ?? $bean->alias,
            'id' => $bean->id
        ]);
    }

    /**
     * @param array $beans
     */
    public function bulkDeleteDocument(array $beans)
    {
        $bulkContainer = [];
        foreach ($beans as $bean) {
            if (! $bean instanceof ElasticBean) {
                continue;
            }

            $bulkContainer['body'][] = [
                Bulk::DELETE => [
                    '_index' => $bean->index ?? $bean->alias,
                    '_id' => $bean->id
                ]
            ];
        }

        if (! empty($bulkContainer['body'])) {
            return $this->model->bulk($bulkContainer);
        }
    }
}
