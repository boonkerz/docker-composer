<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25.06.16
 * Time: 20:51
 */

namespace Docker\Composer;


class Volume
{
    protected $source;

    protected $dest;

    public function __construct($source, $dest)
    {
        $this->setSource($source);
        $this->setDest($dest);
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

    /**
     * Is Relativ?
     *
     * @return bool
     */
    public function isRelativ() {
        return (
            $this->getSource() == '.' ||
            substr($this->getSource(), 0, 2) == './'
        );
    }
    
    
}