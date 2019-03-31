<?php

namespace app\rsa\controller;


/**
 * RSA签名类
 */
class Rsa
{

    public $publicKey = '';
    public $privateKey = '';
    private $_privKey;

    /**
     * * private key
     */
    private $_pubKey;

    /**
     * * public key
     */
    private $_keyPath;

    /**
     * * the keys saving path
     */

    /**
     * * the construtor,the param $path is the keys saving path
     */
    function __construct($publicKey = null, $privateKey = null)
    {
        $this->setKey($publicKey, $privateKey);
    }

    /**
     * 设置公钥和私钥
     * @param string $publicKey 公钥
     * @param string $privateKey 私钥
     */
    public function setKey($publicKey = null, $privateKey = null)
    {
        if (!is_null($publicKey))
            $this->publicKey = $publicKey;
        if (!is_null($privateKey))
            $this->privateKey = $privateKey;
    }

    /**
     * * 设置私钥key
     */
    private function setupPrivKey()
    {
        if (is_resource($this->_privKey)) {
            return true;
        }
        //是否是从文件中直接取出的
        if (strpos($this->privateKey, '-----BEGIN') !== false) {
            $this->_privKey = openssl_pkey_get_private($this->privateKey);
        } else {
            //分隔为每行64个字符的格式
            $pem = chunk_split($this->privateKey, 64, "\n");
            $pem = "-----BEGIN PRIVATE KEY-----\n" . $pem . "-----END PRIVATE KEY-----\n";
            $this->_privKey = openssl_pkey_get_private($pem);
        }

        return true;
    }

    /**
     * * 设置公钥key
     */
    private function setupPubKey()
    {
        if (is_resource($this->_pubKey)) {
            return true;
        }
        //是否是从文件中直接取出的
        if (strpos($this->publicKey, 'BEGIN') !== false) {
            $this->_pubKey = openssl_pkey_get_private($this->publicKey);
        } else {
            //分隔为每行64个字符的格式
            $pem = chunk_split($this->publicKey, 64, "\n");
            $pem = "-----BEGIN PUBLIC KEY-----\n" . $pem . "-----END PUBLIC KEY-----\n";
            $this->_pubKey = openssl_pkey_get_public($pem);
        }
        return true;
    }

    /**
     * * 私钥加密数据
     */
    public function privEncrypt($data)
    {
        if (!is_string($data)) {
            return null;
        }
        $this->setupPrivKey();
        $r = openssl_private_encrypt($data, $encrypted, $this->_privKey);
        if ($r) {
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * * 私钥解密数据
     */
    public function privDecrypt($encrypted)
    {
        if (!is_string($encrypted)) {
            return null;
        }
        $this->setupPrivKey();
        $encrypted = base64_decode($encrypted);
        $r = openssl_private_decrypt($encrypted, $decrypted, $this->_privKey);
        if ($r) {
            return $decrypted;
        }
        return null;
    }

    /**
     * * 公钥加密数据
     */
    public function pubEncrypt($data)
    {
        if (!is_string($data)) {
            return null;
        }
        $this->setupPubKey();
        $r = openssl_public_encrypt($data, $encrypted, $this->_pubKey);
        if ($r) {
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * * 公钥解密数据
     */
    public function pubDecrypt($crypted)
    {
        if (!is_string($crypted)) {
            return null;
        }
        $this->setupPubKey();
        $crypted = base64_decode($crypted);
        $r = openssl_public_decrypt($crypted, $decrypted, $this->_pubKey);
        if ($r) {
            return $decrypted;
        }
        return null;
    }

    /**
     * 构造签名
     * @param string $dataString 被签名数据
     * @return string
     */
    public function sign($dataString)
    {
        $this->setupPrivKey();
        $signature = false;
        openssl_sign($dataString, $signature, $this->_privKey);
        return base64_encode($signature);
    }

    /**
     * 验证签名
     * @param string $dataString 被签名数据
     * @param string $signString 已经签名的字符串
     * @return number 1签名正确 0签名错误
     */
    public function verify($dataString, $signString)
    {
        $this->setupPubKey();
        $signature = base64_decode($signString);
        $flg = openssl_verify($dataString, $signature, $this->_pubKey);
        return $flg;
    }

    public function __destruct()
    {
        is_resource($this->_privKey) && @openssl_free_key($this->_privKey);
        is_resource($this->_pubKey) && @openssl_free_key($this->_pubKey);
    }

}
