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


namespace Nashgao\Elasticsearch\QueryBuilder\Annotation;


use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class NormalizeGet extends AbstractAnnotation
{

}