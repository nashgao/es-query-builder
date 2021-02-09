<?php

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Aspect;

use Nashgao\Elasticsearch\QueryBuilder\Annotation\Acknowledged;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;

/**
 * @Aspect()
 */
class AcknowledgedAspect extends AbstractAspect
{
    public $annotations = [
        Acknowledged::class
    ];
    
    
    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return bool
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint):bool
    {
        return $proceedingJoinPoint->process()['acknowledged'];
    }
}
