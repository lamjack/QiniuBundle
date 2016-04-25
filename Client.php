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

use Qiniu\Auth;
use Qiniu\Http\Error;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Wiz\QiniuBundle\Exception\RuntimeException;

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
     * @var Auth|null
     */
    private $_auth = null;

    /**
     * @var array
     */
    private $_bucketManagers = array();

    /**
     * @var array
     */
    private $_uploadManagers = array();

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
     * 上传文件
     *
     * @param string $bucket
     * @param string $filePath
     * @param string $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function uploadFile($bucket, $filePath, $key)
    {
        $mgr = $this->getUploadManager($bucket);
        /** @var Error $err */
        list($ret, $err) = $mgr->putFile($this->getUploadToken($bucket), $key, $filePath);
        if (null === $err) {
            return $ret;
        } else {
            throw new RuntimeException($err->message(), $err->code());
        }
    }

    /**
     * @param string $bucket
     * @param string $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function stat($bucket, $key)
    {
        $mgr = $this->getBucketManager($bucket);
        /** @var Error $err */
        list($ret, $err) = $mgr->stat($bucket, $key);
        if (null === $err) {
            return $ret;
        } else {
            throw new RuntimeException($err->message(), $err->code());
        }
    }

    /**
     * @param string $bucket
     *
     * @return string
     */
    public function getUploadToken($bucket)
    {
        return $this->getAuth()->uploadToken($bucket);
    }

    /**
     * @return Auth
     */
    public function getAuth()
    {
        if (null === $this->_auth)
            $this->_auth = new Auth($this->accessKey, $this->secretKey);
        return $this->_auth;
    }

    /**
     * @param string $bucket
     *
     * @return UploadManager
     */
    protected function getUploadManager($bucket)
    {
        if (!array_key_exists($bucket, $this->_uploadManagers)) {
            $this->_uploadManagers[$bucket] = new UploadManager();
        }
        return $this->_uploadManagers[$bucket];
    }

    /**
     * @param string $bucket
     *
     * @return BucketManager
     */
    protected function getBucketManager($bucket)
    {
        if (!array_key_exists($bucket, $this->_bucketManagers)) {
            $this->_bucketManagers[$bucket] = new BucketManager($this->getAuth());
        }
        return $this->_bucketManagers[$bucket];
    }
}