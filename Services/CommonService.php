<?php
/**
 * CommonService.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-16/7/5 WIZ TECHNOLOGY
 * @link      http://wizmacau.com
 * @link      https://jacklam.it
 * @link      https://github.com/lamjack
 * @version
 */
namespace Wiz\QiniuBundle\Services;

use Wiz\CoreBundle\Traits\ContainerServiceTrait;

/**
 * Class CommonService
 * @package Wiz\QiniuBundle\Services
 */
class CommonService
{
    use ContainerServiceTrait;

    /**
     * 获取资源的URI地址
     *
     * @param string $path
     *
     * @return string
     */
    public function getResourceUri($path)
    {
        $domain = $this->container->getParameter('wiz_qiniu.domain');
        if (strpos($path, 'http://') === false && strpos($path, 'https://') === false) {
            return $domain . $path;
        } else {
            return $path;
        }
    }
}