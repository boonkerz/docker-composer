<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class Composer3VolumeTest extends \PHPUnit_Framework_TestCase
{
    public function testIfVolumeReadsArrayType() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/composer3volumes.yml'));

        $services = $composer->getServices();

       $this->assertEquals($services[0]->getVolumes()[1]->getType(), Composer\Service\Volume::BIND);
       $this->assertEquals($services[0]->getVolumes()[1]->getSource(), './static');
       $this->assertEquals($services[0]->getVolumes()[1]->getDest(), '/opt/app/static');
       $this->assertEquals($services[0]->getVolumes()[0]->getType(), Composer\Service\Volume::VOLUME);
       $this->assertEquals($services[0]->getVolumes()[0]->getSource(), 'mydata');
       $this->assertEquals($services[0]->getVolumes()[0]->getDest(), '/data');

    }


    public function testIfVolumeReadsStringType() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/composer3volumes.yml'));

        $services = $composer->getServices();

        $this->assertEquals($services[1]->getVolumes()[1]->getType(), Composer\Service\Volume::VOLUME);
        $this->assertEquals($services[1]->getVolumes()[1]->getSource(), 'dbdata');
        $this->assertEquals($services[1]->getVolumes()[1]->getDest(), '/var/lib/postgresql/data');
        $this->assertEquals($services[1]->getVolumes()[0]->getType(), Composer\Service\Volume::BIND);
        $this->assertEquals($services[1]->getVolumes()[0]->getSource(), '/var/run/postgres/postgres.sock');
        $this->assertEquals($services[1]->getVolumes()[0]->getDest(), '/var/run/postgres/postgres.sock');

    }
}
