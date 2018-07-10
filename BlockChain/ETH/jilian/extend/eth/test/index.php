<?php
/**
 * Created by PhpStorm.
 * User: laotianye
 * Date: 2018/6/29
 * Time: 10:00
 */
// include the class file
require_once '../ethereum.php';

// create a new object
$ethereum = new Ethereum('localhost', 8545);
header("Content-Type: text/html;charset=utf-8");


// do your thing
//新建账户
//var_dump( $ethereum->personal_newAccount(['1111111111']));
//返回本地存储的所有账户
//var_dump( $ethereum->personal_listAccounts());
//查询账户余额
$address = "";
//0x9Af740C429Cb54e49AAdEa8C0238484f1c9e3B65 hei
$data = (object)array();
$personal = (object)array();
$data->address = trim($address);
$data->to = '';
$data->gas = '0x76c0';
$data->gasPrice = '0x76c0';
$data->value = '0x76c0';
$personal->from = $data->address;
$personal->to = $data->to;
$personal->value = $data->value;
//var_dump($personal);
//{from ： "0x391694e7e0b0cce554cb130d723a9d27458f9298 ”，to ： “ 0xafa3f8684e54059998bc3a7b0d2b0da075154d66 ”，value ： web3。toWei（1.23，“ ether ”）}
//var_dump(json_encode($data));
//die;
//$param = new Ethereum_Transaction($data->address, $data->to, $data->gas, $data->gasPrice, $data->value, $data = '', $nonce = NULL);
//$res = $ethereum->personal_sendTransaction([$param,'laotianye']);//个人发送交易
//$res = $ethereum->eth_sendTransaction($param); //发送交易
//$res = $ethereum->personal_importRawKey(['2f6aa8a185f2b4936a6891f56aa7cdfba3fc33194b653ac5ef0face9fcd31e8a','zzjbs2018//']); //导入账户如果私钥有0x需要去除0x 并返回账户 开头会加0x 除了0x和原账户一样
$res = $ethereum->personal_listAccounts(); //账户列表
//$res = $ethereum->personal_unlockAccount(['','',200]); //解锁账户
//$res = $ethereum->personal_sign(['0xdfa3ff','','']); //账户签名
//$res = $ethereum->personal_ecRecover(['','']);
//$res = decode_hex($ethereum->eth_gasPrice()); //矿工手续费
//$res = $ethereum->eth_getBalance($address, 'latest', true);//查询余额
//$res = execBalnace($res); //转化为小数和格式转换
var_dump($res);
die;


//余额算法
function execBalnace($balance)
{
//  $balance = hexdec($balance);
//  $balance = number_format($balance,0, '', ''); //精度不准确
    $balance = NumToStr($balance);
    if ($balance == 0) {
        return $balance;
    }
    $len = strlen($balance);
    $maxlen = 18;
    if ($len <= $maxlen) {
        $money = '0.' . str_pad($balance, $maxlen, '0', STR_PAD_LEFT);
        $money = rtrim($money, '0');
    } else {
        $surplus = $len - $maxlen;
        $after = substr($balance, -18);
        $before = substr($balance, 0, $surplus);
        $money = rtrim($before . '.' . $after, '0');
    }
    return $money;
}

//将科学计算法转为全部数字展示
function NumToStr($num)
{
    if (stripos($num, 'e') === false) return $num;
    $num = trim(preg_replace('/[=\'"]/', '', $num, 1), '"');//出现科学计数法，还原成字符串
    $result = "";
    while ($num > 0) {
        $v = $num - floor($num / 10) * 10;
        $num = floor($num / 10);
        $result = $v . $result;
    }
    return $result;
}

//16进制转换
function decode_hex($param)
{
    if (substr($param, 0, 2) == '0x')
        $param = substr($param, 2);

    if (preg_match('/[a-f0-9]+/', $param))
        return hexdec($param);

    return $param;
}