<?php
/**
 * QiniuHelper.php
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
namespace Wiz\QiniuBundle\Helper;

/**
 * Class QiniuHelper
 * @package Wiz\QiniuBundle\Helper
 */
class QiniuHelper
{
    /**
     * @var string
     */
    private $domian;

    /**
     * QiniuHelper constructor.
     *
     * @param string $domian
     */
    public function __construct(string $domian)
    {
        $this->domian = $domian;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function getFileUrl(string $key)
    {
        return sprintf('%s%s', $this->domian, $key);
    }
}