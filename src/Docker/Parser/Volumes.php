<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 20.10.17
 * Time: 22:49
 */

namespace Docker\Parser;


use Docker\Composer\Volume;

class Volumes implements Parser
{

    private $volumes = [];

    public function parse(array $tree): array
    {
        if(!isset($tree['volumes'])) {
            return [];
        }

        foreach($tree['volumes'] as $name => $volumeArr) {
            $this->parseVolumes($name, $volumeArr);
        }

        return $this->volumes;
    }

    private function parseVolumes($name, $volumeArr)
    {
        $temp = new Volume($name);

        if(isset($volumeArr['driver'])) {
            $temp->setDriver($volumeArr['driver']);
        }
        if(isset($volumeArr['external']) && !is_array($volumeArr['external'])) {
            $temp->setExternal($volumeArr['external']);
        }
        if(isset($volumeArr['external']) && is_array($volumeArr['external']) && isset($volumeArr['external']['name'])) {
            $temp->setExternal(true);
            $temp->setExternalName($volumeArr['external']['name']);
        }

        $this->volumes[] = $temp;

    }
}