<?php

namespace Plugin\MineAdmin\CodeGenerator\Command;

use Hyperf\Command\Command;

abstract class AbstractGenCommand extends Command
{
    abstract public function getCommandName();
}