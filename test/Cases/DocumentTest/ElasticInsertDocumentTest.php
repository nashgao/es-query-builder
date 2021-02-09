<?php

declare(strict_types=1);

namespace Nashgao\Test\Cases\DocumentTest;


use Nashgao\Elasticsearch\QueryBuilder\Constant\Bulk;
use Nashgao\Test\Cases\AbstractTest;
use Nashgao\Test\Stub\TestElasticBean;
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


    public function testInsertUpdateDeleteDocument()
    {
        $dao = $this->container->get(TestElasticDao::class);
        $docId = uniqid();
        $inserted = $dao->insertDocument(
            make(TestElasticBean::class)
                ->setIndex($this->index)
                ->setId($docId));

        $this->assertTrue($inserted['result'] === 'created');


        $updated = $dao->updateDocument(
            make(TestElasticBean::class)
                ->setIndex($this->index)
                ->setId($docId)
                ->setString('a'));

        $this->assertTrue($updated['result'] === 'updated');

        $deleted = $dao->deleteDocument(
            make(TestElasticBean::class)
                ->setIndex($this->index)
                ->setId($docId)
                ->setString('b'));

        $this->assertTrue($deleted['result'] === 'deleted');
    }

    public function testBulkInsertUpdateDeleteDocument()
    {
        $dao = $this->container->get(TestElasticDao::class);
        $docIdOne = uniqid();
        $docIdTwo = uniqid();

        $inserted = $dao->bulkInsertDocument(
            [
                make(TestElasticBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdOne)
                    ->setString('a'),
                make(TestElasticBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdTwo)
                    ->setString('b')
            ]
        );

        foreach ($inserted['items'] as $item) {
            $this->assertTrue($item[Bulk::INDEX]['result'] === 'created');
        }


        $updated = $dao->bulkUpdateDocument(
            [
                make(TestElasticBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdOne)
                    ->setString('b'),
                make(TestElasticBean::class)
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
                make(TestElasticBean::class)
                    ->setIndex($this->index)
                    ->setId($docIdOne),
                make(TestElasticBean::class)
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