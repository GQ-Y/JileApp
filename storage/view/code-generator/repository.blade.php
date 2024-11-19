@php use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator ;use Plugin\MineAdmin\CodeGenerator\Model\Enums\SearchTypeEnum@endphp
@php /** @var CodeGenerator $codeGenerator */ @endphp
@php

    echo '<?php'.PHP_EOL;
    echo PHP_EOL;
    echo 'namespace App\\Repository\\'.$codeGenerator->getPackageName() .';' . PHP_EOL;
    echo PHP_EOL;
    echo 'use App\Repository\IRepository;';
    echo PHP_EOL;
    echo 'use App\Model\\'.$codeGenerator->getPackageName() .'\\'.$codeGenerator->getName().' as Model;';
    echo PHP_EOL;
    echo 'use Hyperf\Database\Model\Builder;';
    echo PHP_EOL;
    echo PHP_EOL;
@endphp

class {{$codeGenerator->getName()}}Repository extends IRepository
{
    public function __construct(
        protected readonly Model $model
    ) {}

    public function handleSearch(Builder $query, array $params): Builder
    {
        @foreach($codeGenerator->fields as $field)
            @if($field->is_query)
                @switch($field->query_type)
                    @case(SearchTypeEnum::EQ)

        if (isset($params['{{$field->name}}'])) {
            $query->where('{{$field->name}}', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::LIKE)

        if (isset($params['{{$field->name}}'])) {
            $query->where('{{$field->name}}', 'like', '%'.$params['{{$field->name}}'].'%');
        }
                    @break
                    @case(SearchTypeEnum::IN)

        if (isset($params['{{$field->name}}'])) {
            $query->whereIn('{{$field->name}}', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::NOT_IN)

        if (isset($params['{{$field->name}}'])) {
            $query->whereNotIn('{{$field->name}}', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::BETWEEN)

        if (isset($params['{{$field->name}}'])) {
            $query->whereBetween('{{$field->name}}', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::NOT_BETWEEN)

        if (isset($params['{{$field->name}}'])) {
            $query->whereNotBetween('{{$field->name}}', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::GT)

        if (isset($params['{{$field->name}}'])) {
            $query->where('{{$field->name}}', '>', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::LT)

        if (isset($params['{{$field->name}}'])) {
            $query->where('{{$field->name}}', '<', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::LE)

        if (isset($params['{{$field->name}}'])) {
            $query->where('{{$field->name}}', '<=', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::GE)

        if (isset($params['{{$field->name}}'])) {
            $query->where('{{$field->name}}', '>=', $params['{{$field->name}}']);
        }
                    @break
                    @case(SearchTypeEnum::NE)

        if (isset($params['{{$field->name}}'])) {
            $query->where('{{$field->name}}', '!=', $params['{{$field->name}}']);
        }
                    @break
        @case(SearchTypeEnum::IS_NULL)

        if (isset($params['{{$field->name}}'])) {
            $query->whereNull('{{$field->name}}');
        }
                    @break
                    @case(SearchTypeEnum::IS_NULL)

        if (isset($params['{{$field->name}}'])) {
            $query->whereNotNull('{{$field->name}}');
        }
                    @break
                    @default
                        @break
                @endswitch
            @endif
        @endforeach

        return $query;
    }
}
