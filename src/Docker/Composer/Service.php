<?php
namespace Docker\Composer;


use Docker\Composer\Service\Command;
use Docker\Composer\Service\Deploy;
use Docker\Composer\Service\EnvVar;
use Docker\Composer\Service\Link;
use Docker\Composer\Service\Port;
use Docker\Composer\Service\VolumeFrom;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class Service
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $image;

    /** @var string */
    protected $tag = 'latest';

    /** @var string */
    protected $memory = '100m';


    /** @var string */
    protected $command = "";

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
     * @var \Docker\Composer\Service\Network[]
     */
    protected $networks;

    /**
     * @var array
     */
    protected $links;

    /**
     * @var array
     */
    protected $edges;

    /**
     * @var array
     */
    protected $createCommands;

    /**
     * @var array
     */
    protected $updateCommands;

    /**
     * @var array
     */
    protected $backupCommands;

    /**
     * @var Deploy
     */
    protected $deploy;

    public function __construct($name)
    {
        $this->name = $name;
        $this->edges = new \ArrayIterator();
        $this->links = new \ArrayIterator();
        $this->envVars = new \ArrayIterator();
        $this->ports = new \ArrayIterator();
        $this->volumes = new \ArrayIterator();
        $this->volumesFrom = new \ArrayIterator();
        $this->createCommands = new \ArrayIterator();
        $this->updateCommands = new \ArrayIterator();
        $this->backupCommands = new \ArrayIterator();
        $this->deploy = new Service\Deploy();
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
     * @param \Docker\Composer\Service\Volume $volume
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
     * @return \Docker\Composer\Service\Volume[]
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

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return array
     */
    public function getCreateCommands()
    {
        return $this->createCommands;
    }

    /**
     * @return array
     */
    public function getUpdateCommands()
    {
        return $this->updateCommands;
    }

    /**
     * @param Command $command
     */
    public function addCreateCommand($command)
    {
        $this->createCommands->append($command);
    }

    /**
     * @param Command $command
     */
    public function addUpdateCommand($command)
    {
        $this->updateCommands->append($command);
    }

    /**
     * @return array
     */
    public function getBackupCommands()
    {
        return $this->backupCommands;
    }

    /**
     * @param Command $command
     */
    public function addBackupCommand($command)
    {
        $this->backupCommands->append($command);
    }

    /**
     * @return Service\Network[]
     */
    public function getNetworks(): array
    {
        return $this->networks;
    }

    /**
     * @param Service\Network[] $networks
     */
    public function setNetworks(array $networks)
    {
        $this->networks = $networks;
    }

    /**
     * @param Service\Network $network
     */
    public function addNetwork(\Docker\Composer\Service\Network $network)
    {
        $this->networks[] = $network;
    }

    public function isHttpPortExposed()
    {
        /** @var Port $port */
        foreach($this->getPorts() as $port) {
            if($port->isHttp()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Deploy
     */
    public function getDeploy(): Deploy
    {
        return $this->deploy;
    }

    /**
     * @param Deploy $deploy
     */
    public function setDeploy(Deploy $deploy)
    {
        $this->deploy = $deploy;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand(string $command)
    {
        $this->command = $command;
    }
}