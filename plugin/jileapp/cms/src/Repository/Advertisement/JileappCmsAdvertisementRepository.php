<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

namespace Plugin\Cms\Repository\Advertisement;

use App\Repository\IRepository;
use Hyperf\Database\Model\Builder;
use Plugin\Cms\Model\Advertisement\JileappCmsAdvertisement;

/**
 * 广告表 Repository类
 */
class JileappCmsAdvertisementRepository extends IRepository
{
   public function __construct(
        protected readonly JileappCmsAdvertisement $model
    ) {}

    /**
     * 搜索处理器
     * @param Builder $query
     * @param array $params
     * @return Builder
     */
    public function handleSearch(Builder $query, array $params): Builder
    {
        
        // id
        if (isset($params['id']) && filled($params['id'])) {
            $query->where('id', '=', $params['id']);
        }

        // 广告标题
        if (isset($params['title_title']) && filled($params['title_title'])) {
            $query->where('title_title', 'like', '%'.$params['title_title'].'%');
        }

        // 广告位ID
        if (isset($params['position_id']) && filled($params['position_id'])) {
            $query->where('position_id', '=', $params['position_id']);
        }

        // 类型
        if (isset($params['type_radio']) && filled($params['type_radio'])) {
            $query->where('type_radio', '=', $params['type_radio']);
        }

        // 内容
        if (isset($params['textarea']) && filled($params['textarea'])) {
            $query->where('textarea', 'like', '%'.$params['textarea'].'%');
        }

        // 图片上传
        if (isset($params['content_image']) && filled($params['content_image'])) {
            $query->where('content_image', '=', $params['content_image']);
        }

        // 视频上传
        if (isset($params['video_file']) && filled($params['video_file'])) {
            $query->where('video_file', '=', $params['video_file']);
        }

        // 链接地址
        if (isset($params['url_title']) && filled($params['url_title'])) {
            $query->where('url_title', 'like', '%'.$params['url_title'].'%');
        }

        // 开始时间
        if (isset($params['start_time']) && filled($params['start_time']) && is_array($params['start_time']) && count($params['start_time']) == 2) {
            $query->whereBetween(
                'start_time',
                [ $params['start_time'][0], $params['start_time'][1] ]
            );
        }

        // 结束时间
        if (isset($params['end_time']) && filled($params['end_time']) && is_array($params['end_time']) && count($params['end_time']) == 2) {
            $query->whereBetween(
                'end_time',
                [ $params['end_time'][0], $params['end_time'][1] ]
            );
        }

        // 开关
        if (isset($params['status_switch']) && filled($params['status_switch'])) {
            $query->where('status_switch', 'like', '%'.$params['status_switch'].'%');
        }

        // 排序
        if (isset($params['sort']) && filled($params['sort'])) {
            $query->where('sort', '=', $params['sort']);
        }

        // 创建者
        if (isset($params['created_by']) && filled($params['created_by'])) {
            $query->where('created_by', '=', $params['created_by']);
        }

        // 更新者
        if (isset($params['updated_by']) && filled($params['updated_by'])) {
            $query->where('updated_by', '=', $params['updated_by']);
        }

        // 创建时间
        if (isset($params['created_at']) && filled($params['created_at']) && is_array($params['created_at']) && count($params['created_at']) == 2) {
            $query->whereBetween(
                'created_at',
                [ $params['created_at'][0], $params['created_at'][1] ]
            );
        }

        // 更新时间
        if (isset($params['updated_at']) && filled($params['updated_at']) && is_array($params['updated_at']) && count($params['updated_at']) == 2) {
            $query->whereBetween(
                'updated_at',
                [ $params['updated_at'][0], $params['updated_at'][1] ]
            );
        }

        // 删除时间
        if (isset($params['deleted_at']) && filled($params['deleted_at']) && is_array($params['deleted_at']) && count($params['deleted_at']) == 2) {
            $query->whereBetween(
                'deleted_at',
                [ $params['deleted_at'][0], $params['deleted_at'][1] ]
            );
        }

        return $query;
    }
}