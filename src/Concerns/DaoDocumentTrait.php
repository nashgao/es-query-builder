<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project elasticsearch-proxy-pool
 * @create Created on 2020/10/30 下午4:44
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Concerns;


use Nashgao\Elasticsearch\QueryBuilder\Elasticsearch;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeGet;

/**
 * @property Elasticsearch $model
 */
trait DaoDocumentTrait
{
    /**
     * @NormalizeGet()
     * @param string $index
     * @param int $id
     * @return array
     */
    public function get(string $index, int $id):array
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
    public function getAll(string $index):array
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
     * @NormalizeWrite()
     * @param ElasticsearchBean $bean
     * @return array|bool
     */
    public function insert(ElasticsearchBean $bean)
    {
        $parameters = [
            'index' => $bean->index ?? current($bean->data)->index,
            'id' => $bean->document_id ?? current($bean->data)->document_id,
            'body' => []
        ];

        /**
         * @var                           $key
         * @var ElasticsearchDocumentBean $value
         */
        foreach ($bean->data as $key => $value){
            $parameters['body'] = array_filter_null_value(filterBean($value, ['index','document_id', 'action']));
        }

        return $this->model->index($parameters);
    }

    /**
     * @NormalizeWrite()
     * @param ElasticsearchBean $bean
     * @return array|bool
     */
    public function update(ElasticsearchBean $bean)
    {
        $parameters = [
            'index' => $bean->index ?? current($bean->data)->index,
            'id' => $bean->document_id ?? current($bean->data)->document_id,
            'body' => []
        ];

        /**
         * @var                           $key
         * @var ElasticsearchDocumentBean $value
         */
        foreach ($bean->data as $key => $value){
            $parameters['body']['doc'] = array_filter_null_value(filterBean($value, ['index','document_id','action']));
        }

        return $this->model->update($parameters);
    }

    /**
     * @param string $index
     * @param int $id
     * @return bool
     */
    public function existsDocument(string $index, int $id):bool
    {
        return $this->model->existsSource([
            'index' => $index,
            'id' => $id
        ]);
    }

    /**
     * @NormalizeWrite()
     * @param string $index
     * @param int $id
     * @return array|bool
     */
    public function delete(string $index, int $id)
    {
        return $this->model->delete([
            'index' => $index,
            'id' => $id
        ]);
    }
}