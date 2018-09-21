<?php
/**
 * Date: 2018/6/27
 * Time: 18:33
 */

namespace app\eth\controller;

use think\Db;
use think\Exception;
use Web3\Contract;
use Web3\Contracts\Ethabi;
use Web3\Personal;
use Web3\Web3;

class Ethapi
{
    protected $testAbi = '[
    {
      "constant": true,
      "inputs": [],
      "name": "name",
      "outputs": [
        {
          "name": "",
          "type": "string"
        }
      ],
      "payable": false,
      "stateMutability": "view",
      "type": "function"
    },
    {
      "constant": false,
      "inputs": [
        {
          "name": "_spender",
          "type": "address"
        },
        {
          "name": "_value",
          "type": "uint256"
        }
      ],
      "name": "approve",
      "outputs": [
        {
          "name": "success",
          "type": "bool"
        }
      ],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "totalSupply",
      "outputs": [
        {
          "name": "",
          "type": "uint256"
        }
      ],
      "payable": false,
      "stateMutability": "view",
      "type": "function"
    },
    {
      "constant": false,
      "inputs": [
        {
          "name": "_from",
          "type": "address"
        },
        {
          "name": "_to",
          "type": "address"
        },
        {
          "name": "_value",
          "type": "uint256"
        }
      ],
      "name": "transferFrom",
      "outputs": [
        {
          "name": "success",
          "type": "bool"
        }
      ],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "decimals",
      "outputs": [
        {
          "name": "",
          "type": "uint8"
        }
      ],
      "payable": false,
      "stateMutability": "view",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "standard",
      "outputs": [
        {
          "name": "",
          "type": "string"
        }
      ],
      "payable": false,
      "stateMutability": "view",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [
        {
          "name": "",
          "type": "address"
        }
      ],
      "name": "balanceOf",
      "outputs": [
        {
          "name": "",
          "type": "uint256"
        }
      ],
      "payable": false,
      "stateMutability": "view",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [],
      "name": "symbol",
      "outputs": [
        {
          "name": "",
          "type": "string"
        }
      ],
      "payable": false,
      "stateMutability": "view",
      "type": "function"
    },
    {
      "constant": false,
      "inputs": [
        {
          "name": "_to",
          "type": "address"
        },
        {
          "name": "_value",
          "type": "uint256"
        }
      ],
      "name": "transfer",
      "outputs": [],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "function"
    },
    {
      "constant": true,
      "inputs": [
        {
          "name": "",
          "type": "address"
        },
        {
          "name": "",
          "type": "address"
        }
      ],
      "name": "allowance",
      "outputs": [
        {
          "name": "",
          "type": "uint256"
        }
      ],
      "payable": false,
      "stateMutability": "view",
      "type": "function"
    },
    {
      "inputs": [
        {
          "name": "initialSupply",
          "type": "uint256"
        },
        {
          "name": "tokenName",
          "type": "string"
        },
        {
          "name": "decimalUnits",
          "type": "uint8"
        },
        {
          "name": "tokenSymbol",
          "type": "string"
        }
      ],
      "payable": false,
      "stateMutability": "nonpayable",
      "type": "constructor"
    },
    {
      "anonymous": false,
      "inputs": [
        {
          "indexed": true,
          "name": "from",
          "type": "address"
        },
        {
          "indexed": true,
          "name": "to",
          "type": "address"
        },
        {
          "indexed": false,
          "name": "value",
          "type": "uint256"
        }
      ],
      "name": "Transfer",
      "type": "event"
    },
    {
      "anonymous": false,
      "inputs": [
        {
          "indexed": true,
          "name": "_owner",
          "type": "address"
        },
        {
          "indexed": true,
          "name": "_spender",
          "type": "address"
        },
        {
          "indexed": false,
          "name": "_value",
          "type": "uint256"
        }
      ],
      "name": "Approval",
      "type": "event"
    }
]';
    protected $web3;
    protected $contractAddress = null;
    protected $fromAccount = null;
    protected $ethereum = null;
