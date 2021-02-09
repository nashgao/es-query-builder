<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project composer
 * @create Created on 2021/2/5 下午6:12
 * @author Nash Gao
 */

declare(strict_types=1);


use Nashgao\Elasticsearch\QueryBuilde\Bean\SplBean;
use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticBean;

if (! function_exists('filterBean')) {
    /**
     * Filter the bean and to array with not null
     * @param SplBean $bean
     * @param array $filter
     * @return array
     */
    function filterBean(SplBean $bean, array $filter = []):array
    {
        return $bean->toArray(array_keys(array_diff_key($bean->toArrayWithMapping(), array_fill_keys($filter, null))), $bean::FILTER_NOT_NULL);
    }
}


if (! function_exists('arrayFilterNullValue')) {
    /**
     * @param array $array
     * @return array
     */
    function arrayFilterNullValue(array $array): array
    {
        return array_filter(
            $array,
            function($item) {
                return !is_null($item);
            }
        );
    }
}

if(! function_exists('filterElasticBean')) {
    /**
     * @param ElasticBean $bean
     * @return array
     */
    function filterElasticBean(ElasticBean $bean): array
    {
        return arrayFilterNullValue(filterBean($bean, ['index', 'alias', 'document_id']));
    }
}
