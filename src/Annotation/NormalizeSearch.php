<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"METHOD", "CLASS"})
 */
class NormalizeSearch extends AbstractAnnotation
{
    public bool $anonymous = false;
}
