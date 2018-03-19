<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25.06.16
 * Time: 20:51
 */

namespace Docker\Composer\Service;


use Docker\Composer\Service\Deploy\Placement;
use Docker\Composer\Service\Deploy\RestartPolicy;

class Deploy
{
    const MODE_GLOBAL = 'global';
    const MODE_REPLICATED = 'replicated';

    /** @var string  */
    private $mode = 'replicated';

    /** @var int */
    private $replicas = 1;

    /** @var RestartPolicy */
    private $restartPolicy;

    /** @var Placement */
    private $placement;

    public function __construct()
    {
        $this->restartPolicy = new RestartPolicy();
        $this->placement = new Placement();
    }

    /**
     * @return RestartPolicy
     */
    public function getRestartPolicy(): RestartPolicy
    {
        return $this->restartPolicy;
    }

    /**
     * @param RestartPolicy $restartPolicy
     */
    public function setRestartPolicy(RestartPolicy $restartPolicy)
    {
        $this->restartPolicy = $restartPolicy;
    }

    /**
     * @return int
     */
    public function getReplicas(): int
    {
        return $this->replicas;
    }

    /**
     * @param int $replicas
     */
    public function setReplicas(int $replicas)
    {
        $this->replicas = $replicas;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     */
    public function setMode(string $mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return Placement
     */
    public function getPlacement(): Placement
    {
        return $this->placement;
    }

    /**
     * @param Placement $placement
     */
    public function setPlacement(Placement $placement)
    {
        $this->placement = $placement;
    }

}