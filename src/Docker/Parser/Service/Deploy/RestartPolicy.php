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

class RestartPolicy implements Parser
{

    public function parse(array $tree): \Docker\Composer\Service\Deploy\RestartPolicy
    {
        $restartPolicy = new \Docker\Composer\Service\Deploy\RestartPolicy();

        if(isset($tree['condition'])) {
            if($tree['condition'] == \Docker\Composer\Service\Deploy\RestartPolicy::CONDITION_ANY ||
                $tree['condition'] == \Docker\Composer\Service\Deploy\RestartPolicy::CONDITION_ON_FAILURE ||
                $tree['condition'] == \Docker\Composer\Service\Deploy\RestartPolicy::CONDITION_NONE
            ) {
                $restartPolicy->setCondition($tree['condition']);
            }
        }

        if(isset($tree['delay'])) {
            $restartPolicy->setDelay((int)preg_replace("/[^0-9,.]/", "", $tree['delay']));
        }

        if(isset($tree['max_attempts'])) {
            $restartPolicy->setMaxAttempts($tree['max_attempts']);
        }

        if(isset($tree['window'])) {
            $restartPolicy->setWindow((int)preg_replace("/[^0-9,.]/", "", $tree['window']));
        }

        return $restartPolicy;
    }
}