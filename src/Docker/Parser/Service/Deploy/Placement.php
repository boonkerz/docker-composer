<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 20.10.17
 * Time: 22:49
 */

namespace Docker\Parser\Service\Deploy;

use Docker\Composer\Network;
use Docker\Parser\Parser;

class Placement implements Parser
{

    public function parse(array $tree): \Docker\Composer\Service\Deploy\Placement
    {
        $placement = new \Docker\Composer\Service\Deploy\Placement();

        if(isset($tree['constraints']) && is_array($tree['constraints'])) {

            $temp = [];
            foreach ($tree['constraints'] as $row) {
                $item = explode('==', $row);
                $temp[trim($item[0])] = trim($item[1]);
            }
            $placement->setConstraints($temp);
        }

        if(isset($tree['preferences']) && is_array($tree['preferences'])) {
            $temp = [];
            foreach ($tree['preferences'] as $row) {
                foreach($row as $key => $item) {
                    $temp[$key] = trim($item);
                }
            }

            $placement->setPreferences($temp);
        }

        return $placement;
    }
}