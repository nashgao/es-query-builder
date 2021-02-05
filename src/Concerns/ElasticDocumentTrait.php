<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform

 * @create Created on 2020/10/30 下午4:44
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;


use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeGet;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeWrite;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticsearchIndexBean;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticsearchDocumentBean;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticDocumentTrait
{
    /**
     * @NormalizeGet()
     * @param string $index
     * @param string $id
     * @return array
     */
    public function getDocument(string $index, string $id):array
    {
        $parameters = [
            'index' => $index,
            'id' => $id
        ];

        return $this->model->get($parameters);
    }

    /**
     * @NormalizeGet()
     * @param string $index
     * @return array
     */
    public function getMultiDocuments(string $index):array
    {
        $parameters = [
            'index' => $index,
            'body' => [
                'size' => 10000,
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];

        return $this->model->search($parameters);
    }

    /**
     * @param ElasticsearchDocumentBean $bean
     * @return array
     */
    public function insertDocument(ElasticsearchDocumentBean $bean): array
    {
        $parameters = [
            'index' => $bean->index,
            'id' => $bean->document_id,
            'body' => [
                filterBean($bean, ['index', 'document_id'])
            ]
        ];

        return $this->model->index($parameters);
    }

    /**
     * @param ElasticsearchDocumentBean $bean
     * @return array
     */
    public function updateDocument(ElasticsearchDocumentBean $bean): array
    {
        $parameters = [
            'index' => $bean->index,
            'id' => $bean->document_id,
            'body' => [
                filterBean($bean, ['index', 'document_id'])
            ]
        ];

        return $this->model->update($parameters);
    }

    /**
     * @NormalizeWrite()
     * @param ElasticsearchIndexBean $bean
     * @return array|bool
     */
    public function insertDocuments(ElasticsearchIndexBean $bean)
    {
        $parameters = [
            'index' => $bean->index ?? current($bean->documents)->index,
            'id' => $bean->document_id ?? current($bean->documents)->document_id,
            'body' => []
        ];

        /**
         * @var                           $key
         * @var ElasticsearchDocumentBean $value
         */
        foreach ($bean->documents as $key => $value){
            $parameters['body'] = array_filter_null_value($value->toArray());
        }

        return $this->model->index($parameters);
    }

    /**
     * @NormalizeWrite()
     * @param ElasticsearchIndexBean $bean
     * @return array|bool
     */
    public function updateDocuments(ElasticsearchIndexBean $bean)
    {
        $parameters = [
            'index' => $bean->index ?? current($bean->documents)->index,
            'id' => $bean->document_id ?? current($bean->documents)->document_id,
            'body' => []
        ];

        /**
         * @var                           $key
         * @var ElasticsearchDocumentBean $value
         */
        foreach ($bean->documents as $key => $value){
            $parameters['body']['doc'] = array_filter_null_value($value->toArray());
        }

        return $this->model->update($parameters);
    }

    /**
     * @param string $index
     * @param string $id
     * @return bool
     */
    public function existsDocument(string $index, string $id):bool
    {
        return $this->model->existsSource([
            'index' => $index,
            'id' => $id
        ]);
    }

    /**
     * @NormalizeWrite()
     * @param string $index
     * @param string $id
     * @return array|bool
     */
    public function deleteDocument(string $index, string $id)
    {
        return $this->model->delete([
            'index' => $index,
            'id' => $id
        ]);
    }
}