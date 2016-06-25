<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class LinkTest extends \PHPUnit_Framework_TestCase
{
    public function testIfLinkCorrectForWordpress() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $env = $service->getLinksAsArray();

        $this->assertcount(1, $env);

        $this->assertEquals('db1', $env['db']);

    }

    public function testIfLinkCorrectForDb() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $env = $service->getLinksAsArray();

        $this->assertcount(0, $env);

    }

}