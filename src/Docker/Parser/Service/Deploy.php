<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 20.10.17
 * Time: 22:49
 */

namespace Docker\Parser\Service;

use Docker\Composer\Network;
use Docker\Parser\Parser;
use Docker\Parser\Service\Deploy\Placement;
use Docker\Parser\Service\Deploy\RestartPolicy;

class Deploy implements Parser
{

    public function parse(array $tree): \Docker\Composer\Service\Deploy
    {
        $deploy = new \Docker\Composer\Service\Deploy();

        if(isset($tree['replicas'])) {
            $deploy->setReplicas((int)$tree['replicas']);
        }

        if(isset($tree['mode'])) {
            if($tree['mode'] == \Docker\Composer\Service\Deploy::MODE_GLOBAL || $tree['mode'] == \Docker\Composer\Service\Deploy::MODE_REPLICATED) {
                $deploy->setMode($tree['mode']);
            }
        }

        if(isset($tree['restart_policy'])) {
            $deploy->setRestartPolicy((new RestartPolicy())->parse($tree['restart_policy']));
        }

        if(isset($tree['placement'])) {
            $deploy->setPlacement((new Placement())->parse($tree['placement']));
        }

        return $deploy;
    }
}