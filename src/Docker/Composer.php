<?php
namespace Docker;

use Docker\Composer\Network;
use Docker\Composer\Service;
use Docker\Composer\Volume;
use Docker\Parser\Networks;
use Docker\Parser\Parser;
use Docker\Parser\Services;
use Docker\Parser\Volumes;
use MJS\TopSort\Implementations\GroupedStringSort;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class Composer
{
    private $tree;

    protected $version;

    /** @var Service[] $services */
    protected $services = [];

    protected $networks = [];

    protected $volumes = [];

    public function __construct($content)
    {
        if($content == '') {
            throw new ParseException("No Content");
        }

        $this->tree = Yaml::parse($content);

        $this->parse();
    }

    private function parse() {
        if(!isset($this->tree['version'])) {
            throw new ParseException("No Content");
        }

        $this->version = $this->tree['version'];

        $volumeParser = new Volumes();
        $this->volumes = $volumeParser->parse($this->tree);

        $networksParser = new Networks();
        $this->networks = $networksParser->parse($this->tree);

        $serviceParser = new Services($this->volumes, $this->networks);
        $this->services = $serviceParser->parse($this->tree);


    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return Service[]
     */
    public function getServices() : array
    {
        return $this->services;
    }

    /**
     * @return Network[]
     */
    public function getNetworks(): array
    {
        return $this->networks;
    }

    /**
     * @return Volume[]
     */
    public function getVolumes(): array
    {
        return $this->volumes;
    }

    public function getService($name)
    {
        foreach($this->services as $service) {
            if($service->getName() === $name) {
                return $service;
            }
        }
    }

    /**
     * @param $name
     * @return Volume
     */
    public function getVolume($name)
    {
        foreach($this->volumes as $volume) {
            if($volume->getName() === $name) {
                return $volume;
            }
        }
    }
}