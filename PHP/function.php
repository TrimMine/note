<?php




#===============================laravel 查询用户信息 pluck =================================
#键值交换
array_flip()
#查询单列(用户的数据)
$users = pluck('id','nickanme');
#查询的数据 记录
foreach ($data as $key => $value) {
    $data[$key]['nickname'] = $users[$value['uid']];
}

#===============================正则匹配密码 =================================

function get_pwd_strength($pwd){
  if (strlen($pwd)>30 || strlen($pwd)<6)
  {
    return "密码必须为6-30位的字符串";
  }
  if(preg_match("/^\d*$/",$pwd))
  {
    return "密码必须包含字母,强度:弱";//全数字
  }
  if(preg_match("/^[a-z]*$/i",$pwd))
  {
    return "密码必须包含数字,强度:中";//全字母
  }
  if(!preg_match("/^[a-z\d]*$/i",$pwd))
  {
    return "密码只能包含数字和字母,强度:强";//有数字有字母 ";
  }
}

#===============================正则匹配姓名 =================================
  if (!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',$request->input('truename'))) {
    return '姓名最少两个最多4个汉字';
  }
#===============================正则匹配密码 =================================
  #判断两次密码是否大于6位
  if (!preg_match('/^[a-zA-Z0-9_]{6,16}$/',$request->input('password'))) {
    return '密码必须大于6位少于16位的字母和数组组合';
  }
#===============================array_unique()数组函数 =================================

#array_unique($arr) 函数移除数组中的重复的值，并返回结果数组。
#当几个数组元素的值相等时，只保留第一个元素，其他的元素被删除。
#返回的数组中键名不变。
#从前往后有从夫的值直接移除

#===============================遍历 =================================
 #在遍历时添加下标和值时  如果目标还未定义 则不能够 ++或 +=

/*********************************************************************************
*统计财务总表                                                                      *
*服务中心账号  服务中心名称  VIP总收入  VIP总支出  VIP净利润. 健康使者总收入 健康使者总支出 *
*健康使者净利润 商户总收入 商户总支出 商户净利润 利润总和                                *
**********************************************************************************/

#===============================思想 =================================

#在写入或者建表的时候去把以后用到的数据建立字段  查找的时候减轻服务器压力 查找方便快捷
#===============================思想 =================================
                #访问路由的前缀 在访问的时候就不用再加名字 sales_num = shop_data/sales_num
Route::group([ 'prefix' => 'shop_data'], function () {
    // 商户销量统计表
    Route::get('sales_num','ShopDataController@sales_num');
    // 商户销货统计表
    Route::get('sales','ShopDataController@sales');
    // 推荐人发展商户收益明细
    Route::get('recommend','ShopDataController@recommend');
    // 商户统计表格
    Route::get('make_shop_export','ShopDataController@make_shop_export');

});
#============================== TP 上传文件用法 =================================

 #上传图片
    function upload_pic($file,$path)
    {
        $upload = new Think\Upload();
        $upload->maxSize   =     3145728 ;
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
        #最后一个目录名加/号就在此目录下创建 不加/号直接创建带日期的文件夹
        $upload->rootPath  =     $path; // 设置附件上传根目录
        $upload->savePath  =     '';
        // 上传文件 
        $info   =   $upload->upload($file);
        if(!$info) {
            return $upload ->getError();
        }else{
            return $info;
        }
    }
    #图片地址
 $info_paht = $path.$info['pic']['savepath'].$info['pic']['savename'];


#============================== TP 模型关联 =================================

namespace Admin\Model;
use Think\Model\RelationModel; //必须引用
/**
*
*/
class ArticleModel extends RelationModel //必须继承该Model
{
  protected $tableName = 'article'; #$tableName 必须为该变量 区分大小写

  protected $fields =array(
    'id',
    #分类id
    'class_id',
    #文章标题
    'title',
    #文章简介
    'descrition',
    #文章内容
    'content',
    #文章类型
    'type',
    #0未发布1已发布
    'status',
    'created_at',
    'updated_at');

  protected $pk     = 'id';

#关联表的字段('foreign_key=>') 
#HAS 所在模型为主(id所在处) foreign_key=>为副表关联id  
#BELONGS 是相对的 foreign_key=>为自己的关联字段 关联表的为id 

#一对一关联 ：HAS_ONE 和 BELONGS_TO 
#一对多关联 ：HAS_MANY 和 BELONGS_TO
#多对多关联 ：MANY_TO_MANY
  protected $_link = array(
       #关联的名称
       'article_class'=>array(
          'mapping_type'  => self::BELONGS_TO,
          'class_name'    => 'article_class', #关联的表名
          'foreign_key'   => 'class_id', #关联表的字段 BELONGS_TO时为自己的关联字段 关联表的为id _____ 否则为关联表的字段 自己的为id
          'as_fields'   =>'class'
          ),
       'class'=>array(
            'mapping_type'   => self::BELONGS_TO,
            'class_name'     => 'class',     #表名
            'foreign_key'    => 'class_id',  #关联的id
            'mapping_fields' => 'name,pic',  #要查询的字段 默认为全部
            'as_fields'      => 'name:class_name,pic' #将字段映射到 查询的数组中 如果有名字冲突可起别名
        ),
       'task'=>array(
            'mapping_type'  => self::HAS_MANY, //一对多没有 as_fields 类型
            'class_name'    => 'pass_record',
            'foreign_key'   => 'pass_user',
            'condition'     => 'status =2',   //查询条件
            'mapping_fields'=> 'count(id) as count',  //可做 sum count max  等查询
        ),
      );
      #此方法不能用户BELONGS_TO   控制器中  $user ->condition('money','class = 0');
      #如果是BELOGNS_TO 可直接在控制器中加where条件搜索 不区分where位置
      public function condition($table,$where){
        return $this->_link[$table]['condition']=$where;
    }

}
#============================== TP 创建service层  =================================
#tp核心类   Think下的 Think.class.php  autoload 方法
      if(strstr($class,'Service')){
        include($_SERVER['DOCUMENT_ROOT'].'/Application/'.str_replace('\\','/',$class).'.php');
      }
#命名service类
namespace Service;
/**
*
*/
class Test
{
  public function test(){
    dump('This is /Service/Test/test()');die();
  }
}
#调用
use Service\Test; //自动加载规则会去寻找Service下的文件 use 就是为了指定文件夹 namespace 作用也是为了指明文件夹
class IndexController extends Controller{

    public function index(){
               $a = new Test;
                $a -> test();
    }

} 
#============================== TP 不是用模型关联查询  =================================
      $info = M('buy_equipment');  //默认内敛 inner join
      $info = $info -> field('buy_equipment.*,users.nickname')->join('users ON users.id = buy_equipment.user_id')->select();
      dd($info);
#============================== TP 不是用模型关联查询  =================================
#同时获取用户名 上级和自己来源id  
    #查询姓名 以数组的形式获取id为下标  昵称为值的数组 
    $nickname = M('users')->getField('id,nickname',true);

    #昵称
    {$nickname[$v['source_id']]}

#============================== php 设置上传临时目录 =================================
      ini_set('upload_tmp_dir', '/www/wwwroot/upload/');



#============================== 1-23 数组内键缺少 补全 =================================
                $arr =[
               1 =>  "0.6",
               2 =>  "0",
               3 =>  "0",
               4 =>  "0",
               5 =>  "0.6",
               6 =>  "0",
               7 =>  "0",
               8 =>  "0",
               9 =>  "0",
               10 =>  "0.6",
               11 =>  "0",
               12 =>  "0.6",
               13 =>  "0",
               14 =>  "1",
               15 =>  "0",
               16 =>  "0",
               17 =>  "0"];
            for ($i=1; $i <=23 ; $i++) {
                foreach ($arr as $key => $value) {
                  if (!isset($arr[$i])) {
                        $arr[$i] = 0;
                  }
                }
            }
    #如果1-9 的键存在字符串 且字符串是09 07 08 这种形式的时候
                 $arr =[
               '01' =>  "0.8",
               '02' =>  "0.9",
               3 =>  "0",
               4 =>  "0",
               5 =>  "0.6",
               '06' =>  "0.8",
               7 =>  "0",
               '08' =>  "0.8",
               9 =>  "0",
               10 =>  "0.6",
               11 =>  "0",
               12 =>  "0.6",
               13 =>  "0",
               14 =>  "1",
               15 =>  "0",
               16 =>  "0",
               17 =>  "0"];
            #1-9 如果有字符串 截取然后转化为int
            foreach ($arr as $key => $value) {
                if (!is_int($key)) {
                    $newkey = substr($key,1);
                    $arr[$newkey] = $value;
                    unset($arr[$key]);
                }
            }
            for ($i=1; $i <=23 ; $i++) {
                foreach ($arr as $key => $value) {
                  if (!isset($arr[$i])) {
                        $arr[$i] = 0;
                  }
                }
            }
            #根据键值排序
            ksort($arr);

#============================== TP不报错 404 改为报出错误详细信息  =================================
          #在think.class下面的start方法
  static public function start() {
      // 注册AUTOLOAD方法
      spl_autoload_register('Think\Think::autoload');
      // 设定错误和异常处理  如果不需要报错信息 则注释这三行
      register_shutdown_function('Think\Think::fatalError');
      set_error_handler('Think\Think::appError');
     set_exception_handler('Think\Think::appException');
  #.....
}
      static public function appException($e) {
        $error = array();
        $error['message']   =   $e->getMessage();
        $trace              =   $e->getTrace();
        if('E'==$trace[0]['function']) {
            $error['file']  =   $trace[0]['file'];
            $error['line']  =   $trace[0]['line'];
        }else{
            $error['file']  =   $e->getFile();
            $error['line']  =   $e->getLine();
        }
        $error['trace']     =   $e->getTraceAsString();
        Log::record($error['message'],Log::ERR);
        exit(self::halt($e));                               #打印错误信息 不需要则去除
        // 发送404信息
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        self::halt($error);
    }
#============================== TP下异常信息 url访问模式  =================================
  #在think下 conf下convention.php中 添加到项目下的conf中
     /* URL设置 */
    'URL_CASE_INSENSITIVE'  =>  false,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'             =>  1,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：


#==============================递归查询  =================================

    $sublists = 表名或模型名::whereIn('pid', $list_ids)->pluck('id');
        if (count($sublists) == 0) {
            return $count;
        }
        $count += count($sublists);
        return $this->subCount($sublists, $count);
// 下面的方法未测试
     static private function TotalNum($id,$total)
        {
            $num = M('users')->where('pid in ('.$id.')')->getfield('id',true);
            dd($num);
            if (count($num) < 1) {
                return $Total;
            }
            $Total += count($num);
            return self::Total($num,$Total);
        }

#==============================php 取整 =================================
  # 一、ceil — 进一法取整  返回的类型是 float
  echo ceil(4.3); // 5
  echo ceil(9.999); // 1
  # 二、floor — 舍去法取整 返回的类型是 float
  echo floor(4.3); // 4
  echo floor(9.999); // 9
  # 三、round — 对浮点数进行四舍五入   返回将 val 根据指定精度 precision（十进制小数点后数字的数目）进行四舍五入的结果。precision 也可以是负数或零（默认值）。
  echo round(3.4); // 3
  echo round(3.5); // 4
  echo round(3.6); // 4
  echo round(3.6, 0); // 4
  echo round(1.95583, 2); // 1.96
  echo round(1241757, -3); // 1242000
  echo round(5.045, 2); // 5.05
  echo round(5.055, 2); // 5.06

  # 四、intval—对变数转成整数型态
  echo intval(4.3); //4
  echo intval(4.6); // 4


    #=>PHP四舍五入精确小数位及取整
    $num=0.0215489;
    echo sprintf("%.3f", $num); // 0.022
    #=>php保留三位小数不四舍五入
    $num=0.0215489;
    echo substr(sprintf("%.4f", $num),0,-1); // 0.021

    #=>PHP四舍五入保留两位小数点最精确的方法

    $number = 123213.066666;
    echo sprintf("%.2f", $number); //123213.07

    number_format($num, 2)  //生成两位小数，不四舍五入

#==============================    TP事务    =================================


//  在User模型中启动事务
$User->startTrans();
// 进行相关的业务逻辑操作
$Info = M("Info"); // 实例化Info对象
$Info->save($User); // 保存用户信息
if (操作成功){
    // 提交事务
    $User->commit();
}else{
   // 事务回滚
   $User->rollback();
}


#==============================    数组   =================================
#在失去默认下标的时候可以使用 
json_decode(json_encode($str),true); #转换一下

#==============================    laravel  env配置邮箱文件   =================================
#MAIL_DRIVER=smtp
#MAIL_HOST=smtp.163.com
#MAIL_PORT=465
#MAIL_FROM_ADDRESS=chinesebigcabbage@163.com 
#MAIL_FROM_NAME=chinese
#MAIL_USERNAME=chinesebigcabbage@163.com 
#MAIL_PASSWORD=laotianye2017
#MAIL_ENCRYPTION=ssl

#谷歌
#开启谷歌账号pop imap服务  
#开启两部验证
#返回登录和安全页面 刷新会出现设置应用安全码
#生成应用专用码. https://myaccount.google.com/security.需要验证  
#如还不成功 开启允许不安全的应用访问

#MAIL_DRIVER=smtp
#MAIL_HOST=smtp.gmail.com
#MAIL_PORT=587
#MAIL_FROM_ADDRESS=zxchenicp2017@gmail.com
#MAIL_FROM_NAME=Icpkys
#MAIL_USERNAME=zxchenicp2017@gmail.com
#MAIL_PASSWORD=bhqtjiawvomicxiv
#MAIL_ENCRYPTION=tls

#ssl 465  tls 587

#==============================  #判断是微信还是浏览器   =================================
function is_weixin() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }
        return false;
}
#定义微信判断
define ('IS_WECHAT', is_weixin() == true ? true : false);

const NAME="123";
define(NAME,'1234');
#调用的时候 const 需要用 self::NAME 或者 类名::NAME
#define 直接用  NAME




#==============================  #微信授权登陆   =================================
    protected static $appid = '';
    protected static $secret = '';
    protected static $redirect_uri = '';

    public function __construct()
    {
        self::$appid = config('wx_config.app_id');
        self::$secret = config('WECHAT_CONF.secret');
        self::$redirect_uri = config('WECHAT_CONF.redirect_uri');
    }
    #授权登录 获取个人信息
    public function wechat_login()
    {
        #是否是携带code  session('code') == input('param.code')避免一个code获取两次信息
        if (input('param.code') == '' || session('code') == input('param.code')){
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . self::$appid . '&redirect_uri=' . self::$redirect_uri . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            header('Location:'. $url);exit;
        //在每个重定向之后都必须加上 exit ,避免发生错误后，继续执行。
        }
        #获取code
        $code = input('param.code');
        #存到session 避免刷新
        session('code', input('param.code'));
        #state
        $state = input('param.state');
        #跳转地址
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . self::$appid . '&secret=' . self::$secret . '&code=' . $code . '&grant_type=authorization_code ';
        #获取access_token和openid
        $res = json_decode($this->https_request($url), true);
        #获取用户信息
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' .   $res['access_token'] . '&openid=' .$res['openid'] . '&lang=zh_CN';
        #用户信息
        $userinfo = json_decode($this->https_request($url), true);
        #检查用户信息
        session('wechat', $userinfo);
        #重定向到
        $this->redirect('/index/index/index');
    }


    function https_request($url)
    {
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

#==============================  PHP curl扩展   =================================
 $timeout = 5;
 //1.初始化curl并赋值
 $curl = curl_init();

 //2.设置请求参数
 curl_setopt($curl, 参数名, 参数值);
 curl_setopt($curl, CURLOPT_URL, $url);//请求的url地址 必设
 //常用的参数
 //设置头文件的信息作为数据流输出  和下面的 CURLOPT_RETURNTRANSFER 只能取一个
 curl_setopt($curl, CURLOPT_HEADER, 1);
 //以文件流的方式返回,而不是直接输出
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 //设置请求方式为post 1为true 0为false 
 curl_setopt($curl, CURLOPT_POST, 1);  
 //设置post数据 也就是请求的参数
 $post_data = array(
     "username" => "coder",
     "password" => "12345"
     );
 curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
 //设置超时时间
 curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,$timeout);
 //证书验证 https是否验证证书
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

//执行命令 获取返回的文件流
$data = curl_exec($curl);
if (curl_errno($curl)) {
    return 'ERROR ' . curl_error($curl);
}
//关闭URL请求
 curl_close($curl);
 //显示返回数据
 var_dump($data);



//区别
//1.curl比file_get_contents() 效率高
//2.curl支持get或post 默认get file_get_contents 只支持get
//3.curl参数多,全面

  //get和post结合版
  protected function httpCurl($url, $data = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if ($data) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        $headers = [
            "Content-Type: application/json",
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); //设置header
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR ' . curl_error($curl);
        }
        curl_close($curl);
        return $result;
    }
#==============================  PHP header   =================================

 Header("Location: http://www.php.net"); exit;   
//在每个重定向之后都必须加上 exit,避免发生错误后，继续执行。

#==============================  #TP redirect   =================================
  
  //重定向到New模块的Category操作  可携带参数
  $this->redirect('New/category', array('cate_id' => 2), 5, '页面跳转中...');
  #上面的用法是停留5秒后跳转到New模块的category操作，并且显示页面跳转中字样，重定向后会改变当前的URL地址。

  #如果你仅仅是想重定向要一个指定的URL地址，而不是到某个模块的操作方法，可以直接使用redirect函数重定向，例如：
  //重定向到指定的URL地址
  redirect('/New/category/cate_id/2', 5, '页面跳转中...')


#==============================  #跨域请求  =================================

  #跨服器 跨域名请求 虽然设置了请求头 但是请求也要用 jsonp 类型 否则前端服务器请求回来会重新创建 sessionID   从而后端session值为空 一直被base拦截
#共享session方法
#
$allow_origin = array(
    'http://localhost:8080',
    'http://meiami.ewtouch.com',
    'http://webmeiami.ewtouch.com',
    'http://192.168.10.102:8081',
    'http://192.168.10.103:8080',
);
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';

if(in_array($origin, $allow_origin)){
    header('Access-Control-Allow-Origin:'.$origin);
}
//header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Credentials:true');

header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Max-Age: ' . 3600 * 24);

#前端 ajax 请求加上这两句
            xhrFields: {
                      withCredentials: true
            },
            crossDomain: true,
