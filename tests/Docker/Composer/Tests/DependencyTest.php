<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;

use Docker\Composer;
use MJS\TopSort\ElementNotFoundException;
use PHPUnit\Framework\TestCase;

class DependencyTest extends TestCase
{
    public function testIfDependencyResolverWorks() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        $services = $composer->getServices();

        $this->assertEquals('db', $services[0]->getName());
        $this->assertEquals('wordpress', $services[1]->getName());
    }

    public function testComplex() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file2.yml'));

        $services = $composer->getServices();

        $this->assertEquals('db', $services[0]->getName());
        $this->assertEquals('mongodb', $services[1]->getName());
        $this->assertEquals('nginx', $services[2]->getName());

    }

    /**
     * @expectedException MJS\TopSort\ElementNotFoundException
     */
    public function testIfDependencyCanNotResolved() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file3.yml'));

    }
}
