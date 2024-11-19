<?php

namespace Plugin\MineAdmin\CodeGenerator;

use Hyperf\Command\Concerns\InteractsWithIO;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

class UninstallScript {

    use InteractsWithIO;

    public function __construct()
    {
        global $argv;
        $this->input = new ArrayInput($argv);
        $this->output = new SymfonyStyle($this->input,new ConsoleOutput());
    }

    public function __invoke(){
        $this->output->success('即将卸载代码生成器插件、将会进行以下文件更改，请确认无误后继续：');
    }

}