<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;
use PHPUnit\Framework\TestCase;

class NeosTest extends TestCase
{
    public function testIfImageReturnIsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/neos.yml'));

        $service = $composer->getServices();

        $this->assertEquals("million12/mariadb", $service[0]->getImage());
        $this->assertEquals("latest", $service[0]->getTag());

        $this->assertEquals("million12/typo3-neos", $service[1]->getImage());
        $this->assertEquals("latest", $service[1]->getTag());
    }

    public function testIfServiceIsGettingLinks() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/neos.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $this->assertEquals("db", $service->getLinks()[0]->getHost());
        $this->assertEquals("db", $service->getLinks()[0]->getAs());
    }

    public function testIfServiceReturnCorrectMemValue() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/neos.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $this->assertEquals("100m", $service->getMemory());

    }

}
