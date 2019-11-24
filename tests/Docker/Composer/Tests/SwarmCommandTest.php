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

class SwarmCommandTest extends TestCase
{

    /** @var Composer */
    protected $composer;

    protected function setUp()
    {
        $this->composer = new Composer(file_get_contents(__DIR__ . '/resources/swarmcommand.yml'));
    }

    public function testVolumesCount()
    {

        $service  = $this->composer->getService('sftp');
        $this->assertEquals(["foo:pass:1001"], $service->getCommand());

    }

    protected function tearDown()
    {
        $this->composer = null;
    }
}