<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 21.10.17
 * Time: 01:15
 */

namespace Docker\Composer;


class Network
{
    protected $name;

    protected $driver = 'overlay';

    protected $driverOpts = [];

    protected $external = false;

    protected $externalName = '';

    /**
     * Network constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDriver(): string
    {
        return $this->driver;
    }

    /**
     * @param string $driver
     */
    public function setDriver(string $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return array
     */
    public function getDriverOpts(): array
    {
        return $this->driverOpts;
    }

    /**
     * @param array $driverOpts
     */
    public function setDriverOpts(array $driverOpts)
    {
        $this->driverOpts = $driverOpts;
    }

    /**
     * @return bool
     */
    public function isExternal(): bool
    {
        return $this->external;
    }

    /**
     * @param bool $external
     */
    public function setExternal(bool $external)
    {
        $this->external = $external;
    }

    /**
     * @return string
     */
    public function getExternalName(): string
    {
        return $this->externalName;
    }

    /**
     * @param string $externalName
     */
    public function setExternalName(string $externalName)
    {
        $this->externalName = $externalName;
    }

}