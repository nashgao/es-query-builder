<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project space-admin-server-hyperf
 * @create Created on 2020/9/5 下午5:05
 * @author Nash Gao
 * @namespace App\Annotation
 */

declare(strict_types=1);


namespace Nashgao\Elasticsearch\QueryBuilder\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"METHOD","CLASS"})
 */
class NormalizeSearch extends AbstractAnnotation
{
    public bool $anonymous = false;
}