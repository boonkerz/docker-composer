<?php
namespace Docker;


use Docker\Composer\Command;
use Docker\Composer\EnvVar;
use Docker\Composer\Link;
use Docker\Composer\Port;
use Docker\Composer\Service;
use Docker\Composer\Volume;
use Docker\Composer\VolumeFrom;
use MJS\TopSort\Implementations\GroupedStringSort;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class Composer
{
    private $tree;

    protected $version;

    protected $services = [];

    public function __construct($content)
    {
        if($content == '') {
            throw new ParseException("No Content");
        }

        $this->tree = Yaml::parse($content);

        $this->parse();
    }

    private function parse() {
        if(!isset($this->tree['version']) || $this->tree['version'] != 2) {
            throw new ParseException("No Content");
        }

        $this->version = $this->tree['version'];

        foreach($this->tree['services'] as $name => $serviceArr) {
            $this->parseService($name, $serviceArr);
        }

        $this->depResolve();
    }

    private function parseService($name, $serviceArr)
    {
        $service = new Service(strtolower($name));

        if(isset($serviceArr['depends_on'])) {
            foreach ($serviceArr['depends_on'] as $item) {
                $service->addEdge($item);
            }
        }

        if(isset($serviceArr['restart']) && $serviceArr['restart'] == 'always') {
            $service->setRestart(Service::RESTART_ALWAYS);
        }

        if(isset($serviceArr['image'])) {
            if(strpos($serviceArr['image'], ':') !== false) {
                $image = explode(':', $serviceArr['image']);
                $service->setImage($image[0]);
                $service->setTag($image[1]);
            }else{
                $service->setImage($serviceArr['image']);
            }
        }

        if(isset($serviceArr['mem_limit'])) {
            $service->setMemory($serviceArr['mem_limit']);
        }

        if(isset($serviceArr['links'])) {
            foreach ($serviceArr['links'] as $item) {
                $link = explode(':', $item);
                if(count($link) == 1) {
                    $service->addLink(new Link($link[0], $link[0]));
                    continue;
                }
                $service->addLink(new Link($link[0], $link[1]));
            }
        }

        if(isset($serviceArr['ports'])) {
            foreach ($serviceArr['ports'] as $item) {
                if(strpos($item, "-") !== false) {
                    continue;
                }
                $port = explode(':', $item);
                if(count($port) == 1) {
                    $service->addPort(new Port($port[0], $port[0]));
                    continue;
                }
                $service->addPort(new Port($port[0], $port[1]));
            }
        }

        if(isset($serviceArr['volumes'])) {
            foreach ($serviceArr['volumes'] as $item) {
                $volume = explode(':', $item);
                if(count($volume) == 1) {
                    $service->addVolume(new Volume($volume[0], $volume[0]));
                    continue;
                }elseif(count($volume) == 2) {
                    $service->addVolume(new Volume($volume[0], $volume[1]));
                    continue;
                }

                $backup = false;

                if(isset($volume[3])) {
                    if($volume[3] == 'backup') {
                        $backup = true;
                    }
                }
                if($volume[2] == 'ro') {
                    $service->addVolume(new Volume($volume[0], $volume[1], Volume::RO, $backup));
                    continue;
                }
                $service->addVolume(new Volume($volume[0], $volume[1], Volume::RW, $backup));
                continue;
            }
        }

        if(isset($serviceArr['volumes_from'])) {
            foreach ($serviceArr['volumes_from'] as $item) {
                $volume = explode(':', $item);
                if(count($volume) == 3) {
                    if($volume[3] == 'ro') {
                        $service->addVolumeFrom(new VolumeFrom(strtolower($volume[0]), strtolower($volume[1]), VolumeFrom::READ_ONLY));
                        continue;
                    }
                    $service->addVolumeFrom(new VolumeFrom(strtolower($volume[0]), strtolower($volume[1]), VolumeFrom::READ_WRITE));
                    continue;
                }else if(count($volume) == 2) {
                    $service->addVolumeFrom(new VolumeFrom(strtolower($volume[0]), strtolower($volume[1])));
                    continue;
                }
                $service->addVolumeFrom(new VolumeFrom(strtolower($volume[0]), strtolower($volume[0])));
            }
        }

        if(isset($serviceArr['commands'])) {
            if(isset($serviceArr['commands']['create'])) {
                foreach ($serviceArr['commands']['create'] as $item) {
                    $service->addCreateCommand(new Command($item));
                }
            }
            if(isset($serviceArr['commands']['update'])) {
                foreach ($serviceArr['commands']['update'] as $item) {
                    $service->addUpdateCommand(new Command($item));
                }
            }
            if(isset($serviceArr['commands']['backup'])) {
                foreach ($serviceArr['commands']['backup'] as $item) {
                    $service->addBackupCommand(new Command($item));
                }
            }
        }
        
        

        if(isset($serviceArr['environment'])) {
            foreach ($serviceArr['environment'] as $key => $item) {
                if(strpos($item, '=') === false) {
                    $service->addEnvVar(new EnvVar($key, $item));
                    continue;
                }
                $item = explode("=", $item);
                $service->addEnvVar(new EnvVar($item[0], $item[1]));
            }
        }

        $this->services[] = $service;
    }

    private function depResolve() {

        $sorter = new GroupedStringSort();

        /** @var Service $service */
        foreach($this->getServices() as $service) {
            $sorter->add($service->getName(), $service->getName(), $service->getEdges());
        }

        $sortiert = $sorter->sort();

        usort($this->services, function($key1, $key2) use ($sortiert) {
            if((array_search($key1->getName(), $sortiert) > array_search($key2->getName(), $sortiert))) {
                return 1;
            }
            return -1;
        });

    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return \ArrayIterator
     */
    public function getServices()
    {
        return $this->services;
    }
}