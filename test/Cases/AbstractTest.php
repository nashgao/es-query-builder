<?php

declare(strict_types=1);

namespace Nashgao\Test\Cases;

use Hyperf\Utils\ApplicationContext;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @internal
 * @coversNothing
 */
abstract class AbstractTest extends TestCase
{
    public ContainerInterface $container;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->container = ApplicationContext::getContainer();
    }
}
