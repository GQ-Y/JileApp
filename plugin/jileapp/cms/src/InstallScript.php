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
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ApplicationInterface;
use Mine\Support\Filesystem;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Plugin\Cms\Database\Seeder\JileappCmsAdPosition_seeder_20241120;
use Plugin\Cms\Database\Seeder\JileappCmsSnippets_seeder_20241120;
use Hyperf\Database\Migrations\Migrator;

class InstallScript
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
        $this->output->success('即将安装CMS内容管理插件、将会进行以下文件更改,请稍等');
        $this->table(['文件', '操作'], [
            [BASE_PATH . '/storage/languages', '复制'],
            [BASE_PATH . '/storage/view/cms', '复制'],
        ]);

        $app = ApplicationContext::getContainer()->get(ApplicationInterface::class);
        $app->setAutoExit(false);
        //        $input = new ArrayInput([]);
        //        $app->run($input, new ConsoleOutput());

        Filesystem::copy(
            \dirname(__DIR__) . '/languages',
            BASE_PATH . '/storage/languages',
            false
        );

        // 执行表创建
        $migrator = ApplicationContext::getContainer()->get(Migrator::class);
        $migrator->run([BASE_PATH . '/plugin/jileapp/cms/Database/Migrations']);
        
        // 执行数据填充
        $seeder = new JileappCmsAdPosition_seeder_20241120();
        $seeder->run();

        $seeder2 = new JileappCmsSnippets_seeder_20241120();
        $seeder2->run();
    }
}
