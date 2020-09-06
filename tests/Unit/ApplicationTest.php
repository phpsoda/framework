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
        $app = new Application($basePath);

        self::assertEquals(rtrim($basePath, '\/'), $app->getBasePath());
    }

    /**
     * @dataProvider provideBasePath
     * @param string $basePath
     */
    public function testGetConfigPath(string $basePath)
    {
        $app = new Application($basePath);

        self::assertEquals($app->getBasePath() . DIRECTORY_SEPARATOR . 'config', $app->getConfigPath());
    }

    /**
     * @dataProvider provideBasePathAndFile
     * @param string $basePath
     */
    public function testGetConfigFilePath(string $basePath, string $file)
    {
        $app = new Application($basePath);

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
