<?php

namespace Nashgao\Test\Cases;

use Nashgao\Test\Stub\TestElasticDao;

class ElasticIndexTest extends AbstractTest
{
    private string $index = 'index-test';

    public function testCreateIndex(): void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $created = $dao->createIndex($this->index);
        $this->assertTrue($created['acknowledged']);

        $exists = $dao->existsIndex($this->index);
        $this->assertTrue($exists);
    }


    public function testDeleteIndex() :void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $deleted = $dao->deleteIndex($this->index);
        $this->assertTrue($deleted['acknowledged']);
    }
}
