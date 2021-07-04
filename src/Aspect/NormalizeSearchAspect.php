<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeSearch;

/**
 * @Aspect
 */
class NormalizeSearchAspect extends AbstractAspect
{
    public $annotations = [
        NormalizeSearch::class,
    ];

    public function process(ProceedingJoinPoint $proceedingJoinPoint): array
    {
        try {
            $result = $proceedingJoinPoint->process();
        } catch (Exception $exception) {
            var_dump($exception);
            return [];
        }

        $cleanedResult = $this->cleanSearchResult($result);
        if (isset($result['hits']['total']['value'])) {
            $cleanedResult['total'] = $result['hits']['total']['value'];
        }

        return $cleanedResult;
    }

    protected function cleanSearchResult(array $result, bool $getFirst = false): ?array
    {
        return (! empty($result['hits']['hits'])) ?
            (function () use ($result, $getFirst) {
                return ($getFirst) ? $result['hits']['hits'][0] : $result['hits']['hits'];
            })() : [];
    }
}
