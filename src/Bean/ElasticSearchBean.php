<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Bean;


use Nashgao\Utils\Bean\SplBean as Bean;

class ElasticSearchBean extends Bean
{
    public string $index;
    public string $alias;
    public string $id;

    /**
     * @param string $index
     * @return ElasticSearchBean
     */
    public function setIndex(string $index): ElasticSearchBean
    {
        $this->index = $index;
        return $this;
    }

    /**
     * @param string $alias
     * @return ElasticSearchBean
     */
    public function setAlias(string $alias): ElasticSearchBean
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @param string $id
     * @return ElasticSearchBean
     */
    public function setId(string $id): ElasticSearchBean
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
