<?php

declare(strict_types=1);
/**
 * This file is part of MineAdmin.
 *
 * @link     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */

namespace Plugin\Cms;

use Hyperf\Command\Concerns\InteractsWithIO;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
class UninstallScript
{
    use InteractsWithIO;


    public function __construct()
    {
        global $argv;
        $this->input = new ArrayInput($argv);
        $this->output = new SymfonyStyle($this->input, new ConsoleOutput());
    }

    public function __invoke()
    {
        $this->output->success('即将卸载CMS内容管理插件、将会进行以下文件更改,请稍等');
        $this->table(['文件', '操作'], [
            ['CMS内容管理插件菜单', '删除'],
        ]);
        $this->output->success('卸载CMS内容管理插件成功');
    }
}
