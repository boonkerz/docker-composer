<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class PortTest extends \PHPUnit_Framework_TestCase
{
    public function testIfPortCorrectForWordpress() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $env = $service->getPortsAsArray();

        $this->assertcount(1, $env);

        $this->assertEquals('80', $env['8000']);

    }

    public function testIfPortHttpForWordpress() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $env = $service->getPorts();

        $this->assertcount(1, $env);

        $this->assertTrue($env[0]->isHttp());

    }

    public function testIfPortCorrectForDb() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $env = $service->getPortsAsArray();

        $this->assertcount(0, $env);

    }

}
