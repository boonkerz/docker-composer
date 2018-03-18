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

class Composer3Test extends TestCase
{
    public function testIfImageReturnIsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/composer3.yml'));

        $service = $composer->getServices();

        $this->assertEquals("redis", $service[0]->getImage());
        $this->assertEquals("3.2-alpine", $service[0]->getTag());

        $this->assertEquals("postgres", $service[1]->getImage());
        $this->assertEquals("9.4", $service[1]->getTag());
    }

    public function testIfVolumesIsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/composer3.yml'));

        $this->assertCount(1, $composer->getVolumes());
    }

    public function testIfNetworksIsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/composer3.yml'));

        $this->assertCount(1, $composer->getNetworks());

        /** @var Composer\Network[] $networks */
        $networks = $composer->getNetworks();

        $this->assertEquals('voteapp', $networks[0]->getName());

    }

    public function testIfVolumesFullIsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/composer3full.yml'));

        $this->assertCount(2, $composer->getVolumes());

        /** @var Composer\Volume[] $volumes */
        $volumes = $composer->getVolumes();

        $this->assertEquals('db-data', $volumes[0]->getName());
        $this->assertEquals('test-driver', $volumes[0]->getDriver());
        $this->assertTrue($volumes[0]->isExternal());

        $this->assertEquals('db-data-2', $volumes[1]->getName());
        $this->assertEquals('test-volume', $volumes[1]->getExternalName());
        $this->assertTrue($volumes[1]->isExternal());
    }

    public function testNetworksInServices() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/composer3full.yml'));

        $this->assertCount(5, $composer->getServices());

        $service = $composer->getServices()[0];

        $this->assertCount(1, $service->getNetworks());

        $network = $service->getNetworks()[0];
        $this->assertEquals('voteapp', $network->getName());

    }

    public function testMoreNetworksInServices() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/composer3.yml'));

        $this->assertCount(5, $composer->getServices());

        $service = $composer->getServices()[0];

        $this->assertCount(3, $service->getNetworks());

        $network = $service->getNetworks()[0];
        $this->assertEquals('voteapp', $network->getName());
        $network = $service->getNetworks()[1];
        $this->assertEquals('testnetwork', $network->getName());

    }
}
