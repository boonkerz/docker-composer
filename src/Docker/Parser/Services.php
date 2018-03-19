<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 20.10.17
 * Time: 22:49
 */

namespace Docker\Parser;

use Docker\Composer\Service\Command;
use Docker\Composer\Service\EnvVar;
use Docker\Composer\Service\Link;
use Docker\Composer\Service\Port;
use Docker\Composer\Service;
use Docker\Composer\Service\Volume;
use Docker\Composer\Service\VolumeFrom;
use Docker\Parser\Service\Deploy;
use MJS\TopSort\Implementations\GroupedStringSort;

class Services implements Parser
{

    private $services = [];

    /** @var \Docker\Composer\Volume[] */
    private $volumes = [];

    private $networks = [];

    public function __construct($volumes, $networks)
    {
        $this->volumes = $volumes;
        $this->networks = $networks;
    }

    public function parse(array $tree): array
    {
        foreach($tree['services'] as $name => $serviceArr) {
            $this->parseService($name, $serviceArr);
        }

        $this->depResolve();

        return $this->services;
    }

    private function parseService($name, $serviceArr)
    {
        $service = new Service(strtolower($name));

        if(isset($serviceArr['deploy'])) {
            $service->setDeploy((new Deploy())->parse($serviceArr['deploy']));
        }

        if(isset($serviceArr['depends_on'])) {
            foreach ($serviceArr['depends_on'] as $item) {
                $service->addEdge($item);
            }
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

        if(isset($serviceArr['networks'])) {

            foreach ($serviceArr['networks'] as $item) {
                if(is_array($item)) {
                    $service->addNetwork(new Service\Network(key($item)));
                }else{
                    $service->addNetwork(new Service\Network($item));
                }
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
                if(is_array($item)) {
                    $volume = new Volume($item['source'], $item['target']);
                    if($item['type'] == Volume::BIND) {
                        $volume->setType(Volume::BIND);
                    }

                    $service->addVolume($volume);
                    continue;
                }

                $item = explode(':', $item);
                if(count($item) == 1) {
                    $volume = new Volume($item[0], $item[0]);
                }elseif(count($item) == 2) {
                    $volume = new Volume($item[0], $item[1]);
                }elseif(count($item) == 3) {
                    $volume = new Volume($item[0], $item[1], $item[2]);
                }

                $result = array_filter($this->volumes, function($var) use ($volume) {
                    return $var->getName() == $volume->getSource();
                });

                if(count($result) == 0) {
                    $volume->setType(Volume::BIND);
                }

                $service->addVolume($volume);
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
        foreach($this->services as $service) {
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
}