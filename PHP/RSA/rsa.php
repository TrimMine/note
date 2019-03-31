<?php
/**
 * Created by PhpStorm.
 * User: cabbage
 * Date: 2019/3/18
 * Time: 10:40 AM
 */

class Rsa
{

    public function makeKey()
    {
        //openssl文件路径
        $opensslConfigPath = "/usr/local/openssl/openssl.cnf";
        $config = [
            'config' => $opensslConfigPath,
            "digest_alg" => "sha512",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
        //创建密钥对
        $key = openssl_pkey_new($config);
        //生成私钥
        openssl_pkey_export($key, $privkey, null, $config);
        //生成公钥
        $pubKey = openssl_pkey_get_details($key)['key'];
        echo $privkey . "<hr>";
        echo $pubKey ;
//        //写入到文件或写入到数据库
        file_put_contents('private.key', $privkey);
        file_put_contents('public.key', $pubKey);


        //解密 加密

        
        $pi_key = openssl_pkey_get_private($privkey);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
        $pu_key = openssl_pkey_get_public($pubKey);//这个函数可用来判断公钥是否是可用的
        print_r($pi_key);echo "<hr>";
        print_r($pu_key);echo "<hr>";

        $data = json_encode(['a'=>'b']);//原始数据
        $encrypted = "";
        $decrypted = "";

        echo "source data:",$data. "<hr>";

        echo "private key encrypt:\n";

        openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密
        $encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的
        echo $encrypted. "<hr>";

        echo "public key decrypt:";
        openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来
        echo $decrypted. "<hr>";
        echo "---------------------------------------<hr>";
        echo "public key encrypt:\n";

        openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密
        $encrypted = base64_encode($encrypted);
        echo $encrypted. "<hr>";

        echo "private key decrypt:\n";
        openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密
        echo $decrypted. "<hr>";


    }
}
