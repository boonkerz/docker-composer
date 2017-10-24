<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25.06.16
 * Time: 19:13
 */

namespace Docker\Composer\Service;


class EnvVar
{

    protected $name;

    protected $value;

    public function __construct($name, $value)
    {
        $this->setName($name);
        $this->setValue($value);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}