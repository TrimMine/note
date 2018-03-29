<?php

		#初始时间
		$beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
		#结束时间
		$endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
#=============sql查询语句中转换时间戳====================

		//tp  	   field('*,FROM_UNIXTIME(create_at,"%Y年%m月%d日") as create_at');
		//laravel  selectRaw('*,FROM_UNIXTIME(created_at,"%Y年%m月%d日") as gotmoney_date')
#=========== laravel 对象查询======================
		#定义表名  
		$goods=M('goods');
		#商品名查询
		if(isset($_POST['goods_name']) && $_POST['goods_name']!=''){
			$goods=$goods->where('name','like',$_POST['goods_name']);
		}
		#查询商品数据
		$data=$goods->where(['type'=>2])->get())
		#模糊查询laravel中直接用like $goods在没有转换为数组之前可以无限制的累加查询语句
		#可以产考http://blog.csdn.net/zyu67/article/details/45582297 类的基层封装
		#分页laravel 用对象直接分页
		$num=$_GET['p']==''?10:$_GET['p'];
		# 获取分页
		$data = get_page($num,$users);

#============laravel 转换数组不适用if判断可以这么写=====================
		#直接转换为数组
		($user_province=M('city')->where(['level'=>1])->get()) && $user_province=$user_province->toArray();
#========== json互转=======================
		#数组或字符串转换为json 
		json_encode($str);
		#json转换为数组
		json_decode($str,true); #加上true是转换为数组 否则是对象
#======== 匹配二维数组下第一个指定下标的键和值=========================
#匹配二维数组下第一个指定下标的键和值
 $arr= [
      "a" => ['a'=> "a",1 => "1"],"b" => [2=> "2",3 => "3"],"c" => [4=> "4",5 => "5"],"d" => [6 => "6",7 => "7"],"e" => [8 => "8",9 => "9"],"f" => [10 => "10"11 => "11"],];
     #定义两个容器
     $data[0] = [];
     $data[1] = [];
     foreach ($arr as $key => $value) {
        $i=1;
        foreach ($value as $k => $v){
            if ($i==1) {
            $data[0][$k]=$v;
            }else{
            $data[1][$k]=$v;
            }
            $i++;
         }    
     }

