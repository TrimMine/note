<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2017/9/13
 * Time: 上午12:03
 */

namespace App\Controller\Rest;


use Core\AbstractInterface\AbstractREST;
use Core\Http\Message\Status;

use Core\Component\RPC\Common\Package;
use Core\Component\RPC\Common\Config;
use Core\Component\RPC\Client\Client;

class Index extends AbstractREST
{

    function onRequest($actionName)
    {
        // TODO: Implement onRequest() method.
    }

    function actionNotFound($actionName = null, $arguments = null)
    {
        // TODO: Implement actionNotFound() method.
        $this->response()->withStatus(Status::CODE_NOT_FOUND);
    }

    function afterAction()
    {
        // TODO: Implement afterAction() method.
    }

    function GETIndex(){
        $conf = new Config();
        $conf->setPort(9502);
        $conf->setHost('127.0.0.1');

        $client = new Client();
        $server1 = $client->selectServer($conf);


        $server1->addCall('user','who',null,function (Package $req,Package $res){
            echo "\n\n";
            //var_dump($req);
            var_dump("call success at".$res->__toString()."\n");
        },function (Package $req,Package $res){
            echo "call fail at".$res->__toString()."\n";
        });

        $client->call();
    }
    function POSTIndex(){
        $this->response()->write("this is REST POST Index");
    }

    function GETTest(){
        $this->response()->write("this is REST GET test");
    }
    function POSTTest(){
        $this->response()->write("this is REST POST test");
    }

}