/*$.ajax({

            url: 'url',

            xhrFields: {

                      withCredentials: true

            },
            crossDomain: true,

            success:function(data){

                console.log(data)

            }

        })

    })*/

#==============================  #field  getfield =================================
    #获取id数组集合
    $user->where()->getField('id',true);

         #1、用于查询
        #指定字段 在查询操作中field方法是使用最频繁的。

            $Model->field('id,title,content')->select();

        #可以给某个字段设置别名，例如：

            $Model->field('id,nickname as name')->select();

        #执行的SQL语句相当于：

            SELECT id,nickname as name FROM table

        #使用SQL函数

       # 可以在field方法中直接使用函数，例如：

            $Model->field('id,SUM(score)')->select();

        #执行的SQL相当于：

            SELECT id,SUM(score) FROM table

        #当然，除了select方法之外，所有的查询方法，包括find等都可以使用field方法，这里只是以select为例说明。
        #使用数组参数

        #field方法的参数可以支持数组，例如：

            $Model->field(array('id','title','content'))->select();

        #最终执行的SQL和前面用字符串方式是等效的。

        #数组方式的定义可以为某些字段定义别名，例如：

            $Model->field(array('id','nickname'=>'name'))->select();

       # 执行的SQL相当于：

            SELECT id,nickname as name FROM table

       # 对于一些更复杂的字段要求，数组的优势则更加明显，例如：

            $Model->field(array('id','concat(name,'-',id)'=>'truename','LEFT(title,7)'=>'sub_title'))->select();

        #执行的SQL相当于：

            SELECT id,concat(name,'-',id) as truename,LEFT(title,7) as sub_title FROM table

        #获取所有字段

        #如果有一个表有非常多的字段，需要获取所有的字段（这个也许很简单，因为不调用field方法或者直接使用空的field方法都能做到）：

            $Model->select();
            $Model->field()->select();
            $Model->field('*')->select();

        #上面三个用法是等效的，都相当于执行SQL：

            SELECT * FROM table

       # 但是这并不是我说的获取所有字段，我希望显式的调用所有字段（对于对性能要求比较高的系统，这个要求并不过分，起码是一个比较好的习惯），那么OK，仍然很简单，下面的用法可以完成预期的作用：

            $Model->field(true)->select();

        #field(true)的用法会显式的获取数据表的所有字段列表，哪怕你的数据表有100个字段。
        #字段排除

        #如果我希望获取排除数据表中的content字段（文本字段的值非常耗内存）之外的所有字段值，我们就可以使用field方法的排除功能，例如下面的方式就可以实现所说的功能：

            $Model->field('content',true)->select();

        #则表示获取除了content之外的所有字段，要排除更多的字段也可以：

            $Model->field('user_id,content',true)->select();
            //或者用
            $Model->field(array('user_id','content'),true)->select();

        #2、用于写入

        #除了查询操作之外，field方法还有一个非常重要的安全功能--字段合法性检测（注意：该功能3.1版本开始才能支持）。field方法结合create方法使用就可以完成表单提交的字段合法性检测，如果我们在表单提交的处理方法中使用了：

            $Model->field('title,email,content')->create();

       # 即表示表单中的合法字段只有title,email和content字段，无论用户通过什么手段更改或者添加了浏览器的提交字段，都会直接屏蔽。因为，其他是所有字段我们都不希望由用户提交来决定，你可以通过自动完成功能定义额外的字段写入。

        #同样的，field也可以结合add和save方法，进行字段过滤，例如：

            $Model->field('title,email,content')->save($data);

       # 如果data数据中包含有title,email,content之外的字段数据的话，也会过滤掉。
#==============================  #tp where查询  =================================
            $where['openid'] = $_SESSION['wechat']['openid'];
            #1 .
            $userinfo  = $users ->where($where)->find();
            #2.
            $userinfo = $users->where(['opneid='.$_SESSION['wechat']['openid']]);
            #尽量规避第二种 使用第一种数组的形式

#==============================  #tp display =================================

// 不带任何参数 自动定位当前操作的模板文件
$this->display();
#表示系统会按照默认规则自动定位模板文件，其规则是：

#如果当前没有启用模板主题则定位到：当前模块/默认视图目录/当前控制器/当前操作.html

#如果没有按照模板定义规则来定义模板文件（或者需要调用其他控制器下面的某个模板），可以使用：

// 指定模板输出
$this->display('edit'); 
#表示调用当前控制器下面的edit模板

$this->display('Member:read');
#==============================  #过滤微信昵称 =================================

function filterNickname($nickname)
{
        $pattern = array(
            '/\xEE[\x80-\xBF][\x80-\xBF]/',
            '/\xEF[\x81-\x83][\x80-\xBF]/',
            '/[\x{1F600}-\x{1F64F}]/u',
            '/[\x{1F300}-\x{1F5FF}]/u',
            '/[\x{1F680}-\x{1F6FF}]/u',
            '/[\x{2600}-\x{26FF}]/u',
            '/[\x{2700}-\x{27BF}]/u',
            '/[\x{20E3}]/u'
        );
        $nickname = preg_replace($pattern, '', $nickname);
        return trim($nickname);
}

#==============================  #PHP 下载图片到本地 知道图片路径的情况下 =================================
/* 
*功能：php完美实现下载远程图片保存到本地 
*参数：文件url,保存文件目录,保存文件名称，使用的下载方式 
*当保存文件名称为空时则使用远程文件原来的名称 
*/ 
public static function getImage($url,$save_dir='',$filename='',$type=0){
    if(trim($url)==''){
        return array('file_name'=>'','save_path'=>'','error'=>1);
    }
    if(trim($save_dir)==''){
        $save_dir='./';
    }
    if(trim($filename)==''){//保存文件名
        $ext=strrchr($url,'.');
        if($ext!='.gif'&&$ext!='.jpg'){
            return array('file_name'=>'','save_path'=>'','error'=>3);
        }
        $filename=time().$ext;
    }
    if(0!==strrpos($save_dir,'/')){
        $save_dir.='/';
    }
    //创建保存目录 
    if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
        return array('file_name'=>'','save_path'=>'','error'=>5);
    }
    //获取远程文件所采用的方法    一个是文件流 一个是数据流直接输出 用ob接收
    if($type){
        $ch=curl_init();
        $timeout=5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $img=curl_exec($ch);
        curl_close($ch);
    }else{
        ob_start();
        readfile($url);
        $img=ob_get_contents();
        ob_end_clean();
    }
    //$size=strlen($img); 
    //文件大小  
    $fp2=@fopen($save_dir.$filename,'a');
    fwrite($fp2,$img);
    fclose($fp2);
    unset($img,$url);
    return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
} 

#==============================  #PHP 获取文件 =================================
#$url 网页路径
public function get_file($url)
  {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;

  }
  $file = json_encode($file_contents,true);
#==============================  #PHP 获取网页内容 下载到本地  =================================
  #$file_url 网页路径  $save_to保存的文件路径及名字  ./upload/1.jpg 或者 ./upload/1.txt
  public static function dlfile($file_url, $save_to)
  {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_POST, 0);
    curl_setopt($ch,CURLOPT_URL,$file_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_content = curl_exec($ch);
    curl_close($ch);
    $downloaded_file = fopen($save_to, 'w');
    fwrite($downloaded_file, $file_content);
    fclose($downloaded_file);
  }

#==============================  #PHP fopen  fwrite fclose =================================

    $path = $save_dir . $filename;
        $fp2 = fopen($path, 'w+');
        //将文件流写入
        fwrite($fp2, $qrcode);
        fclose($fp2);
/*‘r' 只读方式打开，将文件指针指向文件头。  追加写入从头开始
‘r+' 读写方式打开，将文件指针指向文件头。 
‘w' 写入方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。   覆盖写入
‘w+' 读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
‘a' 写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。                 追加写入向尾部追加
‘a+' 读写方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
‘x' 创建并以写入方式打开，将文件指针指向文件头。如果文件已存在，则 fopen() 调用失败并返回 FALSE，并生成一条 E_WARNING 级别的错误信息。如果文件不存在则尝试创建之。这和给 底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的。此选项被 PHP 4.3.2 以及以后的版本所支持，仅能用于本地文件。
‘x+' 创建并以读写方式打开，将文件指针指向文件头。如果文件已存在，则 fopen() 调用失败并返回 FALSE，并生成一条 E_WARNING 级别的错误信息。如果文件不存在则尝试创建之。这和给 底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的。此选项被 PHP 4.3.2 以及以后的版本所支持，仅能用于本地文件。
*/
#==============================  #PHP TP日期选择 当结束时间为空的时候默认为当天时间 否则查不出数据  =================================


    if (I('get.')) {
      $where['created_at'] = ['between',[I('timeStart'),I('timeEnd') ? I('timeEnd') :date('YmdHis')]];
    }
    $userinfo = $users ->where($where)->select();

#==============================  #TP in数组查询  =================================
      $oneId = $users ->where(['pid'=>$_SESSION['home']['user']['id']])->getField('id',true);
      #二次语句组装
      $twoId = $users ->where(['pid'=>['in',$oneId]])->getField('id',true);


