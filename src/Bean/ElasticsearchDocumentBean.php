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

class ElasticsearchDocumentBean extends SplBean
{
    public string $index;
    public string $document_id;

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->index = $index;
    }

    /**
     * @param string $document_id
     */
    public function setDocumentId(string $document_id): void
    {
        $this->document_id = $document_id;
    }

    /**
     * @return bool
     */
    public function issetPrimaryKey(): bool
    {
        return isset($this->document_id);
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->document_id;
    }
}