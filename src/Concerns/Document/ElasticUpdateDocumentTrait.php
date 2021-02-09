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
trait ElasticUpdateDocumentTrait
{
    /**
     * @param ElasticBean $bean
     * @return array
     */
    public function updateDocument(ElasticBean $bean): array
    {
        $parameters = [
            'index' => $bean->index,
            'id' => $bean->document_id,
            'body' => [
                'doc' => arrayFilterNullValue(filterBean($bean, ['index', 'alias', 'document_id']))
            ]
        ];

        return $this->model->update($parameters);
    }


    /**
     * @NormalizeWrite()
     * @param array $beans
     * @return array|bool
     */
    public function bulkUpdateDocument(array $beans)
    {
        $bulkContainer = [];
        for ($counter = 0; $counter < count($beans); $counter++) {
            if (! $beans[$counter] instanceof ElasticBean) {
                continue;
            }

            $bulkContainer['body'][Bulk::UPDATE] = filterElasticBean($beans[$counter]);

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
