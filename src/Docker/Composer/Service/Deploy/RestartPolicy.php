<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 25.06.16
 * Time: 20:51
 */

namespace Docker\Composer\Service\Deploy;


class RestartPolicy
{
    const CONDITION_ANY = 'any';
    const CONDITION_ON_FAILURE = 'on-failure';
    const CONDITION_NONE = 'none';

    private $condition = 'any';

    private $delay = 0;

    private $maxAttempts = 10;

    private $window = 120;

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     */
    public function setCondition(string $condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return int
     */
    public function getMaxAttempts(): int
    {
        return $this->maxAttempts;
    }

    /**
     * @param int $maxAttempts
     */
    public function setMaxAttempts(int $maxAttempts)
    {
        $this->maxAttempts = $maxAttempts;
    }

    /**
     * @return int
     */
    public function getWindow(): int
    {
        return $this->window;
    }

    /**
     * @param int $window
     */
    public function setWindow(int $window)
    {
        $this->window = $window;
    }

    /**
     * @return int
     */
    public function getDelay(): int
    {
        return $this->delay;
    }

    /**
     * @param int $delay
     */
    public function setDelay(int $delay)
    {
        $this->delay = $delay;
    }
}