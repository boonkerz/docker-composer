<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class VolumeFromTest extends \PHPUnit_Framework_TestCase
{
    public function testIfVolumeFromCorrectForWordpress() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $volumes = $service->getVolumesFrom();

        $this->assertCount(1, $volumes);

        $this->assertEquals('data', $volumes[0]->getSource());
        $this->assertEquals('data', $volumes[0]->getDest());

    }

    public function testIfVolumeFromCorrectForDb() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $volumes = $service->getVolumesFrom();

        $this->assertCount(0, $volumes);
    }

}
