<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\Acknowledged;

/**
 * @Aspect
 */
class AcknowledgedAspect extends AbstractAspect
{
    public $annotations = [
        Acknowledged::class,
    ];

    /**
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint): bool
    {
        return $proceedingJoinPoint->process()['acknowledged'];
    }
}
