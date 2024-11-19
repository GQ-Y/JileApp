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

namespace Plugin\Cms\Service\Advertisement;

use App\Service\IService;
use Plugin\Cms\Repository\Advertisement\JileappCmsAdvertisementRepository;

/**
 * 广告表服务类
 */
final class JileappCmsAdvertisementService extends IService
{
    public function __construct(
        protected readonly JileappCmsAdvertisementRepository $repository
    ) {}
}