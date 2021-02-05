<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform

 * @create Created on 2020/10/30 下午4:19
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Aspect;


use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeWrite;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;

/**
 * @Aspect()
 */
class NormalizeWriteAspect extends AbstractAspect
{

    public $annotations = [
        NormalizeWrite::class
    ];


    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return bool
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $result = $proceedingJoinPoint->process()['result'];

        if (is_bool($result)){
            return $result;
        }

        return $result === 'created' or $result === 'updated' or  $result ==='deleted';
    }
}