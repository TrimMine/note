<?php
/**
 * Created by PhpStorm.
 * User: cabbage
 * Date: 2019/3/11
 * Time: 4:51 PM
 */

namespace App\Btc;

class BtcMethod
{
    /**
     * 发送交易
     * $formAccount 要发送交易的账户 用户ID
     * $toAddress   接收地址
     * $amount      金额
     * $minconf     确认数
     * return 交易hash值
     */
    public function btcSend($formAccount, $toAddress, $amount, $minconf = 6, $trans_mark = '', $to_mark = '')
    {
        $connect = \App\Btc\Instance::getInstance();
        $hash_id = $connect->sendfrom($formAccount, $toAddress, $amount, $minconf);
        if (strlen($hash_id) != 64 || strpos($hash_id, ' ')) {
            return false;
        }
        return $hash_id;
    }

    /**
     * 设置手续费
     */
    public function btcSetFee()
    {
        $connect = \App\Btc\Instance::getInstance();
        //设置手续费
        $gas = $this->db->where('name', 'btc_gas')->getValue('config', 'value');
        $gas_res = $connect->settxfee($gas);
        if ($gas_res !== true) {
            return false;
        }
        return true;

    }


    /**
     * btc余额
     * 修改为调取为花费的交易统计
     */
    public function btcBalance($address)
    {
        $connect = \App\Btc\Instance::getInstance();
        $unspent = $connect->listunspent(0, 99999999, [$address]);
        $money = 0;
        foreach ($unspent as $k => $v) {
            $money += $v['amount'];
        }
        return $money;
    }

    /**
     * 生成btc地址
     */
    public function bitcoin()
    {
        //38dSWwfs15PPWefdmwmyQ5CXHH4BwBf3uZ
        //38C1fg67MEoqmT3RdgHjoqnpq6nq5ToZxt 0001
        //3CwCtu253Pdn74Kc1LbPXVs6fXmQMAhWF4 0001
        $user_id = $this->user->id;
        $connect = \App\Btc\Instance::getInstance();
        //如果已经有了不在生成
        $lists = $connect->getaddressesbyaccount("$user_id");
        if (count($lists) > 0) {
            return $lists[0];
        }
        $address = $connect->getnewaddress("$user_id");
        if (strlen($address) != 34) {
            return $this->msg(201, '请稍后重试');
        }
        return $address;
    }

    /**
     * @param $address
     * 判断确认点为6之后的余额
     */
    public function transfer($from, $to, $amount)
    {
        $connect = \App\Btc\Instance::getInstance();
        $unspent = $connect->listunspent(0, 99999999, [$from]);
        if (empty($unspent) || count($unspent) < 1) {
            return ['msg' => '余额不足', 'status' => 211];
        }
        $money = 0;
        $fee = 0.00001;
        foreach ($unspent as $k => $v) {
            $money += $v['amount'];
        }
        //未花费的金额
        if ($money < ($amount + $fee)) {
            return ['msg' => '余额不足', 'status' => 201];
        }
        foreach ($unspent as $k => $v) {
            $unspent_list[$k]['txid'] = $v['txid'];
            $unspent_list[$k]['vout'] = $v['vout'];
        }
        $raw_trans = $connect->createrawtransaction(
            $unspent_list,
            [$to => $amount]
        );
        $fund_raw = $connect->fundrawtransaction(
            $raw_trans,
            [
                "changeAddress" => $from, //找零地址
                'feeRate' => $fee //最高手续费
            ]
        );
        if ($fund_raw == 'Insufficient funds') {
            return ['msg' => '余额不足', 'status' => 202];
        }
        if (!isset($fund_raw)) {
            return ['msg' => '稍后重试', 'status' => 203];
        }
        $sign = $connect->signrawtransaction($fund_raw['hex']);
        $result = $connect->sendrawtransaction($sign['hex']);
        return ['msg' => '转账成功', 'status' => 200, 'data' => $result];
    }
}