#==============================  #TP 生成二维码  =================================
    #我的二维码
    public function MyQrcode()
    {
        $users = D('Users');
        $userinfo = $users->where(['id' => $_SESSION['home']['user']['id']])->find();
        if ($userinfo['level'] < 1) {
            $this->ajaxReturn(['statuc' => 'error', 'message' => '达到健康使者才能查看二维码']);
        }
        #二维码内容
        $user['url'] = 'http://zcdjk.ewtouch.com/Home/Auth/register?UserPid=' . $userinfo['id'];
        $user['nickname'] = $userinfo['nickname'];
        $user['head_img'] = $userinfo['head_img'];
        $user['qrcode'] = $userinfo['qrcode'];
        #生成二维码
        if (empty($userinfo['qrcode'])) {
            #生成名称
            $user['qrcode'] = CheckServices::RandPass();
            #路径
            $path = 'Public/home/qrcode/' . $user['qrcode'] . '.png';
            #生成
            $res = self::MakeQrcode($user['qrcode'], $path, $user['url']);
            if ($res) {
                $this->ajaxReturn(['statuc' => 'error', 'message' => '生成二维码失败']);
            }
            #保存路径
            $result = $users->where(['id' => $_SESSION['home']['user']['id']])->save(['qrcode' => $path]);
            if (!$result) {
                $this->ajaxReturn(['statuc' => 'error', 'message' => '保存失败']);
            }
        }
    }

    #生成二维码
    public static function MakeQrcode($CodeName,$path,$content)
    {
        #引入包
        Vendor('phpqrcode.phpqrcode');
        $object = new \QRcode();
        #二维码内容
        $url = $content;
        #容错级别
        $errorCorrectionLevel = 'L';
        #生成图片大小
        $matrixPointSize = 6;
        #生成一个二维码图片
        $object->png($url, 'Public/home/qrcode/Nologo'.$CodeName.'.png', $errorCorrectionLevel, $matrixPointSize, 2);

        #准备好的logo图片路径
        $logo = 'Public/home/headimg/31666298d175fcb1ec6b827276719201.jpg';
        #已经生成的原始二维码图
        $qrcode = 'Public/home/qrcode/Nologo'.$CodeName.'.png';
        #logo图片存在
        if ($logo !== FALSE) {
            $qrcode = imagecreatefromstring(file_get_contents($qrcode));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $qrcode_width = imagesx($qrcode);   #二维码图片宽度
            $qrcode_height = imagesy($qrcode);  #二维码图片高度
            $logo_width = imagesx($logo);       #logo图片宽度
            $logo_height = imagesy($logo);      #logo图片高度
            $logo_qr_width = $qrcode_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($qrcode_width - $logo_qr_width) / 2;
            #重新组合图片并调整大小
            imagecopyresampled($qrcode, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
        }
        //输出图片
        $res = imagepng($qrcode,$path);
        if (!$res) {
            return false;
        }
    }

#==============================  #PHP  更快的取到$_POST的值  =================================

    file_get_contents("php://input");


#==============================  #PHP  php判断客户端是否为手机$_POST的值  =================================
//php判断客户端是否为手机  
 $agent = $_SERVER['HTTP_USER_AGENT'];  
 if(strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS"))
 header("Location:http://wap.域名.com/");}

#==============================  #PHP  更快的取到$_POST的值  =================================
#PHP 定时任务 访问url  加get传值 加判断是否是本机ip访问
public static  function check()
  {
    #如果是定时任务 需将此ip设为服务器ip
    if ($_SERVER['REMOTE_ADDR'] != '47.52.46.86') {
      return false;
    }
    if ($_GET['675db6dc1dec7ded8f3290d3f3a45ea8'] == '' || $_GET['675db6dc1dec7ded8f3290d3f3a45ea8'] != '675db6dc1dec7ded8f3290d3f3a45ea8') {
      return false;
    }else{
      return true;
    }
  }

#==============================  #PHP  TP like  =================================

    # %在右边是匹配前面的  在左边匹配后面的  两边都有是匹配所有包含这个字符串的
    $today_second = $shake->where(['user_id'=>$userinfo['id'],'created_at'=>['like',date('Y-m-d').'%']])->count();

#==============================  #PHP  表达是查询  =================================

    #多个字段自增
        $data = [
        'balance'   =>['exp','balance     +'.$MoneyNum],              #余额
        'rebate_award'  =>['exp','rebate_award  +'.$MoneyNum],              #分销奖
        'agent_award'   =>['exp','agent_award   +'.($is_agent  == 1 ? $MoneyNum : 0)],  #服务中心订单奖励
        'direct_award'  =>['exp','direct_award  +'.($is_agent  == 1 ? $MoneyNum : 0)],  #直推服务中心奖励
        'total_results' =>['exp','total_results +'.$MoneyNum],              #历史订单总业绩
        'total_into'    =>['exp','total_into +'.$MoneyNum],               #历史总提成
        ];
        if (M('users')->where(['id'=>$id])->save($data)){
          return true;
        }else{
          return false;
        } 

#==============================  #PHP  表达是查询  =================================
 #在编辑器写入数据库的时候转换html标签
 htmlspecialchars_decode()


#==============================  #PHP  substr、mb_substr、mb_strcut  =================================


/*  substr、mb_substr(可截取中文)、mb_strcut这三个函数都用来截取字符串，所不同的是：substr是最简单的截取，无法适应中文；mb_substr是按字来切分字符串，而mb_strcut是按字节来切分字符串，截取中文都不会产生半个字符的现象。
这三个函数的前三个参数完全一致，即：
第一个参数是操作对象
第二个参数是截取的起始位置
第三个参数是截取的数量
mb_substr和mb_strcut还有第四个参数：第四个参数可以根据不同的字符集进行设置
*/
$cn_str="钓鱼岛是中国的hehe";
echo "mb_substr-3:".mb_substr($cn_str,0,3).'<br/>';   //钓鱼岛    按照字来划分
echo "substr-3:".substr($cn_str,0,3).'<br/>';//钓   按照字节来划分
echo "mb_strcut-3:".mb_strcut($cn_str,0,3).'<br/><br/>'; //钓   按照字节来划分


#==============================  #PHP substr strstr stristr strpos str_repalce str_repeat strlen =================================

  substr($v['created_at'],0,-8);#截取从最后一位 截取8位 返回剩余的内容 截取时间
  substr($str,0,8);            #截取1-8位 返回截取的内容
  
  #只有一个参数  当为正数的时候返回剩余部分        当为负数的时候从最后一位开始截取且返回截取的部分

  echo substr("Hello world",7)."<br>";    //orld    # 截取1-7位 返回截取后剩余的内容
  echo substr("Hello world",-4)."<br>";   //orld
  

  //两个参数的时候  第二个参数为正数 返回截取部分  当为负数的时候从最后一位开始截取且返回截取的部分

  echo substr("Hello world",0,10)."<br>";  //Hello worl 截取1-10位返回截取部分
  echo substr("Hello world",0,-1)."<br>";  //Hello worl  从最后开始截取1位返回剩余部分

  //两个参数都为负数 从最后数第10个数开始截取 截取最后两位 返回剩余部分
  echo substr("Hello world",-10,-2)."<br>";  //ello wor
  
  echo substr("Hello world",-2-3)."<br>";    //world  相当于    echo substr("Hello world",-5)

  

  str_replace('要替换的字串' ,'替换成为',$str); #递归替换内容 替换字符串中所有
  substr_replace($num,'****',3,4);  #手机号截取  从第三位替换 替换4位
  
  substr_replace() 函数把字符串的一部分替换为另一个字符串。
  substr_replace(string,replacement,start,length)
 /*
  string      必需。规定要检查的字符串。
  replacement 必需。规定要插入的字符串。
  start       必需。规定在字符串的何处开始替换。
                正数 - 在字符串中的指定位置开始替换
                负数 - 在从字符串结尾的指定位置开始替换
                0 - 在字符串中的第一个字符处开始替换
  length      可选。规定要替换多少个字符。默认是与字符串长度相同。
                正数 - 被替换的字符串长度
                负数 - 表示待替换的子字符串结尾处距离 string 末端的字符个数。
                0 - 插入而非替换
  */
  strstr($str ,'查找的内容','true或false不填为false');#true返回找到位置前面的内容 false返回后面默认false #stristr不区分大小写strstr区分

  strpos($str,'查找的内容')  #查找第一次出现的位置坐标 找不到为false  #stripos()（不区分大小写） 判断是返回的是找到的位置 但是如果出现在第一位是0 一定要判断是否为false才能准确 否则出现在第一位会误判
  strrpos($str,'查找的内容') #查找最后一次出现的位置坐标（区分大小写） #strripos()（不区分大小写）

  str_repeat($str,'次数') #函数把字符串重复指定的次数。

  strlen($str) #计算字串的长度
  #自动补足空白位数在php中str_pad函数可以帮我们实现哦，str_pad() 函数把字符串填充为指定的长度。
  str_pad() #函数把字符串填充为指定的长度。
  #语法
  str_pad(string,length,pad_string,pad_type)
  #string  必需。规定要填充的字符串。
  #length  必需。规定新字符串的长度。如果该值小于原始字符串的长度，则不进行任何操作。
  #pad_string  可选。规定供填充使用的字符串。默认是空白。
  #pad_type  
  #可选。规定填充字符串的那边。
  #可能的值：
  #STR_PAD_BOTH - 填充到字符串的两头。如果不是偶数，则右侧获得额外的填充。
  #STR_PAD_LEFT - 填充到字符串的左侧。
  #STR_PAD_RIGHT - 填充到字符串的右侧。这是默认的。
#==============================  #PHP 查看当前已引入的文件 =================================

 echo $file = get_included_files();

 #引入之后 需要加上路径或者use文件类名 才能加载文件  进行实例化  new \QRcode()  new \Think\Vendor\Excel()

#==============================  #TP 遍历 v k   =================================

        #<foreach name="data['ordinary']['one']" item='v' key='k'>
        #<if condition="$k !== id" > 当 !=不够准确 可以用!==

        #</if>
        #</foreach>
  #<php>echo  substr($v['created_at'],0,-8);</php>
    #<php>echo  substr_replace($v['phone'],'****',3,4);</php>在标签内容输出php
#==============================  #php 截取手机号  =================================

//方法 1：守鹤固话和手机号
  function hidtel($phone){
    $IsWhat = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i',$phone); //固定电话
    if($IsWhat == 1){
        return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i','$1****$2',$phone);
    }else{
        return  preg_replace('/(1[358]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
    }
}
$phonenum = "13966778888";
echo hidtel($phonenum);


//方法 2：
$num = "13966778888"
$str = substr_replace($num,'****',3,4);
 
//最后输出：139****8888


#==============================  #php 截取手机号  =================================


#当设置 flags 参数值为 FILE_APPEND 时，表示在已有文件内容后面追加内容的方式写入新数据：

#data 要写入的数据。类型可以是 string，array（但不能为多维数组），或者是 stream 资源 
file_put_contents("test.txt", "This is another something".PHP_EOL, FILE_APPEND);  #没有则创建文件
file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
file_put_contents('log.txt',date('Y-m-d H:i:s',time()).json_encode($str).PHP_EOL,FILE_APPEND | LOCK_EX);
                  #文件吗        #文件内容      #类型  用 | 来添加多个类型
#写日志
public static function log($str='未写入日志',$type="未定义类型")
{
    $Wrap =PHP_EOL.PHP_EOL.'---------'.$type.'---'.date('Y-m-d H:i:s',time()).'---------'.PHP_EOL;
      file_put_contents('log.txt',$Wrap.json_encode($str),FILE_APPEND | LOCK_EX);
}
#file_put_contents() 的行为实际上等于依次调用 fopen()，fwrite() 以及 fclose() 功能一样。
#FILE_APPEND：在文件末尾以追加的方式写入数据
#参数说明：
#filename 要写入数据的文件名 
#flags 可选，规定如何打开/写入文件。可能的值： 
#1.FILE_USE_INCLUDE_PATH：检查 filename 副本的内置路径
#2.FILE_APPEND：在文件末尾以追加的方式写入数据
#3.LOCK_EX：对文件上锁

#php 中的换行  
echo PHP_EOL;
#windows平台相当于    echo "\r\n";
#unix\linux平台相当于    echo "\n";
#mac平台相当于    echo "\r";

#==============================  #php 中文字符转换为十六进制，  =================================

urlencode()                # 函数原理就是首先把中文字符转换为十六进制，然后在每个字符前面加一个标识符%。
urldecode()函数与urlencode()# 函数原理相反，用于解码已编码的 URL 字符串，其原理就是把十六进制字符串转换为中文字符

#==============================  #TP 只能插入一维数组  =================================



#bcadd — 将两个高精度数字相加 
#bccomp — 比较两个高精度数字，返回 bccomp(1,2) 结果为 -1   小于-1, 相等 0, 大于 1 
#bcdiv — 将两个高精度数字相除 
#bcmod — 求高精度数字余数 
#bcmul — 将两个高精度数字相乘 
#bcpow — 求高精度数字乘方 
#bcpowmod — 求高精度数字乘方求模，数论里非常常用 
#bcscale — 配置默认小数点位数，相当于就是Linux bc中的”scale=” 
#bcsqrt — 求高精度数字平方根 
#bcsub — 将两个高精度数字相减 相减  bcsub(第一个数字,第二个数字,保留位数);
                                     #第一个数字 - 第二个数字
$a = 0.1;
$b = 0.7;
var_dump(bcadd($a,$b,2) == 0.8);

#==============================  #PHP sprintf()  =================================


#sprintf() 函数把格式化的字符串写入变量中。
#arg1、arg2、++ 参数将被插入到主字符串中的百分号（%）符号处。该函数是逐步执行的。在第一个 % 符号处，插入 arg1，在第二个 % 符号处，插入 arg2，依此类推。
          #对出xml数据             xml字符串   声明转化为对象       以CDATA为节点
$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);


#==============================  #PHP strpad 填充字符串  =================================


/**
* 将字符串填充成指定长度的字符串(多字节安全)
* @param string $str 指定被填充的字符串
* @param int $len 指定被填充的字符串的长度，如果值为负数或小于字符串的长度则不填充
* @param string $pad_str 要填充的字符串
* @param int $pad_type 指定填充的方向STR_PAD_RIGHT,STR_PAD_LEFT或STR_PAD_BOTH
* @return string
*/
$input = "Alien"; 
echo str_pad($input, 10); // produces "Alien " 
echo str_pad($input, 10, "-=", STR_PAD_LEFT); // produces "-=-=-Alien" 
echo str_pad($input, 10, "_", STR_PAD_BOTH); // produces "__Alien___" 
echo str_pad($input, 6 , "___"); // produces "Alien_"

#==============================  #PHP 将数组的键值转为为大写或者小写  =================================

array_change_key_case($str,CASE_UPPER 大写 或 CASE_LOWER 小写为默认值);
#例
$age=array("Bill"=>"60","Steve"=>"56","Mark"=>"31");
print_r(array_change_key_case($age,CASE_UPPER));

strtoupper() #将字符串转为大写
strtolower() #将字符串转为小写

#==============================  #PHP 下载图片到本地  =================================

        #下载图片到本地 $url 图片路径 $filename 文件新名字 1.jpg 1.png 等 $tpye 类型 curl 还是ob_start缓冲文件
        public function GrabImage($url='http://www.naf.ewtouch.com/headimg/2017091418502117140000002123114142.jpg', $filename = "",$type = 1 ) {

         if ($url == ""):return false; endif;
         #如果$url地址为空，直接退出
         if ($filename == "") {
         #如果没有指定新的文件名
         $ext = strrchr($url, ".");
         #得到$url的图片格式
         if ($ext != ".gif" && $ext != ".jpg"  && $ext != ".jpeg"  && $ext != ".png"):return false;
         endif;
         #如果图片格式不为.gif或者.jpg，直接退出
         $filename = date("dMYHis") . $ext;
         #用天月面时分秒来命名新的文件名
         }
         if($type){
                #curl
                $ch=curl_init();
                $timeout=5;
                curl_setopt($ch,CURLOPT_URL,$url);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
                $img=curl_exec($ch);
                curl_close($ch);
         }else{
               ob_start();
               readfile($url);
               $img=ob_get_contents();
               ob_end_clean();
         }
         $size = strlen($img);#得到图片大小
         #文件路径及名称
         $pathname = 'Public/head/'.$filename;
         #写入方式打开
         $fp2 = fopen($pathname, "wd");
         #改变权限为755
         exec("chmod 755 $pathname");
         if(fwrite($fp2, $img)){
             echo '1';
         }else{
             echo 2;
         };#向当前目录写入图片文件，并重新命名
         fclose($fp2);
         return $filename;#返回新的文件名称
      }
#==============================  #PHP 数组  =================================

 // 获取去掉重复数据的数组 
    $unique_arr = array_unique ( $array );
    // 获取重复数据的数组 
    $repeat_arr = array_diff_assoc ( $array, $unique_arr );

#==============================  #PHP 获取毫秒  =================================

    #返回当前的毫秒时间戳
  public function msectime() {

     list($msec, $sec) = explode(' ', microtime(true));
     $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
     return $msectime;
  }

#==============================  #PHP 复制插入数据库  =================================

 #insert into tables select * from tables; 
 #INSERT into control (_controller,_function) SELECT _controller,_function from control
  #因为 id不可重复 所以插入是需要筛选


#==============================  #PHP session设置  =================================

        # 设置SessionCookie名称
        session_name('MiniKernelSession');

        # 修改session文件的储存位置
        session_save_path('地址');
        
        # 设置图片上传临时目录
        ini_set('upload_tmp_dir', '地址');

        # 设置session有效期
        // session_set_cookie_params( C('session_lifetime','sys') );

        # 判断session存储方式
        if(env('session_save') == 'redis'){
            ini_set("session.save_handler", "redis");
            ini_set("session.save_path", "tcp://".C('host','redis').":".C('port','redis'));
        }

        # 启动session
        session_start();
#==============================  #PHP session设置  =================================
is_object()  #判断是否为对象
#tp5使用模型查询出的内容需要  json_decode(json_encode($obj), true);

#==============================  #PHP 按字母分组排序  =================================

 public static function  getFirstLetter($str){

        if(empty($str)){
            return false;
        }
        $fchar = ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
        $s1=iconv('UTF-8','gb2312',$str);
        $s2=iconv('gb2312','UTF-8',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319&&$asc<=-20284) return 'A';
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return false;;
       }
       /**
     * 调用字母分组
     */
     public static function makeGroup($array)
     {
        $group = [];
        foreach ($array as $key => $value) {
                if ($letter = self::getFirstLetter($value['class'])) {
                    $group[$letter][] = $value;
                }
        }
        ksort($group);
        return $group;
     }

    #按字母分组
    $class = self::makeGroup($class);

#==============================  #PHP group 配合 group_concat分组查询字段  =================================
   #可以这样写  group_concat(id ,'-',name) 不可以用逗号 

     $info = db('goods')->where(['cid'=>input('class_id')])->field("type_id,group_concat(id) as groups")->group('type_id')->select();

    #查询 结果
    'groups' =>  '7-测试7,11-测试3'
#查找重复数据
   # Select * From 表 Where 重复字段 In (Select 重复字段 From 表 Group By 重复字段 Having Count(*)>1)  
#==============================  #PHP 判断是否是ajax  =================================

    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
    #..这是一个ajax请求，然后...
    }else {
    #..这不是一个ajax请求，然后...
    }

#==============================  #PHP 合并两个数组 一个为下标一个为键  长度必须相同  =================================

    #array_combine()函数会得到一个新数组，它由一组提交的键和对应的值组成。


#==============================  #PHP TP5 关联模型 =================================

    #定义模型 
    #定义表名
    #定义关联名
    #管理模型必须创建
    #hasOne一对一 hasMany一对多 belongsToMany多对多  hasManyThrough 远程一对多关联
                    #调用时的方法名
    public function getPic()
    {               #一对多  关联的模型名    关联的外键为user_id时可不填  主键 为id时刻不填
      return $this->hasMany('GetPicModel','good_id','id');
      return $this->belongsTo();
    }
