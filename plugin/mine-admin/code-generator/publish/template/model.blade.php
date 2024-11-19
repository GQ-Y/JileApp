@php use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator @endphp
@php /** @var CodeGenerator $codeGenerator */ @endphp
@php

    echo '<?php'.PHP_EOL;
    echo PHP_EOL;
    echo 'namespace App\\Model\\'.$codeGenerator->getPackageName() .';' . PHP_EOL;
    echo PHP_EOL;
    echo 'use Hyperf\DbConnection\Model\Model as MineModel;';
    echo PHP_EOL;
    echo PHP_EOL;
 @endphp

/**
* Class {{$codeGenerator->table_name}}
@foreach($codeGenerator->fields as $field)
* @property {{$field['cast'] ?? 'string'}} ${{$field['name']}} {{$field['title']}}
@endforeach
*/
class {{$codeGenerator->getName()}} extends MineModel
{
    protected ?string $table = '{{$codeGenerator->table_name}}';

    protected array $fillable = [@foreach($codeGenerator->fields as $field)'{{$field['name']}}',@endforeach];

    protected array $casts = [@foreach($codeGenerator->fields as $field)'{{$field['name']}}' => '{{$field['cast'] ?? 'string'}}',@endforeach];
}