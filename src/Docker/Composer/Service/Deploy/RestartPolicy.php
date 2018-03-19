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

    private $delay = '0';

    private $maxAttempts = 10;

    private $window = '120s';

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
     * @return string
     */
    public function getDelay(): string
    {
        return $this->delay;
    }

    /**
     * @param string $delay
     */
    public function setDelay(string $delay)
    {
        $this->delay = $delay;
    }

    /**
     * @return string
     */
    public function getWindow(): string
    {
        return $this->window;
    }

    /**
     * @param string $window
     */
    public function setWindow(string $window)
    {
        $this->window = $window;
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
}