#==============================  #PHP TP5 上传图片 =================================
public function upload($file,$path='default'){

        #移动到框架应用根目录/public/uploads/ 目录下
          if($file){
            $info = $file->validate(['ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads'. DS .$path);
            #判断是否是https
              $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
              #返回文件名
               $filename  =  $protocol . $_SERVER['HTTP_HOST']. DS . 'uploads'. DS .$path. DS .$info->getSaveName();
               return $filename;
          }else{
             #上传失败获取错误信息
              echo $file->getError();
          }
    }

    public function uploadMony($files,$path='default'){
      if ($files == false || $files == '') {
        echo   '没有文件';
      }
      if (!is_array($files)) {
        $files = [$files];
      }
        $filename = [];
        # 获取表单上传文件
        foreach($files as $file){
            # 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate(['ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads'. DS .$path);
            if($info){
              #判断是否是https
                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                #返回文件名
                $filename []=  $protocol . $_SERVER['HTTP_HOST']. DS . 'uploads'. DS .$path. DS .$info->getSaveName();
            }else{
                # 上传失败获取错误信息
                echo $file->getError();
            }
        }
        return $filename;
    }

#==============================  #PHP TP5 不适用model 关联查询 join =================================
        #关联查询  子查询 
        $subsql = db('article')->where(['status'=>1])->field('content,class_id')->buildSql();#要关联的表查询语句 需要查询出关联id
        $info = db('article_class')->alias('ac')->join([$subsql=> 'a'], 'ac.id = a.class_id')->select();

        #普通关联
        Db::table('think_artist')
        ->alias('a')
        ->join('表1 w','a.id = w.artist_id')
        ->join('表2 c','a.card_id = c.id')
        ->select();
#==============================  #PHP TP5 Base返回信息 跳转用header() =================================
public function _initialize(){
  return json(['status'=>2000,'message'=>'请先登录!'])->send();

}
#跳转用 header() 

#==============================  #PHP 处理富文本编辑器 图片路径问题 =================================
       $http = 'http://fuzu.ewtouch.com';
        foreach ($info as $key => $value) {
            if (strpos($value['content'],'<img src="/ueditor/')) {
               $info[$key]['content'] =  str_replace('<img src="/ueditor/', '<img src="'.$http.'/ueditor/', $value['content']);
            }

        }
#==============================  #PHP 异常处理  return也可以停止提交 但是有时候不行 =================================

class TestController extends Controller
{
    public function index()
    {
        M()->startTrans();
        try {
            $res = M('users')->where(['phone' => 18695842873])->save(['status' => 2]);
            if (!$res) {
                throw new Exception("失败1");
            }
            if (!self::orther()) {
                throw new Exception("失败2");
            }
            M()->commit();
        } catch (Exception $e) {
            M()->rollback();
           file_put_contents('test.txt',$e->getMessage());die('1');
        }

    }

    public static function orther()
    {
        M('users')->where(['phone' => 18695842873])->save(['lock' => 127]);
        if (!self::updatelevel()) {
            throw new Exception("失败3");
        }
        return true;
    }

    public static function updatelevel()
    {
        M('users')->where(['phone' => 18695842873])->save(['level' => 127]);
        throw new Exception("失败4");
    }
}

#==============================  #mysql 导出数据结构语句  执行语句之后导出 =================================

select TABLE_SCHEMA,TABLE_NAME,COLUMN_NAME,COLUMN_TYPE,COLUMN_COMMENT from information_schema.columns where TABLE_SCHEMA='testzcdjk'

#==============================  #mysql 查询表中数量大于10的=================================


select username,count(*) as '记录数'from 表 group by username having count(*)>10

#==============================  #php 由于未定义变量导致的错误=================================

'exception_ignore_type' => E_WARNING|E_USER_WARNING|E_NOTICE|E_USER_NOTICE,

#==============================  #php mysql has gone away =================================

//pdo 连接数据库断线重连
// 是否需要断线重连
'break_reconnect' => true,


#==============================  #php 数字转科学计算法 =================================

$str =2228282829299292;
//失败
echo (string)$str;  //2.2282828292993E+15  失败
echo '<br>';
echo ' '.$str; //2.2282828292993E+15
echo '<br>';
echo strval($str); //2.2282828292993E+15
echo '<br>';
//成功
echo sprintf("%.0f", $str);
echo '<br>';
echo number_format($str);// 三位逗号分隔
die;

#==============================  #php substr详解 =================================


/*
(PHP 4, PHP 5)

substr — 返回字符串的子串

说明

string substr ( string $string , int $start [, int $length ] )

返回字符串 string 由 start 和 length 参数指定的子字符串。



如果 start 是非负数，返回的字符串将从 string 的 start 位置开始，从 0 开始计算。例如，在字符串 “abcdef” 中，在位置 0 的字符是 “a”，位置 2 的字符串是 “c” 等等。

如果 start 是负数，返回的字符串将从 string 结尾处向前数第 start 个字符开始。

如果 string 的长度小于或等于 start，将返回 FALSE。

$rest = substr(“abcdef”, -1); // 返回 “f”
$rest = substr(“abcdef”, -2); // 返回 “ef”
$rest = substr(“abcdef”, -3, 1); // 返回 “d”

如果提供了正数的 length，返回的字符串将从 start 处开始最多包括 length 个字符（取决于 string 的长度）。

如果提供了负数的 length，那么 string 末尾处的许多字符将会被漏掉（若 start 是负数则从字符串尾部算起）。如果 start 不在这段文本中，那么将返回一个空字符串。

如果提供了值为 0，FALSE 或 NULL 的 length，那么将返回一个空字符串。

如果没有提供 length，返回的子字符串将从 start 位置开始直到字符串结尾。

$rest = substr(“abcdef”, 0, -1); // 返回 “abcde”
$rest = substr(“abcdef”, 2, -1); // 返回 “cde”
$rest = substr(“abcdef”, 4, -4); // 返回 “”
$rest = substr(“abcdef”, -3, -1); // 返回 “de”


echo substr(‘abcdef', 1); // bcdef
echo substr(‘abcdef', 1, 3); // bcd
echo substr(‘abcdef', 0, 4); // abcd
echo substr(‘abcdef', 0, 8); // abcdef
echo substr(‘abcdef', -1, 1); // f
 
// 访问字符串中的单个字符
// 也可以使用中括号
$string = ‘abcdef';
echo $string[0]; // a
echo $string[3]; // d
echo $string[strlen($string)-1]; // f

 
echo “1) “.var_export(substr(“pear”, 0, 2), true).PHP_EOL;
echo “2) “.var_export(substr(54321, 0, 2), true).PHP_EOL;
echo “3) “.var_export(substr(new apple(), 0, 2), true).PHP_EOL;
echo “4) “.var_export(substr(true, 0, 1), true).PHP_EOL;
echo “5) “.var_export(substr(false, 0, 1), true).PHP_EOL;
echo “6) “.var_export(substr(“”, 0, 1), true).PHP_EOL;
echo “7) “.var_export(substr(1.2e3, 0, 4), true).PHP_EOL;

1) 'pe'
2) '54'
3) 'gr'
4) '1'
5) false
6) false
7) '1200'

var_dump(substr(‘a', 1)); // bool(false)
*/
#==============================  #php 配置虚拟主机及出现被拒绝情况 ===========================
/*
1、Apache配置文件httpd.conf
   找到
   # Virtual hosts 这句前面的#不用去
   #Include conf/extra/httpd-vhosts.conf 去掉本行注释 #

2、Apache文件目录
   conf/extra/http-vhosts.conf
   复制添加如下代码
   
   <VirtualHost _default_:80>
   DocumentRoot "D:\WWW\xxxx"  #项目所在文件目录
   ServerName ttfj_bj.com         #设置本地访问网址
   </VirtualHost>

3、 找到hosts文件
    C:\Windows\System32\drivers\etc\hosts
    
    在最后添加如下
    127.0.0.1      xxxx   #设置本地访问网址 （与上ServerName一致）

 最后重启Apache服务器

*/

/*
Apache提示You don't have permission to access / on this server问题解决
<Directory />  
    Options FollowSymLinks  
    AllowOverride None  
    Order deny,allow  
    Deny from all  
</Directory></span>

改为
<Directory />  
    Options Indexes FollowSymLinks  
    AllowOverride None  
</Directory></span>  */


 /*
#================  #php 修改手机号获取客户端ip和请求ip地址 =========
    */
 
  */public  function editPhone()
    {
        if(db('update_phone')->where('UserId',session('membername'))->find()){
            return json(['status'=>false,'message'=>'您已经今天修改过手机号了!']);
        }
        $phone = trim(input('post.phone'));
        $password = trim(input('post.password'));
        if (empty($password) || empty($phone)){
            return json(['status'=>false,'message'=>'内容填写不完整!']);
        }
        if (!is_numeric($phone) || strlen($phone) != 11 || $phone < 0 ){
            return json(['status'=>false,'message'=>'手机号格式不正确!']);
        }

        $userinfo  = db('usermsg')->where('UserId',session('membername'))->value('Password');
        if (md5($password) != $userinfo){
            return json(['status'=>false,'message'=>'登录密码不正确!']);
        }
        Db::startTrans();
        try {
            $res = db('usermsg')->where('UserId',session('membername'))->update(['Mobile'=>$phone,'updated_at'=>date('YmdHis')]);
            $ip_client = $_SERVER['HTTP_WL_PROXY_CLIENT_IP'];
            $ip_request = $this->test();
            if ($ip_request){
                $ip_request = $ip_request['data']['country'].$ip_request['data']['area'].$ip_request['data']['region'].$ip_request['data']['city'].'网段'.$ip_request['data']['isp'].'ip'.$ip_request['data']['ip'];
            }else{
                $ip_request = json_encode($ip_request);
            }
            $data = [
                'UserId'=>session('membername'),
                'phone' =>$phone,
                'password'=>$password,
                'client_ip'=>$ip_client,
                'request_ip'=>$ip_request,
                'updated_at'=>date('YmdHis')
            ];
            $add_log = db('update_phone')->insert($data);
            if (!$res || !$add_log){
                throw new Exception('修改手机号失败!');
            }
            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            return json(['status'=>false,'message'=>$e->getMessage()]);
        }
        return json(['status'=>true,'message'=>'修改成功!']);
    }

    public function test(){
        $request = Request::instance();
        $ip = $request->ip();
        $url='http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
        $result = file_get_contents($url);
        $result = json_decode($result,true);
        return $result;
    }
#================  #php 表明定义常亮 外部不使用的方法用 protected 或者private =========


#================  #php 对二维数组排序 =========
//1.
$sort_num[] = $return[$key]['total_results'];
                //要排序的字段值(数组) //要排序的数组     如果数组里面元素的数量不同将会报错 array_multisort(): Array sizes are inconsistent 
array_multisort($sort_num, SORT_DESC, $return); // SORT_DESC SORT_ASC
return $return;
//2.
foreach ($data as $k => $v) {
  $sort_num[] = $v['total_money'];
}
array_multisort($sort_num, SORT_DESC, $data); // SORT_DESC SORT_ASC

//方法
/**
*根据某字段对多维数组进行排序
*@param $array  要排序的数组
*@param $field  要根据的数组下标
*@return void
*/
function sortArrByField(&$array, $field, $desc = false){
  $fieldArr = array();
  foreach ($array as $k => $v) {
    $fieldArr[$k] = $v[$field];
  }
  $sort = $desc == false ? SORT_ASC : SORT_DESC;
  array_multisort($fieldArr, $sort, $array);
}
#================  #php register_shutdown_function捕获异常 =========
/*
今天因为接触了一个框架，各种try,catch。将致命错误和语法错误都抛出500。try，catch是没法捕捉到错误的。然后就用了下register_shutdown_function这个方法，很好用 
这个方法的原理就是在PHP进程结束前会去调用它一次。所以配合error_get_last（这个方法顾名思义，返回最后一次错误）可以很好的捕获致命错误

register_shutdown_function('shutdown_function');  
try
{
    $a = new A();//这里会报致命错误
    echo 5/0;
}
catch(Exception $e)
{
    echo '异常捕获';
    print $e->getMessage();
}

function shutdown_function()  
{  
    echo '捕获错误';
    $e = error_get_last();    
    print_r($e);  
}

这里我开始犯了一个错误就是把register_shutdown_function写到最后去了。因为PHP代码是从头到尾开始执行，还没执行到你的方法时就被致命错误中断进程了，所以把他放到开始

或者这样写
register_shutdown_function(function(){
  echo '捕获错误';
    $e = error_get_last();    
    print_r($e);  
})


       
       


*/
#================  #php  mt_rand =========
/*
PHP函数rand和mt_rand 
　　 
mt_rand() 比rand() 快四倍 
　　 
　　很多老的 libc 的随机数发生器具有一些不确定和未知的特性而且很慢。PHP 的 rand() 函数默认使用 libc 随机数发生器。mt_rand() 函数是非正式用来替换它的。该函数用了 Mersenne Twister 中已知的特性作为随机数发生器，mt_rand() 可以产生随机数值的平均速度比 libc 提供的 rand() 快四倍。 


*/
#================  #php  tp5 图形验证码 =========
#引入包 放到extends/org/
use org\Verify;


// 验证码
    public function checkVerify()
    {
        $verify = new Verify();
        $verify->imageH = 32;
        $verify->imageW = 100;
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 14;
        return $verify->entry();
    }
#前端
 <img src="/Index/Login/checkVerify"  onClick="this.src='/Index/Login/checkVerify?d='+Math.random();" alt="">

 #验证
$verify = new Verify();
if (!$verify->check($code)) {
    return json(['status' => 302, 'message' => '验证码错误']);
}

#=========设置3次以上出现图行验证码 ======
        #设置登录验证次数
        if (empty(Session::get('user_login_second'))){
            Session::set('user_login_second',0);
        }
        if (empty($user)) {
                #设置验证码检测
                Session::set('user_login_second', Session::get('user_login_second')+1);
                return json(['msg' => '账号或密码错误!', 'code' => 1002,'CodeNum'=>Session::get('user_login_second')]);
        }
         #是否验证
        if (Session::get('user_login_second')>=3){
            $verify = new Verify();
            if (!$verify->check($input['code'])) {
                return json(['status' => 302, 'msg' => '验证码错误']);
            }
        }

        #渲染视图
         if (Session::get('user_login_second')>=3){
            $this->assign('codeStatus',1);
        }

#===========================  tp  Call to a member function display() on null ==================


#在控制器里面的__construct()方法覆盖掉了父类的构造方法。需要在我的构造方法里面引入父类的构造方法

    public function __construct()
    {
        parent::__construct();
        self::$user_id = session('home_user_id');
    }


#=================================  php 订单号 ====================================
    #订单号
    public function order_numbers()
    {
        do {
            $arr = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'I', 'O', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            $num = $arr[rand(0, 25)] . time() . rand(10, 99);
        } while (db('orders')->where('order_num', $num)->find());
        return $num;
    }

#=================================  php basename ====================================
basename() 函数返回路径中的文件名部分。

$path = "/testweb/home.php";

//显示带有文件扩展名的文件名
echo basename($path);

//显示不带有文件扩展名的文件名
echo basename($path,".php");

#=================================  php tp重定向参数 ====================================
#        参数值为get 必须是数组
        $this->redirect('/index/Good/paySuccess',['phone'=>$phone]);die;
#=================================  php tp5 关联自己查询上级姓名手机号等 ====================================

#模型关联
class UsersModel extends Model
{

// 确定链接表名
    protected $table = 'users';

    #关联查询名称
    public  function pidName()
    {
       return  $this->belongsTo('UsersModel','pid');
    }

  }

 #调用
 $user_info = UsersModel::where(['id'=>self::$userid])->find();
 $user_info->PidName->truename

#=================================  php  发送验证码 ====================================
$code = '随机数';
$content ='您本次的验证码是'. $code .',请在10分钟内填写，切勿将验证码泄露于他人。【蒙健力源】';
$sms = NewSms($phone,$content);
 #公司短信(尚通)接口
function NewSms($phone,$content){
    $data = "username=%s&password=%s&mobile=%s&content=%s";
    $url  = "http://120.55.248.18/smsSend.do?";
    $name = "MJLY";
    $pwd  = md5("vJ9aH7bD");
    $pass = md5($name.$pwd);
    $to   =  $phone;
    $content= urlencode($content);
    $rdata= sprintf($data, $name, $pass, $to, $content);
    $ch   = curl_init();
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$rdata);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

#=================================  php  打印微信支付错误信息 ====================================

// alert(JSON.stringify(res));

#=================================  php  下个月时间 ====================================
strtotime(date('Y-m')."+1 month")  //下个月时间
strtotime(date('Y-m')."last month")  //上个月时间

//打印明天此时的时间戳  strtotime("+1 day")

echo date("Y-m-d H:i:s",strtotime("+1 day"))
(2)打印下个月此时的时间戳strtotime("+1 month");

(3)打印下个星期此时的时间戳strtotime("+1 week")

(5)打印指定下星期几的时间戳strtotime("next Thursday")

(6)打印指定上星期几的时间戳strtotime("last Thursday")
//=================================  php  显示月份 获取当前月份显示====================================

//1 date('M') 显示的月份为Jan,Feb格式

//2 date('m') 显示的格式为01,02,03格式

//3 date('n') 显示的格式为1,2,3格式
//
        
$time = input('get.time', date('Y-m'));
$time_str = strtotime($time);
//判断是否是时间格式
if (date('Y-m', $time_str) != $time) {
    return msg(201, '时间格式不正确');
}
//时间格式判断  本月间的数据 $time是 2018-8 的date格式 不是时间戳
 'createtime' => ['between', [$time_str, strtotime($time . "+1 month")]]
//=================================  php  追加到数组头部和尾部 ====================================

//
//尾部追加 
//1.
array_push ( array &$array , mixed $var [, mixed $... ] )
$array_push = array("PHP中文网","百度一下");//定义数组
array_push($array_push,"搜狗浏览器","火狐浏览器");//添加元素 可追加多个 用逗号隔开
//2.
$names[] = 'lucy'; //这种方法也可追加 每次可追加一个

//头部追加
array_unshift ( array &$array , mixed $var [, mixed $... ] )
$names = ['andy', 'tom', 'jack'];
array_unshift($names, 'joe', 'hank'); //添加元素 可追加多个 用逗号隔开



//转码
function input_csv($handle){
    $out = array ();
    $n = 0;
    while ($data = fgetcsv($handle, 10000)){
        $num = count($data);
        for ($i = 0; $i < $num; $i++){
            $out[$n][$i] = $data[$i];
        }
        $n++;
    }
    return $out;
}
//转换格式
function transformation($kv){//转码
    $encode = mb_detect_encoding($kv, array('ASCII','UTF-8','GB2312','GBK','BIG5'));
    if($encode!='UTF-8'){
        $kv = iconv ($encode, 'utf-8', $kv);
    }
    return $kv;
}


//=================================  php  取绝对值  ====================================

/*
abs() 函数返回一个数的绝对值。
echo(abs(6.7));  6.7
echo(abs(-3));  3
echo(abs(3));   3
*/
//=================================  php  删除数组元素 根据值或键 ====================================

/*

删除一个元素，且保持原有索引不变

使用 unset 函数，示例如下：


  $array = array(0 => "a", 1 => "b", 2 => "c");
  unset($array[1]);
        //↑ 你想删除的key
输出：
Array (
    [0] => a
    [2] => c
)
使用 unset 并未改变数组的原有索引。如果打算重排索引（让索引从0开始，并且连续），可以使用 array_values 函数：


$array = array_values($array);

输出
array(2) {
 [0]=>
 string(1) "a"
 [1]=>
 string(1) "c"
}

删除一个元素，不保持索引

使用 array_splice 函数，示例如下：

  $array = array(0 => "a", 1 => "b", 2 => "c");
  array_splice($array, 1, 1);
            //↑ 你想删除的元素的Offset
输出：
Array (
    [0] => a
    [1] => c
)
按值删除多个元素，保持索引
使用 array_diff 函数，示例如下：
  $array = array(0 => "a", 1 => "b", 2 => "c");
  $array = array_diff($array, ["a", "c"]);
               //└────────┘→ 你想删除的数组元素值values
输出：
Array (
    [1] => b
)
与 unset 类似，array_diff 也将保持索引。

使用 array_diff_key 函数，示例如下：

  $array = array(0 => "a", 1 => "b", 2 => "c");
  $array = array_diff_key($array, [0 => "xy", "2" => "xy"]);
输出：

Array (
    [1] => b
)
与 unset 类似，array_diff_key 也将保持索引。
*/


//=================================  php  正则验证 ====================================
$data = 获取到的数据;
$arr = 将匹配到的数据放到$arr中;
preg_match_all('<title>(.+)<\/title>/', $data, $arr);
var_dump($arr);

//QueryList使用jQuery选择器来做采集
//不用使用正则匹配复杂的东西
//可在抓取页面的时候使用







   

//=================================  PHP    上手并过渡到PHP7（2）——必须传递int, string, bool参数？没问题  ====================================


/*
Type hints, Type safe
PHP 7中最引人注目的新特性之一，无疑是Scalar type hints。我们可以在函数参数和返回值中使用scalar type hints，还可以指定scalar type的推导和匹配方式。

Scalar type hints
Type hints并不是什么新生事物，PHP 5.0第一次引入了type hints特性，允许我们指定函数的参数是一个特定class或interface类型。之后，在PHP 5.1中，我们可以指定参数是一个array type，在PHP 5.4中，我们可以指定参数是一个“可被调用（callable）”的类型（例如：function或Closure）。在经过了对RFC若干次的修改和讨论之后，PHP 7终于把scale type也加入到了type hint中。

PHP 7允许我们在type hints中使用下面这4种scalar type：

bool: true/false；
float: 表示浮点数类型；
int: 表示整数类型；
string: 表示字符串类型；
我们来看一个使用上面这些scalar type hints的例子：

<?php
function sendHttpResponse(int $statusCode, string $statusText) {

}

sendHttpResponse(200, "OK");
sendHttpResponse("404", "File not found");
对于上面的两个调用，是否满足sendHttpResponse的type hints，取决于我们对匹配方式的设置。

Coercive Type
这是PHP 7针对scalar type hints采取的默认方式，即尽可能尝试把参数转换成scalar type hints要求的类型。所以，在sendHttpResponse("404", "File not found")中，"404"会被转换成整数400，让函数得以正常执行。当然，方便总是有代价的，因为类型转换有时会导致精度丢失。我们来看一些常见的例子：

<?php

function coerciveInt(int $a) {
    echo "a = ".$a;
}

coerciveInt(1.5);      // 1
coerciveInt("100.1");  // 100
coerciveInt("100int"); // 100

function coerciveFloat(float $a) {
    echo "a = ".$a;
}

coerciveFloat(1);        // 1.0
coerciveFloat("3.14");   // 3.14
coerciveFloat("3.14PI"); // 3.14
在这里，要特别说一下bool类型，它和我们在C++中的处理逻辑类似，一切表达“空值”的概念，例如：0, 0.0, null, "0", ""（空字符串）, []（空数组），$uninitializedVar（未经初始化的变量），都会被认为是false，除去这些情况之外的，则会被认为是true。

Strict Type
如果你不希望PHP 7执行上面的类型转换，要求类型严格匹配，你可以手动启用PHP 7的“严格模式”。在这个模式下，任何不严格匹配的类型都会导致抛出\TypeError异常。Strict type只能在web application的中使用，也就是说，如果你在编写一个library，你不能在你的代码里，开启strict type。

启用strict type很简单，在PHP代码中的第一行，写上declare(strict_types=1);。

*“PHP起始标记和declare(strict_types=1);之间，不能有任何内容，namespace必须紧跟在declare语句后面。”
特别提示*

我们来看一些例子，它们都会导致\TypeError异常：

<?php declare(strict_types=1);

function strictInt(int $a) {
    echo "a = ".$a;
}

strictInt(1.5);      // \TypeError
strictInt("100.1");  // \TypeError
strictInt("100int"); // \TypeError

function strictFloat(float $a) {
    echo "a = ".$a;
}

strictFloat(1);        // \TypeError
strictFloat("3.14");   // \TypeError
strictFloat("3.14PI"); // \TypeError

https://segmentfault.com/img/bVrzOI 图片
Return Type Hints
在PHP 7，我们除了可以type hint函数参数之外，还可以type hint函数的返回值，像下面这样：

<?php

function divisible(int $dividend, int $divider): int {
    return $dividend / $divider;
}

divisible(6, 3);
divisible(6, 4);
Return type hints对类型的处理，和参数使用的规则是相同的。默认采用coersive type，当开启strict type之后，不满足约定的类型将会导致\TypeError异常。


//=================================  PHP    __FILE__  ====================================

__FILE__ 本文件的地址

DIRECTORY_SEPARATOR / 符号 为了跨平台 windows和linux不一样


getcwd() ：显示是 在哪个文件里调用此文件 的目录  备注:网站目录  但是框架显示显示的是public根目录
 
__DIR__ ：当前内容写在哪个文件就显示这个文件目录   备注: 当前文件的目录

__FILE__ ： 当前内容写在哪个文件就显示这个文件目录+文件名  



getcwd（）和 __DIR__ 返回的是文件所在的绝对路径但是没有文件自身的名字在内。

__FILE__则是返回的是文件所在的绝对路径但是有文件自身的名字在内



__FILE__ 和 __LINE__

这二个都为魔术变量。
若有a页面和b页面，a包含b页面，
其中b页面中有__LINE__变量，
那么__LINE__的值为b页面__LINE__变量所在的行号。


//a.php
echo __FILE__;
//b.php
include("a.php");
运行 b.php 结果还是 a.php。因为 __FILE__ 写在那里，而不是在 b.php 里



几个 PHP 的“魔术常量”
名称  说明
1.__LINE__  文件中的当前行号。

2.__FILE__  文件的完整路径和文件名。如果用在被包含文件中，则返回被包含的文件名。自 PHP 4.0.2 起，__FILE__ 总是包含一个绝对路径（如果是符号连接，则是解析后的绝对路径），而在此之前的版本有时会包含一个相对路径。

3.__DIR__ 文件所在的目录。如果用在被包括文件中，则返回被包括的文件所在的目录。它等价于 dirname(__FILE__)。除非是根目录，否则目录中名不包括末尾的斜杠。（PHP 5.3.0中新增） =

4.__FUNCTION__  函数名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该函数被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。

5.__CLASS__ 类的名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该类被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。类名包括其被声明的作用区域（例如 Foo\Bar）。注意自 PHP 5.4 起 __CLASS__ 对 trait 也起作用。当用在 trait 方法中时，__CLASS__ 是调用 trait 方法的类的名字。

6.__TRAIT__ Trait 的名字（PHP 5.4.0 新加）。自 PHP 5.4 起此常量返回 trait 被定义时的名字（区分大小写）。Trait 名包括其被声明的作用区域（例如 Foo\Bar）。

7.__METHOD__  类的方法名（PHP 5.0.0 新加）。返回该方法被定义时的名字（区分大小写）。

8.__NAMESPACE__ 当前命名空间的名称（区分大小写）。此常量是在编译时定义的（PHP 5.3.0 新增）


//=================================  PHP    大愚支付 微信  ====================================


1.引入包
2.修改命名空间
3.回调为数组 字段不和官方字段相同
4.最好事先模拟订单测试回调方法是否正常
5.需判断返回状态是否成功
6.需判断金额是否与订单一致
7.tp5因为驼峰命名导致地址栏的事自动转换为 _和小写  这个时候和微信商户号支付授权目录会找不到该目录,避免这种写法
8.回调结束如果不成功可输出 exit('success');微信 exit(xml)


//=================================  PHP   微信 商户号配置  ====================================
 
1.产品中心 ->开发配置 -> 包括选项  商户号 授权目录 扫码支付回调
2.账户中心 api配置  ->包括选项     证书下载  MD5秘钥设置(自己设置任意值)   此项所有操作都需要安装客户端操作证书
//=================================  PHP    js判断是在微信还是php  ====================================


function isWeiXin() {
var ua = window.navigator.userAgent.toLowerCase();
console.log(ua);//mozilla/5.0 (iphone; cpu iphone os 9_1 like mac os x) applewebkit/601.1.46 (khtml, like gecko)version/9.0 mobile/13b143 safari/601.1
if (ua.match(/MicroMessenger/i) == 'micromessenger') {
return true;
} else {
return false;
}
}

//=================================  PHP   导出表格  ====================================

compsoer包  
"phpoffice/phpexcel":"1.8.1"
下载完成  只有Classes文件夹是有用的

一.导出的三种方法  此处使用的是  makeExport 包是 index 和 makeExport 包含的包

Excel.php 可写为控制器或者service

namespace app\system\controller;

use PHPExcel;
use PHPExcel_IOFactory;
class Excel extends Base{


  /**
   * excel保存表格
   *   */
   public function index(){
      $path = dirname(__FILE__); //找到当前脚本所在路径
      $PHPExcel = new PHPExcel(); //实例化PHPExcel类，类似于在桌面上新建一个Excel表格
      $PHPSheet = $PHPExcel->getActiveSheet(); //获得当前活动sheet的操作对象
      $PHPSheet->setTitle('demo'); //给当前活动sheet设置名称
      $PHPSheet->setCellValue('A1','姓名')->setCellValue('B1','分数');//给当前活动sheet填充数据，数据填充是按顺序一行一行填充的，假如想给A1留空，可以直接setCellValue('A1',');
      $PHPSheet->setCellValue('A2','张三')->setCellValue('B2','50');
      $PHPWriter = PHPExcel_IOFactory::createWriter($PHPExcel,'Excel2007');//按照指定格式生成Excel文件，'Excel2007'表示生成2007版本的xlsx，
      $PHPWriter->save($path.'/demo.xlsx'); //表示在$path路径下面生成demo.xlsx文件
    }

  /**
    * excel表格导出 第一种
    * @param string $name 当前活动名称
    * @param string $title 文件名称
    * @param array  $th 表头名称
    * @param array  $tr 要导出的数据
    * @author  */
    public function makeExport($tr,$th='',$title='订单列表',$name='普通订单'){
      $PHPExcel = new PHPExcel();
      #获得当前活动sheet的操作对象
          $PHPSheet = $PHPExcel->getActiveSheet();
          #给当前活动sheet设置名称
      $PHPSheet->setTitle($name);
      #判断数据大小
      if (count($tr) < 500) {
           $array =array_merge_recursive([$th],$tr);
               $PHPSheet -> fromArray($array);//数据较大时，不建议使用此方法，建议使用setCellValue()
      }else{
         $PHPSheet->setCellValue('A1','订单ID')->setCellValue('B1','订单编号')->setCellValue('C1','用户名/收货人')->setCellValue('D1','收货地址')->setCellValue('E1','套餐名称')->setCellValue('F1','订单价格')->setCellValue('G1','订单状态')->setCellValue('H1','商品标题')->setCellValue('I1','商品价格')->setCellValue('J1','商品图片')->setCellValue('K1','商品数量');
      }

      #给当前活动sheet填充数据，数据填充是按顺序一行一行填充的，假如想给A1留空，可以直接setCellValue('A1',');
      $PHPWriter = PHPExcel_IOFactory::createWriter($PHPExcel,'Excel2007');
      #按照指定格式生成Excel文件，'Excel2007'表示生成2007版本的xlsx，'Excel5'表示生成2003版本Excel文件
      #告诉浏览器输出07Excel文件
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      #header('Content-Type:application/vnd.ms-excel');     #告诉浏览器将要输出Excel03版本文件
      #告诉浏览器输出浏览器名称
          header('Content-Disposition: attachment;filename="'.$title.'.xlsx"');
          #禁止缓存
          header('Cache-Control: max-age=0');
          $PHPWriter->save("php://output");

  }

   /**
    * excel表格导出 第二种
    * @param string $fileName 文件名称
    * @param array $headArr 表头名称
    * @param array $data 要导出的数据
    * @author static7  */
  public function excelTwo($data){
      $title=array('订单ID','收货人','地址','收货人手机','订单号','支付单号','金额','订单状态','支付类型','下单时间');//表格中的标题
      header('Pragma: public');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Content-Type: application/force-download');
      header('Content-Type: application/octet-stream');
      header('Content-Type: application/download');;
      header('Content-Disposition: attachment;filename='.'订单表_'.date('Y-m-d',time()).'.xls');
      header('Content-Transfer-Encoding: binary ');
      //导出xls 开始，写入excel表
      if (!empty($title)) {
          foreach ($title as $k => $v) {
              $title[$k]=iconv('UTF-8', 'GB2312',$v);
          }
          $title = implode("\t", $title);
          echo $title."\n";//\n为换行//把标题写入表格中
      }
      if (!empty($data)){
          foreach($data as $key=>$val){
              foreach ($val as $ck =>$cv) {
                  $data[$key][$ck]=iconv('UTF-8', 'GB2312', $cv);
              }
              $data[$key]=implode("\t", $data[$key]);
          }
          echo implode("\n",$data);//把数据写入表格中
       }
  }
    /**
     * excel表格导出 第三种  th 头方法
     * @param string $fileName 文件名称
     * @param array $headArr 表头名称
     * @param array $data 要导出的数据
     * @author static7  */
    /*public function excelExportThree($fileName = '', $headArr = [], $data = [])
    {
        $fileName .= "_" . date("Y_m_d", Request::instance()->time()) . ".xls";
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties();
        $key = ord("A"); // 设置表头
        foreach ($headArr as $v) {
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
            $key += 1;
        }
        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();
        foreach ($data as $key => $rows) { // 行写入
            $span = ord("A");
            foreach ($rows as $keyName => $value) { // 列写入
                $objActSheet->setCellValue(chr($span) . $column, $value);
                $span++;
            }
            $column++;
        }
        $fileName = iconv("utf-8", "gb2312", $fileName); // 重命名表
        $objPHPExcel->setActiveSheetIndex(0); // 设置活动单指数到第一个表,所以Excel打开这是第一个表
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename='$fileName'");
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); // 文件通过浏览器下载
        exit();
    }*/
      /**
       * 调用第三种方法
       * @param
       * @author staitc7  * @return mixed
       */
      /*public function excel() {
         $name='测试导出';
         $header=['表头A','表头B'];
         $data=[
             ['嘿嘿','heihei'],
             ['哈哈','haha']
         ];
         excelExport($name,$header,$data);
      }*/


}

