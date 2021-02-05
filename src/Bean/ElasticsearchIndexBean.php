<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @project composer
 * @create Created on 2021/2/5 下午4:57
 * @author Nash Gao
 */

declare(strict_types=1);



namespace Nashgao\Elasticsearch\QueryBuilder\Bean;


use Nashgao\Elasticsearch\QueryBuilde\Bean\SplBean;

class ElasticsearchIndexBean extends SplBean
{
    public string $index;
    public array $aliases;
    public array $documents;

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->index = $index;
    }

    /**
     * @param array $aliases
     */
    public function setAliases(array $aliases): void
    {
        $this->aliases = $aliases;
    }

    /**
     * @param array $documents
     */
    public function setDocuments(array $documents): void
    {
        $this->documents = $documents;
    }

    /**
     * @return bool
     */
    public function issetPrimaryKey(): bool
    {
        return false;
    }

    /**
     * @return null
     */
    public function getPrimaryKey()
    {
        return null;
    }
}