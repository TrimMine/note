<?php

namespace Home\Controller;

use Think\Controller;

/**
 *
 */
class FollowController extends Controller
{

    protected static $appid = 'wx1067a0c94e9bb8a6';
    protected static $secret = 'c74f9a75d87a48da21a020fcb15ce42d';
    protected static $redirect_uri = 'https://cndjk.net/Home/Wechat/wechat_info.html';
    protected static $token = 'zcdjk_token_check';


    #扫码关注页面
    public function following()
    {
        $this->display('following');
        exit;
    }

    #接受消息或验证配置
    public function ObtainWecaht()
    {

        if (isset($_GET["echostr"])) {
            #配置服务器第一次 验证token是否有效
            self::valid();
        } else {
            #接受消息
            self::reply();

        }
    }

    #此方法不能使用静态
    public function reply()
    {
        $postStr = file_get_contents("php://input");
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            #用户发送的消息类型判断
            switch ($RX_TYPE) {
                case "event":        #关注取消事件
                    $result = $this->receiveFollow($postObj);
                    break;
                /* case "text":  	 	#文本消息
                     $result = $this->receiveText($postObj);
                     break;
                 case "image": 		#图片消息
                     $result = $this->receiveImage($postObj);
                     break;
                 case "voice":  		#语音消息
                     $result = $this->receiveVoice($postObj);
                     break;
                 case "video":  		#视频消息
                     $result = $this->receiveVideo($postObj);
                     break;
                 case "location":	#位置消息
                     $result = $this->receiveLocation($postObj);
                     break;
                 case "link":   		#链接消息
                     $result = $this->receiveLink($postObj);
                     break;*/
                default:
                    $result = $this->receiveReply($postObj);
                    break;
            }
            echo $result;
        } else {
            // $log = new CallbackController();
            // $log->log($postStr, '接受并回复消息失败');
            // exit;
        }
    }

    #验证token
    public static function valid()
    {
        $echoStr = $_GET["echostr"];
        if (self::checkSignature()) {
            echo $echoStr;
            exit;

        } else {
            $log = new CallbackController();
            $log->log('验证失败', '消息');
        }
    }

    #配置服务器验证token 获取服务器参数
    public static function checkSignature()
    {
        #从GET参数中读取三个字段的值
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        #读取预定义的TOKEN
        $token = self::$token;
        #对数组进行排序
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        #对三个字段进行sha1运算
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        #判断我方计算的结果是否和微信端计算的结果相符
        #这样利用只有微信端和我方了解的token作对比,验证访问是否来自微信官方.
        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 暂时设置为统一回复内容
     */
    private function receiveReply($object)
    {
        $content = '你好~ 这是大健康共享平台,快去商城选购吧~';
        $result = $this->transmitText($object, $content);
        return $result;
    }


    /*
     * 关注取消事件
     */
    private function receiveFollow($object)
    {

        if ($object->Event == 'subscribe') {
            #插入数据				openid 等字串类型一定要加引号!
            $data['openid'] = "$object->FromUserName";
            $data['is_follow'] = '1';
            if (!empty($object->EventKey)){
                $data['pid'] = substr($object->EventKey, 8);
                #判断是否推荐人数大于10人  如果回调推荐10人没有成功升级 此处再推一个无等级的也可升级
                file_put_contents('guanzhu.log', "$object->FromUserName".PHP_EOL,FILE_APPEND);
            }
            $data['created_at'] = date('YmdHis');
            #查询是否已存在
            if (!M('users')->where(['openid' => $data['openid']])->find()) {
                M('users')->add($data);
            } else {
                M('users')->where(['openid' => $data['openid']])->save(['is_follow' => 1]);
            }
            #关注
            $content = "您好！欢迎关注大健康共享平台！紫晨大健康联手山西卫视春节联欢晚会新春送新福，点击进入商城，百万红包等你来拿！";
            $result = $this->transmitText($object, $content);
            return $result;

        } elseif ($object->Event == 'unsubscribe') {
            #取消关注
            $openid = "$object->FromUserName";
            if (M('users')->where(['openid' => $openid])->find()) {
                M('users')->where(['openid' => $openid])->save(['is_follow' => 2]);
            }
        } elseif ($object->Event == 'SCAN') {
            #扫码 但是已关注
            $openid = "$object->FromUserName";
            $info = M('users')->where(['openid' => $openid])->find();
            if ($info && $info['phone'] == '') {
                M('users')->where(['openid' => $openid])->save(['pid' =>"$object->EventKey"]);
            }

        } else {
            #未知错误
            $log = new CallbackController();
            #$log ->log('其他类型'.$object->Event,'关注取消事件');
        }


    }

    /*
     * 接收文本消息
     */
    private function receiveText($object)
    {
        $content = "你发送的是文本，内容为：" . $object->Content;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收图片消息
     */
    private function receiveImage($object)
    {
        $content = "你发送的是图片，地址为：" . $object->PicUrl;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收语音消息
     */
    private function receiveVoice($object)
    {
        $content = "你发送的是语音，媒体ID为：" . $object->MediaId;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收视频消息
     */
    private function receiveVideo($object)
    {
        $content = "你发送的是视频，媒体ID为：" . $object->MediaId;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收位置消息
     */
    private function receiveLocation($object)
    {
        $content = "你发送的是位置，纬度为：" . $object->Location_X . "；经度为：" . $object->Location_Y . "；缩放级别为：" . $object->Scale . "；位置为：" . $object->Label;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 接收链接消息
     */
    private function receiveLink($object)
    {
        $content = "你发送的是链接，标题为：" . $object->Title . "；内容为：" . $object->Description . "；链接地址为：" . $object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    /*
     * 回复文本消息
     */
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    #获取AccessToken
    public function makeAccessToken()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . self::$appid . '&secret=' . self::$secret;
        $AccessToken = $this->https_request($url);
        $_SESSION['AccessToken'] = json_decode($AccessToken, true);
    }

    #创建或更新菜单
    public function makeMenu()
    {
        $this->createMenu(self::$data);
    }

    #创建菜单方法
    public function createMenu($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $_SESSION['AccessToken']['access_token']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;

    }

    #获取菜单
    public function getMenu()
    {
        return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . $_SESSION['AccessToken']['access_token']);
    }

    #删除菜单
    public function deleteMenu()
    {
        return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=" . $_SESSION['AccessToken']['access_token']);
    }

    protected static $data = '{
		     "button":[
		      {
		           "type":"view",
	               "name":"进商城领红包",
	               "url":"https://cndjk.net/Home/Index/index.html"
		      }]
		}';
            /*,
		      {
		           "type":"view",
		           "name":"平台简介",
	               "url":"https://cndjk.net/Home/Index/introduce.html?type=3"
		      },
		      {
		           "name":"联系我们",
		           "sub_button":[
		            {
		               "type":"view",
		               "name":"注册流程",
	               		"url":"https://cndjk.net/Home/Index/NewDetail.html?id=34"
		            },
		            {
		               "type":"view",
		               "name":"客服电话",
	               		"url":"https://cndjk.net/Home/Index/service.html"
		            }]
		       }*/
    #获取token
    protected function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

}