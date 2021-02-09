<?php

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
