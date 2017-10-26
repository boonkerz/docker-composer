<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 20.10.17
 * Time: 22:49
 */

namespace Docker\Parser;

use Docker\Composer\Network;

class Networks implements Parser
{

    private $networks = [];

    public function parse(array $tree): array
    {
        if(!isset($tree['networks'])) {
            return [];
        }

        foreach($tree['networks'] as $name => $networkArr) {
            $this->parseNetworks($name, $networkArr);
        }

        return $this->networks;
    }

    private function parseNetworks($name, $networkArr)
    {
        $temp = new Network($name);

        if(isset($networkArr['driver'])) {
            $temp->setDriver($networkArr['driver']);
        }
        if(isset($networkArr['external']) && !is_array($networkArr['external'])) {
            $temp->setExternal($networkArr['external']);
        }
        if(isset($volumeArr['external']) && is_array($networkArr['external']) && isset($networkArr['external']['name'])) {
            $temp->setExternal(true);
            $temp->setExternalName($networkArr['external']['name']);
        }

        $this->networks[] = $temp;

    }
}