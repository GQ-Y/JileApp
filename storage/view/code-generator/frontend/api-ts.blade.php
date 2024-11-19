@php
    use Plugin\MineAdmin\CodeGenerator\Model\CodeGenerator;
    use Hyperf\Stringable\Str;
    /**
     *   @var CodeGenerator $codeGenerator
     */
@endphp
import type { ResponseStruct } from '#/global'

export interface {{ $codeGenerator->getName() }}Vo {
@foreach($codeGenerator->fields as $field)
  // {{$field->comment}}
  {{ $field->name }}: {{ stripos($field->type, 'int') < 1 ? 'string' : 'number' }}
@endforeach
}

// {{$codeGenerator->menu_name}}查询
export function page(params: {{ $codeGenerator->getName() }}Vo): Promise<ResponseStruct<{{$codeGenerator->getName()}}Vo[]>> {
  return useHttp().get('/admin/{{Str::snake($codeGenerator->getPackageName())}}/{{Str::snake($codeGenerator->getName())}}/list', { params })
}

// {{$codeGenerator->menu_name}}新增
export function create(data: {{ $codeGenerator->getName() }}Vo): Promise<ResponseStruct<null>> {
  return useHttp().post('/admin/{{Str::snake($codeGenerator->getPackageName())}}/{{Str::snake($codeGenerator->getName())}}', data)
}

// {{$codeGenerator->menu_name}}编辑
export function save(id: number, data: {{ $codeGenerator->getName() }}Vo): Promise<ResponseStruct<null>> {
  return useHttp().put(`/admin/{{Str::snake($codeGenerator->getPackageName())}}/{{Str::snake($codeGenerator->getName())}}/${id}`, data)
}

// {{$codeGenerator->menu_name}}删除
export function deleteByIds(ids: number[]): Promise<ResponseStruct<null>> {
  return useHttp().delete('/admin/{{Str::snake($codeGenerator->getPackageName())}}/{{Str::snake($codeGenerator->getName())}}', { data: ids })
}