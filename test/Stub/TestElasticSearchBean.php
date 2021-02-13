<?php


namespace Nashgao\Test\Stub;

use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticSearchBean;

class TestElasticSearchBean extends ElasticSearchBean
{
    public string $string;

    /**
     * @param string $string
     * @return TestElasticSearchBean
     */
    public function setString(string $string): TestElasticSearchBean
    {
        $this->string = $string;
        return $this;
    }
}