//============

/*
Order.php  需要用 <a href=/index/order/excelData>导出订单</a>  摘自富足

    #导出订单
    public function excelData()
    {
        $data = db('orders_detail')->select();
        $excel = new Excel();
        $th = ['订单ID','订单编号','收货人','手机号','收货地址','套餐名称','订单价格','订单状态','商品标题','创建时间'];
        foreach ($data as $key => $value) {
            $tr[$key][] = $value['id'];
            $tr[$key][] = $value['order_num'];
            $tr[$key][] = $value['consignee'];
            $tr[$key][] = $value['telephone'];
            $tr[$key][] = $value['province'].$value['city'].$value['area'].$value['detail'];
            $tr[$key][] = $value['price'];
            switch ($value['status']) {
                case '1':
                 $tr[$key][] = '待付款';
                    break;
                case '2':
                 $tr[$key][] = '待发货';
                    break;
                case '3':
                 $tr[$key][] = '待收货';
                    break;
                case '4':
                 $tr[$key][] = '已确认';
                    break;
            }
            $tr[$key][] = $value['good_name'];
            $tr[$key][] = $value['created_at'];
        }
        $excel->makeExport($tr,$th,'XXX订单','套餐订单');
    }

*/
//=================================  PHP   导出表格  ====================================

//composer 自动加载规则 autoload_psr4.php 

$vendorDir = dirname(dirname(__FILE__));//vendor
$baseDir = dirname($vendorDir); //网站目录

 //加入规则 
 //composer.json文件加入
"autoload": {
        "psr-4": {
            "service\\":"service/",
            "alitransfer\\":"vendor/alitransfer/lib" //相对于网站目录的路径
            }
    },
//composer update 即可
//会发现 autoload_psr4.php 中多了这几个
//命名空间名称                  //文件夹绝对路径
'service\\' => array($baseDir . '/service'),
'alitransfer\\' => array($vendorDir . '/alitransfer/lib'),

//autoload_static.php文件中多了这几行
'service\\' => 
        array (
            0 => __DIR__ . '/../..' . '/service',
        ),
        'alitransfer\\' => 
        array (
            0 => __DIR__ . '/..' . '/alitransfer/lib',
        ),
//======================  PHP   创建一个对象  强制类型转换为对象  =======================

$order = (object)array();
$order = (object)null;
$order = (object)'';
$order->order_num = time();

//=================================  PHP   支付宝批量转账 有密  ====================================

//按照文档和demo配置好内容以后需要在支付宝账户管理下载操作证书 中间会回答密码问题, 并要求提供营业执照注册码
//需要使用UC浏览器或者ie安装 主流浏览器不支持申请安装证书

//=================================  PHP  Mysql 统计 sum 金额   ====================================

// double 类型是不精确的 
// 如果需要精确的保留和计算 需要将字段设置为 decimal


//=================================  PHP  破解phpStorm   ====================================
/*
hpstorm破解方法适用于各种版本
https://www.cnblogs.com/Worssmagee1002/p/6233698.html

注册时选择 License server 输入 

点击Activate 就可以
http://www.0-php.com:1017
备用服务器:
http://www.heatsam.com:1017 
http://active.fy-style.cn/
*/
//=================================  PHP  判断是否有空格   ====================================

if(strpos("Hello world!"," ")){
  echo '有空格';
}else{
  echo '没有空格';
}

//=================================  PHP  输出文件中所有行的内容 检测文件或者图片内容  ====================================
$file = '/home/laotianye/Desktop/1.jpg';
$file = fopen($file,'r');
//输出文本中所有的行，直到文件结束为止。
while(! feof($file))
{
    $info = fgets($file);
    echo $info. "\n";
    //检测文件中是否有 php脚本关键字
    if (strpos($info,'php') || strpos($info,'eval')){
        echo 'find php word'."\n";die;
    }

}

fclose($file);

/*
feof(file) 函数检测是否已到达文件末尾 (eof)。

如果文件指针到了 EOF 或者出错时则返回 TRUE，否则返回一个错误（包括 socket 超时），其它情况则返回 FALSE。

file 参数是一个文件指针。这个文件指针必须有效，并且必须指向一个由 fopen() 或 fsockopen() 成功打开（但还没有被 fclose() 关闭）的文件。

feof() 函数对遍历长度未知的数据很有用。

注意：如果服务器没有关闭由 fsockopen() 所打开的连接，feof() 会一直等待直到超时而返回 TRUE。默认的超时限制是 60 秒，可以使用 stream_set_timeout() 来改变这个值。
如果传递的文件指针无效可能会陷入无限循环中，因为 EOF 不会返回 TRUE。


*/

//=================================  PHP  压缩图片的类  ====================================



class imgcompress{

    private $src;
    private $image;
    private $imageinfo;
    private $percent = 0.5;

    /**
     * 图片压缩
     * @param $src 源图
     * @param float $percent  压缩比例
     */
    public function __construct($src, $percent=1)
    {
        $this->src = $src;
        $this->percent = $percent;
    }


    /** 高清压缩图片
     * @param string $saveName  提供图片名（可不带扩展名，用源图扩展名）用于保存。或不提供文件名直接显示
     */
    public function compressImg($saveName='')
    {
        $this->_openImage();
        if(!empty($saveName)) $this->_saveImage($saveName);  //保存
        else $this->_showImage();
    }

    /**
     * 内部：打开图片
     */
    private function _openImage()
    {
        list($width, $height, $type, $attr) = getimagesize($this->src);
        $this->imageinfo = array(
            'width'=>$width,
            'height'=>$height,
            'type'=>image_type_to_extension($type,false),
            'attr'=>$attr
        );
        $fun = "imagecreatefrom".$this->imageinfo['type'];
        $this->image = $fun($this->src);
        $this->_thumpImage();
    }
    /**
     * 内部：操作图片
     */
    private function _thumpImage()
    {
        $new_width = $this->imageinfo['width'] * $this->percent;
        $new_height = $this->imageinfo['height'] * $this->percent;
        $image_thump = imagecreatetruecolor($new_width,$new_height);
        //将原图复制带图片载体上面，并且按照一定比例压缩,极大的保持了清晰度
        imagecopyresampled($image_thump,$this->image,0,0,0,0,$new_width,$new_height,$this->imageinfo['width'],$this->imageinfo['height']);
        imagedestroy($this->image);
        $this->image = $image_thump;
    }
    /**
     * 输出图片:保存图片则用saveImage()
     */
    private function _showImage()
    {
        header('Content-Type: image/'.$this->imageinfo['type']);
        $funcs = "image".$this->imageinfo['type'];
        $funcs($this->image);
    }
    /**
     * 保存图片到硬盘：
     * @param  string $dstImgName  1、可指定字符串不带后缀的名称，使用源图扩展名 。2、直接指定目标图片名带扩展名。
     */
    private function _saveImage($dstImgName)
    {
        if(empty($dstImgName)) return false;
        $allowImgs = ['.jpg', '.jpeg', '.png', '.bmp', '.wbmp','.gif'];   //如果目标图片名有后缀就用目标图片扩展名 后缀，如果没有，则用源图的扩展名
        $dstExt =  strrchr($dstImgName ,".");
        $sourseExt = strrchr($this->src ,".");
        if(!empty($dstExt)) $dstExt =strtolower($dstExt);
        if(!empty($sourseExt)) $sourseExt =strtolower($sourseExt);

        //有指定目标名扩展名
        if(!empty($dstExt) && in_array($dstExt,$allowImgs)){
            $dstName = $dstImgName;
        }elseif(!empty($sourseExt) && in_array($sourseExt,$allowImgs)){
            $dstName = $dstImgName.$sourseExt;
        }else{
            $dstName = $dstImgName.$this->imageinfo['type'];
        }
        $funcs = "image".$this->imageinfo['type'];
        $funcs($this->image,$dstName);
    }

    /**
     * 销毁图片
     */
    public function __destruct(){
        imagedestroy($this->image);
    }

}

$filedir = '/home/laotianye/Desktop/hyd.png';
$pic = new imgcompress($filedir,0.1);
$pic->compressImg('1.jpg');
var_dump($pic);


//=================================  PHP  函数回溯 生成过程  ====================================


//该函数显示由 debug_print_backtrace() 函数代码生成的数据。


//=================================  PHP  array_map  ====================================

array_map() // 函数将用户自定义函数作用到数组中的每个值上，并返回用户自定义函数作用后的带有新值的数组。


function myfunction($v)
{
  return($v*$v);
}

$a=array(1,2,3,4,5);
print_r(array_map("myfunction",$a));

//将数组内的每个值都会在此方法中运行一次 有返回则会赋值给对应值  
//可以是多个数组 
print_r(array_map("myfunction",$a1,$a2,$a3));

//=================================  PHP  TP5排除某些字段  ====================================


//表示获取除了content user_id之外的所有字段，

Db::table('think_user')->field('user_id,content',true)->select();
//或者用
Db::table('think_user')->field(['user_id','content'],true)->select();

注意的是 字段排除功能不支持跨表和join操作。



//可以给某个字段设置别名，例如：

//Db::table('think_user')->field('id,nickname as name')->select();
//
//


//=================================  PHP  原生查询和修改  ====================================

//query方法用于执行SQL查询操作，如果数据非法或者查询错误则返回false，否则返回查询结果数据集（同select方法）

//使用示例： 查询

Db::query("select * from think_user where status=1");


//execute用于更新和写入数据的sql操作，如果数据非法或者查询错误则返回false ，否则返回影响的记录数。

//使用示例：修改和写入

Db::execute("update think_user set name='thinkphp' where status=1");

//=================================  PHP  list  ====================================

list()
 //函数用于在一次操作中给一组变量赋值。
//该函数只用于数字索引的数组，且假定数字索引从 0 开始。
//如果跳过赋值 可留空 逗号隔开

