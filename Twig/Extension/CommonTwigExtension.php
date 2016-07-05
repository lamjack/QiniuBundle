<?php
/**
 * CommonTwigExtension.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-16/3/23 WIZ TECHNOLOGY
 * @link      http://wizmacau.com
 * @link      http://jacklam.it
 * @link      https://github.com/lamjack
 * @version
 */
namespace Wiz\QiniuBundle\Twig\Extension;

use Wiz\QiniuBundle\Services\CommonService;

/**
 * Class CommonTwigExtension
 * @package Wiz\QiniuBundle\Twig\Extension
 */

/**
 * Class CommonTwigExtension
 * @package Wiz\QiniuBundle\Twig\Extension
 */
class CommonTwigExtension extends \Twig_Extension
{
    /**
     * @var CommonService
     */
    private $service;

    /**
     * CommonTwigExtension constructor.
     *
     * @param CommonService $service
     */
    public function __construct(CommonService $service)
    {
        $this->service = $service;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('qiniu_attachment', array($this->service, 'getResourceUri'), ['is_safe' => ['html']])
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wiz_qiniu.twig_extension.common';
    }
}