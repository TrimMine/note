<?php
/**
 * Created by PhpStorm.
 * User: KOOO
 * Date: 2018/1/11
 * Time: 14:38
 */

namespace App\RPC;

use Core\Component\RPC\AbstractInterface\AbstractActionRegister;
use Core\Component\RPC\Common\ActionList;
use Core\Component\RPC\Common\Package;
use Core\Component\Socket\Client\TcpClient;

class User extends AbstractActionRegister
{

    function register(ActionList $actionList)
    {
       echo 'register';
        $actionList->registerAction('who', function (Package $req, Package $res, TcpClient $client) {
            var_dump('your req package is' . $req->__toString());
            $res->setMessage('this is User.who');
        });


        $actionList->registerAction('login', function (Package $req, Package $res, TcpClient $client) {
            var_dump('your req package is' . $req->__toString());
            $res->setMessage('this is User.login');
        });

        $actionList->setDefaultAction(function (Package $req, Package $res, TcpClient $client) {
            $res->setMessage('this is user.default');
        });

    }
}