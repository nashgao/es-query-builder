<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project composer
 * @create Created on 2021/2/9 下午5:23
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns\Document;


use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeGet;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticBean;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticGetDocumentTrait
{

    /**
     * @param ElasticBean $bean
     * @return bool
     */
    public function existsDocument(ElasticBean $bean):bool
    {
        return $this->model->existsSource([
            'index' => $bean->index ?? $bean->alias,
            'id' => $bean->document_id
        ]);
    }

    /**
     * @NormalizeGet()
     * @param ElasticBean $bean
     * @return array
     */
    public function getDocument(ElasticBean $bean):array
    {
        $parameters = [
            'index' => $bean->index ?? $bean->alias,
            'id' => $bean->document_id
        ];

        return $this->model->get($parameters);
    }

    /**
     * @NormalizeGet()
     * @param ElasticBean $bean
     * @return array
     */
    public function getMultiDocuments(ElasticBean $bean):array
    {
        $parameters = [
            'index' => $bean->index ?? $bean->alias,
            'body' => [
                'size' => $this->model->configurations['mac_doc'],
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];

        return $this->model->search($parameters);
    }
}