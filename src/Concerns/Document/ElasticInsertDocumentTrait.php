<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project composer
 * @create Created on 2021/2/9 下午5:22
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns\Document;


use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeWrite;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticBean;
use Nashgao\Elasticsearch\QueryBuilder\Constant\Bulk;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticInsertDocumentTrait
{
    /**
     * @param ElasticBean $bean
     * @return array
     */
    public function insertDocument(ElasticBean $bean): array
    {
        $parameters = [
            'index' => $bean->index ?? $bean->alias,
            'id' => $bean->document_id,
            'body' => filterElasticBean($bean)
        ];

        return $this->model->index($parameters);
    }


    /**
     * @NormalizeWrite()
     * @param array $beans
     * @return array|bool
     */
    public function bulkInsertDocument(array $beans)
    {
        $bulkContainer = [];
        for ($counter = 0; $counter < count($beans); $counter++ ){
            if (! $beans[$counter] instanceof ElasticBean) {
                continue;
            }

            $bulkContainer['body'][Bulk::INDEX] = filterElasticBean($beans[$counter]);

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