//    protected $pass = '@@wallet&&2018';
    protected $pass = '2018jilian@@';
    protected $gas = null;

    public function __construct()
    {
        $this->web3 = new Web3('http://localhost:8545');
        include_once ROOT_PATH . 'extend/eth/ethereum.php';
        $this->ethereum = new \Ethereum('localhost', 8545);

        $config = db('config')->where(['group' => 'wallet'])->column('name,value');
        //手续费
        $this->gas = $config['wallet_gas'];
        //合约地址
        $this->contractAddress = $config['wallet_contract'];
        $this->fromAccount = $config['wallet_address'];
        //发币账户地址
//        $this->fromAccount = '0x00E82AA1fD6Ac5ec0967dA004475df96053c8aef';
//        $res = $this->ethereum->eth_getBalance($this->fromAccount, 'latest', true);//查询余额
//        dd($res);
    }

    public function index()
    {
        $personal = $this->web3->personal;
        $personal->batch(true);
        $personal->listAccounts();
        $personal->provider->execute(function ($err, $data) {
            if ($err !== null) {
                dd($err);
            }
            dd($data);
        });
    }

    /**
     * 每隔一小时检测一次
     * 是否有未成功的订单 然后重置状态
     * 超过三次状态为失败
     * 查询为超过三次 状态为6的 近2天的
     */
    public function checkStatus()
    {
        try {
            $info = db('user_withdraw')->where(['status' => 6, 'created_at' => ['egt', strtotime(date('Y-m-d') . "-1 day")], 'is_success' => 1])->select();
            if (count($info) < 1) {
                echo '没有检测的订单!';
            }
            foreach ($info as $k => $v) {
                //次数超限 修改为失败 不在检测
                if ($v['times'] >= 3) {
                    $sql_res = db('user_withdraw')->where(['id' => $v['id']])->update(['status' => 7, 'updated_at' => time()]);
                    if (!$sql_res) throw  new Exception('修改失败!', 201);
                    continue;
                }
                $res = $this->https_request($v['txhash']);
                //修改已成功的订单
                if (isset($res['result']['status']) && $res['result']['status'] == 1 && $v['is_success'] != 2) {
                    $sql_success_res = db('user_withdraw')->where(['id' => $v['id']])->update(['is_success' => 2, 'updated_at' => time()]);
                    if (!$sql_success_res) throw  new Exception('修改失败!', 203);
                    continue;
                }
                //修改失败要重置的订单
                if (isset($res['result']['status']) && $res['result']['status'] == 0 && $v['is_success'] == 1) {
                    $sql_save_res = db('user_withdraw')->where(['id' => $v['id']])->update(['status' => 2, 'updated_at' => time()]);
                    if (!$sql_save_res) throw  new Exception('修改失败!', 202);
                    echo '重置状态 ' . $v['id'] . " \n";
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }

        echo '检查完毕' . "\n";
        exit;

    }

    //以太坊官网接口
    public function https_request($txhash)
    {
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, 'https://api.etherscan.io/api?module=transaction&action=gettxreceiptstatus&txhash=' . $txhash . '&apikey=YourApiKeyToken');
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return json_decode($data, true);
    }

    /*
     *查询未处理提现订单
     */
    public function withdraw()
    {
        if (db('user_withdraw')->where(['status' => 5, 'times' => ['lt', 3]])->find()) {
            echo '还有未处理完的提现订单!';
            exit;
        }
        $ids = db('user_withdraw')->where(['status' => 2, 'times' => ['lt', 3]])->column('id');
        if (count($ids) < 1) {
            echo '没有要处理的订单' . "\n";
            exit;
        }

        $res = db('user_withdraw')->whereIn('id', $ids)->update(['status' => 5]);
        if (!$res) {
            file_put_contents('Withdrawfailed.txt', PHP_EOL . PHP_EOL . '-----------' . date('Y-m-m H:i:s') . '-----------' . PHP_EOL . '修改状态失败!' . json_encode($ids), FILE_APPEND);
        }
        Db::startTrans();
        try {
            $info = db('user_withdraw')->where(['id' => ['in', $ids], 'status' => 5])->order('times', 'asc')->select();
            $i = 0;
            foreach ($info as $k => $v) {
                db('user_withdraw')->where(['id' => $v['id']])->update(['times' => $v['times'] + 1, 'updated_at' => time()]);
                $result = $this->Send($v['real_money'], $v['address'], $v['id']);
                if ($result !== true) {
                    db('user_withdraw')->where(['id' => $v['id']])->update(['status' => 2, 'updated_at' => time()]);
                    file_put_contents('Withdrawfailed.txt', PHP_EOL . PHP_EOL . '-----------' . date('Y-m-m H:i:s') . '-----------' . PHP_EOL . $result, FILE_APPEND);
                    continue;
                }
                $i++;
            }
            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            file_put_contents('Withdrawfailed.txt', PHP_EOL . PHP_EOL . '-----------' . date('Y-m-m H:i:s') . '-----------' . PHP_EOL . $e->getMessage() . ' Code ' . $e->getCode(), FILE_APPEND);
        }
        if ($i == 0) {
            echo '没有要处理的订单' . "\n";
            exit;
        }
        echo PHP_EOL . '本次处理成功,条数---' . $i . PHP_EOL;
    }

    /**
     * testSend
     * @return string
     */
    public function Send($num, $to, $id)
    {
        $gas_num = $this->gas;
        $number = $num * 1000000;
        $toAccount = $to;
        $fromAccount = $this->fromAccount;
        try {
            //解锁账户
            $msg = $this->unlock();
            if ($msg !== true) {
                throw new Exception($msg);
            }
            $contract = new Contract('http://localhost:8545', $this->testAbi);
            $contract->at($this->contractAddress)->send('transfer', $toAccount, $number, [
                'from' => $fromAccount,
                'gas' => '0x' . dechex($gas_num),
            ], function ($err, $result) use ($contract, $fromAccount, $toAccount, $id) {
                if ($err !== null) {
                    throw new Exception($err->getMessage());
                }
                if ($result) {
                    echo "\nTransaction has made:) id: " . $result . "\n";
                    file_put_contents('WithdrawSuccessId.txt', PHP_EOL . PHP_EOL . '-----------' . date('Y-m-m H:i:s') . '-----交易HashId------' . PHP_EOL . $result, FILE_APPEND);
                }
                $transactionId = $result;
                if (!preg_match('/^0x[a-f0-9]{64}$/', $transactionId) === 1) {
                    throw new Exception('转账hash值不正确,转账失败!');
                }
                //修改交易状态
                $res = db('user_withdraw')->where(['id' => $id])->update(['status' => 6, 'txhash' => $transactionId, 'dispose_at' => time(), 'updated_at' => time()]);
                if (!$res) {
                    throw new Exception('修改失败');
                }

            });
            //交易完成锁定账户
            $msg = $this->lock();
            if ($msg !== true) {
                throw new Exception($msg);
            }


        } catch (Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

    //16进制转换
    public function decode_hex($param)
    {
        if (substr($param, 0, 2) == '0x')
            $param = substr($param, 2);

        if (preg_match('/[a-f0-9]+/', $param))
            return hexdec($param);

        return $param;
    }

    //解锁账户
    private function unlock()
    {
        $res = $this->ethereum->personal_unlockAccount([$this->fromAccount, $this->pass]); //解锁账户
        if (!$res) {
            return '解锁失败!';
        }
        return true;
    }

    //锁定账户
    public function lock()
    {
        $res = $this->ethereum->personal_lockAccount([$this->fromAccount]); //锁定账户
        if (!$res) {
            return '锁定失败!';
        }
        return true;
    }
}