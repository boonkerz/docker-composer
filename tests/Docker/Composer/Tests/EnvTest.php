<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class EnvTest extends \PHPUnit_Framework_TestCase
{
    public function testIfEnvCorrectForWordpress() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $env = $service->getEnvVarsAsArray();

        $this->assertArrayHasKey('WORDPRESS_DB_HOST', $env);
        $this->assertArrayHasKey('WORDPRESS_DB_PASSWORD', $env);

        $this->assertEquals('db:3306', $env['WORDPRESS_DB_HOST']);
        $this->assertEquals('pass1', $env['WORDPRESS_DB_PASSWORD']);

    }

    public function testIfEnvCorrectForDb() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $env = $service->getEnvVarsAsArray();

        $this->assertArrayHasKey('MYSQL_ROOT_PASSWORD', $env);
        $this->assertArrayHasKey('MYSQL_DATABASE', $env);

        $this->assertEquals('pass1', $env['MYSQL_PASSWORD']);
        $this->assertEquals('wordpress', $env['MYSQL_DATABASE']);
    }

}
