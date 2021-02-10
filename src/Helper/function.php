<?php

declare(strict_types=1);


use EasySwoole\Spl\SplBean;
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
        $validKeys = array_diff_key($bean->toArrayWithMapping(), array_fill_keys($filter, null));
        if (empty($validKeys)) {
            return [];
        }
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
            function ($item) {
                return !is_null($item);
            }
        );
    }
}

if (! function_exists('filterElasticBean')) {
    /**
     * @param ElasticBean $bean
     * @return array
     */
    function filterElasticBean(ElasticBean $bean): array
    {
        return arrayFilterNullValue(filterBean($bean, ['index', 'alias', 'id']));
    }
}
