<?php

namespace Plugin\MineAdmin\CodeGenerator\Repository;

use App\Repository\IRepository;
use Hyperf\Collection\Arr;
use Hyperf\Database\Model\Builder;
use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;

final class Repository extends IRepository
{
    public function __construct(
        protected readonly CodeGenerator $model
    ){}

    public function handleSearch(Builder $query, array $params): Builder
    {
        return $query->when(Arr::get($params,'databaseConnection'),function (Builder $query,$databaseConnection){
            return $query->where('database_connection',$databaseConnection);
        })->when(Arr::get($params,'tableName'),function (Builder $query,$tableName){
            return $query->where('table_name',$tableName);
        });
    }
}