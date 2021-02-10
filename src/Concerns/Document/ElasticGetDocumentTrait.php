<?php

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
            'id' => $bean->id
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
            'id' => $bean->id
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
                'size' => $this->model->configurations['max_doc'],
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];

        return $this->model->search($parameters);
    }
}
