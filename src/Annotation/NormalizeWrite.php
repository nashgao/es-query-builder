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


namespace Nashgao\Elasticsearch\QueryBuilder\Annotation;


use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation()
 * @Target("METHOD")
 */
class NormalizeWrite extends AbstractAnnotation
{

}