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

use Nashgao\Test\Stub\TestElasticDao;

class ElasticAliasTest extends AbstractTest
{
    public string $index = 'alias-test';

    public string $alias = 'test-alias';

    public function setUp(): void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $created = $dao->createIndex($this->index);
        $this->assertTrue($created['acknowledged']);
    }

    public function testAliasOperations()
    {
        $dao = $this->container->get(TestElasticDao::class);
        $updated = $dao->updateAliases($this->index, $this->alias);
        $this->assertTrue($updated['acknowledged']);

        $existed = $dao->existsAlias($this->index, $this->alias);
        $this->assertTrue($existed);

        $deleted = $dao->deleteAlias($this->index, $this->alias);
        $this->assertTrue($deleted['acknowledged']);
    }

    public function tearDown(): void
    {
        $dao = $this->container->get(TestElasticDao::class);
        $deleted = $dao->deleteIndex($this->index);
        $this->assertTrue($deleted['acknowledged']);
    }
}
