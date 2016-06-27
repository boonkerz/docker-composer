<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25.06.16
 * Time: 20:51
 */

namespace Docker\Composer;


class VolumeFrom
{
    protected $source;

    protected $dest;

    public function __construct($source, $dest)
    {
        $this->source = $source;
        $this->dest = $dest;
    }

    /**
     * @return mixed
     */
    public function getDest()
    {
        return $this->dest;
    }

    /**
     * @param mixed $dest
     */
    public function setDest($dest)
    {
        $this->dest = $dest;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }
    
}