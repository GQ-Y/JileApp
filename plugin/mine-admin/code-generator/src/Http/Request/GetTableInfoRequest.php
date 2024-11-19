<?php

namespace Plugin\MineAdmin\CodeGenerator\Http\Request;

use Hyperf\Validation\Request\FormRequest;

final class GetTableInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'table_name' => 'required|string',
            'database_connection' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'table_name' => trans('code-generator.table_name'),
            'database_connection' => trans('code-generator.database_connection'),
        ];
    }

}