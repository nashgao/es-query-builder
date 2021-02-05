<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project space-importer
 * @create Created on 2020/12/31 上午4:43
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Aspect;


use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeGet;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;

/**
 * @Aspect()
 */
class NormalizeGetAspect extends AbstractAspect
{
    public $annotations = [
        NormalizeGet::class
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint): ?array
    {
        $result = $proceedingJoinPoint->process();
        return $this->cleanSearchResult($result);
    }

    /**
     * @param array $result
     * @param bool $getFirst
     * @return array|null
     */
    protected function cleanSearchResult(array $result, bool $getFirst = false):?array
    {
        return (!empty($result['hits']['hits'])) ?
            ( function () use ( $result , $getFirst ){
                return ($getFirst) ? $result['hits']['hits'][0] : $result['hits']['hits'];
            })() : [];
    }

}