<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeWrite;

/**
 * @Aspect
 */
class NormalizeWriteAspect extends AbstractAspect
{
    public $annotations = [
        NormalizeWrite::class,
    ];

    /**
     * @throws Exception
     * @return bool
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $result = $proceedingJoinPoint->process()['result'];

        if (is_bool($result)) {
            return $result;
        }

        return $result === 'created' or $result === 'updated' or $result === 'deleted';
    }
}
