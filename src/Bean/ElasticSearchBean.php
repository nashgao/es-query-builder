<?php

declare(strict_types=1);

namespace Nashgao\Elasticsearch\QueryBuilder\Bean;

use Nashgao\Utils\Bean\SplBean as Bean;

class ElasticSearchBean extends Bean
{
    public string $index;

    public string $alias;

    public string $id;

    public function setIndex(string $index): ElasticSearchBean
    {
        $this->index = $index;
        return $this;
    }

    public function setAlias(string $alias): ElasticSearchBean
    {
        $this->alias = $alias;
        return $this;
    }

    public function setId(string $id): ElasticSearchBean
    {
        $this->id = $id;
        return $this;
    }

    public function issetPrimaryKey(): bool
    {
        return isset($this->id);
    }

    public function getPrimaryKey(): string
    {
        return $this->id;
    }
}
