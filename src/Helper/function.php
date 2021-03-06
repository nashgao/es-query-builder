<?php

declare(strict_types=1);

use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticSearchBean;

if (! function_exists('arrayFilterNullValue')) {
    function arrayFilterNullValue(array $array): array
    {
        return array_filter(
            $array,
            function ($item) {
                return ! is_null($item);
            }
        );
    }
}

if (! function_exists('filterElasticBean')) {
    function filterElasticBean(ElasticSearchBean $bean): array
    {
        return arrayFilterNullValue(filterBean($bean, ['index', 'alias', 'id']));
    }
}
