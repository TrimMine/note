<?php

namespace server;

use think\Exception;

class Websocket
{
    public $server;
    public static $prefix_client = 'client';
    public static $prefix_user = 'user';

    public function __construct()
    {
        //清除redis 登录的客户端
//        $this->clearRedis();
        $this->server = new \swoole_websocket_server("0.0.0.0", 8332);
        $this->server->set(
            [
                'enable_static_handler' => true,
                'document_root' => "/www/wwwroot/juli.host/public/assets",
                'worker_num' => 4,
            ]
        );
//        $this->server->listen("0.0.0.0", 8081, SWOOLE_SOCK_TCP);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('workerstart', [$this, 'onWorkerStart']);
        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('close', [$this, 'onClose']);
        $this->server->start();
    }

    public function onWorkerStart($server, $worker_id)
    {
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../application/');
        // 加载框架里面的文件
        require __DIR__ . '/../thinkphp/base.php';
    }


    /**
     * request回调
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response)
    {
        $_SERVER = [];
        if (isset($request->server)) {
            foreach ($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        if (isset($request->header)) {
            foreach ($request->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        $_GET = [];
        if (isset($request->get)) {
            foreach ($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }
        $_POST = [];
        if (isset($request->post)) {
            foreach ($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }
        $_POST['http_server'] = $this->server;
        ob_start();
        // 执行应用并响应
        try {
            \think\App::run()->send();
        } catch (\Exception $e) {
            // todo
        }
        $res = ob_get_contents();
        ob_end_clean();

        $response->end($res);
    }

    /**
     * @param $server
     * @param $request
     * @get $type 1=登录 2=跳转页面|重连(需要主动断开然后重连)
     */
    public function onOpen($server, $request)
    {
        try {

////            $redis = Redis::getRedis();
//            if (!$session = $redis->get($request->cookie['PHPSESSID'])) {
//                throw new Exception('请先登录', 2000);
////            $server->disconnect($request->fd); //需要swoole 4.0版本才能用
//            }
//            $user_id = unserialize(explode('|', $session)[1])['user_id'];  //检测是否已经在线
//            //验证session
//            Login::loginSocket($server, $request, $user_id);

        } catch (Exception $e) {
            $server->push($request->fd, msgPro($e->getCode(), $e->getMessage()));
            echo $e->getMessage();
        }

    }

    public function onMessage($server, $frame)
    {
        try {
            //心跳检测
            if ($frame->data == 'Heart') {
                $server->push($frame->fd, 'Heart');
            }
//            //用户和医生进入聊天 邀请上级进入
//            $this->invitation($server, $frame);
//            //发送接收消息
//            $this->sendMsg($server, $frame);

            //检测是否合法
//        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            //查询当前用户聊天对象
            //消息入库
//        $frame->data = json_decode($frame->data,true);
            //展示给所有用户
//        $server->push($frame->data['id'], $frame->data['msg']);
        } catch (Exception $e) {
            if ($e->getCode() > 200) {
                $server->push($frame->fd, msgPro($e->getCode(), $e->getMessage()));
            }
            echo $e->getMessage() . "\n";
            echo $e->getCode() . "\n";
        }
    }

    public function onClose($server, $fd)
    {
//        $redis = Redis::getRedis();
//        //是否存在 防止踢掉用户找不到该ID
//        if ($redis->hExists(self::$prefix_client, $fd)) {
//            $user_id = $redis->hget(self::$prefix_client, $fd);
//            $redis->hDel(self::$prefix_client, $fd);
//            if ($redis->hExists(self::$prefix_client, $fd)) {
//                $redis->hDel(self::$prefix_user, $user_id);
//            }
//          $nickname = db('users')->where(['id'=>$user_id])->value('nickname');
//          $server->push($fd,msgPro(200,'用户'.$nickname.'已退出'));
//        }

        echo "client {$fd} closed\n";
    }