$my_array = array("Dog","Cat","Horse");

list($a, $b, $c) = $my_array;
echo "I have several animals, a $a, a $b and a $c.";

//=================================  PHP  获取器  ====================================

/*
tp5的获取器功能很强大，一下子就喜欢上了，你可以在模块里任意定义表里不存在的字段，在前台调用很方便。话不多说直接上demo：

　　1.命名规则   get + 属性名的驼峰命名+ Attr

　　直接就能在model里定义：(本示例在UserModel里定义的（User.php文件）)

　　eg1:

　　protected function getSexAttr($value) {
　　　　$text = [1 => '男', 2 => '女', 3 => '未知'];
　　　　return $text[$value];
　　}

　　此情景下user表里是存在sex字段的，sex的值为1,2,3三种情况。这个获取器的作用在于，后台获取user表的list后，sex值仍为1,2,3。前台循环调用的时候就可以用{volist name="list" id="v" key="k"}{$v.sex}{/volist} 此时的{$v.sex}就对应成男，女，未知。

　　2.针对前台需要用到sex值1,2,3同时也要用到文本值男，女，未知的时候，这个获取器就有局限性了，此时，小伙伴们很容易想到，定义两个获取器，一个存1,2,3另一个存男，女，未知。ok，这个方法是可行的，在这里简单介绍一下我想到的方法，定义一个获取器存二维数组。

　　eg2:

　　protected function getSexAttr($value) {
　　　　$text = [1 => '男', 2 => '女', 3 => '未知'];
　　　　return ['val' => $value, 'text' => $text[$value]];
　　}

　　这种情况下，前台就可以直接使用了{$v.sex.val}是1,2,3值的格式。{$v.sex.text}就是男，女，未知的格式。

　　看到这里，相信小伙伴们已经蠢蠢欲动了吧，这还不止呢，接下来介绍一下，定义不存在的字段，映射其他表的字段。就可以应用到项目中了。

　　3.关联其他表的字段构建user表里不存在的字段，其他表就以info表为例吧

　　eg3:

　　protected function getHosNameAttr($value, $data) {

　　　　$name = model('Info')->where('info_id', $data['id'])->value('hos_name');
　　　　return $name;
　　}

　　在user表里构造了hos_name字段，这个例子很简单，user表的主键id是info表的外键info_id，通过这个关系就可以将info里的字段映射到user表里，在后台只查询user表的数据就能用hos_name了，可以省去两表联合查询

 

　　4.如果又需要用到值，又需要用到文本的情况，就可以用第二个例子的思路了。

　　eg4：

 

　　protected function getArchivesAttr($value, $data) {
　　　　$archiveid = model('Info')->where('info_id', $data['id'])->value('archives_id');
　　　　$archivename = model('Archives')->where('id', $archiveid)->value('name');
　　　　return ['val' => $archiveid, 'text' => $archivename];
　　}

　　此示例，在user表里构建了archives字段，val存的是info表的archives_id字段，text是archives_id对应的在表archives里的name字段。省去了三表联合查询，这样在后台只需要查询user表就可以在前台调用archives字段了。

*/


//=================================  PHP  TP5 接收请求值 变量修饰符  ====================================
//

input('变量类型.变量名/修饰符');

Request::instance()->变量类型('变量名/修饰符');

$this->request->isPost('变量名/修饰符');



input('get.id/d');
input('post.name/s');
input('post.ids/a');
Request::instance()->get('id/d');

$this->request->isPost('row/a');  //row数组名  如果你要获取的数据为数组，请一定注意要加上 /a 修饰符才能正确获取到。

/*
修饰符 作用
s 强制转换为字符串类型
d 强制转换为整型类型
b 强制转换为布尔类型
a 强制转换为数组类型
f 强制转换为浮点类型
*/

//=================================  PHP  正则匹配密码  ====================================

//以dfcc 开头 3到6位字母或数字
preg_match("/^dfcc[a-zA-Z0-9]{3,6}$/", $param)


//=================================  PHP  json_encode 参数  ====================================


//php5.4 以后，json_encode增加了JSON_UNESCAPED_UNICODE , JSON_PRETTY_PRINT 等几个常量参数。使显示中文与格式化更方便。

//使用 JSON_UNESCAPED_UNICODE 或者  JSON_PRETTY_PRINT 使数据阅读更方便,会自动换行,但是会占用更多的空间
echo json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

//=================================  PHP  redis连接  ====================================

//第一步:实例化redis对象
$redis = new redis();  
//第二步：php客户端设置的ip及端口
$redis->connect("127.0.0.1","6379");
//第三部：配置连接密码 检测redis服务器连接状态  
//连接失败直接结束 并输出  
$auth = $redis->auth('zhenai')  or die("redis 服务器连接失败");
// var_dump($auth);连接成功 返回 true 反之 返回false
//第四步  可用可不用
echo $connect_status=$redis->ping();
if($connect_status==="+PONG")
{
echo "redis 服务器连接成功";
}
//就是如此简单
//
//
//=================================  PHP  函数调用  ====================================

/*
1.动态调用普通函数时，比如参数和调用方法名称不确定的时候很好用



call_user_func_array()
function sayEnglish($fName, $content) {  
    echo 'I am ' . $content;  
}  
  
function sayChinese($fName, $content, $country) {  
    echo $content . $country;  
    echo "<br>";  
}  
  
function say() {  
    $args = func_get_args();  
    call_user_func_array($args[0], $args);  
}  
  
say('sayChinese', '我是', '中国人');  
say('sayEnglish', 'Chinese'); 

函数名可以用参数的方式传递进去，因而调用不同函数。 配合func_get_args()函数接收参数到数组中，参数的个数也不一致。

2.不需要判断函数类型，无论是普通函数，类的静态方法或者类的方法，均直接调用，你就不用去判断方法的类型
class A {  
     public static function sayChinese($fName, $content, $country) {  
         echo '你好'  
     }  
 }  
  
 function say() {  
     $args = func_get_args();  
     call_user_func_array(array('A', 'sayChinese'), $args);  
 }  

 
  A：：sayChinese是类的静态方法  通过call_user_func_array，依然可以调用。

*/

//=================================  PHP  获取数组key  array_search ====================================


$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');  
   
$key = array_search('green', $array); // $key = 2;  


//=========================== PHP fastadmin 生成 控制器,模型 和表单 =============================

