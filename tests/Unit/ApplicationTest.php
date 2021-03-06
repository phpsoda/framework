<?php

namespace Tests\Unit;

use PHPSoda\Application;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @dataProvider provideBasePath
     * @param string|null $basePath
     */
    public function testSetBasePath(string $basePath)
    {
        Application::initialize($basePath);
        $app = Application::getInstance();

        self::assertEquals(rtrim($basePath, '/'), $app->getBasePath());
    }

    /**
     * @dataProvider provideBasePath
     * @param string $basePath
     */
    public function testGetConfigPath(string $basePath)
    {
        Application::initialize($basePath);
        $app = Application::getInstance();

        self::assertEquals($app->getBasePath() . DIRECTORY_SEPARATOR . 'config', $app->getConfigPath());
    }

    /**
     * @dataProvider provideBasePathAndFile
     * @param string $basePath
     * @param string $file
     */
    public function testGetConfigFilePath(string $basePath, string $file)
    {
        Application::initialize($basePath);
        $app = Application::getInstance();

        self::assertEquals($app->getConfigPath() . DIRECTORY_SEPARATOR . $file, $app->getConfigFilePath($file));
    }

    /**
     * @return array
     */
    public function provideBasePath(): array
    {
        return [
            [''],
            ['/example'],
            ['/example/'],
        ];
    }

    /**
     * @return array
     */
    public function provideBasePathAndFile(): array
    {
        return [
            ['', 'app.php'],
            ['/example', 'app.php'],
            ['/example/', 'app.php'],
        ];
    }
}
