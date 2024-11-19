@php use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator @endphp
@php /** @var CodeGenerator $codeGenerator */ @endphp
@php

    echo '<?php'.PHP_EOL;
    echo PHP_EOL;
    echo 'namespace App\\Http\\Admin\\Request\\'.$codeGenerator->getPackageName() .';' . PHP_EOL;
    echo PHP_EOL;
    echo 'use Hyperf\Validation\Request\FormRequest;';
    echo PHP_EOL;
    echo PHP_EOL;
@endphp

class {{$codeGenerator->getName()}}Request extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [@foreach($codeGenerator->fields as $field)
                @if($field->is_required)

            '{{$field->name}}' => 'required',@endif
            @endforeach

        ];
    }

    public function attributes(): array
    {
        return [@foreach($codeGenerator->fields as $field)'{{$field->name}}' => '{{$field->comment}}',@endforeach];
    }

}