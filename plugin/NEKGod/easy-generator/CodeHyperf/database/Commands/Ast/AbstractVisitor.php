<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace CodeHyperf\Database\Commands\Ast;

use CodeHyperf\Database\Commands\ModelData;
use CodeHyperf\Database\Commands\ModelOption;
use PhpParser\NodeVisitorAbstract;

abstract class AbstractVisitor extends NodeVisitorAbstract
{
    public function __construct(protected ModelOption $option, protected ModelData $data)
    {
    }
}
