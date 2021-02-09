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
            'id' => $bean->document_id
        ]);
    }

    /**
     * @param array $beans
     */
    public function bulkDelete(array $beans)
    {
        $bulkContainer = [];
        for ($counter = 0; $counter < count($beans); $counter++) {
            if (! $beans[$counter] instanceof ElasticBean) {
                continue;
            }

            $bulkContainer['body'][Bulk::DELETE] = [
                'index' => $beans[$counter]->index ?? $beans[$counter]->alias,
                'id' => $beans[$counter]->document_id
            ];

            if ($counter % 1000 === 0) {
                $response = $this->model->bulk($bulkContainer);
                $bulkContainer = []; // reset container
                unset($response);
            }
        }

        if (! empty($bulkContainer['body'])) {
            $this->model->bulk($bulkContainer);
        }
    }
}
