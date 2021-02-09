<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Bean;

class ElasticBean extends SplBean
{
    public string $index;
    public string $alias;
    public string $id;

    /**
     * @param string $index
     * @return ElasticBean
     */
    public function setIndex(string $index): ElasticBean
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @param string $alias
     * @return ElasticBean
     */
    public function setAlias(string $alias): ElasticBean
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @param string $id
     * @return ElasticBean
     */
    public function setId(string $id): ElasticBean
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool
     */
    public function issetPrimaryKey(): bool
    {
        return isset($this->id);
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->id;
    }
}
