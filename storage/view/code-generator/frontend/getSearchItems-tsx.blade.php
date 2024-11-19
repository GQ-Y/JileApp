/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo <root@imoi.cn>
 * @Link   https://github.com/mineadmin
*/

import type { MaSearchItem } from '@mineadmin/search'

export default function getSearchItems(t: any): MaSearchItem[] {
  return [
    @foreach($codeGenerator->fields as $field)
    @if($field->is_query)
    {
      label: () => '{{$field->comment}}',
      prop: '{{$field->name}}',
      render: () => <{{$field->form_component}} />,
      @if(!empty($field->form_component_config))
      renderProps: @json($field->form_component_config, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES),
      @endif
    },
    @endif
    @endforeach
  ]
}
