<?php
namespace Docker;

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

        $serviceParser = new Services();
        $this->services = $serviceParser->parse($this->tree);

        $networksParser = new Networks();
        $this->networks = $networksParser->parse($this->tree);


    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return array
     */
    public function getServices() : array
    {
        return $this->services;
    }

    /**
     * @return array
     */
    public function getNetworks(): array
    {
        return $this->networks;
    }

    /**
     * @return array
     */
    public function getVolumes(): array
    {
        return $this->volumes;
    }
}