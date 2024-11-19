<?php

namespace Plugin\NEK\CodeGenerator\Service;

use Doctrine\DBAL\Types\Type;
use Hyperf\Database\Schema\Builder;
use Hyperf\DbConnection\Db;
use Plugin\NEK\CodeGenerator\Http\Vo\TableColumn;

final class GeneratorService
{

    public function getSchemaBuilder(string $databaseConnection): Builder
    {
        return Db::connection($databaseConnection)->getSchemaBuilder();
    }

    /**
     * @return TableColumn[]
     */
    public function getTableInfo(string $databaseConnection,string $tableName): array
    {
        $builder = $this->getSchemaBuilder($databaseConnection);
        $tableFields = $builder->getConnection()->getDoctrineSchemaManager()->listTableColumns($tableName,);
        $columns = [];
        foreach ($tableFields as $field){
            $columns[] = new TableColumn(
                $field->getName(),
                Type::lookupName($field->getType()),
                $field->getComment()
            );
        }
        return $columns;
    }
}