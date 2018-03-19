<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25.06.16
 * Time: 20:51
 */

namespace Docker\Composer\Service\Deploy;

class Placement
{

    private $constraints = [];

    private $preferences = [];

    /**
     * @return array
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }

    /**
     * @param array $constraints
     */
    public function setConstraints(array $constraints)
    {
        $this->constraints = $constraints;
    }

    /**
     * @return array
     */
    public function getPreferences(): array
    {
        return $this->preferences;
    }

    /**
     * @param array $preferences
     */
    public function setPreferences(array $preferences)
    {
        $this->preferences = $preferences;
    }

}