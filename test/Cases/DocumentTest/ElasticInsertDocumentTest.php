<?php

declare(strict_types=1);

namespace Nashgao\Test\Cases\DocumentTest;


use Nashgao\Elasticsearch\QueryBuilder\Bean\ElasticBean;
use Nashgao\Test\Cases\AbstractTest;
use Nashgao\Test\Stub\TestElasticDao;

class ElasticInsertDocumentTest extends AbstractTest
{
    private string $index = 'index-insert';

    public function setUp(): void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $created = $dao->createIndex($this->index);
        $this->assertTrue($created['acknowledged']);
    }


    public function testInsertDeleteDocument()
    {
        $dao = $this->container->get(TestElasticDao::class);
        $inserted = $dao->insertDocument(
            make(ElasticBean::class)
                ->setIndex($this->index)
                ->setDocumentId(uniqid()));
        var_dump($inserted);
    }


    public function tearDown() :void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $deleted = $dao->deleteIndex($this->index);
        $this->assertTrue($deleted['acknowledged']);
    }
}