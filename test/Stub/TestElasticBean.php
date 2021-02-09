<?php


namespace Nashgao\Test\Stub;


use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticBean;

class TestElasticBean extends ElasticBean
{
    public string $string;

    /**
     * @param string $string
     * @return TestElasticBean
     */
    public function setString(string $string): TestElasticBean
    {
        $this->string = $string;
        return $this;
    }


}