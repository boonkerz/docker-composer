<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class WordpressTest extends \PHPUnit_Framework_TestCase
{
    public function testIfImageReturnIsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        $service = $composer->getServices();

        $this->assertEquals("mysql", $service[0]->getImage());
        $this->assertEquals("5.7", $service[0]->getTag());

        $this->assertEquals("wordpress", $service[1]->getImage());
        $this->assertEquals("latest", $service[1]->getTag());
    }

    public function testIfServiceIsCorrectRestart() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $this->assertEquals(Composer\Service::RESTART_ALWAYS, $service->getRestart());
    }

    public function testIfServiceReturnCorrectMemValue() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $this->assertEquals("20m", $service->getMemory());

        $service = $composer->getServices()[1];

        $this->assertEquals("100m", $service->getMemory());

        $service = $composer->getServices()[2];

        $this->assertEquals("25m", $service->getMemory());
    }

}
