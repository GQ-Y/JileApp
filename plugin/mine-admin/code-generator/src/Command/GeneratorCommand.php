<?php

namespace Plugin\MineAdmin\CodeGenerator\Command;

use Hyperf\Command\Command;
use Hyperf\Command\Annotation\Command as CommandAnnotation;
use Hyperf\DbConnection\Db;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

//#[CommandAnnotation]
final class GeneratorCommand extends Command
{
    protected ?string $name = 'mine-admin:generator';

    protected function configure()
    {
        $this->setDescription('Generate code');
        $this->addArgument('table', InputArgument::REQUIRED, 'Table name');
        $this->addOption('database_connection', 'd', InputArgument::OPTIONAL, 'Database connection', 'default');
        $this->addOption('package_name', 'p', InputArgument::OPTIONAL, 'Package name', null);
        $this->addOption('gen_menu', 'g', InputArgument::OPTIONAL, 'Generate menu', false);
        $this->addOption('menu_name', 'm', InputArgument::OPTIONAL, 'Menu name', null);
        $this->addOption('menu_id', 'i', InputArgument::OPTIONAL, 'Menu identifier', null);
        $this->addOption('menu_parent_id', 't', InputArgument::OPTIONAL, 'Parent menu ID', null);
        $this->addOption('field','field',InputOption::VALUE_IS_ARRAY,'Field Configuration',[]);
        $this->addOption('search_field','search_field',InputOption::VALUE_IS_ARRAY,'Search Field Configuration',[]);
        $this->addOption('show_field','show_field',InputOption::VALUE_IS_ARRAY,'Show Field Configuration',[]);
        $this->addOption('form_field','form_field',InputOption::VALUE_IS_ARRAY,'Form Field Configuration',[]);
    }

    public function __invoke()
    {
        $builder = Db::connection($this->input->getOption('database_connection'))->getSchemaBuilder();
        $fields = $this->input->getOption('field');
        $searchFields = $this->input->getOption('search_field');
        $showFields = $this->input->getOption('show_field');
        $formFields = $this->input->getOption('form_field');
        $table = $this->input->getArgument('table');
        $package = $this->input->getOption('package_name');
        $menuName = $this->input->getOption('menu_name');
        $menuId = $this->input->getOption('menu_id');
        $menuParentId = $this->input->getOption('menu_parent_id');
        $tableFields = $builder->getConnection()->getDoctrineSchemaManager()->listTableColumns($table);
        $columns = [];
        $genMenu = $this->input->getOption('gen_menu');
        foreach ($tableFields as $field){
            $fieldOption = explode(',',$field);
            $columns[] = [
                'name' => $fieldOption[0],
                'form_type' => $fieldOption[1],
            ];
        }
        $this->line(json_encode($columns));

    }
}