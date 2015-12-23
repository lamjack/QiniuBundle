<?php
/**
 * Client.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <linjue@wilead.com>
 * @copyright 2007-15/12/23 WIZ TECHNOLOGY
 * @link      http://wizmacau.com
 * @link      http://jacklam.it
 * @link      https://github.com/lamjack
 * @version
 */

namespace Wiz\QiniuBundle;

use Qiniu\Qiniu;
use Qiniu\Client as QiniuClient;

/**
 * Class Client
 * @package Wiz\QiniuBundle
 */
class Client
{
    /**
     * @var string
     */
    protected $accessKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * @var array
     */
    private $_bucketCache = array();

    /**
     * Client constructor.
     *
     * @param string $accessKey
     * @param string $secretKey
     */
    public function __construct($accessKey, $secretKey)
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    /**
     * @param string $name
     *
     * @return QiniuClient
     */
    public function getBucket($name)
    {
        if (!array_key_exists($name, $this->_bucketCache)) {
            $this->_bucketCache[$name] = Qiniu::create(array(
                'access_key' => $this->accessKey,
                'secret_key' => $this->secretKey,
                'bucket' => $name
            ));
        }
        return $this->_bucketCache[$name];
    }
}