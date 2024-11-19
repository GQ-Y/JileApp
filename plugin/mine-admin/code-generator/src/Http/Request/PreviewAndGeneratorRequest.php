<?php

namespace Plugin\MineAdmin\CodeGenerator\Http\Request;

use Hyperf\Validation\Request\FormRequest;

final class PreviewAndGeneratorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer',
        ];
    }
}