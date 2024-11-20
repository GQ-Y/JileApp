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
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Plugin\Cms\Model\Advertisement\JileappCmsAdvertisement;
use Plugin\Cms\Model\Article\JileappCmsArticle;
use Plugin\Cms\Model\Categorie\JileappCmsCategorie;
use Plugin\Cms\Model\Position\JileappCmsAdPosition;
use Plugin\Cms\Model\Snippets\JileappCmsSnippet;

#[Controller(prefix: 'api/cms/v1')]
class ApiController extends Base
{
    /**
     * 获取CMS变量内容.
     */
    #[RequestMapping(path: 'snippets/{code}', methods: 'get,post')]
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
    #[RequestMapping(path: 'ad/{code}', methods: 'get,post')]
    public function getAd(string $code): Result
    {
        if (empty($code)) {
            return $this->error('广告代码不能为空');
        }
        $ad = JileappCmsAdPosition::query()
            ->where('code_title', $code)
            ->where('status_switch', 1)
            ->first();
        if (! $ad) {
            return $this->error('广告位不存在或未启用');
        }
        $ad_vertisement = JileappCmsAdvertisement::query()
            ->where('position_id', $ad->id)
            ->where('status_switch', 1)
            ->get();
        // 通过广告位id获取广告内容
        return $this->success([
            $ad_vertisement,
        ]);
    }

    #[RequestMapping(path: 'categorie', methods: 'get,post')]
    public function getCategorie()
    {
        $categorie = JileappCmsCategorie::query()
            ->where('status_switch', '1')
            ->get();
        return $this->success([
            $categorie,
        ]);
    }

    //  获取分组下的文章
    #[RequestMapping(path: 'article', methods: 'get,post')]
    public function article(RequestInterface $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->error('分组id不能为空');
            $categories = JileappCmsCategorie::query()->where('id', $id)->where('status_switch', 1)->first();
            if (! $categories) {
                return $this->error('分组不存在或未启用');
            }
        }
        $article = JileappCmsArticle::query()
            ->where('category_id', $request->input('id'))
            ->where('status', 1)
            ->get();
        return $this->success([
            $article,
        ]);
    }
}
