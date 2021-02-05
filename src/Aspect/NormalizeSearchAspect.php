<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project space-admin-server-hyperf
 * @create Created on 2020/9/5 下午5:06
 * @author Nash Gao
 * @namespace App\Aspect
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Aspect;


use Nashgao\Elasticsearch\QueryBuilder\Annotation\NormalizeSearch;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;

/**
 * @Aspect()
 */
class NormalizeSearchAspect extends AbstractAspect
{
    public $annotations = [
        NormalizeSearch::class,
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint): array
    {
        try {
            $result = $proceedingJoinPoint->process();
        } catch (Exception $exception) {
            var_dump($exception);
            return [];
        }

        $cleanedResult =  $this->cleanSearchResult($result);
        if (isset($result['hits']['total']['value']))
            $cleanedResult['total'] = $result['hits']['total']['value'];

        return $cleanedResult;
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