<?php
/**
 * Created by PhpStorm.
 * User: cabbage
 * Date: 2019/8/16
 * Time: 3:29 PM
 */

namespace personal;

/**
 * Class RpcHttp
 * @package personal
 * eth 请求 简略
 */
class EthRpc
{
    protected $host;
    protected $port;

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * 发送ETH请求
     */
    function doRequest($method, $params = [])
    {
        $data = json_encode([
            'jsonrpc' => "2.0",
            'method' => $method,
            'params' => $params,
            'id' => 1
        ]);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->host);
        curl_setopt($curl, CURLOPT_PORT, $this->port);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR ' . curl_error($curl);
        }
        curl_close($curl);
        $result = json_decode($result);
        return $result['result'];
    }
}

