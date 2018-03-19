<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 20.10.17
 * Time: 22:49
 */

namespace Docker\Parser;


interface Parser
{

    public function parse(array $tree);

}