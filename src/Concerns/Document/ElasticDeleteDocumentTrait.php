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
trait ElasticDeleteDocumentTrait
{
    /**
     * @NormalizeWrite
     * @return array|bool
     */
    public function deleteDocument(ElasticSearchBean $bean)
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
}
