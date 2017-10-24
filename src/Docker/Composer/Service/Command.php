<?php
namespace Docker\Composer\Service;


class Command
{
    protected $exec = '';

    public function __construct($exec)
    {
        $this->exec = $exec;
    }

    /**
     * @return string
     */
    public function getExec()
    {
        return $this->exec;
    }

    /**
     * @param string $exec
     */
    public function setExec($exec)
    {
        $this->exec = $exec;
    }

}