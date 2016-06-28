<?php
namespace Docker\Composer;


use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class Service
{

    const RESTART_NONE = 0;
    const RESTART_ALWAYS = 1;

    /** @var string */
    protected $name;

    /** @var string */
    protected $image;

    /** @var string */
    protected $memory;

    /**
     * @var array
     */
    protected $envVars;

    /**
     * @var array
     */
    protected $ports;

    /**
     * @var array
     */
    protected $volumes;

    /**
     * @var array
     */
    protected $volumesFrom;

    /**
     * @var array
     */
    protected $links;

    /**
     * @var array
     */
    protected $edges;

    /** @var Int */
    protected $restart = self::RESTART_NONE;

    public function __construct($name)
    {
        $this->name = $name;
        $this->edges = new \ArrayIterator();
        $this->links = new \ArrayIterator();
        $this->envVars = new \ArrayIterator();
        $this->ports = new \ArrayIterator();
        $this->volumes = new \ArrayIterator();
        $this->volumesFrom = new \ArrayIterator();
        $this->memory = '25m';
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
     * @return array
     */
    public function getEdges()
    {
        return $this->edges;
    }

    /**
     * @param string $edge
     */
    public function addEdge($edge)
    {
        $this->edges->append($edge);
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return array
     */
    public function getEnvVars()
    {
        return $this->envVars;
    }

    /**
     * @return array
     */
    public function getPorts()
    {
        return $this->ports;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param EnvVar $envVar
     */
    public function addEnvVar($envVar)
    {
        $this->envVars->append($envVar);
    }

    /**
     * @param Link $link
     */
    public function addLink($link)
    {
        $this->links->append($link);
    }

    /**
     * @param Volume $volume
     */
    public function addVolume($volume)
    {
        $this->volumes->append($volume);
    }

    /**
     * @param VolumeFrom $volumeFrom
     */
    public function addVolumeFrom($volumeFrom)
    {
        $this->volumesFrom->append($volumeFrom);
    }

    /**
     * @param Port $port
     */
    public function addPort($port)
    {
        $this->ports->append($port);
    }

    public function getEnvVarsAsArray()
    {
        $temp = [];
        /** @var EnvVar $item */
        foreach ($this->envVars as $item) {
            $temp[$item->getName()] = $item->getValue();
        }

        return $temp;
    }

    public function getLinksAsArray()
    {
        $temp = [];
        /** @var Link $item */
        foreach ($this->links as $item) {
            $temp[$item->getHost()] = $item->getAs();
        }

        return $temp;
    }

    public function getPortsAsArray()
    {
        $temp = [];
        /** @var Port $item */
        foreach ($this->ports as $item) {
            $temp[$item->getSource()] = $item->getDest();
        }

        return $temp;
    }

    public function getVolumesAsArray()
    {
        $temp = [];
        /** @var Volume $item */
        foreach ($this->volumes as $item) {
            $temp[$item->getSource()] = $item->getDest();
        }

        return $temp;
    }

    public function getVolumesFromAsArray()
    {
        $temp = [];
        /** @var VolumeFrom $item */
        foreach ($this->volumesFrom as $item) {
            $temp[$item->getSource()] = $item->getDest();
        }

        return $temp;
    }

    /**
     * @return Int
     */
    public function getRestart()
    {
        return $this->restart;
    }

    /**
     * @param Int $restart
     */
    public function setRestart($restart)
    {
        $this->restart = $restart;
    }

    /**
     * @return array
     */
    public function getVolumes()
    {
        return $this->volumes;
    }

    /**
     * @return array
     */
    public function getVolumesFrom()
    {
        return $this->volumesFrom;
    }

    /**
     * @return string
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param string $memory
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;
    }
}