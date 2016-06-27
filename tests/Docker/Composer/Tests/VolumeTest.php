<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class VolumeTest extends \PHPUnit_Framework_TestCase
{
    public function testIfVolumeCorrectForWordpress() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $volumes = $service->getVolumes();

        $this->assertCount(0, $volumes);

    }

    public function testIfVolumeCorrectForDb() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $volumes = $service->getVolumes();

        $this->assertCount(1, $volumes);

        $this->assertEquals('./.data/db', $volumes[0]->getSource());
        $this->assertEquals('/var/lib/mysql', $volumes[0]->getDest());
    }

    public function testIfVolumeIsRelativ() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $volumes = $service->getVolumes();

        $this->assertCount(1, $volumes);

        $this->assertTrue($volumes[0]->isRelativ());
    }

}
