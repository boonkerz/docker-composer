<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class LamppTest extends \PHPUnit_Framework_TestCase
{
    public function testIfPortCorrectForWordpress() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/lampp.yml'));

        /** @var Composer\Service $service */
        foreach($composer->getServices() as $service) {
            /** @var Composer\Port $port */
            foreach($service->getPorts() as $port) {
                if ($port->isHttp()) {
                    echo "is http";
                }
            }
        }
    }
}