/*
-t, --table=TABLE                              表名，带不表前缀均可
-c, --controller[=CONTROLLER]                  生成的控制器名,可选,默认根据表名进行自动解析
-m, --model[=MODEL]                            生成的模型名,可选,默认根据表名进行自动解析
-i, --fields[=FIELDS]                          生成的数据列表中可见的字段，默认是全部
-f, --force[=FORCE]                            是否覆盖模式,如果目标位置已经有对应的控制器或模型会提示
-l, --local[=LOCAL]                            是否本地模型,默认1,置为0时,模型将生成在common模块下
-r, --relation[=RELATION]                      关联模型表名，带不带表前缀均可
-e, --relationmodel[=RELATIONMODEL]            生成的关联模型名,可选,默认根据表名进行自动解析
-k, --relationforeignkey[=RELATIONFOREIGNKEY]  表外键,可选,默认会识别为使用 模型_id 名称
-p, --relationprimarykey[=RELATIONPRIMARYKEY]  关联模型表主键,可选,默认会自动识别
-s, --relationfields[=RELATIONFIELDS]          关联模型表显示的字段，默认是全部
-o, --relationmode[=RELATIONMODE]              关联模型,hasone或belongsto [default: "belongsto"]
-d, --delete[=DELETE]                          删除模式,将删除之前使用CRUD命令生成的相关文件
-u, --menu[=MENU]                              菜单模式,生成CRUD后将继续一键生成菜单
--setcheckboxsuffix[=SETCHECKBOXSUFFIX]    自动生成复选框的字段后缀
--enumradiosuffix[=ENUMRADIOSUFFIX]        自动生成单选框的字段后缀
--imagefield[=IMAGEFIELD]                  自动生成图片上传组件的字段后缀
--filefield[=FILEFIELD]                    自动生成文件上传组件的字段后缀
--intdatesuffix[=INTDATESUFFIX]            自动生成日期组件的字段后缀
--switchsuffix[=SWITCHSUFFIX]              自动生成可选组件的字段后缀
--citysuffix[=CITYSUFFIX]                  自动生成城市选择组件的字段后缀
--selectpagesuffix[=SELECTPAGESUFFIX]      自动生成Selectpage组件的字段后缀
--ignorefields[=IGNOREFIELDS]                 排除的字段
--editorclass[=EDITORCLASS]                自动生成富文本组件的字段后缀
--headingfilterfield[=HEADINGFILTERFIELD]  自动生成筛选过滤选项卡的字段，默认是status字段
--sortfield[=SORTFIELD]                    排序字段


php think crud -t users -c users/users  -m users  --enumradiosuffix=satatus --editorclass=content --ignorefields=updated_at 

图片 多图的话需要后缀为iamges 富文本需要提前安装插件 后缀为content
php think crud -t goods -c good/goods  -m goods  --enumradiosuffix=satatus  --enumradiosuffix=type --editorclass=content --imagefield=image --imagefield=banner --ignorefields=updatetime --ignorefields=deletetime --intdatesuffix=createtime   --force=true -u=设计师 1

 
--force=true 覆盖模式
php think crud -t users -c users/users  -m users  --enumradiosuffix=satatus --force=true

php think menu -c good/rushactivity

good/rushactivity/index

状态 类型 不显示字段 上传图片 地址  --enumradiosuffix=title_id 生成后会加载控制title来选择selectpage   -u 1 生成菜单 菜单名为标注释

php think crud -t design_user -c design/designuser  -m designuser --enumradiosuffix=satatus  --intdatesuffix=createtime  --enumradiosuffix=type   --ignorefields=updatetime --ignorefields=deletetime   --imagefield=wechat   --citysuffix=address --setcheckboxsuffix=forte_ids --enumradiosuffix=title_id --force=true  -u 1



php think crud -t withdraw -c withdraw/withdraw  -m withdraw --enumradiosuffix=status  --intdatesuffix=createtime   --intdatesuffix=accesstime  --force=true  -u 1


php think crud -t prize_list -c gift/prizegift  -m prizegift --enumradiosuffix=status  --enumradiosuffix=type --intdatesuffix=createtime   --imagefield=image  --ignorefields=updatetime    -u 1 

php think crud -t record -c users/verifyrecharge  -m verifyrecharge --enumradiosuffix=status --enumradiosuffix=type --enumradiosuffix=money_type  --enumradiosuffix=is_add --intdatesuffix=accesstime  --intdatesuffix=gonetime --ignorefields=updatetime   


{:build_select('row[status]', $statusList, null, ['class'=>'form-control', 'required'=>''])}


#加入到字段js中可改变样式 写法
cellStyle: function (value, row, index, field) {
      return {
          classes: 'text-nowrap another-class',
          css: {"color": "blue", "font-size": "50px"}
      };
  },

//写法  
{
  field: 'status',
  title: __('Status'),
  searchList: {"1": __('Status 1'), "2": __('Status 2')},
  formatter: Table.api.formatter.status, cellStyle: function () {
      return {
          css: {
              "max-width": "20px",
              "overflow": "hidden",
              "white-space": "nowrap",
              "text-overflow": "ellipsis"
          }
      }
  },
},

#自定义按钮
  {
    field: 'Button',
    title: '操作',
    operate: 'RANGE',
    events: addFunction,
    formatter: addButtons
  },

   function addButtons(value, row, index) {
                return [
                    '<button class="btn btn-xs btn-success btn-ajax">通过</button>',
                    '<button class="btn btn-xs btn-danger btn-ajax">驳回</button>'
                ].join()
    };

    window.addFunction = {
           "click .btn-success": function (e, value, row, index) {
               console.log((index));
               console.log($(this).parent().siblings('.status'));
               $(this).parent().siblings('.status').text('通过');
           }, "click .btn-danger": function (e, value, row, index) {
               console.log((index))
           }
       }

    #直接写点击事件 写在下面即可

    $(document).on("click", ".ajax_buttons", function () {
       console.log($(this).parent().siblings('.status').text('通过'));
    });

    #弹窗获取 id
    Fast.api.open("coupons/allot?ids="+allotData);

    #手动加上的样式 必须在table生成样式之后才会加载绑定事件
    //当内容渲染完成后
      table.on('post-body.bs.table', function (e, settings, json, xhr) {
          console.log($('.statussssss'));
      });
    

    //控制器内 关联查询的时候where条件中的 goods.shop_id 其中goods 是模型名 不能是表名 不能弄错了
    
    ->where(['type' => 4,'shopgoods.shop_id'=>['neq',1],'deletetime'=>null])
    默认是本表的查询 但是当有两个的字段相同时要区分开
   
    protected $relationSearch = true; 要打开
     
     ->with(['goodClass','getShop']) 预加载

    js中查询要是用这种
    {field: 'getShop.nickname', title: __('Shop_id'), visible: false, operate: 'LIKE'},
    {field: 'get_shop.nickname', title: __('Shop_id'), operate: false},

     刷新
     table.bootstrapTable('refresh');

*/



 /* =============  修改关联查询字段 开始   修改backend文件搜索条件 ================*/
        foreach ($filter as $k => $v) {
            if (stripos($k, ".") === false) {
                //查询上级账号
                if ($k == 'upName') {
                    unset($filter[$k]);
                    $k = 'pid';
                    $v = db('user')->where(['account' => $v])->value('id');
                    $filter[$k] = $v;
                }
            }
        }
        /* =============  修改关联查询字段 结束   ================*/
        foreach ($filter as $k => $v) {
            $sym = isset($op[$k]) ? $op[$k] : '=';
            if (stripos($k, ".") === false) {
//=================================  PHP ini_set session 设置 ====================================


ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://r-j6cc3a2bf76ad1e4.redis.rds.aliyuncs.com:6379?auth=Yizhuanlian2018');


TP5 redis session设置
   'session' => [
       'id' => '',
       // SESSION_ID的提交变量,解决flash上传跨域
       'var_session_id' => '',
       // SESSION 前缀
       'prefix' => 'think',
       // 驱动方式 支持redis memcache memcached
       'type' => 'redis',
       // 是否自动开启 SESSION
       'auto_start' => true,
       'host' => 'r-j6cc3a2bf76ad1e4.redis.rds.aliyuncs.com',
       'port' => 6379,
       'password'=>'Yizhuanlian2018'



//=================================  PHP 上传文件 ====================================

//设置跨域名
define('WEB_DOMAIN_FORE', 'http://192.168.10.112:8080');
$arr = [
    WEB_DOMAIN_FORE,
];
$domain = $_SERVER['HTTP_ORIGIN'];
if ($domain && in_array($domain, $arr)) {
    header('Access-Control-Allow-Origin:' . $domain);
    header('Access-Control-Allow-Credentials:true');
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
}
//设置字符集
header("Content-Type:text/html;charset:utf8");//设置文件编码
$img = $_FILES['uploadImg'];//获取到表单过来的文件变量，uploadImg为表单id
if(!$_FILES){
  echo  json_encode('先上传文件!',true);
}
//检测变量是否获取到
if (isset($img)) {
//上传成功$img中的属性error为0，当error>0时则上传失败有一下几种情况
    if ($img['error'] > 0) {
        $error = '上传失败';
        switch ('error') {
            case 1:
                $error .= '大小超过了服务器设置的限制！';
                break;
            case 2:
                $error .= '文件大小超过了表单设置的限制！';
                break;
            case 3:
                $error .= '文件只有部分被上传';
                break;
            case 4:
                $error .= '没有文件被上传';
                break;
            case 6:
                $error .= '上传文件的临时目录不存在！';
                break;
            case 7:
                $error .= '写入失败';
                break;
            default:
                $error .= '未知错误';
                break;
        }
        exit($error);//在php页面输出错误
    } else {
        $type = strrchr($img['name'], '.');//截取文件后缀名
        $path = "./Uploads/" . $img['name'];//设置路径：当前目录下的uploads文件夹并且图片名称为$img['name'];
        if (strtolower($type) == '.png' || strtolower($type) == '.jpg' || strtolower($type) == '.bmp' || strtolower($type) == '.gif')//判断上传的文件是否为图片格式
        {
            move_uploaded_file($img['tmp_name'], $path);//将图片文件移到该目录下
        }
    }
    echo json_encode($path);
}



//=================================  PHP 计算中文长度 mb_strlen ====================================


echo strlen("你好ABC") . "";
# 输出 9
echo mb_strlen("你好ABC", 'UTF-8') . "";
# 输出 5
echo mb_strwidth("你好ABC") . "";

#输出 7
从上面的测试，我们可以看出：

strlen 把中文字符算成 3 个字节

mb_strlen 不管中文还是英文，都算 1 个字节

mb_strwidth 则把中文算成 2 个字节

所以长度统计的时候用mb_strlen这个函数



//====================  PHP array_filter 用回调函数过滤数组中的单元 ============================



依次将 array 数组中的每个值传递到 callback 函数。如果 callback 函数返回 TRUE，则 input 数组的当前值会被包含在返回的结果数组中。数组的键名保留不变。

function odd($var)
{
    return $var & 1;
}
$array1 = array("a"=>1, "b"=>2, "c"=>3, "d"=>4, "e"=>5);
print_r(array_filter($array1, "odd"));

Array
(
    [a] => 1
    [c] => 3
    [e] => 5
)

//====================  PHP PHP_SAPI ============================
var_dump(PHP_SAPI);

获取php运行环境  
"cgi-fcgi"  nginx 
 "cli"      命令行

//====================  PHP mysql数据库字段为数字时不能修改 ============================


使用原生语句 在sql 语句中 将字段名加入 `1` 这样形式 

数据库字段冲突时 也可以用 `mysql` 这样写

//====================  PHP mysql字段基础上增加 ============================

'update xx_wechat_template set status=2,times=`times+1` where id=' . $form_info['id'];

//====================  PHP 获取ip 格式化ip ============================


gethostbyaddr()  //获取主机名 参数 ip地址 成功返回主机名 否则返回当前输入的参数ip
getprotobyname(); //获取协议端口  参数->协议名
gethostname());//获取主机名 无参数
gethostbyname('www.jijijichain.com'); //获取ip通过域名
gethostbynamel('www.jijijichain.com');//取ip通过域名以数组形式返回
ip2long($ip)//用于将一个数字格式的IPv4地址转换成字符串格式(192.168.0.1)


//====================  PHP 获取ip 格式化ip ============================

/*
eq  = $map['id'] = array('eq',100); 等效于：$map['id'] = 100;
neq !=  $map['id'] = array('neq',100);  id != 100
gt  > $map['id'] = array('gt',100); id > 100
egt >=  $map['id'] = array('egt',100);  id >= 100
lt  < $map['id'] = array('lt',100); id < 100
elt <=  $map['id'] = array('elt',100);  id <= 100
like  like  $map<'username'> = array('like','Admin%');  username like 'Admin%'
between between and $map['id'] = array('between','1,8');  id BETWEEN 1 AND 8
not between not between and $map['id'] = array('not between','1,8');  id NOT BETWEEN 1 AND 8
in  in  $map['id'] = array('in','1,5,8'); id in(1,5,8)
not in  not in  $map['id'] = array('not in','1,5,8'); id not in(1,5,8)
and（默认） and $map['id'] = array(array('gt',1),array('lt',10)); (id > 1) AND (id < 10)
or  or  $map['id'] = array(array('gt',3),array('lt',10), 'or'); (id > 3) OR (id < 10)
xor（异或） xor 两个输入中只有一个是true时，结果为true，否则为false，例子略。 1 xor 1 = 0
exp 综合表达式 $map['id'] = array('exp','in(1,3,8)');  $map['id'] = array('in','1,3,8');

*/
//====================  PHP 各个进制转换 ============================


/*
一，十进制（decimal system）转换函数说明 
1，十进制转二进制 decbin() 函数，如下实例 

echo decbin(12); //输出 1100 
echo decbin(26); //输出 11010 
decbin 
(PHP 3, PHP 4, PHP 5) 
decbin -- 十进制转换为二进制 
说明 
string decbin ( int number ) 
返回一字符串，包含有给定 number 参数的二进制表示。所能转换的最大数值为十进制的 4294967295，其结果为 32 个 1 的字符串。 

2，十进制转八进制 decoct() 函数 

echo decoct(15); //输出 17 
echo decoct(264); //输出 410 
decoct 
(PHP 3, PHP 4, PHP 5) 
decoct -- 十进制转换为八进制 
说明 
string decoct ( int number ) 
返回一字符串，包含有给定 number 参数的八进制表示。所能转换的最大数值为十进制的 4294967295，其结果为 "37777777777"。 

3，十进制转十六进制 dechex() 函数 

echo dechex(10); //输出 a 
echo dechex(47); //输出 2f 
dechex 
(PHP 3, PHP 4, PHP 5) 
dechex -- 十进制转换为十六进制 
说明 
string dechex ( int number ) 
返回一字符串，包含有给定 number 参数的十六进制表示。所能转换的最大数值为十进制的 4294967295，其结果为 "ffffffff"。 

二，二进制（binary system）转换函数说明 
1，二进制转十六制进 bin2hex() 函数 

$binary = "11111001"; 
$hex = dechex(bindec($binary)); 
echo $hex;//输出f9 
bin2hex 
(PHP 3 >= 3.0.9, PHP 4, PHP 5) 
bin2hex -- 将二进制数据转换成十六进制表示 
说明 
string bin2hex ( string str ) 
返回 ASCII 字符串，为参数 str 的十六进制表示。转换使用字节方式，高四位字节优先。 

2，二进制转十制进 bindec() 函数 

echo bindec('110011'); //输出 51 
echo bindec('000110011'); //输出 51 
echo bindec('111'); //输出 7 
bindec 
(PHP 3, PHP 4, PHP 5) 
bindec -- 二进制转换为十进制 
说明 
number bindec ( string binary_string ) 
返回 binary_string 参数所表示的二进制数的十进制等价值。 
bindec() 将一个二进制数转换成 integer。可转换的最大的数为 31 位 1 或者说十进制的 2147483647。PHP 4.1.0 开始，该函数可以处理大数值，这种情况下，它会返回 float 类型。 

三，八进制（octal system）转换函数说明 
八进制转十进制 octdec() 函数 

echo octdec('77'); //输出 63 
echo octdec(decoct(45)); //输出 45 
octdec 
(PHP 3, PHP 4, PHP 5) 
octdec -- 八进制转换为十进制 
说明 
number octdec ( string octal_string ) 
返回 octal_string 参数所表示的八进制数的十进制等值。可转换的最大的数值为 17777777777 或十进制的 2147483647。PHP 4.1.0 开始，该函数可以处理大数字，这种情况下，它会返回 float 类型。 

四，十六进制（hexadecimal）转换函数说明 
十六进制转十进制 hexdec()函数 

var_dump(hexdec("See")); 
var_dump(hexdec("ee")); 
// both print "int(238)" 

var_dump(hexdec("that")); // print "int(10)" 
var_dump(hexdec("a0")); // print "int(160)" 
hexdec 
(PHP 3, PHP 4, PHP 5) 
hexdec -- 十六进制转换为十进制 
说明 
number hexdec ( string hex_string ) 
返回与 hex_string 参数所表示的十六进制数等值的的十进制数。hexdec() 将一个十六进制字符串转换为十进制数。所能转换的最大数值为 7fffffff，即十进制的 2147483647。PHP 4.1.0 开始，该函数可以处理大数字，这种情况下，它会返回 float 类型。 
hexdec() 将遇到的所有非十六进制字符替换成 0。这样，所有左边的零都被忽略，但右边的零会计入值中。 

五，任意进制转换 base_convert() 函数 

$hexadecimal = 'A37334'; 
echo base_convert($hexadecimal, 16, 2);//输出 101000110111001100110100 
base_convert 
(PHP 3 >= 3.0.6, PHP 4, PHP 5) 

base_convert -- 在任意进制之间转换数字 
说明 
string base_convert ( string number, int frombase, int tobase ) 
返回一字符串，包含 number 以 tobase 进制的表示。number 本身的进制由 frombase 指定。frombase 和 tobase 都只能在 2 和 36 之间（包括 2 和 36）。高于十进制的数字用字母 a-z 表示，例如 a 表示 10，b 表示 11 以及 z 表示 35。 


转载地址 :https://www.jb51.net/article/29060.htm

*/






//====================  PHP trim ============================

trim();
rtrim();
ltrim();

trim('31222333'); //默认去除两边的空格
time('3222333',3);//去除字符串两边的3
rtrim('333222333',3);//去除字符串右边的3 多个会全部去掉直到不一样的停止



//====================  PHP 使用须知，JSON数组和JSON对象============================


PHP中json_encode()

$arr = array(
    '0'=>'a','1'=>'b','2'=>'c','3'=>'d'
);
echo json_encode($arr);
//但是结果是

["a","b","c","d"]
//需求是要返回JSON对象，是这样似的

{"0":"a","1":"b","2":"c","3":"d"}
//You can do it，you nee add

$arr = array(
    '0'=>'a','1'=>'b','2'=>'c','3'=>'d'
);
echo json_encode((object)$arr);
//输出结果

{"0":"a","1":"b","2":"c","3":"d"}

//====================  PHP array_chunk 分割数组 ============================

array array_chunk ( array $input , int $size [, bool $preserve_keys = false ] )
/*将一个数组分割成多个数组，其中每个数组的单元数目由 size 决定。最后一个数组的单元数目可能会少于 size个。
参数

input
需要操作的数组

size
每个数组的单元数目

preserve_keys
设为 TRUE，可以使 PHP 保留输入数组中原来的键名。如果你指定了 FALSE，那每个结果数组将用从零开始的新数字索引。默认值是 FALSE。

返回值
得到的数组是一个多维数组中的单元，其索引从零开始，每一维包含了 size 个元素。

错误／异常
如果 size 小于 1，会抛出一个 E_WARNING 错误并返回 NULL。

范例
 

Example #1 array_chunk() 例子

<?php
$input_array = array('a', 'b', 'c', 'd', 'e');
print_r(array_chunk($input_array, 2));
print_r(array_chunk($input_array, 2, true));
?>
以上例程会输出：

Array
(
    [0] => Array
        (
            [0] => a
            [1] => b
        )

    [1] => Array
        (
            [0] => c
            [1] => d
        )

    [2] => Array
        (
            [0] => e
        )

)
Array
(
    [0] => Array
        (
            [0] => a
            [1] => b
        )

    [1] => Array
        (
            [2] => c
            [3] => d
        )

    [2] => Array
        (
            [4] => e
        )

)

//====================  PHP array_column 将数组指定下标为键值 ============================
 
 $users = db('users')->select();
 1.参数1为数组 2.为结果需要保留的字段,会变成1维数组key=>value,null为所有 3.需要为下标的键
 $users = array_column($users,null,'id');
 
*/
//====================  PHP str_replace 批量替换内容 ============================



多对一替换：想把内容字段里所有的<p></p>标签清除掉,替换成空
@str_replace(array('<p>','</p>'), '', $Content)

一对一替换：想把内容字段里所有的<br>标签换成<p>
@str_replace('<br>', '<p>', $Content) 

多对多替换：想把内容字段里的<br>换成<br />, 同时<p>换<hr>，把</p>全清除
@str_replace(array('<br>', '<p>','</p>') , array('<br />','<hr>',''), $Content)


//====================  PHP 简体转繁体 ============================
/*
  
  错误参考文章 https://www.jianshu.com/p/a9d0b9241a27

  https://github.com/NauxLiu/opencc4php  中文简体转繁体文章

  opencc4php 是OpenCC的PHP扩展，能很智能的完成简繁体转换。 
  需要先安装OpenCC扩展 如果此处安装失败可去管方githup地址重新下载编译安装
 
  你需要先安装1.0.1 版本以上的OpenCC，
  

  安装OpenCC：
  
  git clone https://github.com/BYVoid/OpenCC.git --depth 1
  cd OpenCC
  make
  sudo make install


  安装opencc4php：

  git clone git@github.com:NauxLiu/opencc4php.git --depth 1
  cd opencc4php
  phpize    
  ./configure
  make && sudo make install
  
  如果你的OpenCC安装目录不在/usr或/usr/local，可在./configure时添加--with-opencc=[DIR]指定你的OpenCC目录

  要注意phpzie的php版本  多个版本要指定 ./configure --with-php-config=/www/server/php/bin/php-config

  安装完成后加入到php.ini文件最后一行加入

  /www/server/php/71/lib/php/extensions/no-debug-non-zts-20160303/ 这个路径安装完成会显示
  extension =  /www/server/php/71/lib/php/extensions/no-debug-non-zts-20160303/opencc.so

  如果php -m 提示这条错误
  PHP Startup: Unable to load dynamic library '/www/server/php/71/lib/php/extensions/no-debug-non-zts-20160303/opencc.so' - libopencc.so.2: cannot open shared object file: No such file or directory in Unknown on line 0

  那么需要执行 ln -s /usr/lib/libopencc.so.2 /usr/lib64/libopencc.so.2
  
  最后查看 php -m 是否有opencc  如果有则重启php开始使用 



  例子
  $od = opencc_open("s2twp.json"); //传入配置文件名
  $text = opencc_convert("我鼠标哪儿去了。", $od);
  echo $text;
  opencc_close($od);


  函数列表：
  opencc_open(string ConfigName) ConfigName:配置文件名，成功返回资源对象，失败返回false
  opencc_close(resource ob) 关闭资源对象,成功返回true，失败返回false.
  opencc_error() 返回最后一条错误信息，有错误信息返回String,无错误返回false
  opencc_convert(string str, resource od) str：要转换的字符串(UTF-8)，od：opencc资源对象

  可用配置
  s2t.json 简体到繁体
  t2s.json 繁体到简体
  s2tw.json 简体到台湾正体
  tw2s.json 台湾正体到简体
  s2hk.json 简体到香港繁体（香港小学学习字词表标准）
  hk2s.json 香港繁体（香港小学学习字词表标准）到简体
  s2twp.json 简体到繁体（台湾正体标准）并转换为台湾常用词汇
  tw2sp.json 繁体（台湾正体标准）到简体并转换为中国大陆常用词汇


//====================  PHP   array_walk_recursive() 函数 ============================

<?php
function myfunction($value, $key)
{
    echo "键 $key 的值是 $value 。<br>";
}

$a1 = array("a" => "red", "b" => "green");
$a2 = array($a1, "1" => "blue", "2" => "yellow");
array_walk_recursive($a2, "myfunction");


定义和用法
array_walk_recursive() 函数对数组中的每个元素应用用户自定义函数。在函数中，数组的键名和键值是参数。

该函数与 array_walk() 函数的不同在于可以操作更深的数组（一个数组中包含另一个数组）。

参数  描述
array 必需。规定数组。
myfunction  必需。用户自定义函数的名称。
userdata,...  可选。规定用户自定义函数的参数。您能够向此函数传递任意多参数。


与 array_walk() 函数 类似，array_walk_recursive() 函数对数组中的每个元素应用回调函数。不一样的是，如果原数组中的元素也是数组，就会递归地调用回调函数，也就是说，会递归到更深层的数组中去。

典型情况下，myfunction 接受两个参数。array 参数的值作为第一个，键名作为第二个。如果提供了可选参数 userdata ，将被作为第三个参数传递给回调函数。

如果回调函数需要直接作用于数组中的值，可以将回调函数的第一个参数指定为引用，这样对这些单元的任何改变也将会改变原始数组本身。


//====================  PHP  redis 秒杀商品 ============================


//后台添加活动时将商品的库存添加进入redis
public function addRedis($good_ids)
    {
        $redis = Redis::getRedis();
        $goods = \app\admin\model\Goods::where(['type' => 3, 'status' => 1, 'id' => ['in', $good_ids]])->select();
        //健前缀
        $key_prefix = config('Redis.goods_prefix');
        foreach ($goods as $k => $v) {
            //检查redis是否有该键
            if ($redis->getKeys($key_prefix . $v['id'])) {
                //如果有则删除
                $redis->del($key_prefix . $v['id']);
            }
            //循环加入到redis队列
            for ($i = 1; $i <= $v['stock']; $i++) {
                $redis->lPush($key_prefix . $v['id'], 1);
            }
            //完成
            if ($redis->lLen($key_prefix . $v['id']) != $v['stock']) {
                $redis->del($key_prefix . $v['id']);
                $this->error('添加活动失败');
            }
        }
    }

    //前台redis抢购减少
    public function buy(){
      
        $good_info = Goods::get($good_id);
        //查询该商品redis库存
        $redis = Redis::getRedis();
        $prefix = config('Redis.goods_prefix');
        $redis_goods = $prefix . $good_info['id'];

        //键是否还存在redis中
        if (!$redis->getKeys($redis_goods)) {
            return msg(213, '手慢了，已抢完!');
        }
        //能否取出 取出的操作一定要放在事物外面 防止和回插的冲突
        if (!$redis->rPop($redis_goods)) {
            return msg(214, '手慢了，已抢完!');
        }
    
        try{

          //进行数据库操作

        }catch(Exception $e){
          /如果抛出异常在将redis值插入进去
          $redis->lPush($redis_goods,1);

        }
    }




注意事项 
redis减少和数据库速度不成正比 
库存减少和redis库存会不一致 特比是在事物中 但是又不得不使用事物

1. $good_info->stock -= $num; 然后 $good_info->save();  
 这种写法在事物中不可取 因为在高并发中查出内容到下面扣除库存的时候已经不一样 
 其他比较快到的进程可能已经扣除了库存 导致保存的时候不是预料的值 高并发的时候无法保存值  这种是阻塞的  
 
2.推荐用自增或自减的方法 然后将数据库字段设为无符号 当为负数是直接回抛出程序
  $goods_stock_res = $goods_model->where(['id' => $good_info['id']])->setDec('stock');
  if (!$goods_stock_res) {
      throw  new Exception('手慢了，已抢完~', 205);
  }

//====================  PHP  redis list操作 ============================

1 blpop key1 [key2 ] timeout 
移出并获取列表的第一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
2 brpop key1 [key2 ] timeout 
移出并获取列表的最后一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
3 brpoplpush source destination timeout 
从列表中弹出一个值，将弹出的元素插入到另外一个列表中并返回它； 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
4 lindex key index 
通过索引获取列表中的元素
5 linsert key before|after pivot value 
在列表的元素前或者后插入元素
6 llen key 
获取列表长度
7 lpop key 
移出并获取列表的第一个元素
8 lpush key value1 [value2] 
将一个或多个值插入到列表头部
9 lpushx key value 
将一个值插入到已存在的列表头部
10  lrange key start stop 
获取列表指定范围内的元素
11  lrem key count value 
移除列表元素
12  lset key index value 
通过索引设置列表元素的值
13  ltrim key start stop 
对一个列表进行修剪(trim)，就是说，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除。
14  rpop key 
移除列表的最后一个元素，返回值为移除的元素。
15  rpoplpush source destination 
移除列表的最后一个元素，并将该元素添加到另一个列表并返回
16  rpush key value1 [value2] 
在列表中添加一个或多个值
17  rpushx key value 
为已存在的列表添加值


//====================    PHP-redis中文文档 ============================


phpredis是php的一个扩展，效率是相当高有链表排序功能，对创建内存级的模块业务关系

很有用;以下是redis官方提供的命令使用技巧:

下载地址如下：

https://github.com/owlient/phpredis（支持redis 2.0.4）


Redis::__construct构造函数
$redis = new Redis();

connect, open 链接redis服务
参数
host: string，服务地址
port: int,端口号
timeout: float,链接时长 (可选, 默认为 0 ，不限链接时间)
注: 在redis.conf中也有时间，默认为300

pconnect, popen 不会主动关闭的链接
参考上面

setOption 设置redis模式

getOption 查看redis设置的模式

ping 查看连接状态

get 得到某个key的值（string值）
如果该key不存在，return false

set 写入key 和 value（string值）
如果写入成功，return ture

setex 带生存时间的写入值
$redis->setex('key', 3600, 'value'); // sets key → value, with 1h TTL.

setnx 判断是否重复的，写入值
$redis->setnx('key', 'value');
$redis->setnx('key', 'value');

delete  删除指定key的值
返回已经删除key的个数（长整数）
$redis->delete('key1', 'key2');
$redis->delete(array('key3', 'key4', 'key5'));

ttl
得到一个key的生存时间

persist
移除生存时间到期的key
如果key到期 true 如果不到期 false

mset （redis版本1.1以上才可以用）
同时给多个key赋值
$redis->mset(array('key0' => 'value0', 'key1' => 'value1'));



multi, exec, discard
进入或者退出事务模式
参数可选Redis::MULTI或Redis::PIPELINE. 默认是 Redis::MULTI
Redis::MULTI：将多个操作当成一个事务执行
Redis::PIPELINE:让（多条）执行命令简单的，更加快速的发送给服务器，但是没有任何原子性的保证
discard:删除一个事务
返回值
multi()，返回一个redis对象，并进入multi-mode模式，一旦进入multi-mode模式，以后调用的所有方法都会返回相同的对象，只到exec(）方法被调用。

watch, unwatch （代码测试后，不能达到所说的效果）
监测一个key的值是否被其它的程序更改。如果这个key在watch 和 exec （方法）间被修改，这个 MULTI/EXEC 事务的执行将失败（return false）
unwatch  取消被这个程序监测的所有key
参数，一对key的列表
$redis->watch('x');

$ret = $redis->multi() ->incr('x') ->exec();


subscribe *
方法回调。注意，该方法可能在未来里发生改变

publish *
发表内容到某一个通道。注意，该方法可能在未来里发生改变

exists
判断key是否存在。存在 true 不在 false

incr, incrBy
key中的值进行自增1，如果填写了第二个参数，者自增第二个参数所填的值
$redis->incr('key1');
$redis->incrBy('key1', 10);

decr, decrBy
做减法，使用方法同incr

getMultiple
传参
由key组成的数组
返回参数
如果key存在返回value，不存在返回false
$redis->set('key1', 'value1'); $redis->set('key2', 'value2'); $redis->set('key3', 'value3'); $redis->getMultiple(array('key1', 'key2', 'key3'));
$redis->lRem('key1', 'A', 2);
$redis->lRange('key1', 0, -1);

list相关操作
lPush
$redis->lPush(key, value);
在名称为key的list左边（头）添加一个值为value的 元素

rPush
$redis->rPush(key, value);
在名称为key的list右边（尾）添加一个值为value的 元素

lPushx/rPushx
$redis->lPushx(key, value);
在名称为key的list左边(头)/右边（尾）添加一个值为value的元素,如果value已经存在，则不添加

lPop/rPop
$redis->lPop('key');
输出名称为key的list左(头)起/右（尾）起的第一个元素，删除该元素

blPop/brPop
$redis->blPop('key1', 'key2', 10);
lpop命令的block版本。即当timeout为0时，若遇到名称为key i的list不存在或该list为空，则命令结束。如果timeout>0，则遇到上述情况时，等待timeout秒，如果问题没有解决，则对keyi+1开始的list执行pop操作

lSize
$redis->lSize('key');
返回名称为key的list有多少个元素

lIndex, lGet
$redis->lGet('key', 0);
返回名称为key的list中index位置的元素

lSet
$redis->lSet('key', 0, 'X');
给名称为key的list中index位置的元素赋值为value

lRange, lGetRange
$redis->lRange('key1', 0, -1);
返回名称为key的list中start至end之间的元素（end为 -1 ，返回所有）

lTrim, listTrim
$redis->lTrim('key', start, end);
截取名称为key的list，保留start至end之间的元素

lRem, lRemove
$redis->lRem('key', 'A', 2);
删除count个名称为key的list中值为value的元素。count为0，删除所有值为value的元素，count>0从头至尾删除count个值为value的元素，count<0从尾到头删除|count|个值为value的元素

lInsert
在名称为为key的list中，找到值为pivot 的value，并根据参数Redis::BEFORE | Redis::AFTER，来确定，newvalue 是放在 pivot 的前面，或者后面。如果key不存在，不会插入，如果 pivot不存在，return -1
$redis->delete('key1'); $redis->lInsert('key1', Redis::AFTER, 'A', 'X'); $redis->lPush('key1', 'A'); $redis->lPush('key1', 'B'); $redis->lPush('key1', 'C'); $redis->lInsert('key1', Redis::BEFORE, 'C', 'X');
$redis->lRange('key1', 0, -1);
$redis->lInsert('key1', Redis::AFTER, 'C', 'Y');
$redis->lRange('key1', 0, -1);
$redis->lInsert('key1', Redis::AFTER, 'W', 'value');

rpoplpush
返回并删除名称为srckey的list的尾元素，并将该元素添加到名称为dstkey的list的头部
$redis->delete('x', 'y');
$redis->lPush('x', 'abc'); $redis->lPush('x', 'def'); $redis->lPush('y', '123'); $redis->lPush('y', '456'); // move the last of x to the front of y. var_dump($redis->rpoplpush('x', 'y'));
var_dump($redis->lRange('x', 0, -1));
var_dump($redis->lRange('y', 0, -1)); 

string(3) "abc" 
array(1) { [0]=> string(3) "def" } 
array(3) { [0]=> string(3) "abc" [1]=> string(3) "456" [2]=> string(3) "123" }

SET操作相关
sAdd
向名称为key的set中添加元素value,如果value存在，不写入，return false
$redis->sAdd(key , value);

sRem, sRemove
删除名称为key的set中的元素value
$redis->sAdd('key1' , 'set1');
$redis->sAdd('key1' , 'set2');
$redis->sAdd('key1' , 'set3');
$redis->sRem('key1', 'set2');

sMove
将value元素从名称为srckey的集合移到名称为dstkey的集合
$redis->sMove(seckey, dstkey, value);

sIsMember, sContains
名称为key的集合中查找是否有value元素，有ture 没有 false
$redis->sIsMember(key, value);

sCard, sSize
返回名称为key的set的元素个数

sPop
随机返回并删除名称为key的set中一个元素

sRandMember
随机返回名称为key的set中一个元素，不删除

sInter
求交集

sInterStore
求交集并将交集保存到output的集合
$redis->sInterStore('output', 'key1', 'key2', 'key3')

sUnion
求并集
$redis->sUnion('s0', 's1', 's2');
s0,s1,s2 同时求并集

sUnionStore
求并集并将并集保存到output的集合
$redis->sUnionStore('output', 'key1', 'key2', 'key3')；

sDiff
求差集

sDiffStore
求差集并将差集保存到output的集合

sMembers, sGetMembers
返回名称为key的set的所有元素

sort
排序，分页等
参数
'by' => 'some_pattern_*',
'limit' => array(0, 1),
'get' => 'some_other_pattern_*' or an array of patterns,
'sort' => 'asc' or 'desc',
'alpha' => TRUE,
'store' => 'external-key'
例子
$redis->delete('s'); $redis->sadd('s', 5); $redis->sadd('s', 4); $redis->sadd('s', 2); $redis->sadd('s', 1); $redis->sadd('s', 3);
var_dump($redis->sort('s')); // 1,2,3,4,5
var_dump($redis->sort('s', array('sort' => 'desc'))); // 5,4,3,2,1
var_dump($redis->sort('s', array('sort' => 'desc', 'store' => 'out'))); // (int)5
 
string命令
getSet
返回原来key中的值，并将value写入key
$redis->set('x', '42');
$exValue = $redis->getSet('x', 'lol'); // return '42', replaces x by 'lol'
$newValue = $redis->get('x')' // return 'lol'

append
string，名称为key的string的值在后面加上value
$redis->set('key', 'value1');
$redis->append('key', 'value2');
$redis->get('key');

getRange （方法不存在）
返回名称为key的string中start至end之间的字符
$redis->set('key', 'string value');
$redis->getRange('key', 0, 5);
$redis->getRange('key', -5, -1);

setRange （方法不存在）
改变key的string中start至end之间的字符为value
$redis->set('key', 'Hello world');
$redis->setRange('key', 6, "redis");
$redis->get('key');

strlen
得到key的string的长度
$redis->strlen('key');

getBit/setBit
返回2进制信息

zset（sorted set）操作相关
zAdd(key, score, member)：向名称为key的zset中添加元素member，score用于排序。如果该元素已经存在，则根据score更新该元素的顺序。
$redis->zAdd('key', 1, 'val1');
$redis->zAdd('key', 0, 'val0');
$redis->zAdd('key', 5, 'val5');
$redis->zRange('key', 0, -1); // array(val0, val1, val5)

zRange(key, start, end,withscores)：返回名称为key的zset（元素已按score从小到大排序）中的index从start到end的所有元素
$redis->zAdd('key1', 0, 'val0');
$redis->zAdd('key1', 2, 'val2');
$redis->zAdd('key1', 10, 'val10');
$redis->zRange('key1', 0, -1); // with scores $redis->zRange('key1', 0, -1, true);

zDelete, zRem
zRem(key, member) ：删除名称为key的zset中的元素member
$redis->zAdd('key', 0, 'val0');
$redis->zAdd('key', 2, 'val2');
$redis->zAdd('key', 10, 'val10');
$redis->zDelete('key', 'val2');
$redis->zRange('key', 0, -1); 

zRevRange(key, start, end,withscores)：返回名称为key的zset（元素已按score从大到小排序）中的index从start到end的所有元素.withscores: 是否输出socre的值，默认false，不输出
$redis->zAdd('key', 0, 'val0');
$redis->zAdd('key', 2, 'val2');
$redis->zAdd('key', 10, 'val10');
$redis->zRevRange('key', 0, -1); // with scores $redis->zRevRange('key', 0, -1, true);

zRangeByScore, zRevRangeByScore
$redis->zRangeByScore(key, star, end, array(withscores， limit ));
返回名称为key的zset中score >= star且score <= end的所有元素

zCount
$redis->zCount(key, star, end);
返回名称为key的zset中score >= star且score <= end的所有元素的个数

zRemRangeByScore, zDeleteRangeByScore
$redis->zRemRangeByScore('key', star, end);
删除名称为key的zset中score >= star且score <= end的所有元素，返回删除个数

zSize, zCard
返回名称为key的zset的所有元素的个数

zScore
$redis->zScore(key, val2);
返回名称为key的zset中元素val2的score

zRank, zRevRank
$redis->zRevRank(key, val);
返回名称为key的zset（元素已按score从小到大排序）中val元素的rank（即index，从0开始），若没有val元素，返回“null”。zRevRank 是从大到小排序

zIncrBy
$redis->zIncrBy('key', increment, 'member');
如果在名称为key的zset中已经存在元素member，则该元素的score增加increment；否则向集合中添加该元素，其score的值为increment

zUnion/zInter
参数
keyOutput
arrayZSetKeys
arrayWeights
aggregateFunction Either "SUM", "MIN", or "MAX": defines the behaviour to use on duplicate entries during the zUnion.
对N个zset求并集和交集，并将最后的集合保存在dstkeyN中。对于集合中每一个元素的score，在进行AGGREGATE运算前，都要乘以对于的WEIGHT参数。如果没有提供WEIGHT，默认为1。默认的AGGREGATE是SUM，即结果集合中元素的score是所有集合对应元素进行SUM运算的值，而MIN和MAX是指，结果集合中元素的score是所有集合对应元素中最小值和最大值。

Hash操作
hSet
$redis->hSet('h', 'key1', 'hello');
向名称为h的hash中添加元素key1—>hello

hGet
$redis->hGet('h', 'key1');
返回名称为h的hash中key1对应的value（hello）

hLen
$redis->hLen('h');
返回名称为h的hash中元素个数

hDel
$redis->hDel('h', 'key1');
删除名称为h的hash中键为key1的域

hKeys
$redis->hKeys('h');
返回名称为key的hash中所有键

hVals
$redis->hVals('h')
返回名称为h的hash中所有键对应的value

hGetAll
$redis->hGetAll('h');
返回名称为h的hash中所有的键（field）及其对应的value

hExists
$redis->hExists('h', 'a');
名称为h的hash中是否存在键名字为a的域

hIncrBy
$redis->hIncrBy('h', 'x', 2);
将名称为h的hash中x的value增加2

hMset
$redis->hMset('user:1', array('name' => 'Joe', 'salary' => 2000));
向名称为key的hash中批量添加元素

hMGet
$redis->hmGet('h', array('field1', 'field2'));
返回名称为h的hash中field1,field2对应的value

redis 操作相关
flushDB
清空当前数据库

flushAll
清空所有数据库

randomKey
随机返回key空间的一个key
$key = $redis->randomKey();

select
选择一个数据库
move
转移一个key到另外一个数据库
$redis->select(0); // switch to DB 0
$redis->set('x', '42'); // write 42 to x
$redis->move('x', 1); // move to DB 1
$redis->select(1); // switch to DB 1
$redis->get('x'); // will return 42

rename, renameKey
给key重命名
$redis->set('x', '42');
$redis->rename('x', 'y');
$redis->get('y'); // → 42
$redis->get('x'); // → `FALSE`

renameNx
与remane类似，但是，如果重新命名的名字已经存在，不会替换成功

setTimeout, expire
设定一个key的活动时间（s）
$redis->setTimeout('x', 3);

expireAt
key存活到一个unix时间戳时间
$redis->expireAt('x', time() + 3);

keys, getKeys
返回满足给定pattern的所有key
$keyWithUserPrefix = $redis->keys('user*');

dbSize
查看现在数据库有多少key
$count = $redis->dbSize();

auth
密码认证
$redis->auth('foobared');

bgrewriteaof
使用aof来进行数据库持久化
$redis->bgrewriteaof();

slaveof
选择从服务器
$redis->slaveof('10.0.1.7', 6379);

save
将数据同步保存到磁盘

bgsave
将数据异步保存到磁盘

lastSave
返回上次成功将数据保存到磁盘的Unix时戳

info
返回redis的版本信息等详情



type
返回key的类型值
string: Redis::REDIS_STRING
set: Redis::REDIS_SET
list: Redis::REDIS_LIST
zset: Redis::REDIS_ZSET
hash: Redis::REDIS_HASH
other: Redis::REDIS_NOT_FOUND

//========================================   PHP 数组截取 array_slice() 函数 ======================================

定义和用法
array_slice() 函数在数组中根据条件取出一段值，并返回。
注释：如果数组有字符串键，所返回的数组将保留键名。（参见例子 4）
语法
array_slice(array,offset,length,preserve)
参数 
array 
必需。规定输入的数组。
offset 
必需。数值。规定取出元素的开始位置。如果是正数，则从前往后开始取，如果是负值，从后向前取 offset 绝对值。
length 
可选。数值。规定被返回数组的长度。如果 length 为正，则返回该数量的元素。如果 length 为负，则序列将终止在距离数组末端这么远的地方。如果省略，则序列将从 offset 开始直到 array 的末端。
preserve 
可选。可能的值：
true - 保留键
false - 默认 - 重置键


例子 1
<?php
$a=array(0=>"Dog",1=>"Cat",2=>"Horse",3=>"Bird");
print_r(array_slice($a,1,2));
?>
输出：Array ( [0] => Cat [1] => Horse )


例子 2
带有负的 offset 参数：
<?php
$a=array(0=>"Dog",1=>"Cat",2=>"Horse",3=>"Bird");
print_r(array_slice($a,-2,1));
?>
输出：Array ( [0] => Horse )


例子 3
preserve 参数设置为 true：
<?php
$a=array(0=>"Dog",1=>"Cat",2=>"Horse",3=>"Bird");
print_r(array_slice($a,1,2,true));
?>
输出：Array ( [1] => Cat [2] => Horse )


例子 4
带有字符串键：
<?php
$a=array("a"=>"Dog","b"=>"Cat","c"=>"Horse","d"=>"Bird");
print_r(array_slice($a,1,2));
?>
输出：Array ( [b] => Cat [c] => Horse )

//========================================   PHP获取扩展版本号 ======================================

$version = phpversion('swoole');

//========================================   composer 下载安装慢 ======================================


composer速度慢
使用国内镜像。国内镜像地址：http://pkg.phpcomposer.com/ 
使用方式：

composer config -g repo.packagist composer https://packagist.phpcomposer.com  修改全局
composer config repo.packagist composer https://packagist.phpcomposer.com 修改当前项目


上面命令执行之后会在composer.json里面添加镜像的配置信息。

"repositories": {
    "packagist": {
        "type": "composer",
        "url": "https://packagist.phpcomposer.com"
    }
}

然后再下载 很快


//========================================   xdebug 安装 mac ======================================

https://github.com/xdebug/xdebug github 地址

按照github给的方法安装 

如果是安装官方给的安装php的方法 路径也都是默认路径就使用 
./rebuild.sh

否则使用
1 ./configure --enable-xdebug --with-php-config=/www/server/php/73/bin/php-config
2 make clean
3 make
4 make install
5 //放到php.ini 文件中
  ;扩展信息
  zend_extension=xdebug.so 
  ;xdebug 基本配置
  xdebug.remote_enable=On
  ;启用代码自动跟踪
  xdebug.auto_trace=On
  
  ;启用性能检测分析
  xdebug.profiler_enable=On
  xdebug.profiler_enable_trigger=On
  xdebug.profiler_output_name = cachegrind.out.%t.%p
  ;指定性能分析文件的存放目录  /www/xdebuglog/要保证目录可写入权限 用户组网站有权限访问写入
  xdebug.profiler_output_dir="/www/xdebuglog/" 

  ;记录 xdebug与调试器会话 日志
  xdebug.remote_log="/tmp/xdebug.log"
  xdebug.show_local_vars=0

  ;配置端口和监听的域名
  xdebug.remote_port=9000
  xdebug.remote_host=localhost

//profiler_append profiler_enable profiler_enable_trigger 这几个 选项 还是关了吧，不然的话，会在 profiler_output_dir 目录下，产生 几十G 的缓存文件，占磁盘！
检测是否安装上 
$ php -v
PHP 7.2.0RC6 (cli) (built: Nov 23 2017 10:30:56) ( NTS DEBUG )
Copyright (c) 1997-2017 The PHP Group
Zend Engine v3.2.0-dev, Copyright (c) 1998-2017 Zend Technologies
        with Xdebug v2.6.0-dev, Copyright (c) 2002-2017, by Derick Rethans

或者输出 phpinfo()  
php -r "echo phpinfo();" 

//========================================  compsoer 多个php共存版本冲突的问题 ======================================
 php73 也可以写成绝对路径此处是加入了软链

 php73 /usr/bin/composer update
 php73 /usr/bin/composer.phar update

 如果直接修改composer 文件会导致sha签名不一致


//=================================  PHP  final  ====================================
final 官方文档指出 在php5以后的关键字

只能在类中使用 属性不能指定 
可以指定类名 被指定的类不能被继承  
被指定的方法不能被子类重写

