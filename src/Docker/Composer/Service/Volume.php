<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25.06.16
 * Time: 20:51
 */

namespace Docker\Composer\Service;


class Volume
{
    const RO = 'ro';
    const RW = 'rw';

    const VOLUME = 'volume';
    const BIND = 'bind';

    protected $source;

    protected $dest;

    protected $mode = Volume::RW;

    protected $type = Volume::VOLUME;

    protected $backup = false;

    public function __construct($source, $dest, $mode = Volume::RW, $backup = false)
    {
        $this->setSource($source);
        $this->setDest($dest);
        $this->setBackup($backup);
        $this->setMode($mode);
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

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param int $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return boolean
     */
    public function isBackup()
    {
        return $this->backup;
    }

    /**
     * @param boolean $backup
     */
    public function setBackup($backup)
    {
        $this->backup = $backup;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }


}