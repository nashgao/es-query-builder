<?php
/**
 * Copyright (C) SPACE Platform PTY LTD - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nash Gao <nash@spaceplaform.co>
 * @organization Space Platform
 * @author Nash Gao
 */

declare(strict_types=1);


namespace Nashgao\Test\Cases;

use Nashgao\Test\Stub\TestElasticBean;
use Nashgao\Test\Stub\TestElasticDao;

class ElasticCatTest extends AbstractTest
{
    public string $index = 'cat-test';

    public string $alias = 'cat-alias';

    public function setUp(): void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $created = $dao->createIndex($this->index);
        $this->assertTrue($created['acknowledged']);

        $alias = $dao->updateAliases($this->index, $this->alias);
        $this->assertTrue($alias['acknowledged']);

        $inserted = $dao->insertDocument(
            make(TestElasticBean::class)
                ->setIndex($this->index)
                ->setId(uniqid())
                ->setString('a')
        );
        $this->assertTrue($inserted['result'] === 'created');
    }

    public function testCatOperations()
    {
        $dao = $this->container->get(TestElasticDao::class);

        $alias = $dao->catAlias($this->alias);
        $this->assertNotEmpty($alias);

        $aliases = $dao->catAliases();
        $this->assertNotEmpty($aliases);

        $index = $dao->catIndex($this->index);
        $this->assertNotEmpty($index);

        $indices = $dao->catIndices();
        $this->assertNotEmpty($indices);
    }

    public function tearDown(): void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $deleted = $dao->deleteIndex($this->index);
        $this->assertTrue($deleted['acknowledged']);
    }
}
