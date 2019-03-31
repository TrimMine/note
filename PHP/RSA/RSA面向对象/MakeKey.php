<?php
/**
 * Created by PhpStorm.
 * User: cabbage
 * Date: 2019/3/18
 * Time: 2:21 PM
 */

namespace app\rsa\controller;


class MakeKey
{
    protected $config = [];
    protected $key = '';
    protected $private_key = '';
    protected $public_key = '';

    /**
     * MakeKey constructor.
     * @param string $conf
     * @param string $sha
     * @param string $key_bits
     * @param int $key_type
     * init config
     */
    public function __construct($conf = '/usr/local/openssl/openssl.cnf', $sha = 'sha512', $key_bits = '2048', $key_type = OPENSSL_KEYTYPE_RSA)
    {
        $this->config = [
            'config' => $conf,
            'digest_alg' => $sha,
            'private_key_bits' => $key_bits,
            'private_key_type' => $key_type,
        ];

    }

    /**
     * 生成公钥/私钥
     */
    public function getKeys($dir = 'keys')
    {
        try {
            dd(file_get_contents('keys/201903181643292_private.key'));
            if (!extension_loaded('openssl')) {
                throw new \Exception('请先安装openssl扩展');
            }
            //生成秘钥对
            $this->key = openssl_pkey_new($this->config);
            if (!is_resource($this->key)) {
                throw new \Exception('获取秘钥对失败');
            }
            //生成私钥
            openssl_pkey_export($this->key, $this->private_key, null, $this->config);
            if (empty($this->private_key)) {
                throw new \Exception('私钥获取失败', 201);
            }
            //生成公钥
            $pubKey = openssl_pkey_get_details($this->key);
            if (isset($pubKey['key']) && !empty($pubKey['key'])) {
                $this->public_key = $pubKey['key'];
            } else {
                throw new \Exception('公钥获取失败', 202);
            }
            //写入文件
            $data = $this->writeFile($dir);
        } catch (\Exception $e) {
            return ['status' => $e->getCode(), 'msg' => $e->getMessage()];
        }
        return ['status' => 200, 'data' => $data, 'msg' => 'success'];
    }

    /**
     * @return array
     * 写入文件
     */
    private function writeFile($dir)
    {
        if (!empty($dir) && !is_dir($dir)) {
            mkdir('./' . $dir);
        }
        $path = $dir . "/" . date('YmdHis') . mt_rand(1, 99);
        $private_path = $path . '_private.key';
        $public_path = $path . '_public.key';
        file_put_contents($private_path, $this->private_key);
        file_put_contents($public_path, $this->public_key);
        return ['public' => $public_path, 'private' => $private_path];
    }
}