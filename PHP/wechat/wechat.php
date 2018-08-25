<?php 
	
#$db = new \pod("mysql:host=localhost;dbname=test",$user,$password);
 $wx = new Wechat();
$wx->makeAccessToken();
$wx->makeMenu();

Class Wechat{
		protected static $appid = 'wx6925ffbb43bb76b7';
		protected static $appsecret = '7d85ac1057d7d01f3439c682693927fd';
    	#获取AccessToken
        public function makeAccessToken()
        {
        	$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.self::$appid.'&secret='.self::$appsecret;
        	$AccessToken = $this->https_request($url);
        	$_SESSION['AccessToken'] = json_decode($AccessToken,true);
        }

        #创建或更新菜单
        public function makeMenu()
        {
        	$this->createMenu(self::$data);
        }

	    #创建菜单方法
		public function createMenu($data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$_SESSION['AccessToken']['access_token']);
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
		public function getMenu(){
		return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$_SESSION['AccessToken']['access_token']);
		}

		#删除菜单
		public function deleteMenu(){
		return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$_SESSION['AccessToken']['access_token']);
		}

		protected static $data = '{
		     "button":[
		      {
		           "type":"view",
	               "name":"个人博客",
	               "url":"https://www.iyanyan.cn"
		      },
		      {
		           "type":"view",
		           "name":"下载APP",
	               "url":"https://cndjk.net/home/index/downApp"
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
		       }]
		}';

		#获取token
		protected function https_request($url, $data = null)
	     {
	         $curl = curl_init();
	         curl_setopt($curl, CURLOPT_URL, $url);
	         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	         if (!empty($data)){
	             curl_setopt($curl, CURLOPT_POST, 1);
	             curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	         }
	         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	         $output = curl_exec($curl);
	         curl_close($curl);
	         return $output;
	     }
}


 // var_dump($_SESSION);die;
