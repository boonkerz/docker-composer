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

class CommandTest extends TestCase
{

    /** @var Composer */
    protected $composer;

    protected function setUp()
    {
        $this->composer = new Composer(file_get_contents(__DIR__ . '/resources/zammad.yml'));
    }

    public function testCommandIsEqual()
    {
        $this->assertEquals(["zammad-init"], $this->composer->getService('zammad-init')->getCommand());
    }

    protected function tearDown()
    {
        $this->composer = null;
    }
}