    /**
     * 启动服务清除redis用户信息
     */
    public function clearRedis()
    {
        $redis = Redis::getRedis();
        $redis->del(self::$prefix_user);
        $redis->del(self::$prefix_client);
    }

    //用户和医生进入聊天 邀请上级进入
    public function invitation($server, $frame)
    {
        if ($frame->data['type'] == 'Invitation-client') {
            $redis = Redis::getRedis();
            //查找用户的上级
            $user_id = $redis->hGet(self::$prefix_client, $frame->fd);
            $user = db('user')->where(['id' => $user_id])->find();
            $up_fd = $redis->hGet(self::$prefix_user, $user['pid']);
            //检测是否在线
            if ($up_fd) {
                $server->push($up_fd, msgPro(601, '您的直推用户' . $user['nickname'] . '正在和医生聊天,是否进入聊天室'));
            }
        }
    }

    //回复接收消息
    public function sendMsg($server, $frame)
    {
        if ($frame->data['type'] == 'normal') {
            $list_id = $frame->data['list_id']; //房间名字
            $msg = $frame->data['msg']; //内容 语音时为文件路径
            $msg_type = $frame->data['msg_type']; //消息类型 1文字 2语音
            $sound_time = $frame->data['sound_time']; //语音时间
            if (!is_numeric($list_id) || $list_id < 0) {
                throw new Exception('输入不合法', 301);
            }
            if (strlen($msg) > 30000) {
                throw new Exception('消息输入长度超过限制', 302);
            }
        }
    }

}

new Websocket();


//以上代码之后还需要修改 think下的request.php 
//两行注释和加了一句话 #EDIT内容

/**
     * 获取当前请求URL的pathinfo信息（含URL后缀）
     * @access public
     * @return string
     */
    public function pathinfo()
    {
        //#EDIT 添加的一句话
        if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '/'){
            return ltrim($_SERVER['PATH_INFO'], '/');
        }
//        if (is_null($this->pathinfo)) { #EDIT
            if (isset($_GET[$this->config->get('var_pathinfo')])) {
                // 判断URL里面是否有兼容模式参数
                $_SERVER['PATH_INFO'] = $_GET[$this->config->get('var_pathinfo')];
                unset($_GET[$this->config->get('var_pathinfo')]);
            } elseif ($this->isCli()) {
                // CLI模式下 index.php module/controller/action/params/...
                $_SERVER['PATH_INFO'] = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : '';
            }
 
            // 分析PATHINFO信息
            if (!isset($_SERVER['PATH_INFO'])) {
                foreach ($this->config->get('pathinfo_fetch') as $type) {
                    if (!empty($_SERVER[$type])) {
                        $_SERVER['PATH_INFO'] = (0 === strpos($_SERVER[$type], $_SERVER['SCRIPT_NAME'])) ?
                        substr($_SERVER[$type], strlen($_SERVER['SCRIPT_NAME'])) : $_SERVER[$type];
                        break;
                    }
                }
            }
 
            $this->pathinfo = empty($_SERVER['PATH_INFO']) ? '/' : ltrim($_SERVER['PATH_INFO'], '/');
//        }
 
        return $this->pathinfo;
    }
 
    /**
     * 获取当前请求URL的pathinfo信息(不含URL后缀)
     * @access public
     * @return string
     */
    public function path()
    {
//        if (is_null($this->path)) {#EDIT
            $suffix   = $this->config->get('url_html_suffix');
            $pathinfo = $this->pathinfo();
            if (false === $suffix) {
                // 禁止伪静态访问
                $this->path = $pathinfo;
            } elseif ($suffix) {
                // 去除正常的URL后缀
                $this->path = preg_replace('/\.(' . ltrim($suffix, '.') . ')$/i', '', $pathinfo);
            } else {
                // 允许任何后缀访问
                $this->path = preg_replace('/\.' . $this->ext() . '$/i', '', $pathinfo);
            }
//        }
 
        return $this->path;
    }

/*    
http://bingxiong.vip/2018/04/tp5-support-swoole/
详细修改地址 

