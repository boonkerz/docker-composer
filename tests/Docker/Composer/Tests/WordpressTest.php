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

        $this->assertEquals("mysql:5.7", $service[0]->getImage());

        $this->assertEquals("wordpress:latest", $service[1]->getImage());
    }

    public function testIfServiceIsCorrectRestart() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $this->assertEquals(Composer\Service::RESTART_ALWAYS, $service->getRestart());
    }

}
