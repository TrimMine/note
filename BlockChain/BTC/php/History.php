<?php
/**
 * Created by PhpStorm.
 * User: cabbage
 * Date: 2019/3/11
 * Time: 4:05 PM
 */

namespace App\Btc;

/**
 * Class History
 * @package App\Btc
 * btc记录
 */
class History
{
    // TODO 生成系统账户拨款账户
    /**
     * @param string $address
     * @return mixed
     * 未使用
     */
    static function getHistory($address)
    {
        $data = json_decode(self::httpRequest($address), true);
        if (empty($data) || count($data) < 1) {
            return $data;
        }
        $lists = [];
        $info = $data['data']['list'];
        foreach ($info as $k => $v) {
            if ($v['inputs'][0]['prev_addresses'] == $address) {
                $lists[$k]['address'] = $v['inputs'][0]['prev_addresses'];
                $lists[$k]['type'] = '转出';
            } else {
                $lists[$k]['type'] = '转入';
                if ($v['outputs'][0]['addresses'] != $address) {
                    $lists[$k]['addresses'] = $v['outputs'][0]['addresses'][0];
                    $lists[$k]['value'] = $v['outputs'][1]['value'];
                } else {
                    $lists[$k]['address'] = $v['outputs'][1]['addresses'][0];
                    $lists[$k]['value'] = $v['outputs'][0]['value'];
                }
            }
            if ($v['block_height'] < 6) {
                $lists[$k]['status'] = '未确认';
            } else {
                $lists[$k]['status'] = '转账完成';
            }
            $lists[$k]['time'] = date('Y-m-d H:i:s', $v['created_at']);
            //转账金额
            $len = strlen($lists[$k]['value']);
            if ($len <= 8) {
                $lists[$k]['value'] = '0.' . str_pad($lists[$k]['value'], 8, "0", STR_PAD_LEFT);
            } else {
                $double = substr($lists[$k]['value'], 0, -8);
                $int = substr($lists[$k]['value'], 0, $len - 8);
                $lists[$k]['value'] = $int . "." . $double;
            }
        }
        return $lists;
    }

    /**
     * @param string $address
     * @return array
     * 在使用
     */
    static function lists($address)
    {
        $opts=array(
            "http"=>array(
                "method"=>"GET",
                "timeout"=>10
            ),
        );
        $context = stream_context_create($opts);
        $height = @file_get_contents("https://blockchain.info/latestblock",false,$context);
        $height = json_decode($height, true)['height'];
        $data = @file_get_contents("https://blockchain.info/multiaddr?active={$address}",false,$context);
        $data = json_decode($data, true);
        if (empty($data) || count($data) < 1) {
            return [];
        }
        $return = [];
        foreach ($data['txs'] as $k => $v) {
//            $return[$k]['fee'] = $v['fee'];
//            $return[$k]['hash'] = $v['hash'];
            $return[$k]['block_height'] = $v['block_height'] ?? "未知";//块高度
            $return[$k]['ok_number'] = empty($v['block_height']) ? "0" : $height - $return[$k]['block_height']; //确认数
            if ($return[$k]['ok_number'] >= 6) {
                $return[$k]['status'] = '已完成';
            }else{
                $return[$k]['status'] = '未确认';
            }
            unset($return[$k]['block_height']);
            unset($return[$k]['ok_number']);
            $return[$k]['time'] = date('Y-m-d H:i:s', $v['time']);
            if ($v['result'] > 0) {
                $return[$k]['type'] = "转入";
                //发款方
                foreach ($v['inputs'] as $a => $b) {
                    $return[$k]['address'][] = [$b['prev_out']['addr'],];
                }
            } else {
                $return[$k]['type'] = '转出';
                //收款方
                foreach ($v['out'] as $a => $b) {
                    $return[$k]['address'][] = [$b['addr'],];
                }
            }
            //转账金额
            $return[$k]['value'] =  abs($v['result']) / 100000000;

        }
        return $return;
    }

    static function httpRequest($address)
    {
        $url = 'https://chain.api.btc.com/v3/address/' . $address . '/tx';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR ' . curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }

}
