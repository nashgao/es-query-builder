<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Constant;

class Bulk
{
    const INDEX = 'index';

    const UPDATE = 'update';

    const DELETE = 'delete';

    public static function isAction(string $action): bool
    {
        return $action === self::INDEX
            or $action === self::UPDATE
            or $action === self::DELETE;
    }
}