#========== laravel 连贯查询 join=======================
          #留言板首页 超级玛丽奥
          public function index(){
                #查询留言
                if ($info=M('forum')
                        #forum表中fid为0的
                        ->where(['fid'=>0])
                        #给forum表中的id起别名
                        ->select('*','forum.id as forum_id')
                        #链接两个表
                        ->join('users','users.id','forum.uid')
                        ->orderBy('forum.created_at',DESC)
                        ->get()){
                        $info=$info->toArray();
                }
                #查询所有系统回复
                if ($reply=M('forum')->where('fid','!=',0)->get()) {
                        $reply=$reply->toArray();
                }
                #遍历插入系统回复
                foreach ($info as $key => $value){
                        foreach ($reply as $k => $v) {
                                if ($value['id']==$v['fid']) {
                                        $info[$key]['reply']=$v['content'];
                                }       
                        }
                }
		#=====================生成订单随机码=====================
                do {
                	$num=date('YmdHis',time()).rand(0,100).rand(1000,2000);
                } while (#查询数据库是否已经有相同的值);

		#=====================生成短信随机码=====================

			 $str = "";
	         $ji = '0123456789abcdefghijklmn';   #字符串可用下标的方式取值
	         do {
	             for($i=0;$i<6;$i++){
	              $str .= $ji[rand(0,strlen($ji)-1)];
	             }
	        } while (false);
	        echo $str;


	      #=============================短信验证码====================
	        public  function edit_phone_code(){
			  	# 定义验证码
			  	$code = '';
			  	# 获取验证码
			  	for ($i=0; $i < 4; $i++) {
			  		$code .= rand(0,9);
			  	}
			  	# 组合信息
			  	$data = [];
			  	$data['phone'] = $_GET['phone'];
			  	$data['code'] = $code;
			  	$data['created_at'] = time();
			  	$data['updated_at'] = $data['created_at'];
			  	# 插入数据
			  	if(M('pcode') -> insert($data)){
			  		# 发送短信
			  		if(PhoneMessage::sendCode(3,$_GET['phone'],$code)){
			  			$this -> ajaxReturn(['status'=>1,'message'=>'发送成功'],'JSONP');
			  		}else{
			  			$this -> ajaxReturn(['status'=>3,'message'=>'系统错误.短信接口错误:'.PhoneMessage::$error['message']],'JSONP');
			  		}
			  	}else{
			  		$this -> ajaxReturn(['status'=>2,'message'=>'系统错误.数据库错误'],'JSONP');
		  	}

   #=====================  #TP 组合查询====================

		  	      
		#或查询和与查询 (or and)
		$where=[];
        $where['login_name']=$_GET['username'];
        $where['phone']=$_GET['username'];
        #定义或
        $where['_logic']='OR';
        #复合语句 定义二维数据
        $map['_complex'] = $where;
        $map['password']=md5($_GET['password']);
        # 总后台登录
        $user=M('agents') -> where($map) ->find();
        #gt 大于  lt于
        #分页
        // 默认每页条数
        }
        // 默认每页条数
        $num = 2;
        // $p=($_GET['p']<1?0:($_GET['p']-1))*($_GET['num'] < 1?$num:$_GET['num']);
        #第几页
        $p=$_GET['p']<1?0:($_GET['p']-1);
        // 获取分页的数据 10秒停止缓存          -> cache(10)
        $data['data'] = M('shops') -> where($where) -> limit($p,$num) -> select();



    #===================input上传多文件=====================
#       <input type="file" name="pic[]" multiple="true"/>
#=================laravel 字段自增 自减==================
DB::table('users')->increment('votes'); #不写参数默认加1
DB::table('users')->increment('votes', 5);
DB::table('users')->decrement('votes');  # 不写参数默认减一
DB::table('users')->decrement('votes', 5);

#TP自减setDec() 自增setInc()
array_merge_recursive() #合并二维数组 追加合并
array_merge() #合并二维数组 追加合并

#========================laravel5 事务回滚====================
#方法一

//不需要引入，直接开干

public function Transaction(){ 

　　DB::beginTransaction(); //开启事务

　　$sql1 = DB::table('demo')->where('id','6')->delete(); 
　　$sql2 = DB::table('errcode')->where('id','4')->delete();

　　if($rs1&&$rs2){   //判断两条同时执行成功

　　　　DB::commit();  //提交
　　　　return 1;

　　}else{

　　　　DB::rollback();  //回滚
　　　　return 0;
　　}

}

#方法二
public function Transaction(Request $request, $id)
{
　　$externalAccount = ExternalAccounts::find($id);
　　DB::beginTransaction();

　　try {

　　　　$externalAccount->fund_number = 876;
　　　　$externalAccount->capital_balance = '阿斯顿发过火';
　　　　$externalAccount->save();
　　　　DB::commit();

　　} catch (Exception $e){

　　　　DB::rollback();
　　　　throw $e;

　　}
}

#===============正则=================
#匹配手机号
#/^1[34578]{1}\d{9}$/

#===============laravel打印sql语句=================
DB::enableQueryLog();//开启查询
/************************
 *   中间为查询语句放置处  *
 ***********************/
dd(DB::getQueryLog());//打印查询SQL


#===============laravel orwhere查询=================
// AccountRecord::TYPE_HEALTH_BALANCE为type类型  1 ,2 ,3
$log=AccountRecord::whereIn('type',[1 ,2 ,3])->where(function($query){
            $query->where('user_id',self::$user_info['id'])
                ->orWhere(function($query){
                    $query->where('to_id',self::$user_info);
                });
            })->get();
#===============laravel 原生或和绑定查询=================
$log=AccountRecord::whereIn('type',[AccountRecord::TYPE_HEALTH_BALANCE,AccountRecord::TYPE_HEALTH_STIMULATE,AccountRecord::TYPE_HEALTH_SHOP])
 -> whereRaw('(user_id = ? or to_id = ?)',[self::$user_info['id'],self::$user_info['id']])
 -> get();


#===============laravel ajax返回语句=================

return response()->json(['status'=>1,'message'=>'修改成功']);

#===============限制ip登陆=================
$ip = '115.57.130.99';
if($_SERVER["REMOTE_ADDR"]!=$ip){
    exit();
}
#===============laravel 判断是否为空 =================
#在使用Laravel Eloquent模型时，我们可能要判断取出的结果集是否为空，但我们发现直接使用is_null或empty是无法判段它结果集是否为空的。

#var_dump之后我们很容易发现，即使取到的空结果集， Eloquent仍然会返回Illuminate\Database\Eloquent\Collection对象实例。
#其实，Eloquent已经给我们封装几个判断方法。

$result = Model::where()->get();
#不为空则
if ($result->first()) {} 
if (!$result->isEmpty()) {} 
if ($result->count()) {}

#===============================laravel 判断是否有错误或者成功信息 =================================
/*
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                 @endif*/

#===============================laravel 判断是什么方法传值 =================================
 $request->isMethod('post');
 $request->isMethod('get');
 $request->isMethod('put');
 #路由  
Route::get('announcement/index','AnnouncementController@index');
            #访问名                    访问控制器内的方法名
#===============================运用数据表模型   =================================
 # 没有条件时  可以先实例化模型
        $log= new Announcement(); 
        if ($request->has('title')) {   #has方法判断是否有参数
            $log =$log->where('title','like','%'.$request->input('title').'%');
        }
        $log = $log ->paginate(10);  #laravel中的分页 分页后不能在进行数据库操作
#===============================laravel中上传删除   =================================
#上传文件
$request->file('pic')#获取文件
#删除文件
unlink($_SERVER['DOCUMENT_ROOT'].$it['pic']);


#===============================$_SERVER =================================

#获取当前服务器项目的根目录
$_SERVER['REMOTE_PORT'] //端口。 
$_SERVER['SERVER_NAME'] //服务器主机的名称。 
$_SERVER['PHP_SELF']//正在执行脚本的文件名 
$_SERVER['argv'] //传递给该脚本的参数。 
$_SERVER['argc'] //传递给程序的命令行参数的个数。 
$_SERVER['GATEWAY_INTERFACE']//CGI 规范的版本。 
$_SERVER['SERVER_SOFTWARE'] //服务器标识的字串 
$_SERVER['SERVER_PROTOCOL'] //请求页面时通信协议的名称和版本 
$_SERVER['REQUEST_METHOD']//访问页面时的请求方法 
$_SERVER['QUERY_STRING'] //查询(query)的字符串。 
$_SERVER['DOCUMENT_ROOT'] //当前运行脚本所在的文档根目录 
$_SERVER['HTTP_ACCEPT'] //当前请求的 Accept: 头部的内容。 
$_SERVER['HTTP_ACCEPT_CHARSET'] //当前请求的 Accept-Charset: 头部的内容。 
$_SERVER['HTTP_ACCEPT_ENCODING'] //当前请求的 Accept-Encoding: 头部的内容 
$_SERVER['HTTP_CONNECTION'] //当前请求的 Connection: 头部的内容。例如：“Keep-Alive”。 
$_SERVER['HTTP_HOST'] //当前请求的 Host: 头部的内容。 
$_SERVER['HTTP_REFERER'] //链接到当前页面的前一页面的 URL 地址。 
$_SERVER['HTTP_USER_AGENT'] //当前请求的 User_Agent: 头部的内容。 
$_SERVER['HTTPS']//如果通过https访问,则被设为一个非空的值(on)，否则返回off 
$_SERVER['SCRIPT_FILENAME'] #当前执行脚本的绝对路径名。 
$_SERVER['SERVER_ADMIN'] #管理员信息 
$_SERVER['SERVER_PORT'] #服务器所使用的端口 
$_SERVER['SERVER_SIGNATURE'] #包含服务器版本和虚拟主机名的字符串。 
$_SERVER['PATH_TRANSLATED'] #当前脚本所在文件系统（不是文档根目录）的基本路径。 
$_SERVER['SCRIPT_NAME'] #包含当前脚本的路径。这在页面需要指向自己时非常有用。 
$_SERVER['PHP_AUTH_USER'] #当 PHP 运行在 Apache 模块方式下，并且正在使用 HTTP 认证功能，这个变量便是用户输入的用户名。 
$_SERVER['PHP_AUTH_PW'] #当 PHP 运行在 Apache 模块方式下，并且正在使用 HTTP 认证功能，这个变量便是用户输入的密码。 
$_SERVER['AUTH_TYPE'] #当 PHP 运行在 Apache 模块方式下，并且正在使用 HTTP 认证功能，这个变量便是认证的类型

#===============================搜索用 get方式不适用post =================================


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
<?php
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
header('Access-Control-Allow-Origin:*'); #域名 或*hao
header("Access-Control-Allow-Credentials:true"); 
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
    //获取远程文件所采用的方法  
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
  substr($str,0,8);            #截取0-8位 返回截取的内容 
  substr($str,8);              #截取0-8位 返回截取后剩余的内容 

  str_replace('要替换的字串' ,'替换成为',$str); #递归替换内容 替换字符串中所有
  substr_replace($num,'****',3,4);  #手机号截取  从第三位替换 替换4位

  strstr($str ,'查找的内容','true或false不填为false');#true返回找到位置前面的内容 false返回后面默认false #stristr不区分大小写strstr区分

  strpos($str,'查找的内容')  #查找第一次出现的位置坐标 找不到为false  #stripos()（不区分大小写）
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
#bccomp — 比较两个高精度数字，返回-1, 0, 1 
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
                //要排序的字段值(数组) //要排序的数组
array_multisort($sort_num, SORT_DESC, $return); // SORT_DESC SORT_ASC
return $return;
//2.
foreach ($data[$value['id']] as $k => $v) {
  $sort_num[] = $v['total_money'];
}
array_multisort($sort_num, SORT_DESC, $data[$value['id']]); // SORT_DESC SORT_ASC

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
?> 

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

#验证姓名
   public static function CheckName($str){
      if (!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',$str)) {
        return '姓名最少两个最多4个汉字';
        }
   }

   #验证密码
    public static function CheckPassword($str){
    if (!preg_match('/^[a-zA-Z0-9_]{6,16}$/',$str)) {
      return '密码必须大于6位少于16位的字母或数字';
      }
   }
   #验证交易密码
    public static function CheckDealPass($str){
    if (!preg_match('/^[0-9]{6}$/',$str)) {
      return '交易密码必须为6位数字';
      }
   }
   #生成随机数
   public static function RandNumber($user_id)
   {
    $str = '';
    do {
      $str =mt_rand()(1,100).mt_rand(200,900);
    } while (M('pass_record')->where('user_id='.$user_id.' and pass_number='.$str)->find());
     return $str;
   }
   #生成随机数
   public static  function RandPass()
   {
    $str = md5(mt_rand(0,99)*(substr(time(),0,3)).mt_rand(100,200)*(substr(time(),4,7)));
    return $str;
   }
   #验证手机号
   public static function CheckPhone($phone){
      if (!preg_match("/^1[34578]{1}\d{9}$/", I('phone'))) {
      return '手机号不合法';
      }
   }

   #判断两次密码是否一致
   public static function CheckRepeat($password,$repassword){
      if ($password != $repassword) {
      return '两次密码不一致';
      }
    }
    public function check_email($email)
    {
      if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email)) {
        return '邮箱格式不正确!';
      }
    }
