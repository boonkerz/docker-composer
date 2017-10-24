<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25.06.16
 * Time: 20:51
 */

namespace Docker\Composer\Service;


class Port
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
     * Is HTTP?
     *
     * @return bool
     */
    public function isHttp() {
        return ($this->getDest() == '80');
    }

    /**
     * Is HTTPS?
     *
     * @return bool
     */
    public function isHttps() {
        return ($this->getDest() == '443');
    }
}