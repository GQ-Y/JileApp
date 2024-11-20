<?php

declare(strict_types=1);
/**
 * This file is part of MineAdmin.
 *
 * @link     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */

namespace Plugin\Cms\Http\Controller;

use App\Http\Common\Controller\AbstractController as Base;
use App\Http\Common\Result;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\Swagger\Annotation as OA;
use Plugin\Cms\Model\Advertisement\JileappCmsAdvertisement;
use Plugin\Cms\Model\Position\JileappCmsAdPosition;
use Plugin\Cms\Model\Snippets\JileappCmsSnippet;

#[Controller(prefix: 'api/cms/v1')]
class ApiController extends Base
{
    /**
     * 获取CMS变量内容.
     */
    #[GetMapping(path: 'snippets/{code}')]
    #[OA\Get(
        path: '/api/cms/v1/snippets/{code}',
        summary: '获取CMS变量内容',
        tags: ['cms'],
        parameters: [
            new OA\Parameter(
                name: 'code',
                description: '变量代码',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            ),
        ]
    )]
    #[OA\Response(
        response: 200,
        description: '成功',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'code', type: 'integer', example: 200),
                new OA\Property(property: 'message', type: 'string', example: '操作成功'),
                new OA\Property(property: 'data', type: 'object'),
            ]
        )
    )]
    public function getSnippet(string $code): Result
    {
        if (empty($code)) {
            return $this->error('变量代码不能为空');
        }

        $snippet = JileappCmsSnippet::query()
            ->where('code', $code)
            ->where('status', 1)
            ->first();

        if (! $snippet) {
            return $this->error('变量不存在或未启用');
        }

        return $this->success([
            'content' => $snippet->content,
        ]);
    }

    //  获取广告内容
    #[GetMapping(path: 'ad/{code}')]
    public function getAd(string $code): Result
    {
        if (empty($code)) {
            return $this->error('广告代码不能为空');
        }
        $ad = JileappCmsAdPosition::query()
            ->where('code', $code)
            ->where('status', 1)
            ->first();
        if (! $ad) {
            return $this->error('广告位不存在或未启用');
        }
        $ad_vertisement = JileappCmsAdvertisement::query()
            ->where('ad_position_id', $ad->id)
            ->where('status', 1)
            ->get();
        // 通过广告位id获取广告内容
        return $this->success([
            $ad_vertisement,
        ]);
    }
}