//=================================  PHP preg_match()  ====================================

   /* 
    int preg_match ( string $pattern , string $subject [, array &$matches [, int $flags = 0 [, int $offset = 0 ]]] )$pattern: 要搜索的模式，字符串形式。

    $subject: 输入字符串。

    $matches: 如果提供了参数matches，它将被填充为搜索结果。 $matches[0]将包含完整模式匹配到的文本， $matches[1] 将包含第一个捕获子组匹配到的文本，以此类推。

    $flags：flags 可以被设置为以下标记值：

    PREG_OFFSET_CAPTURE: 如果传递了这个标记，对于每一个出现的匹配返回时会附加字符串偏移量(相对于目标字符串的)。 注意：这会改变填充到matches参数的数组，使其每个元素成为一个由 第0个元素是匹配到的字符串，第1个元素是该匹配字符串 在目标字符串subject中的偏移量。

    offset: 通常，搜索从目标字符串的开始位置开始。可选参数 offset 用于 指定从目标字符串的某个未知开始搜索(单位是字节)。

    返回值
    返回 pattern 的匹配次数。 它的值将是 0 次（不匹配）或 1 次，因为 preg_match() 在第一次匹配后 将会停止搜索。preg_match_all() 不同于此，它会一直搜索subject 直到到达结尾。 如果发生错误preg_match()返回 FALSE。

    */
   
