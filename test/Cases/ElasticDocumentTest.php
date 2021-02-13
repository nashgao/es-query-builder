<?php

declare(strict_types=1);

namespace Nashgao\Test\Cases;

use Nashgao\Elasticsearch\QueryBuilder\Constant\Bulk;
use Nashgao\Test\Stub\TestElasticSearchBean;
use Nashgao\Test\Stub\TestElasticDao;
use Swoole\Coroutine;

class ElasticDocumentTest extends AbstractTest
{
    private string $index = 'index-insert';

    public function setUp(): void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $created = $dao->createIndex($this->index);
        $this->assertTrue($created['acknowledged']);
    }


    public function testElasticOperation()
    {
        $dao = $this->container->get(TestElasticDao::class);
        $docId = uniqid();
        $inserted = $dao->insertDocument(
            make(TestElasticSearchBean::class)
                ->setIndex($this->index)
                ->setId($docId)
                ->setString('a')
        );

        $this->assertTrue($inserted['result'] === 'created');

        $exists = $dao->existsDocument(
            make(TestElasticSearchBean::class)
                ->setIndex($this->index)
                ->setId($docId)
        );

        $this->assertTrue($exists);
        
        $get = $dao->getDocument(
            make(TestElasticSearchBean::class)
                ->setIndex($this->index)
                ->setId($docId)
        );

        $this->assertTrue($get['_source']['string'] === 'a');

        $updated = $dao->updateDocument(
            make(TestElasticSearchBean::class)
                ->setIndex($this->index)
                ->setId($docId)
                ->setString('b')
        );

        $this->assertTrue($updated['result'] === 'updated');

        $deleted = $dao->deleteDocument(
            make(TestElasticSearchBean::class)
                ->setIndex($this->index)
                ->setId($docId)
                ->setString('b')
        );

        $this->assertTrue($deleted['result'] === 'deleted');
    }


    public function testElasticBulkOperation()
    {
        $dao = $this->container->get(TestElasticDao::class);
        $docIdOne = uniqid('1');
        $docIdTwo = uniqid('2');
        $inserted = $dao->bulkInsertDocument(
            [
                make(TestElasticSearchBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdOne)
                    ->setString('a'),
                make(TestElasticSearchBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdTwo)
                    ->setString('a')
            ]
        );

        foreach ($inserted['items'] as $item) {
            $this->assertTrue($item[Bulk::INDEX]['result'] === 'created');
        }


        Coroutine::sleep(1);
        $getMulti = $dao->getMultiDocuments(
            make(TestElasticSearchBean::class)
                ->setIndex($this->index)
        );

        $this->assertEquals(2, $getMulti['hits']['total']['value']);


        $updated = $dao->bulkUpdateDocument(
            [
                make(TestElasticSearchBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdOne)
                    ->setString('b'),
                make(TestElasticSearchBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdTwo)
                    ->setString('b')
            ]
        );

        foreach ($updated['items'] as $item) {
            $this->assertTrue($item[Bulk::UPDATE]['result'] === 'updated');
        }

        $deleted = $dao->bulkDeleteDocument(
            [
                make(TestElasticSearchBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdOne),
                make(TestElasticSearchBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdTwo)
            ]
        );
        foreach ($deleted['items'] as $item) {
            $this->assertTrue($item[Bulk::DELETE]['result'] === 'deleted');
        }
    }


    public function tearDown() :void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $deleted = $dao->deleteIndex($this->index);
        $this->assertTrue($deleted['acknowledged']);
    }
}
