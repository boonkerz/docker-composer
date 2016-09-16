<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24.06.16
 * Time: 17:10
 */

namespace Docker\Composer\Tests;


use Docker\Composer;

class WordpressTest extends \PHPUnit_Framework_TestCase
{
    public function testIfImageReturnIsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        $service = $composer->getServices();

        $this->assertEquals("mysql", $service[0]->getImage());
        $this->assertEquals("5.7", $service[0]->getTag());

        $this->assertEquals("wordpress", $service[1]->getImage());
        $this->assertEquals("latest", $service[1]->getTag());
    }

    public function testIfServiceIsCorrectRestart() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[1];

        $this->assertEquals(Composer\Service::RESTART_ALWAYS, $service->getRestart());
    }

    public function testIfServiceReturnCorrectMemValue() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $this->assertEquals("20m", $service->getMemory());

        $service = $composer->getServices()[1];

        $this->assertEquals("100m", $service->getMemory());

        $service = $composer->getServices()[2];

        $this->assertEquals("100m", $service->getMemory());
    }

    public function testIfCommandsCorrect() {
        $composer = new Composer(file_get_contents(__DIR__ . '/resources/file1.yml'));

        /** @var Composer\Service $service */
        $service = $composer->getServices()[0];

        $createCommands = $service->getCreateCommands();
        $updateCommands = $service->getUpdateCommands();
        $backupCommands = $service->getBackupCommands();

        $this->assertCount(5, $createCommands);

        $this->assertEquals("mysql -uroot -pPassword -e \"create database wordpress;\"", $createCommands[0]->getExec());
        $this->assertEquals("mysql -uroot -pPassword wordpress < /setup/database.sql", $createCommands[1]->getExec());
        $this->assertEquals("mysql -uroot -pPassword wordpress < /setup/migrate_1.sql", $createCommands[2]->getExec());
        $this->assertEquals("mysql -uroot -pPassword wordpress -e \"DELETE FROM domain;\"", $createCommands[3]->getExec());
        $this->assertEquals("mysql -uroot -pPassword wordpress -e \"INSERT INTO domain (shop_id,name,redirect) VALUE (1,'{domain}','');\"", $createCommands[4]->getExec());

        $this->assertCount(1, $updateCommands);

        $this->assertEquals("mysql -uroot -pPassword wordpress < /setup/migrate_1.sql", $updateCommands[0]->getExec());

        $this->assertCount(1, $backupCommands);

        $this->assertEquals("mysqldump > test.sql", $backupCommands[0]->getExec());

    }

}
