<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeGet;

/**
 * @Aspect
 */
class NormalizeGetAspect extends AbstractAspect
{
    public $annotations = [
        NormalizeGet::class,
    ];

    /**
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint): ?array
    {
        $result = $proceedingJoinPoint->process();
        return $this->cleanSearchResult($result);
    }

    protected function cleanSearchResult(array $result, bool $getFirst = false): ?array
    {
        return (! empty($result['hits']['hits'])) ?
            (function () use ($result, $getFirst) {
                return ($getFirst) ? $result['hits']['hits'][0] : $result['hits']['hits'];
            })() : [];
    }
}