//=================================  PHP    laravel 'Data Missing'  ====================================


//larave 插入到数据库或者读取数据的时候字段缺少值 或者created_at 或updated_at缺少值或者值不符合时间戳 会报错
// 当进行toArray操作是会报错
//=================================  PHP    scandir  ====================================

// scandir() 函数返回指定目录中的文件和目录的数组。

$dir = "/images/";

// 以升序排序 - 默认
$a = scandir($dir);

// 以降序排序
$b = scandir($dir,1);

print_r($a);
print_r($b);
/*
结果：
Array
(
[0] => .
[1] => ..
[2] => cat.gif
[3] => dog.gif
[4] => horse.gif
[5] => myimages
)
Array
(
[0] => myimages
[1] => horse.gif
[2] => dog.gif
[3] => cat.gif
[4] => ..
[5] => .
)
*/
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


getcwd() ：显示是 在哪个文件里调用此文件 的目录

__DIR__ ：当前内容写在哪个文件就显示这个文件目录

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


//=================================  PHP    大愚支付  ====================================


1.引入包
2.修改命名空间
3.回调为数组 字段不和官方字段相同
4.最好事先模拟订单测试回调方法是否正常
5.需判断返回状态是否成功
6.需判断金额是否与订单一致
7.tp5因为驼峰命名导致地址栏的事自动转换为 _和小写  这个时候和微信商户号支付授权目录会找不到该目录,避免这种写法


//=================================  PHP    商户号配置  ====================================
 
1.产品中心 ->开发配置 -> 包括选项  商户号 授权目录 扫码支付回调
2.账户中心 api配置  ->包括选项     证书下载  MD5秘钥设置(自己设置任意值)   此项所有操作都需要安装客户端操作证书