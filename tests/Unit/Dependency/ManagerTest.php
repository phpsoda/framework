<?php

namespace Tests\Unit\Dependency;

use PHPSoda\Application;
use PHPSoda\Dependency\Manager;
use Tests\TestCase;

class ManagerTest extends TestCase
{
    /**
     * @var Manager
     */
    private $manager;

    public function setUp(): void
    {
        $this->manager = new Manager(Application::getInstance());
    }

    public function testResolve()
    {
        self::assertTrue($this->manager->resolve(TestCase::class) instanceof TestCase);
    }
}
