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

class SectionDeployTest extends TestCase
{
    public function testIfRepicasReturn2() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/wordpress.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getService('wordpress');

        $this->assertEquals(2, $service->getDeploy()->getReplicas(), "Replicas wrong");
    }

    public function testIfModeIsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/wordpress.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getService('wordpress');

        $this->assertEquals(Composer\Service\Deploy::MODE_REPLICATED, $service->getDeploy()->getMode(), "Mode wrong");

        $service = $composer->getService('dbcluster');

        $this->assertEquals(Composer\Service\Deploy::MODE_GLOBAL, $service->getDeploy()->getMode(), "Mode wrong");
    }

    public function testRestartPolicy() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/wordpress.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getService('wordpress');

        $this->assertEquals(Composer\Service\Deploy\RestartPolicy::CONDITION_ON_FAILURE, $service->getDeploy()->getRestartPolicy()->getCondition(), "Condition wrong");

        $this->assertEquals(11, $service->getDeploy()->getRestartPolicy()->getDelay(), "Delay wrong");

        $service = $composer->getService('dbcluster');

        $this->assertEquals(Composer\Service\Deploy\RestartPolicy::CONDITION_ANY, $service->getDeploy()->getRestartPolicy()->getCondition(), "Condition wrong");

        $this->assertEquals(0, $service->getDeploy()->getRestartPolicy()->getDelay(), "Delay wrong");

    }

    public function testPlacement() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/wordpress.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getService('dbcluster');

        $this->assertEquals(2, count($service->getDeploy()->getPlacement()->getConstraints()), "Constraints Count wrong");
        $this->assertEquals(1, count($service->getDeploy()->getPlacement()->getPreferences()), "Preferences Count wrong");

        $service = $composer->getService('wordpress');

        $this->assertEquals(0, count($service->getDeploy()->getPlacement()->getConstraints()), "wordpress does not have constraints");
        $this->assertEquals(0, count($service->getDeploy()->getPlacement()->getPreferences()), "wordpress does not have constraints");

    }
}
