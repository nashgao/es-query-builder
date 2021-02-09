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


use Nashgao\Elasticsearch\QueryBuilder\Concerns\Document\ElasticDeleteDocumentTrait;
use Nashgao\Elasticsearch\QueryBuilder\ElasticsearchModel;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\Document\ElasticUpdateDocumentTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\Document\ElasticInsertDocumentTrait;
use Nashgao\Elasticsearch\QueryBuilder\Concerns\Document\ElasticGetDocumentTrait;

/**
 * @property ElasticsearchModel $model
 */
trait ElasticDocumentTrait
{
    use ElasticGetDocumentTrait;
    use ElasticInsertDocumentTrait;
    use ElasticUpdateDocumentTrait;
    use ElasticDeleteDocumentTrait;

}