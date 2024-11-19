<?php

namespace Plugin\MineAdmin\CodeGenerator;

use Hyperf\Command\Concerns\InteractsWithIO;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ApplicationInterface;
use Mine\Support\Filesystem;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallScript {

    use InteractsWithIO;

    public function __construct()
    {
        global $argv;
        $this->input = new ArrayInput($argv);
        $this->output = new SymfonyStyle($this->input,new ConsoleOutput());
    }

    public function __invoke(){

        $this->info('即将安装代码生成器插件、将会进行以下文件更改，请确认无误后继续：');
        $this->table(['文件', '操作'], [
            [BASE_PATH.'/storage/languages', '复制'],
            [BASE_PATH.'/storage/view/code-generator', '复制'],
        ]);

        $app = ApplicationContext::getContainer()->get(ApplicationInterface::class);
        $app->setAutoExit(false);
        $input = new ArrayInput([
            'vendor:publish',
            'package'=>'hyperf/view-engine',
            '--force'   =>  true,
        ]);
        $app->run($input,new ConsoleOutput());

        Filesystem::copy(
            dirname(__DIR__) . '/languages',
            BASE_PATH.'/storage/languages',
            false
        );
        Filesystem::copy(
            dirname(__DIR__) . '/publish/template',
            BASE_PATH.'/storage/view/code-generator',
            false
        );
    }

}