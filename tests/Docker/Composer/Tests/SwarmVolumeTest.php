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

class SwarmVolumeTest extends TestCase
{

    /** @var Composer */
    protected $composer;

    protected function setUp()
    {
        $this->composer = new Composer(file_get_contents(__DIR__ . '/resources/swarmvolumes.yml'));
    }

    public function testVolumesCount()
    {
        $this->assertEquals(2, count($this->composer->getVolumes()));
    }

    public function testVolumeDriver() {

        $this->assertEquals('local', $this->composer->getVolume('db')->getDriver());

        $this->assertEquals('swarm', $this->composer->getVolume('www')->getDriver());

    }

    public function testDriverOpts() {
        $this->assertEquals(3, count($this->composer->getVolume('db')->getDriverOpts()));

        $this->assertEquals('nfs', $this->composer->getVolume('db')->getDriverOpts()['type']);
        $this->assertEquals('addr=freenas,rw', $this->composer->getVolume('db')->getDriverOpts()['o']);
        $this->assertEquals(':/mnt/daten/docker', $this->composer->getVolume('db')->getDriverOpts()['device']);
    }

    protected function tearDown()
    {
        $this->composer = null;
    }
}