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

class GeneralTest extends TestCase
{
    public function testIfVersionCorrectReturn() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));
        $this->assertEquals(2, $composer->getVersion());
    }

    /**
     * @expectedException Symfony\Component\Yaml\Exception\ParseException
     */
    public function testIfComposerThrowAnExecptionIfYamlInvalid() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/wrongFormat.yml'));
    }

    /**
     * @expectedException Symfony\Component\Yaml\Exception\ParseException
     */
    public function testIfYamlHasWrongVersion() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/wrongVersion.yml'));
    }
}
