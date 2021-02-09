<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project composer
 * @create Created on 2021/2/9 下午6:04
 * @author Nash Gao
 */

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Constant;

class Bulk
{
    const INDEX = 'index';
    const UPDATE = 'update';
    const DELETE = 'delete';

    public static function isAction(string $action): bool
    {
        return $action === self::INDEX or
            $action === self::UPDATE or
            $action === self::DELETE;
    }
}