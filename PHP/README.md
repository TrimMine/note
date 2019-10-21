### 时间设置

##### 初始时间
    $beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
##### 结束时间
    $endToday = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

-------------------------------------------------------------------

### sql查询语句中转换时间戳

#### tp  	   
    field('*,FROM_UNIXTIME(create_at,"%Y年%m月%d日") as create_at');
### laravel  
    selectRaw('*,FROM_UNIXTIME(created_at,"%Y年%m月%d日") as gotmoney_date')
    
-------------------------------------------------------------------

### json互转

##### 数组或字符串转换为json 
    json_encode($str);
##### json转换为数组
    //加上true是转换为数组 否则是对象
    json_decode($str,true);
    
-------------------------------------------------------------------
   
### 生成随机码

    //数据表字段用 varchar 字符串 int类型 如果首字母或者前面数字是0会被忽略掉
    
-------------------------------------------------------------------

### input上传多文件
     <input type="file" name="pic[]" multiple="true"/> 
     
-------------------------------------------------------------------
### PHP框架字段自增 自减
##### laravel
    ->increment('votes'); //不写参数默认加1 
    ->increment('votes', 5);
    ->decrement('votes');  //不写参数默认减一
    ->decrement('votes', 5);

##### TP
    setDec() //自减
    setInc() //自增

-------------------------------------------------------------------
### 合并二维数组
###### 合并数组不会覆盖
    array_merge_recursive() 

###### 合并数组,但是相同下标的数组会被合并掉,不过有主次关系,根据前后摆放顺序可选择保留哪个数组的下标和值
    array_merge()

-------------------------------------------------------------------
### 正则
###### 匹配手机号
    /^1[34578]{1}\d{9}$/
#### 常用的验证规则
##### 验证手机号
       public static function CheckPhone($phone){
          if (!preg_match("/^1[34578]{1}\d{9}$/", I('phone'))) {
          return '手机号不合法';
          }
       }
###### 验证姓名
       public static function CheckName($str){
          if (!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',$str)) {
              return '姓名最少两个最多4个汉字';
            }
       }

##### 验证密码
       public static function CheckPassword($str){
       if (!preg_match('/^[a-zA-Z0-9_]{6,16}$/',$str)) {
             return '密码必须大于6位少于16位的字母或数字';
         }
      }
      //字母和数字的结合
      if (!preg_match("/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$/", $param)) {
          return false;
      }
##### 验证交易密码
        public static function CheckDealPass($str){
          if (!preg_match('/^[0-9]{6}$/',$str)) {
             return '交易密码必须为6位数字';
          }
       }
#####检查ID号
       public function check_uid($uid)
       {
           if (!is_numeric($uid) || $uid < 0 || !preg_match('/^[0-9]{1,11}$/', $uid)) {
               return false;
           }
           return true;
       }
##### 检查賬號
    public function check_account($param)
    {
        if (!preg_match("/^[a-z0-9]{5,20}$/", $param)) {
            return false;
        }
        return true;
    }

##### 检查账号是否已存在
    public function check_account_isset($param)
    {
        if (db('users')->where('account', $param)->find()) {
            return false;
        }
        return true;
    }

######  检查新賬號 大小写
    public function check_new_account($param)
    {
        if (!preg_match("/^[a-zA-Z0-9]{3,6}$/", $param)) {
            return false;
        }

        return true;
    }

###### 手机号注册上限  暂定99个
    public function check_mobile_num($param)
    {
        $count = db('users')->where('mobile', $param)->count();
        if ($count > 0) {
            return false;
        }
        return true;
    }
#####  生成随机数
     public static function RandNumber($user_id)
     {
        $str = '';
        do {
          $str =mt_rand()(1,100).mt_rand(200,900);
        } while (sql_result);
         return $str;
     }
#####  生成随机数
       public static  function RandPass()
       {
        $str = md5(mt_rand(0,99)*(substr(time(),0,3)).mt_rand(100,200)*(substr(time(),4,7)));
        return $str;
       }

##### 邮箱验证        
    public function check_email($email)
    {
      if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email)) {
        return '邮箱格式不正确!';
      }
    }
##### 检查是否是字母组成
    public function check_letter($param)
    {
        if (!preg_match("/^[a-zA-Z]{3,20}$/", $param)) {
            return false;
        }

        return true;
    }

##### 检查登錄密碼
    public function check_pass($param)
    {
        if (strlen($param) < 6 || strlen($param) > 16) {
            return false;
        }
        return true;
    }

##### 检查支付密碼
    public function check_payment($param)
    {
        if (strlen($param) != 6 || !preg_match("/^[\d]*$/i", $param) || !is_numeric($param)) {
            return false;
        }
        return true;
    }

##### 检查推荐码
    public function check_upCode($param)
    {
        if (strlen($param) !== 6) {
            return false;
        }
        if (!$upId = db('users')->where('push_code', $param)->find()) {
            return false;
        }
        return $upId;
    }

#####  检查推荐码
    public function check_upPhone($param)
    {
        if (!is_numeric($param) || $param < 0 || !preg_match('/^1[3456789]{1}\d{9}$/', $param)) {
            return false;
        }
        if (!$upId = db('users')->where(['mobile' => $param])->find()) {
            return false;
        }
        return $upId;
    }

##### 检查真实姓名
    public function check_name($name)
    {
        #验证姓名
        if (!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,5}$/', $name)) {
            return false;
        }
        return true;
    }

##### 检查省市县
    public function check_area($name)
    {
        if (!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,8}$/', $name)) {
            return false;
        }
        return true;
    }
-------------------------------------------------------------------

### PHP preg_match() 匹配  

>###### 函数
    int preg_match ( string $pattern , string $subject [, array &$matches [, int $flags = 0 [, int $offset = 0 ]]] )
>###### 参数
       $pattern: 要搜索的模式，字符串形式。
 
       $subject: 输入字符串。

       $matches: 如果提供了参数matches，它将被填充为搜索结果。 
       $matches[0] 将包含完整模式匹配到的文本， 
       $matches[1] 将包含第一个捕获子组匹配到的文本，以此类推。

       $flags：flags 可以被设置为以下标记值：

       PREG_OFFSET_CAPTURE: 如果传递了这个标记，对于每一个出现的匹配返回时会附加字符串偏移量(相对于目标字符串的)。 
       注意：这会改变填充到matches参数的数组，使其每个元素成为一个由 第0个元素是匹配到的字符串，第1个元素是该匹配字符串 在目标字符串subject中的偏移量。

       offset: 通常，搜索从目标字符串的开始位置开始。
       注意：可选参数 offset 用于 指定从目标字符串的某个未知开始搜索(单位是字节)。
>######  返回值
       返回 pattern 的匹配次数。 它的值将是 0 次（不匹配）或 1 次，因为 preg_match() 在第一次匹配后 将会停止搜索。preg_match_all() 不同于此，它会一直搜索subject 直到到达结尾。 如果发生错误preg_match()返回 FALSE。


-------------------------------------------------------------------


### PHP函数  
>#### scandir()   返回指定目录中的文件和目录的数组。

    $dir = "/images/";

    // 以升序排序 - 默认
    $a = scandir($dir);
    
    // 以倒序排序
    $b = scandir($dir,1);
    
   
>##### 结果

    print_r($a);
    
        Array(
        [0] => .
        [1] => ..
        [2] => cat.gif
        [3] => dog.gif
        [4] => horse.gif
        [5] => myimages
        )
        
        
    print_r($b);
        
        Array(
        [0] => myimages
        [1] => horse.gif
        [2] => dog.gif
        [3] => cat.gif
        [4] => ..
        [5] => .
        )
        
-------------------------------------------------------------------

### laravel 打印sql语句
    DB::enableQueryLog(); //开启查询
    /************************
     *   sql操作             *
     ***********************/
    dd(DB::getQueryLog());  //打印查询SQL


-------------------------------------------------------------------
### laravel 原生或和绑定查询
    -> whereRaw('(user_id = ? or to_id = ?)',[1,1])  // user_id = ?  占位符
    

-------------------------------------------------------------------

### 限制ip登陆
    $ip = '112.17.10.19';
    
    if($_SERVER["REMOTE_ADDR"] != $ip){
       return 'ip不允许访问'
    }




-------------------------------------------------------------------
#### laravel 判断是否为空

在使用Laravel Eloquent模型时，我们可能要判断取出的结果集是否为空，但我们发现直接使用is_null或empty是无法判段它结果集是否为空的。

var_dump之后我们很容易发现，即使取到的空结果集， Eloquent仍然会返回Illuminate\Database\Eloquent\Collection对象实例。

其实，Eloquent已经给我们封装几个判断方法。

    $result = Model::where()->get();
    //不为空则
    if ($result->first()) {}
    if (!$result->isEmpty()) {}
    if ($result->count()) {}


-------------------------------------------------------------------

### PHP $_SERVER 选项 

> ##### 获取当前服务器项目的根目录
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

-------------------------------------------------------------------
### 搜索方式用 get 方式不适用 post 

-------------------------------------------------------------------
### PHP 查询单列(用户的数据)
##### laravel
    ->pluck('id','nickanme');
##### TP5
    ->column('nickanme','id'); //tp 翻过来写id会为数组下标 如果一维数组和直接利用下标调用用户的数据
也可以用 函数 array_flip(array) 键值交换
     
-------------------------------------------------------------------
### PHP 正则匹配密码

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

- 以dfcc 开头 3到6位字母或数字

         preg_match("/^dfcc[a-zA-Z0-9]{3,6}$/", $param)

-------------------------------------------------------------------
### PHP array_unique() 移除数组中的重复的值

##### array_unique($arr) 函数移除数组中的重复的值，并返回结果数组。
- 当几个数组元素的值相等时，只保留第一个元素，其他的元素被删除。
- 返回的数组中键名不变。
- 从前往后有重复的值直接移除

##### array_diff_assoc() 比较两个(或更多)数组的键和值
参数
- $array1 被比较的数组
- $array2 参与比较的数组
    
        $repeat_arr = array_diff_assoc ( $array1, $array2, ... );

-------------------------------------------------------------------


### PHP TP3.2 模型关联 

    namespace Admin\Model;
    use Think\Model\RelationModel; //必须引用

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

-------------------------------------------------------------------
### PHP TP3.2 不用模型关联查询  
      $info = M('buy_equipment');  //默认内联 inner join
      $info = $info -> field('buy_equipment.*,users.nickname')
               ->join('users ON users.id = buy_equipment.user_id')
               ->select();
      dd($info);

-------------------------------------------------------------------
### PHP 取整方法 
1. ##### ceil — 进一法取整  返回的类型是 float
      ```
         echo ceil(4.3); // 5
         echo ceil(9.999); // 1 
      ```
2. ##### floor — 舍去法取整 返回的类型是 float
    ```
        echo floor(4.3); // 4
        echo floor(9.999); // 9
    ```
3. ##### round — 对浮点数进行四舍五入   返回将 val 根据指定精度 precision（十进制小数点后数字的数目）进行四舍五入的结果。precision 也可以是负数或零（默认值）。
    ```    
        echo round(3.4); // 3
        echo round(3.5); // 4
        echo round(3.6); // 4
        echo round(3.6, 0); // 4
        echo round(1.95583, 2); // 1.96
        echo round(1241757, -3); // 1242000
        echo round(5.045, 2); // 5.05
        echo round(5.055, 2); // 5.06
    ``` 
4. ##### intval—对变数转成整数型态
    ``` 
      echo intval(4.3); //4
      echo intval(4.6); // 4
    ``` 
5. ##### sprintf  四舍五入精确小数位及取整
    ###### 保留三位小数 四舍五入
        $num=0.0215489;
        echo sprintf("%.3f", $num); // 0.022
    
    ###### 保留三位小数 不四舍五入
        $num=0.0215489;
        echo substr(sprintf("%.4f", $num),0,-1); // 0.021

    ###### 四舍五入保留两位小数点最精确的方法
        $number = 123213.066666;
        echo sprintf("%.2f", $number); //123213.07
        
    ######  生成两位小数，不四舍五入
        number_format($num, 2);  
 

-------------------------------------------------------------------
### PHP TP3.2 数据库事务   

##### 在User模型中启动事务
    $User->startTrans();
    //进行相关的业务逻辑操作
    $Info = M("Info"); // 实例化Info对象
    $Info->save($User); // 保存用户信息
    
    if (操作成功){
        // 提交事务
        $User->commit();
    }else{
       // 事务回滚
       $User->rollback();
    }
    
-------------------------------------------------------------------
### PHP 数组失去默认下标
##### 转换一下就有下标了

    json_decode(json_encode($arr),true); 

-------------------------------------------------------------------
### laravel  env配置邮箱文件
##### ssl配置   端口 465
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.163.com
    MAIL_PORT=465
    MAIL_FROM_ADDRESS=chinesebigcabbage@163.com 
    MAIL_FROM_NAME=chinese
    MAIL_USERNAME=chinesebigcabbage@163.com 
    MAIL_PASSWORD=password
    MAIL_ENCRYPTION=ssl

- 谷歌
- 开启谷歌账号pop imap服务  
- 开启两部验证
- 返回登录和安全页面 刷新会出现设置应用安全码
- 生成应用专用码 https://myaccount.google.com/security 需要验证  
- 如还不成功 开启允许不安全的应用访问

##### tls配置   端口 587
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_FROM_ADDRESS=z2017@gmail.com
    MAIL_FROM_NAME=Icpkys
    MAIL_USERNAME=z2017@gmail.com
    MAIL_PASSWORD=tjiawvicxiv
    MAIL_ENCRYPTION=tls

    
-------------------------------------------------------------------
### 判断是微信还是浏览器 
    function is_weixin() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
            return false;
    }
##### 定义微信判断为常量
    define ('IS_WECHAT', is_weixin() == true ? true : false);
    
#### const 和 define
    const NAME="123";
    define(NAME,'1234');
- 调用的时候 const 需要用 self::NAME 或者 类名::NAME
- define 直接用  NAME

-------------------------------------------------------------------

### PHP 微信授权登陆  
#### 内容基于tp5    
    protected static $appid = '';
    protected static $secret = '';
    protected static $redirect_uri = '';

    public function __construct()
    {
        self::$appid = config('wx_config.app_id');
        self::$secret = config('WECHAT_CONF.secret');
        self::$redirect_uri = config('WECHAT_CONF.redirect_uri');
    }
    //授权登录 获取个人信息
    public function wechat_login()
    {
         //是否是携带code  session('code') == input('param.code')避免一个code获取两次信息
        if (input('param.code') == '' || session('code') == input('param.code')){
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . self::$appid . '&redirect_uri=' . self::$redirect_uri . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
            header('Location:'. $url);exit;
            //在每个重定向之后都必须加上 exit ,避免发生错误后，继续执行。
        }
        //获取code
        $code = input('param.code');
        //存到session 避免刷新
        session('code', input('param.code'));
        //state
        $state = input('param.state');
        //跳转地址
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . self::$appid . '&secret=' . self::$secret . '&code=' . $code . '&grant_type=authorization_code ';
        //获取access_token和openid
        $res = json_decode($this->https_request($url), true);
        //获取用户信息
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' .   $res['access_token'] . '&openid=' .$res['openid'] . '&lang=zh_CN';
        //用户信息
        $userinfo = json_decode($this->https_request($url), true);
        //检查用户信息
        session('wechat', $userinfo);
        //重定向到
        $this->redirect('/index/index/index');
    }

    //curl请求
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

    
-------------------------------------------------------------------
####  PHP curl扩展  
1. ##### 初始化curl并赋值
         $curl = curl_init();
         $timeout = 5;

2. ##### 设置请求参数
         curl_setopt($curl, 参数名, 参数值);
         curl_setopt($curl, CURLOPT_URL, $url);//请求的url地址 必设
- #### 常用的参数
>     //设置头文件的信息作为数据流输出  和下面的 CURLOPT_RETURNTRANSFER 只能取一个
>     curl_setopt($curl, CURLOPT_HEADER, 1);
>
>     //以文件流的方式返回,而不是直接输出
>     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

>     //设置请求方式为post 1为true 0为false 
>     curl_setopt($curl, CURLOPT_POST, 1);  
>
>     //设置post数据 也就是请求的参数
>     $post_data =[
>         "username" => "coder",
>         "password" => "12345"
>      ];
>         
>     curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

>     //设置超时时间
>     curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,$timeout);
>     //证书验证 https是否验证证书
>     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
>     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    
>     //执行命令 获取返回的文件流
>     $data = curl_exec($curl);
>     if (curl_errno($curl)) {
>         return 'ERROR ' . curl_error($curl);
>     }

>     //关闭URL请求
>     curl_close($curl);
>     //显示返回数据
>     var_dump($data);

#### 区别
##### curl 和 file_get_contents 区别
> 1. curl比 file_get_contents() 效率高
> 2. curl支持get或post 默认get file_get_contents 只支持get
> 3. curl参数多,全面

#### 示例
>##### get和post结合版
>     protected function httpCurl($url, $data = false)
>     {
>        $curl = curl_init();
>        curl_setopt($curl, CURLOPT_URL, $url);
>        if ($data) {
>            curl_setopt($curl, CURLOPT_POST, true);
>            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
>        }
>        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
>        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
>        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
>        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
>        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
>        $result = curl_exec($curl);
>        if (curl_errno($curl)) {
>            return 'ERROR ' . curl_error($curl);
>        }
>        curl_close($curl);
>        return $result;
>    }
-------------------------------------------------------------------


###  PHP header 跳转  

- #####  在每个重定向之后都必须加上 exit,避免发生错误后，继续执行。
    Header("Location: http://www.php.net"); 
    exit;   


    
-------------------------------------------------------------------
###  TP3.2 redirect 重定向  
  
- ##### 重定向到New模块的Category操作  可携带参数
        $this->redirect('New/category', array('cate_id' => 2), 5, '页面跳转中...');
        
        //上面的用法是停留5秒后跳转到New模块的category操作，并且显示页面跳转中字样，重定向后会改变当前的URL地址。

- ##### 如果你仅仅是想重定向要一个指定的URL地址，而不是到某个模块的操作方法，可以直接使用redirect函数重定向，例如：
      //重定向到指定的URL地址
      redirect('/New/category/cate_id/2', 5, '页面跳转中...')

-------------------------------------------------------------------
### PHP 跨域 设置跨域请求头 
跨域很普遍 特别是现在前后端分离的为主流的情况下

- 使用原本的session机制,需要设置请求头,这也是本章所讲的
- 使用token机制,每次请求的时候带上唯一标识token来验证用户是否登录
- 还有其他发方法,不再叙述

##### 本次使用的TP5框架 
    //在入口文件处设置前端的请求域名
    $allow_origin = array(
        'http://localhost:8080',
        'http://meiami.eeeaaa.com',
        'http://webmeiami.eeeaaa.com',
        'http://192.168.10.102:8081',
        'http://192.168.10.103:8080',
    );
    //获取请求来源域名    
    $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
    
    if(in_array($origin, $allow_origin)){
        header('Access-Control-Allow-Origin:'.$origin);
    }
    //header('Access-Control-Allow-Origin:*');
    header('Access-Control-Allow-Credentials:true');
    
    header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
    header('Access-Control-Max-Age: ' . 3600 * 24);
    
#### 前端 
######ajax 请求加上这两句
    xhrFields: {
              withCredentials: true
    },
    crossDomain: true,
    
    $.ajax({
            url: 'url',
            xhrFields: {
                      withCredentials: true
            },
            crossDomain: true,
            success:function(data){
                console.log(data)
            }
        })
     })



    
-------------------------------------------------------------------
### PHP TP5 field 使用技巧 

- ##### 获取除了content之外的所有字段，要排除更多的字段也可以：
        $Model->field('user_id,content',true)->select();
- ##### 可以在field方法中直接使用函数，例如：
        $Model->field('id,SUM(score)')->select();
- 注意 字段排除功能不支持跨表和join操作。
-------------------------------------------------------------------

### 过滤微信昵称 

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

    
-------------------------------------------------------------------

###PHP 下载图片到本地 知道图片路径的情况下 
* 功能：php完美实现下载远程图片保存到本地
* 参数：文件url,保存文件目录,保存文件名称，使用的下载方式
* 当保存文件名称为空时则使用远程文件原来的名称
   ```
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
   ``` 
-------------------------------------------------------------------
### PHP 获取文件

######$url 网页路径
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

  
### PHP 获取网页内容 下载到本地 

- $file_url 网页路径  $save_to保存的文件路径及名字  ./upload/1.jpg 或者 ./upload/1.txt

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
-------------------------------------------------------------------
### PHP fopen 解读使用 fwrite fclose
    $path = $save_dir . $filename;
    $fp2 = fopen($path, 'w+');
    //将文件流写入
    fwrite($fp2, $qrcode);
    fclose($fp2);
>- r   只读方式打开，将文件指针指向文件头。  追加写入从头开始
>- r+  读写方式打开，将文件指针指向文件头。 
>- w   写入方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。   覆盖写入
>- w+  读写方式打开，将文件指针指向文件头并将文件大小截为零。如果文件不存在则尝试创建之。
>- a   写入方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。                 追加写入向尾部追加
>- a+  读写方式打开，将文件指针指向文件末尾。如果文件不存在则尝试创建之。
>- x   创建并以写入方式打开，将文件指针指向文件头。如果文件已存在，则 fopen() 调用失败并返回 FALSE，并生成一条 E_WARNING 级别的错误信息。如果文件不存在则尝试创建之。这和给 底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的。此选项被 PHP 4.3.2 以及以后的版本所支持，仅能用于本地文件。
>- x+  创建并以读写方式打开，将文件指针指向文件头。如果文件已存在，则 fopen() 调用失败并返回 FALSE，并生成一条 E_WARNING 级别的错误信息。如果文件不存在则尝试创建之。这和给 底层的 open(2) 系统调用指定 O_EXCL|O_CREAT 标记是等价的。此选项被 PHP 4.3.2 以及以后的版本所支持，仅能用于本地文件。

-------------------------------------------------------------------

### PHP  更快的取到$_POST的值  
    
    file_get_contents("php://input");

### PHP 判断客户端是否为手机 
    $agent = $_SERVER['HTTP_USER_AGENT'];  
    if(strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS")){
        header("Location:http://wap.域名.com/");
    }
 
-------------------------------------------------------------------
### PHP  substr、mb_substr、mb_strcut 
 
##### 共同点  substr、mb_substr(可截取中文)、mb_strcut这三个函数都用来截取字符串
##### 不同点：
   1. substr是最简单的截取，无法适应中文；
   2. mb_substr是按字来切分字符串，而mb_strcut是按字节来切分字符串，截取中文都不会产生半个字符的现象。
- 这三个函数的前三个参数完全一致，即：
- 第一个参数是操作对象
- 第二个参数是截取的起始位置
- 第三个参数是截取的数量
##### 注意: mb_substr和mb_strcut还有第四个参数：第四个参数可以根据不同的字符集进行设置
     $cn_str = "钓鱼岛是中国的hehe";
     
     echo "mb_substr-3:".mb_substr($cn_str,0,3).'<br/>';   //钓鱼岛    按照字来划分
     
     echo "substr-3:".substr($cn_str,0,3).'<br/>';//钓   按照字节来划分
     
     echo "mb_strcut-3:".mb_strcut($cn_str,0,3).'<br/><br/>'; //钓   按照字节来划分
 
-------------------------------------------------------------------
  
### PHP函数  substr
    substr($v['created_at'],0,-8);// 截取从最后一位 截取8位 返回剩余的内容 截取时间
    substr($str,0,8);            // 截取1-8位 返回截取的内容
    
    // 只有一个参数  当为正数的时候返回剩余部分        当为负数的时候从最后一位开始截取且返回截取的部分
  
    echo substr("Hello world",7)."<br>";    //orld    //  截取1-7位 返回截取后剩余的内容
    echo substr("Hello world",-4)."<br>";   //orld
    
  
    //两个参数的时候  第二个参数为正数 返回截取部分  当为负数的时候从最后一位开始截取且返回截取的部分
  
    echo substr("Hello world",0,10)."<br>";  //Hello worl 截取1-10位返回截取部分
    echo substr("Hello world",0,-1)."<br>";  //Hello worl  从最后开始截取1位返回剩余部分
  
    //两个参数都为负数 从最后数第10个数开始截取 截取最后两位 返回剩余部分
    echo substr("Hello world",-10,-2)."<br>";  //ello wor
    
    echo substr("Hello world",-2-3)."<br>";    //world  相当于    echo substr("Hello world",-5)
  
-------------------------------------------------------------------

  
    str_replace('要替换的字串' ,'替换成为',$str); // 递归替换内容 替换字符串中所有
    substr_replace($num,'****',3,4);  // 手机号截取  从第三位替换 替换4位
    
    substr_replace() 函数把字符串的一部分替换为另一个字符串。
    substr_replace(string,replacement,start,length)
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
    strstr($str ,'查找的内容','true或false不填为false');// true返回找到位置前面的内容 false返回后面默认false // stristr不区分大小写strstr区分
  
    strpos($str,'查找的内容')  // 查找第一次出现的位置坐标 找不到为false  // stripos()（不区分大小写） 判断是返回的是找到的位置 但是如果出现在第一位是0 一定要判断是否为false才能准确 否则出现在第一位会误判
    strrpos($str,'查找的内容') // 查找最后一次出现的位置坐标（区分大小写） // strripos()（不区分大小写）
  
    str_repeat($str,'次数') // 函数把字符串重复指定的次数。
  
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
  
-------------------------------------------------------------------
### PHP 查看当前已引入和使用的文件

    echo $file = get_included_files();

-------------------------------------------------------------------
 
 
### PHP 截取手机号

####方法 1. 固话和手机号
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


####方法 2. 手机号

    $num = "13966778888";
    $str = substr_replace($num,'****',3,4);
    //最后输出：139****8888

 
-------------------------------------------------------------------
### PHP file_put_contents 使用方法
###### file_put_contents ($filename, $data, $flags = 0, $context = null)
    
    file_put_contents('log.txt',date('Y-m-d H:i:s',time()).json_encode($str).PHP_EOL,FILE_APPEND | LOCK_EX);
    file_put_contents() 的行为实际上等于依次调用 fopen()，fwrite() 以及 fclose() 功能一样。
    参数说明：
    filename 要写入数据的文件名 
    data 要写入数据
    flags 可选，规定如何打开/写入文件。可能的值： 
          1.FILE_USE_INCLUDE_PATH：检查 filename 副本的内置路径
          2.FILE_APPEND：在文件末尾以追加的方式写入数据
          3.LOCK_EX：对文件上锁
    context 是一套可以修改流的行为的选项。若使用 null，则忽略
    
#### 示例 
    #写日志
    public static function log($str='未写入日志',$type="未定义类型")
    {
          $Wrap =PHP_EOL.PHP_EOL.'---------'.$type.'---'.date('Y-m-d H:i:s',time()).'---------'.PHP_EOL;
          file_put_contents('log.txt',$Wrap.json_encode($str),FILE_APPEND | LOCK_EX);
    }
    
-------------------------------------------------------------------
###php 中的换行
  
    echo PHP_EOL;
    windows平台相当于    echo "\r\n";
    unix\linux平台相当于    echo "\n";
    mac平台相当于    echo "\r";
  
  
-------------------------------------------------------------------
### PHP 中文字符转换为十六进制

- ##### 函数原理就是首先把中文字符转换为十六进制，然后在每个字符前面加一个标识符%。
        urlencode()
- ##### 用于解码已编码的 URL 字符串，其原理就是把十六进制字符串转换为中文字符                
        urldecode()


-------------------------------------------------------------------
### PHP 高精度加减 


- bcadd — 将两个高精度数字相加 
- bccomp — 比较两个高精度数字，返回 bccomp(1,2) 结果为 -1   小于-1, 相等 0, 大于 1 
- bcdiv — 将两个高精度数字相除 
- bcmod — 求高精度数字余数 
- bcmul — 将两个高精度数字相乘 
- bcpow — 求高精度数字乘方 
- bcpowmod — 求高精度数字乘方求模，数论里非常常用 
- bcscale — 配置默认小数点位数，相当于就是Linux bc中的”scale=” 
- bcsqrt — 求高精度数字平方根 
- bcsub — 将两个高精度数字相减 相减  

        bcsub(第一个数字,第二个数字,保留位数);
              第一个数字 - 第二个数字
                                      
        $a = 0.1;
        $b = 0.7;
        var_dump(bcadd($a,$b,2) == 0.8);
 
 
-------------------------------------------------------------------
### PHP 处理XML数据 
    $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

  
-------------------------------------------------------------------

### PHP strpad() 填充字符串 


#### 释义: 将字符串填充成指定长度的字符串(多字节安全)
* @param string $str 指定被填充的字符串
* @param int $len 指定被填充的字符串的长度，如果值为负数或小于字符串的长度则不填充
* @param string $pad_str 要填充的字符串
* @param int $pad_type 指定填充的方向STR_PAD_RIGHT,STR_PAD_LEFT或STR_PAD_BOTH
* @return string

        $input = "Alien"; 
        echo str_pad($input, 10); // produces "Alien " 
        echo str_pad($input, 10, "-=", STR_PAD_LEFT); // produces "-=-=-Alien" 
        echo str_pad($input, 10, "_", STR_PAD_BOTH); // produces "__Alien___" 
        echo str_pad($input, 6 , "___"); // produces "Alien_"



-------------------------------------------------------------------
### PHP array_change_key_case() 将数组的键值转为为大写或者小写 

- array_change_key_case($str,CASE_UPPER);
- CASE_LOWER 小写  默认值
- CASE_UPPER 大写
#### 例
    $age = array("A"=>"60","B"=>"56","c"=>"31");
    print_r(array_change_key_case($age,CASE_UPPER));
#### 字符串转换大小写
    strtoupper() //将字符串转为大写
    strtolower() //将字符串转为小写
 
 
-------------------------------------------------------------------
### PHP 下载图片到本地

参数
- $url 图片路径 
- $filename 文件新名字 1.jpg 1.png 等 
- $tpye 类型 curl 还是ob_start缓冲文件

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
  
  
-------------------------------------------------------------------
### PHP 获取毫秒

      #返回当前的毫秒时间戳
      public function msectime() {
         list($msec, $sec) = explode(' ', microtime(true));
         $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
         return $msectime;
      }


-------------------------------------------------------------------
### Mysql 复制插入数据库

    insert into tables select * from tables; 
 
-------------------------------------------------------------------

### PHP group 配合 group_concat分组查询字段 
     #可以这样写  group_concat(id ,'-',name) 不可以用逗号
     $info = db('goods')->where(['cid'=>input('class_id')])->field("type_id,group_concat(id) as groups")->group('type_id')->select();
     #查询 结果
    'groups' =>  '7-测试7,11-测试3'
    
#### 查找重复数据
    Select * From 表 Where 重复字段 In (Select 重复字段 From 表 Group By 重复字段 Having Count(*)>1)  
  
-------------------------------------------------------------------
### PHP 判断是否是ajax

    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
       return true;
    }


-------------------------------------------------------------------

### PHP TP5 上传图片

##### 单图    
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
##### 多图
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
 
 
-------------------------------------------------------------------
### PHP TP5 关联查询 join

#####  关联查询  子查询 
    $subsql = db('article')->where(['status'=>1])->field('content,class_id')->buildSql();#要关联的表查询语句 需要查询出关联id
    $info = db('article_class')->alias('ac')->join([$subsql=> 'a'], 'ac.id = a.class_id')->select();
    
#####  普通关联
    Db::table('think_artist')
    ->alias('a')
    ->join('表1 w','a.id = w.artist_id')
    ->join('表2 c','a.card_id = c.id')
    ->select();
  
  
-------------------------------------------------------------------
### PHP 处理富文本编辑器 图片路径问题
       $http = 'http://aaaa.com';
        foreach ($info as $key => $value) {
            if (strpos($value['content'],'<img src="/ueditor/')) {
               $info[$key]['content'] =  str_replace('<img src="/ueditor/', '<img src="'.$http.'/ueditor/', $value['content']);
            }
        }

-------------------------------------------------------------------
 
### Mysql 导出数据结构语句  执行语句之后导出 

    select TABLE_SCHEMA,TABLE_NAME,COLUMN_NAME,COLUMN_TYPE,COLUMN_COMMENT from information_schema.columns where TABLE_SCHEMA='testzcdjk'
    
-------------------------------------------------------------------

### Mysql 查询表中数量大于10的

    select username,count(*) as '记录数'from 表 group by username having count(*)>10

 
-------------------------------------------------------------------
### PHP error mysql has gone away 
- php中的mysql配置 TP5

         pdo 连接数据库断线重连
         是否需要断线重连
        'break_reconnect' => true,
 
  
  
-------------------------------------------------------------------

### PHP substr() 函数详解 

##### substr — 返回字符串的子串
- 说明

        string substr ( string $string , int $start [, int $length ] )
        返回字符串 string 由 start 和 length 参数指定的子字符串。
    
- 如果 start 是非负数，返回的字符串将从 string 的 start 位置开始，从 0 开始计算。例如，在字符串 “abcdef” 中，在位置 0 的字符是 “a”，位置 2 的字符串是 “c” 等等。
    
- 如果 start 是负数，返回的字符串将从 string 结尾处向前数第 start 个字符开始。
    
- 如果 string 的长度小于或等于 start，将返回 FALSE。
    
        $rest = substr(“abcdef”, -1); // 返回 “f”
        $rest = substr(“abcdef”, -2); // 返回 “ef”
        $rest = substr(“abcdef”, -3, 1); // 返回 “d”
        
- 如果提供了正数的 length，返回的字符串将从 start 处开始最多包括 length 个字符（取决于 string 的长度）。

- 如果提供了负数的 length，那么 string 末尾处的许多字符将会被漏掉（若 start 是负数则从字符串尾部算起）。如果 start 不在这段文本中，那么将返回一个空字符串。

- 如果提供了值为 0，FALSE 或 NULL 的 length，那么将返回一个空字符串。
 
- 如果没有提供 length，返回的子字符串将从 start 位置开始直到字符串结尾。
    
        $rest = substr(“abcdef”, 0, -1); // 返回 “abcde”
        $rest = substr(“abcdef”, 2, -1); // 返回 “cde”
        $rest = substr(“abcdef”, 4, -4); // 返回 “”
        $rest = substr(“abcdef”, -3, -1); // 返回 “de”
    
    
        echo substr(‘abcdef', 1); // bcdef
        echo substr(‘abcdef', 1, 3); // bcd
        echo substr(‘abcdef', 0, 4); // abcd
        echo substr(‘abcdef', 0, 8); // abcdef
        echo substr(‘abcdef', -1, 1); // f
    
- 访问字符串中的单个字符
- 也可以使用中括号

        $string = ‘abcdef';
        echo $string[0]; // a
        echo $string[3]; // d
        echo $string[strlen($string)-1]; // f
    
-------------------------------------------------------------------
### PHP var_export() 函数
1.var_export 用于将数组转换成字符串
    
    $arr = [
    'key1'=>'val1',
    'key2'=>'val2',
    'key3'=>'val3',
    'key4'=>'val4',
    'key5'=>'val5'
    ];
    
    $str = var_export($arr,true);
    echo $str;//结果 array ( 'key1' => 'val1', 'key2' => 'val2', 'key3' => 'val3', 'key4' => 'val4', 'key5' => 'val5', )
    
2.什么地方会用到该方法？
    
    （1）通常，在数据库里面会创建一张表，用于存放所有配置项的信息（该表往往只有两个字段：name和value）
    
    （2）我们在后台修改配置项的值以后，除了保存到数据表以外，还要保存到文件中，以方便读取，这里就要用到该方法了
    
    （3）将修改后的配置表所有数据取出，存放到数组$data中
    
    $path = 'web.php';
    $str = '<?php return ';
    $str .= var_export($data,true);//数组转字符串
    $str .= ';';
    file_put_contents($path,$str);
    这样就将数组保存成字符串了
    
    作者：huang2017 
    来源：CSDN 
    原文：https://blog.csdn.net/huang2017/article/details/69258767 
 
 
-------------------------------------------------------------------

### PHP 配置虚拟主机及出现被拒绝情况 

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
4、 最后重启Apache服务器


##### Apache提示You don't have permission to access / on this server问题解决
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

  
-------------------------------------------------------------------
### PHP 对二维数组排序 

                //要排序的字段值(数组) //要排序的数组     如果数组里面元素的数量不同将会报错  

* 根据某字段对多维数组进行排序
* @param $array  要排序的数组 如果数组里面元素的数量不同将会报错 array_multisort(): Array sizes are inconsistent
* @param $field  要根据的数组下标
* @return void

        function sortArrByField(&$array, $field, $desc = false){
          $fieldArr = array();
          foreach ($array as $k => $v) {
            $fieldArr[$k] = $v[$field];
          }
          $sort = $desc == false ? SORT_ASC : SORT_DESC;
          array_multisort($fieldArr, $sort, $array);
        }


-------------------------------------------------------------------

### PHP register_shutdown_function 捕获异常 
今天因为接触了一个框架，各种try,catch。将致命错误和语法错误都抛出500。try，catch是没法捕捉到错误的。然后就用了下register_shutdown_function这个方法，很好用 
这个方法的原理就是在PHP进程结束前会去调用它一次。所以配合error_get_last（这个方法顾名思义，返回最后一次错误）可以很好的捕获致命错误

    register_shutdown_function('shutdown_function');  
    try{
        $a = new A();//这里会报致命错误
        echo 5/0;
    }catch(Exception $e){
        echo '异常捕获';
        print $e->getMessage();
    }
    function shutdown_function()  
    {  
        echo '捕获错误';
        $e = error_get_last();    
        print_r($e);  
    }

-  这里我开始犯了一个错误就是把register_shutdown_function写到最后去了。因为PHP代码是从头到尾开始执行，还没执行到你的方法时就被致命错误中断进程了，所以把他放到开始

或者这样写

    register_shutdown_function(function(){
        echo '捕获错误';
        $e = error_get_last();    
        print_r($e);  
    })
    
转载 忘记了原文地址  如果冒犯请联系我删除 抱歉
 
-------------------------------------------------------------------
### PHP函数 rand 和  mt_rand 
　　 
mt_rand() 比rand() 快四倍 
　　
  
  
-------------------------------------------------------------------
### PHP  tp5 图形验证码 

- 验证码

        #引入包 放到extends/org/
        use org\Verify;
        
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
- 前端

        <img src="/Index/Login/checkVerify"  onClick="this.src='/Index/Login/checkVerify?d='+Math.random();" alt="">

- 验证

        $verify = new Verify();
        if (!$verify->check($code)) {
            return json(['status' => 302, 'message' => '验证码错误']);
        }




-------------------------------------------------------------------
### PHP 生成订单号
    //tp5
    public static function order_numbers($table = 'orders', $order_num = 'order_num', $str = '')
    {
        do {
            if (empty($str)) {
                $str = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'S', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                $str = $str[mt_rand(0, 25)];
            }
            $num = $str . date('YmdHis') . mt_rand(10, 99);
        } while (db($table)->where($order_num, $num)->find());
        return $num;
    }
 
-------------------------------------------------------------------


### PHP basename

basename() 函数返回路径中的文件名部分。
- 定义路径
     
        $path = "/testweb/home.php";

- 显示带有文件扩展名的文件名

        echo basename($path);

- 显示不带有文件扩展名的文件名

        echo basename($path,".php");
  
-------------------------------------------------------------------

### PHP  尚通短信 发送验证码

- 调用

        $code = '随机数';
        $content ='您本次的验证码是'. $code .',请在10分钟内填写，切勿将验证码泄露于他人。【蒙健力源】';
        $sms = NewSms($phone,$content);
    
- (尚通)接口
    
        function NewSms($phone,$content){
            $data = "username=%s&password=%s&mobile=%s&content=%s";
            $url  = "http://120.55.248.18/smsSend.do?";
            $name = "MJLY";
            $pwd  = md5("密码");
            $pass = md5(用户名.$pwd);
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


-------------------------------------------------------------------
### PHP  打印微信支付错误信息 

     alert(JSON.stringify(res));
 
-------------------------------------------------------------------
### PHP 时间加减

- 下个月时间

      strtotime(date('Y-m')."+1 month")  
      
- 上个月时间

      strtotime(date('Y-m')."last month")  
      
- 打印明天此时的时间戳
  
      strtotime("+1 day")

      echo date("Y-m-d H:i:s",strtotime("+1 day"))
      
- 打印下个月此时的时间戳
    
      strtotime("+1 month");
  
- 打印下个星期此时的时间戳

      strtotime("+1 week")
  
- 打印指定下星期几的时间戳
 
      strtotime("next Thursday")

- 打印指定上星期几的时间戳
  
      strtotime("last Thursday")
  
  
-------------------------------------------------------------------

### PHP  显示月份 获取当前月份显示

1. 显示的月份为Jan,Feb格式
    
        date('M') 

2. 显示的格式为01,02,03格式
    
        date('m')

3. 显示的格式为1,2,3格式
    
        date('n') 


-------------------------------------------------------------------
### PHP 判断参数是否是时间格式

     $time = input('get.time', date('Y-m'));
     $time_str = strtotime($time);
     if (date('Y-m', $time_str) != $time) {
         return msg(201, '时间格式不正确');
     }
 
 
-------------------------------------------------------------------
### PHP  追加到数组头部和尾部 

##### 尾部追加 
方法1. 

        array_push ( array &$array , mixed $var [, mixed $... ] )
        $array_push = array("PHP中文网","百度一下");//定义数组
        array_push($array_push,"搜狗浏览器","火狐浏览器");//添加元素 可追加多个 用逗号隔开
方法2.

        $names[] = 'lucy'; //这种方法也可追加 每次可追加一个

##### 头部追加

    array_unshift ( array &$array , mixed $var [, mixed $... ] )
    $names = ['andy', 'tom', 'jack'];
    array_unshift($names, 'joe', 'hank'); //添加元素 可追加多个 用逗号隔开

  
  
-------------------------------------------------------------------
### php  取绝对值  
    abs() 函数返回一个数的绝对值。
    echo(abs(6.7));  6.7
    echo(abs(-3));  3
    echo(abs(3));   3


-------------------------------------------------------------------

### php  删除数组元素 根据值或键 


- 删除一个元素，且保持原有索引不变
    
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

- 删除一个元素，不保持索引
    
  使用 array_splice 函数，示例如下：
    
      $array = array(0 => "a", 1 => "b", 2 => "c");
      array_splice($array, 1, 1);
                //↑ 你想删除的元素的Offset
      输出：
      Array (
          [0] => a
          [1] => c
      )
- 按值删除多个元素，保持索引

  使用 array_diff 函数，示例如下：

      $array = array(0 => "a", 1 => "b", 2 => "c");
      $array = array_diff($array, ["a", "c"]);
                   //└────────┘→ 你想删除的数组元素值values
      输出：
      Array (
          [1] => b
      )
      
- 与 unset 类似，array_diff 也将保持索引。

  使用 array_diff_key 函数，示例如下：
      
      $array = array(0 => "a", 1 => "b", 2 => "c");
      $array = array_diff_key($array, [0 => "xy", "2" => "xy"]);
      输出：
      
      Array (
          [1] => b
      )
      与 unset 类似，array_diff_key 也将保持索引。
   
-------------------------------------------------------------------

### PHP    __FILE__  getcwd __LINE__ 等 魔术常量

名称  说明
1. __LINE__  文件中的当前行号。

2. __FILE__  文件的完整路径和文件名。如果用在被包含文件中，则返回被包含的文件名。自 PHP 4.0.2 起，__FILE__ 总是包含一个绝对路径（如果是符号连接，则是解析后的绝对路径），而在此之前的版本有时会包含一个相对路径。

3. __DIR__ 文件所在的目录。如果用在被包括文件中，则返回被包括的文件所在的目录。它等价于 dirname(__FILE__)。除非是根目录，否则目录中名不包括末尾的斜杠。（PHP 5.3.0中新增） =

4. __FUNCTION__  函数名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该函数被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。

5. __CLASS__ 类的名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该类被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。类名包括其被声明的作用区域（例如 Foo\Bar）。注意自 PHP 5.4 起 __CLASS__ 对 trait 也起作用。当用在 trait 方法中时，__CLASS__ 是调用 trait 方法的类的名字。

6. __TRAIT__ Trait 的名字（PHP 5.4.0 新加）。自 PHP 5.4 起此常量返回 trait 被定义时的名字（区分大小写）。Trait 名包括其被声明的作用区域（例如 Foo\Bar）。

7. __METHOD__  类的方法名（PHP 5.0.0 新加）。返回该方法被定义时的名字（区分大小写）。

8. __NAMESPACE__ 当前命名空间的名称（区分大小写）。此常量是在编译时定义的（PHP 5.3.0 新增）

  
-------------------------------------------------------------------

### PHP    大愚支付 微信  

  1.引入包
  2.修改命名空间
  3.回调为数组 字段不和官方字段相同
  4.最好事先模拟订单测试回调方法是否正常
  5.需判断返回状态是否成功
  6.需判断金额是否与订单一致
  7.tp5因为驼峰命名导致地址栏的事自动转换为 _和小写  这个时候和微信商户号支付授权目录会找不到该目录,避免这种写法
  8.回调结束如果不成功可输出 exit('success');微信 exit(xml)

### PHP   微信 商户号配置  
 
1.产品中心 ->开发配置 -> 包括选项  商户号 授权目录 扫码支付回调
2.账户中心 api配置  ->包括选项     证书下载  MD5秘钥设置(自己设置任意值)   此项所有操作都需要安装客户端操作证书

-------------------------------------------------------------------
### PHP    js判断是在微信还是php  

    function isWeiXin() {
    var ua = window.navigator.userAgent.toLowerCase();
        console.log(ua);//mozilla/5.0 (iphone; cpu iphone os 9_1 like mac os x) applewebkit/601.1.46 (khtml, like gecko)version/9.0 mobile/13b143 safari/601.1
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return true;
        } else {
            return false;
        }
    }

-------------------------------------------------------------------

### PHP   导出表格  

compsoer包  "phpoffice/phpexcel":"1.8.1"
下载完成  只有Classes文件夹是有用的

一.导出的三种方法  此处使用的是  makeExport 包是 index 和 makeExport 包含的包

    Excel.php 可写为控制器或者 service
    
    namespace app\system\controller;
    
    use PHPExcel;
    use PHPExcel_IOFactory;
    class Excel extends Base{
    
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
            $PHPSheet->setCellValue('A1','订单ID')
                ->setCellValue('B1','订单编号')
                ->setCellValue('C1','用户名/收货人')
                ->setCellValue('D1','收货地址')
                ->setCellValue('E1','套餐名称')
                ->setCellValue('F1','订单价格')
                ->setCellValue('G1','订单状态')
                ->setCellValue('H1','商品标题')
                ->setCellValue('I1','商品价格')
                ->setCellValue('J1','商品图片')
                ->setCellValue('K1','商品数量');
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


订单导出控制器Order.php  需要用 <a href=/index/order/excelData>导出订单</a>  

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


-------------------------------------------------------------------

### PHP   创建一个对象  强制类型转换为对象  

    $order = (object)array();
    $order = (object)null;
    $order = (object)'';
    $order->order_num = time();


-------------------------------------------------------------------
### PHP   支付宝批量转账 有密  

- 按照文档和demo配置好内容以后需要在支付宝账户管理下载操作证书 中间会回答密码问题, 并要求提供营业执照注册码
- 需要使用UC浏览器或者ie安装 主流浏览器不支持申请安装证书


-------------------------------------------------------------------


### PHP  Mysql 统计 sum 金额   

- double 类型是不精确的 
- 如果需要精确的保留和计算 需要将字段设置为 decimal



-------------------------------------------------------------------
### PHP  判断是否有空格   
    if(strpos("Hello world!"," ")){
        echo '有空格';
    }else{
        echo '没有空格';
    }


-------------------------------------------------------------------
### PHP  输出文件中所有行的内容 检测文件或者图片内容  
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

- feof(file) 函数检测是否已到达文件末尾 (eof)。

- 如果文件指针到了 EOF 或者出错时则返回 TRUE，否则返回一个错误（包括 socket 超时），其它情况则返回 FALSE。

- file 参数是一个文件指针。这个文件指针必须有效，并且必须指向一个由 fopen() 或 fsockopen() 成功打开（但还没有被 fclose() 关闭）的文件。

- feof() 函数对遍历长度未知的数据很有用。

- 注意：如果服务器没有关闭由 fsockopen() 所打开的连接，feof() 会一直等待直到超时而返回 TRUE。默认的超时限制是 60 秒，可以使用 stream_set_timeout() 来改变这个值。
- 如果传递的文件指针无效可能会陷入无限循环中，因为 EOF 不会返回 TRUE。

-------------------------------------------------------------------

### PHP  压缩图片的类  
```php
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

```
-------------------------------------------------------------------

### PHP  函数回溯 生成过程  

- 该函数显示由 debug_print_backtrace() 函数代码生成的数据。

-------------------------------------------------------------------

### PHP  array_map  

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


-------------------------------------------------------------------

### PHP  TP5 原生查询和修改  

- query方法用于执行SQL查询操作，如果数据非法或者查询错误则返回false，否则返回查询结果数据集（同select方法）

  使用示例： 查询

        Db::query("select * from think_user where status=1");


- execute用于更新和写入数据的sql操作，如果数据非法或者查询错误则返回false ，否则返回影响的记录数。

    使用示例：修改和写入

        Db::execute("update think_user set name='thinkphp' where status=1");

-------------------------------------------------------------------
### PHP  list  

list()
- 函数用于在一次操作中给一组变量赋值。
- 该函数只用于数字索引的数组，且假定数字索引从 0 开始。
- 如果跳过赋值 可留空 逗号隔开

        $my_array = array("Dog","Cat","Horse");
        
        list($a, $b, $c) = $my_array;
        echo "I have several animals, a $a, a $b and a $c.";


-------------------------------------------------------------------
### PHP  TP5 接收请求值 变量修饰符  
    input('变量类型.变量名/修饰符');
    
    Request::instance()->变量类型('变量名/修饰符');
    
    $this->request->isPost('变量名/修饰符');
    
    input('get.id/d');
    input('post.name/s');
    input('post.ids/a');
    Request::instance()->get('id/d');
    
    $this->request->isPost('row/a');  //row数组名  如果你要获取的数据为数组，请一定注意要加上 /a 修饰符才能正确获取到。
修饰符 作用
- s 强制转换为字符串类型
- d 强制转换为整型类型
- b 强制转换为布尔类型
- a 强制转换为数组类型
- f 强制转换为浮点类型


-------------------------------------------------------------------
### PHP  json_encode 参数  
```php
- php5.4 以后，json_encode增加了JSON_UNESCAPED_UNICODE , JSON_PRETTY_PRINT 等几个常量参数。使显示中文与格式化更方便。

- 使用 JSON_UNESCAPED_UNICODE 或者  JSON_PRETTY_PRINT 使数据阅读更方便,会自动换行,但是会占用更多的空间

echo json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
```

-------------------------------------------------------------------

### PHP  redis连接  

- 第一步:实例化redis对象

        $redis = new redis();
- 第二步：php客户端设置的ip及端口

        $redis->connect("127.0.0.1","6379");
- 第三部：配置连接密码 检测redis服务器连接状态  连接失败直接结束 并输出
  
        $auth = $redis->auth('zhenai')  or die("redis 服务器连接失败");
        var_dump($auth);连接成功 返回 true 反之 返回false
- 第四步  可用可不用
        
        echo $connect_status=$redis->ping();
        if($connect_status==="+PONG"){
            echo "redis 服务器连接成功";
        }


-------------------------------------------------------------------

### PHP  获取数组key  array_search 
    $array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');  
       
    $key = array_search('green', $array); // $key = 2;  



-------------------------------------------------------------------
###  PHP fastadmin 生成 控制器,模型 和表单 及小技巧
#####  PHP fastadmin 生成 控制器,模型
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
    
     
    --force=true 覆盖模式 -f 1
    -m 0  不生成model
    php think crud -t users -c users/users  -m users  --enumradiosuffix=satatus --force=true
    
    php think menu -c orders/ordersConfirm
    good/rushactivity/index
    
    状态 类型 不显示字段 上传图片 地址  --enumradiosuffix=title_id 生成后会加载控制title来选择selectpage   -u 1 生成菜单 菜单名为标注释
    
    php think crud -t design_user -c design/designuser  -m designuser --enumradiosuffix=satatus  --intdatesuffix=createtime  --enumradiosuffix=type   --ignorefields=updatetime --ignorefields=deletetime   --imagefield=wechat   --citysuffix=address --setcheckboxsuffix=forte_ids --enumradiosuffix=title_id --force=true  -u 1
    
    php think crud -t withdraw -c withdraw/withdraw  -m withdraw --enumradiosuffix=status  --intdatesuffix=createtime   --intdatesuffix=accesstime  --force=true  -u 1
    
    php think crud -t prize_list -c gift/prizegift  -m prizegift --enumradiosuffix=status  --enumradiosuffix=type --intdatesuffix=createtime   --imagefield=image  --ignorefields=updatetime    -u 1 
    
    php think crud -t platform -c platform/platform  -m platform --enumradiosuffix=status --enumradiosuffix=type --enumradiosuffix=money_type  --enumradiosuffix=is_add --intdatesuffix=accesstime  --intdatesuffix=gonetime --ignorefields=updatetime   

    php think crud -t users -c users/users  -m userlog --enumradiosuffix=type --intdatesuffix=createtime   --ignorefields=updatetime    -u 1

    {:build_select('row[status]', $statusList, null, ['class'=>'form-control', 'required'=>''])}

#### 奇银巧技

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
    
##### 自定义按钮
###### 第一步
    {
        field: 'operate',
        title: __('Operate'),
        operate: false,
        class: 'button_status',
        formatter: Controller.api.formatter.buttons
      },
###### 第二步  放在为表格绑定事件 下面

      Table.api.bindevent(table);      
      //点击通过
      $(document).on('click', ".access", function () {
          var data = $(this);
          var id = data.data('id');
          $.post('shop/shopapply/access', {id: id}, function (res) {
              if (res.status == 200) {
                  layer.alert(res.message);
                  data.parent().siblings('.status').html('<a href="javascript:;" class="searchit" data-toggle="tooltip" title="" data-field="status" data-value="2" data-original-title="点击搜索 通过"><span class="text-success"><i class="fa fa-circle"></i> 通过</span></a>');
                   data.parent().html('已处理');
              }else{
                  layer.alert(res.message);
              }
          })
      });

######  第三步 下面的api绑定加入方法
        api: {
            formatter: {
                buttons: function (value, row, index) {
                    return [
                        '<button class="btn btn-xs btn-success access" data-id=' + row.id + '  data-status=' + row.status + ' >通过</button>',
                        '<button class="btn btn-xs btn-danger reject" data-id=' + row.id + '   data-status=' + row.status + '>驳回</button>'
                    ];
                }
            },
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
  
##### 直接写点击事件 写在下面即可
    
        $(document).on("click", ".ajax_buttons", function () {
           console.log($(this).parent().siblings('.status').text('通过'));
        });
    
##### 弹窗获取 id
        Fast.api.open("coupons/allot?ids="+allotData);
    
##### 手动加上的样式 必须在table生成样式之后才会加载绑定事件

        //当内容渲染完成后
          table.on('post-body.bs.table', function (e, settings, json, xhr) {

                $.each($('td.button_status'),function(index,value){
                      var status =$(this).children().data('status');
                      if(status !== 1){
                          $(this).html('已处理');
                      }
                  });
          });
        
##### 关联 
        //控制器内 关联查询的时候where条件中的 goods.shop_id 其中goods 是模型名 不能是表名 不能弄错了
        
        ->where(['type' => 4,'shopgoods.shop_id'=>['neq',1],'deletetime'=>null])
        默认是本表的查询 但是当有两个的字段相同时要区分开
       
        protected $relationSearch = true; 要打开
         
         ->with(['goodClass','getShop']) 预加载
    
        js中查询要是用这种
        {field: 'getShop.nickname', title: __('Shop_id'), visible: false, operate: 'LIKE'},
        {field: 'get_shop.nickname', title: __('Shop_id'), operate: false},
    
##### js回调刷新
    table.bootstrapTable('refresh');


##### 关联时修改where查询条件 fastadmin
```php
     /* =============修改关联查询字段 开始   修改backend文件搜索条件 ================*/
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
        替换为
        foreach ($filter as $k => $v) {
            $sym = isset($op[$k]) ? $op[$k] : '=';
            if (stripos($k, ".") === false) {
```                
-------------------------------------------------------------------

### PHP 上传文件 原生
```php
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
```

-------------------------------------------------------------------

###  PHP 计算中文长度 mb_strlen 


    echo strlen("你好ABC") . "";
    //输出 9
    echo mb_strlen("你好ABC", 'UTF-8') . "";
    //输出 5
    echo mb_strwidth("你好ABC") . "";
    
    //输出 7
    从上面的测试，我们可以看出：
    
    strlen 把中文字符算成 3 个字节
    
    mb_strlen 不管中文还是英文，都算 1 个字节
    
    mb_strwidth 则把中文算成 2 个字节
    
    所以长度统计的时候用mb_strlen这个函数


-------------------------------------------------------------------
### PHP array_filter 用回调函数过滤数组中的单元 

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

-------------------------------------------------------------------
### PHP PHP_SAPI 获取php运行环境

    var_dump(PHP_SAPI);
    "cgi-fcgi"  nginx 
     "cli"      命令行
     
-------------------------------------------------------------------

### PHP mysql数据库字段为数字时不能修改 或者与系统字段冲突时

    使用原生语句 在sql 语句中 将字段名加入 `1` 这样形式 
    
    数据库字段冲突时 也可以用 `mysql` 这样写


-------------------------------------------------------------------
### PHP mysql字段数值基础上增加 

    'update xx_wechat_template set status=2,times=`times+1` where id=' . $form_info['id'];
   
-------------------------------------------------------------------
### PHP 获取ip 格式化ip 

1. 获取主机名 参数 ip地址 成功返回主机名 否则返回当前输入的参数ip

         gethostbyaddr()  
         
2. 获取协议端口  参数->协议名    
    
        getprotobyname(); 
        
3. 获取主机名 无参数
    
        gethostname());
        
4. 获取ip通过域名
   
        gethostbyname('www.jijijichain.com');
        
5. 取ip通过域名以数组形式返回 
        
        gethostbynamel('www.jijijichain.com');
        
6. 用于将一个数字格式的IPv4地址转换成字符串格式(192.168.0.1)
    
         ip2long($ip)



-------------------------------------------------------------------
### PHP tp5 计算符号
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


-------------------------------------------------------------------
### PHP cal_days_in_month() 获取指定月份的天数

    $days = cal_days_in_month(CAL_GREGORIAN, 4, 2011);
#### 获取当月天数
    echo date('t');

    如果出现找不到该方法 cal_days_in_month()
    1.是因为安装php的时候没有 简单的就使用下面的方法
      if (!function_exists('cal_days_in_month')) 
      { 
          function cal_days_in_month($calendar, $month, $year) 
          { 
              return date('t', mktime(0, 0, 0, $month, 1, $year)); 
          } 
      } 


    2.想要使用原方法就用
    http://www.ypgogo.com/Event/info/vid/53511    
    Fatal error: Call to undefined function: cal_days_in_month() in ...
    再去查手册，原来要使用PHP日历函数，必须要在编译的时候使用参数--with-calendar。我们使用的那台服务器显然没有安装这个功能。于是要使用phpize来安装了。方法如下：

    第一步：使用ssh登录服务器，必须有权限才行啊。租用虚拟主机的站长自己想办法吧。

    第二步：找到PHP安装程序

    cd /your_path/php-5.3.14/ext/calendar

    your_path，就是你放PHP安装文件的路径。ext是扩展包的路径。到里面一看，有不少东西呢，关键看有没有calendar这个路径。

    第三步：#/usr/daemon/php/bin/phpize

    这个/usr/daemon是我安装php的路径，你的服务器上在哪里你要自己找一找，用locate找吧

    第四步：#./configure --with-php-config=/usr/daemon/php/bin/php-config

    同样，你的服务器上这个php-config文件肯定与我这个不同。

    第四步：make

    看看有没有错误。有错误的话要处理好再继续下一步。

    第五步：make install

    第六步：修改php.ini文件。在最后添加一句extentsion=calendar.so

    如果你的php.ini文件中extension路径那句还是注释着的话，需要激活。你把目录下的 calendar.so拷贝到你php.ini中的extension_dir指向的目录中。一般第五步结束的时候，会提示你，calendar.so被拷贝到哪个路径了。你注意看就可以发现。

    第七步：重启apache即可。#service httpd restart


-------------------------------------------------------------------
### 计算当前日期的星期日历
```php
    /**
     * 计算星期
     */
    public function week()
    {
        //当月天数
        $total_day = date("t");
        //当前星期
        $week = (int)date("N");
        //当前日期
        $today = (int)date('d');
        $date = [];
        for ($i = $week; $i <= 7; $i++) {
            //超过了当前月份天数
            if ($today > $total_day) {
                $today = 1;
            } else {
                $date[$i] = $today++;
            }
        }
        $last_days = 0;
        //当前日期
        $today = (int)date('d');
        for ($i = $week; $i >= 1; $i--) {
            if ($today <= 0) {
                if ($last_days == 0) {
                    //上月天数
                    $last_days = date('t', mktime(0, 0, 0, date('m') - 1, 1, date('Y')));
                    $today = (int)$last_days;
                }
                $date[$i] = $today--;
            } else {
                $date[$i] = $today--;

            }
        }
        ksort($date);
        dd($date);
    }

```
-------------------------------------------------------------------
### PHP 查询openssl配置文件路径
####进入命令行输入
    echo '<?php phpinfo(); ?>' | php 2>&1 |grep -i ssl
    默认是为 /usr/local/openssl/openssl.cnf



-------------------------------------------------------------------
### PHP生成公钥和私钥对
          public function makeKey()
            {
                //openssl文件路径
                $opensslConfigPath = "/usr/local/openssl/openssl.cnf";
                $config = [
                    'config' => $opensslConfigPath,
                    "digest_alg" => "sha512",
                    "private_key_bits" => 2048,
                    "private_key_type" => OPENSSL_KEYTYPE_RSA,
                ];
                //创建密钥对
                $key = openssl_pkey_new($config);
                //生成私钥
                openssl_pkey_export($key, $privkey, null, $config);
                //生成公钥
                $pubKey = openssl_pkey_get_details($key)['key'];
                echo $privkey . "<hr>";
                echo $pubKey ;
                //写入到文件或写入到数据库
                file_put_contents('private.key', $privkey);
                file_put_contents('public.key', $pubKey);
            }
##### 生成结果 每64个字符一个换行
            私钥
            -----BEGIN PRIVATE KEY----- 
            MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDQ385/WvfFOBBY 
            JVQvKKO2FnbTkh/QsOd+2TpE1pH//aMGA7oVGws6EhA/PBf2e1vhGmPK00Oba4wz /4CKitP5rNGh2ltweOQRhYN5jJGGPiFjBPQwQHckiaNlIMH4PZodqdrceStpNrEd 03PITf6QlIG8WXQbD2RFdWniZ/39V8YijuWQ0GOHM/8rtJLvplU+v8fsdDZaoHqB RJ13NTvsr+9C5ubr540AcWmueM1TdExO+tdM2eaEvZLeFZiXaq9JrlVOHjlUSdPq BB5Q0V8DcDUh4QtMCeG+nW6BThtYjsRoO2dWbb11GJEgqg7c8pDm+aA01O34o877 
            2jH/KX7VAgMBAAECggEAdQzWdXwO2VBfqGXS1VKa25GfKVT7y0E3mVg2VRlBXAlQ 
            8C/qeaVcF0DEJguRCil7BZx6S9E0U8ZjHUiTShAeVg5Is8Df+RlmBYOid90UN/xd 
            TVYbWWbm3WzcSfGfgXNUCEeFRIQKlb12Z9Z1TcyXWYI/acNfU0K+2EXB/oR0SyF/ 
            r4G7RRnz/YEZPEiYqUAG0TfSMXNxMrYov9G5jE5rUqy3lzcC5Eh1/HJc+IAqw4Pk 
            qPKOAIvV+n+k9R5OEI5/7PDX/h0KbnF5IsLFMviGHwZCD8A4pse6EgUUmlu4PES8 H9eZyCpbjYy5fyeo6/4pXONROHskgEHtBoCxvD9hSQKBgQDvMC0Ijbs8gmfeFpqM km5U1IDTObnDTQ9kSdoQwg+YTgt7T9zZ2HFnf0tiVFMr1xMSATWv30a02OLaC5w9 
            J5+9ovUNZ2IJxXQpAslOYb8h0/FtftOZFozx9gBNTrkL35cryBR1cQ3pG6Px5y61 
            z92FIQiVDgFf4dfjaRM4eeMdKwKBgQDfji2JfDjZEGOGL/sxzjv5b5Ekgdbpnuu/ 
            1nPlApqX6l67VAJa2CH/DHWUn/9v+Ch1XcQaEJbQpyw9Pj5kYX/MVbwTlnSGW9Ms 
            0Ym/NNWWdBGZhRA0IuNT87m7gFfllGV9r/ono/Y6UKu1tluhoXo4i20XK5d54PBv 
            1+KXHi/T/wKBgQCTVkfHRxcZNPMqeR4GjYTtOGGKu7pUNbnPezaasA/PL/Qep5lR j+R7boxPK8Z38OpMYvZhOdZiPF+xFQnPGgNqW2E8OnzHrBvbz12VrNyBx/6mBkPt 
            v1hfC7wv4thWGgsS6xK/LT72YxJgRpodYMgB49FXj+ME3yePbABs/5gJNQKBgQDN mWP16sIZl8IAWkZqUuLDj8Dr02HE8Dye7OsfdlqZVpoTLLsRs27osxu8Ob3hy1fi QP8mfZVGhkjgdktJZIX1dfAID7pRC0hXEsrdiAjbWxoIl+EEIgXyYtexQuMTqHwC 
            sQKezGOa1DBnaTQynWDbehc1VQj1tVNLeT/SfZe9HwKBgQCwpP3Ol8N5GoD4ll0e Oz6Xf6J8dpq6Dote4+sUzCwOLHmHb6Wd+tJ95WMCeeuUxhcr6sTLmNHFQFAn8RA9 
            DYzOQ1FW+iu10k/WfDymuRKeedXZXdgBao/Wya9smwqJb8jPUXnfQfz3vgel2hs5 
            F7vu+bfBgIW9Dz/TCJAhavCXWQ== 
            -----END PRIVATE KEY-----

            公钥
            -----BEGIN PUBLIC KEY----- 
            MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0N/Of1r3xTgQWCVULyij thZ205If0LDnftk6RNaR//2jBgO6FRsLOhIQPzwX9ntb4RpjytNDm2uMM/+AiorT +azRodpbcHjkEYWDeYyRhj4hYwT0MEB3JImjZSDB+D2aHana3HkraTaxHdNzyE3+ 
            kJSBvFl0Gw9kRXVp4mf9/VfGIo7lkNBjhzP/K7SS76ZVPr/H7HQ2WqB6gUSddzU7 
            7K/vQubm6+eNAHFprnjNU3RMTvrXTNnmhL2S3hWYl2qvSa5VTh45VEnT6gQeUNFf A3A1IeELTAnhvp1ugU4bWI7EaDtnVm29dRiRIKoO3PKQ5vmgNNTt+KPO+9ox/yl+ 
            1QIDAQAB 
            -----END PUBLIC KEY-----


-------------------------------------------------------------------
### PHP判断扩展是否存在
    if (!extension_loaded('openssl')) {
       throw new \Exception('请先安装openssl扩展');
    }


-------------------------------------------------------------------

##  PHP trim 
包括
- trim();  //默认去除两边的空格
- rtrim(); //默认去除右边的空格
- ltrim(); //默认去除左边的空格

        trim('31222333');   //默认去除两边的空格
        time('3222333',3);  //去除字符串两边的3
        rtrim('333222333',3);   //去除字符串右边的3 多个会全部去掉直到不一样的停止




-------------------------------------------------------------------

## PHP array_chunk 分割数组 

    array array_chunk ( array $input , int $size [, bool $preserve_keys = false ] )
    将一个数组分割成多个数组，其中每个数组的单元数目由 size 决定。最后一个数组的单元数目可能会少于 size个。
#### 参数

    1. input 
    需要操作的数组
    
    2. size  
    每个数组的单元数目
    
    3. preserve_keys
    设为 TRUE，可以使 PHP 保留输入数组中原来的键名。如果你指定了 FALSE，那每个结果数组将用从零开始的新数字索引。默认值是 FALSE。
    
#### 返回值
    得到的数组是一个多维数组中的单元，其索引从零开始，每一维包含了 size 个元素。
    错误／异常
    如果 size 小于 1，会抛出一个 E_WARNING 错误并返回 NULL。

#### 范例 array_chunk() 例子
            设置一个数组
            $input_array = array('a', 'b', 'c', 'd', 'e');

1.常用
        print_r(array_chunk($input_array, 2));
        输出:
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
2.加true 
       
        print_r(array_chunk($input_array, 2, true));
        
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

-------------------------------------------------------------------
## PHP array_column 将数组指定下标为键值 
#### 参数
     array_column(array,value,key);
     1.array 参数1为数组 
     2.value 为结果需要保留的字段,会变成1维数组key=>value,null为所有 
     3.key 需要为下标的键
     
     //查询出结果数组
     $users = db('users')->select();
     
     $users = array_column($users,null,'id');

-------------------------------------------------------------------
## PHP str_replace 批量替换内容 

- 多对一替换 

        想把内容字段里所有的<p></p>标签清除掉,替换成空
        
        str_replace(array('<p>','</p>'), '', $Content)

- 一对一替换
    
        想把内容字段里所有的<br>标签换成<p>
        ``
        str_replace('<br>', '<p>', $Content) 

- 多对多替换
    
        想把内容字段里的<br>换成<br />, 同时<p>换<hr>，把</p>全清除
        
        str_replace(array('<br>', '<p>','</p>') , array('<br />','<hr>',''), $Content)



-------------------------------------------------------------------
## PHP 简体转繁体 
  
- [错误参考文章链接](https://www.jianshu.com/p/a9d0b9241a27)


- [中文简体转繁体文章链接](https://github.com/NauxLiu/opencc4php)   

1. opencc4php 是OpenCC的PHP扩展，能很智能的完成简繁体转换。 
2. 需要先安装OpenCC扩展 如果此处安装失败可去管方githup地址重新下载编译安装
3. 你需要先安装1.0.1 版本以上的OpenCC，

###### 安装OpenCC：
  
      git clone https://github.com/BYVoid/OpenCC.git --depth 1
      cd OpenCC
      make
      sudo make install


###### 安装opencc4php：

      git clone git@github.com:NauxLiu/opencc4php.git --depth 1
      cd opencc4php
      phpize    
      ./configure
      make && sudo make install
  
      - 如果你的OpenCC安装目录不在/usr或/usr/local，可在./configure时添加--with-opencc=[DIR]指定你的OpenCC目录
    
      - 要注意phpzie的php版本  多个版本要指定 ./configure --with-php-config=/www/server/php/bin/php-config
    
      - 安装完成后加入到php.ini文件最后一行加入

      /www/server/php/71/lib/php/extensions/no-debug-non-zts-20160303/ 这个路径安装完成会显示
      extension =  /www/server/php/71/lib/php/extensions/no-debug-non-zts-20160303/opencc.so

      如果php -m 提示这条错误
      PHP Startup: Unable to load dynamic library '/www/server/php/71/lib/php/extensions/no-debug-non-zts-20160303/opencc.so' - libopencc.so.2: cannot open shared object file: No such file or directory in Unknown on line 0
    
      那么需要执行 ln -s /usr/lib/libopencc.so.2 /usr/lib64/libopencc.so.2
      
      最后查看 php -m 是否有opencc  如果有则重启php开始使用 



###### 例子
      $od = opencc_open("s2twp.json"); //传入配置文件名
      $text = opencc_convert("我鼠标哪儿去了。", $od);
      echo $text;
      opencc_close($od);


###### 函数列表：
      opencc_open(string ConfigName) ConfigName:配置文件名，成功返回资源对象，失败返回false
      opencc_close(resource ob) 关闭资源对象,成功返回true，失败返回false.
      opencc_error() 返回最后一条错误信息，有错误信息返回String,无错误返回false
      opencc_convert(string str, resource od) str：要转换的字符串(UTF-8)，od：opencc资源对象

###### 可用配置
      s2t.json 简体到繁体
      t2s.json 繁体到简体
      s2tw.json 简体到台湾正体
      tw2s.json 台湾正体到简体
      s2hk.json 简体到香港繁体（香港小学学习字词表标准）
      hk2s.json 香港繁体（香港小学学习字词表标准）到简体
      s2twp.json 简体到繁体（台湾正体标准）并转换为台湾常用词汇
      tw2sp.json 繁体（台湾正体标准）到简体并转换为中国大陆常用词汇

-------------------------------------------------------------------
## PHP  redis 秒杀商品 


-   后台添加活动时将商品的库存添加进入redis
```php
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
```
- 前台redis抢购减少
```php
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
```

- 注意事项 
  >   - redis减少和数据库速度不成正比 
  >   - 库存减少和redis库存会不一致 特比是在事物中 但是又不得不使用事物

- 1.错误写法

  >   ```
  >   $good_info->stock -= $num; 然后 $good_info->save(); 
  >
  >   这种写法在事物中不可取 因为在高并发中查出内容到下面扣除库存的时候已经不一样 
  >   其他比较快到的进程可能已经扣除了库存 导致保存的时候不是预料的值 高并发的时候无法保存值  
  >   这种是阻塞的 
  >   ```  
- 2.推荐
  >  用自增或自减的方法 然后将数据库字段设为无符号 当为负数是直接回抛出程序
  >```
  >    $goods_stock_res = $goods_model->where(['id' => $good_info['id']])->setDec('stock');
  >    if (!$goods_stock_res) {
  >        throw  new Exception('手慢了，已抢完~', 205);
  >    }
  >```


-------------------------------------------------------------------

## PHP  redis list操作 

1. `blpop key1 [key2 ] timeout`
 
    移出并获取列表的第一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
2. `brpop key1 [key2 ] timeout`
 
    移出并获取列表的最后一个元素， 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
3. `brpoplpush source destination timeout`
 
    从列表中弹出一个值，将弹出的元素插入到另外一个列表中并返回它； 如果列表没有元素会阻塞列表直到等待超时或发现可弹出元素为止。
4. `lindex key index`
 
    通过索引获取列表中的元素
5. `linsert key before|after pivot value`
 
    在列表的元素前或者后插入元素
6. `llen key`
 
    获取列表长度
7. `lpop key`
 
    移出并获取列表的第一个元素
8. `lpush key value1 [value2]`
 
    将一个或多个值插入到列表头部
9. `lpushx key value`
 
    将一个值插入到已存在的列表头部
10. `lrange key start stop`
 
    获取列表指定范围内的元素
11. `lrem key count value`
 
    移除列表元素
12. `lset key index value`
 
    通过索引设置列表元素的值
13. `ltrim key start stop`
 
    对一个列表进行修剪(trim)，就是说，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除。
14. `rpop key`
 
    移除列表的最后一个元素，返回值为移除的元素。
15. `rpoplpush source destination`
 
    移除列表的最后一个元素，并将该元素添加到另一个列表并返回
16. `rpush key value1 [value2]`
 
    在列表中添加一个或多个值
17. `rpushx key value`
 
    为已存在的列表添加值



-------------------------------------------------------------------
## PHP获取扩展版本号 

    $version = phpversion('swoole');


-------------------------------------------------------------------
## composer 下载安装慢 

1. composer速度慢

    使用国内镜像。[国内镜像地址](http://pkg.phpcomposer.com) 
    使用方式：
        
        修改全局
        composer config -g repo.packagist composer https://packagist.phpcomposer.com
        修改当前项目  
        composer config repo.packagist composer https://packagist.phpcomposer.com 

        上面命令执行之后会在composer.json里面添加镜像的配置信息。
        
        "repositories": {
            "packagist": {
                "type": "composer",
                "url": "https://packagist.phpcomposer.com"
            }
        }

        然后再下载 很快


-------------------------------------------------------------------
## xdebug 安装 mac 

github [安装地址](https://github.com/xdebug/xdebug)

按照github给的方法安装 
    
    如果是安装官方给的安装php的方法 路径也都是默认路径就使用 
    ./rebuild.sh
    
    否则使用
 1. `./configure --enable-xdebug --with-php-config=/www/server/php/73/bin/php-config`
 2. `make clean`
 3. `make`
 4. `make install`
 5. 配置放到php.ini 文件中
 
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
        
 - profiler_append profiler_enable profiler_enable_trigger 这几个 选项 还是关了吧，不然的话，会在 profiler_output_dir 目录下，产生 几十G 的缓存文件，占磁盘！
    
### 检测是否安装上 
```sh
    $ php -v
      输出:
      PHP 7.2.0RC6 (cli) (built: Nov 23 2017 10:30:56) ( NTS DEBUG )
      Copyright (c) 1997-2017 The PHP Group
      Zend Engine v3.2.0-dev, Copyright (c) 1998-2017 Zend Technologies
      with Xdebug v2.6.0-dev, Copyright (c) 2002-2017, by Derick Rethans
    
      或者输出 phpinfo()  
      php -r "echo phpinfo();" 

```

-------------------------------------------------------------------
## compsoer 多个php共存版本冲突的问题 

- php73 也可以写成绝对路径此处是加入了软链

        php73 /usr/bin/composer update
        php73 /usr/bin/composer.phar update

- 如果直接修改 composer 那个二进制文件 文件会导致sha签名不一致



-------------------------------------------------------------------
## PHP  final  

- final 官方文档指出 在php5以后的关键字
- 只能在类中使用 属性不能指定 
- 可以指定类名 被指定的类不能被继承  
- 被指定的方法不能被子类重写


-------------------------------------------------------------------
## PHP 数组截取 array_slice() 函数  转载

- 定义和用法

 >   array_slice() 函数在数组中根据条件取出一段值，并返回。
 >   
 >   注释：如果数组有字符串键，所返回的数组将保留键名。（参见例子 4）
    
- 语法

        array_slice(array,offset,length,preserve)
    
- 参数 
1. > array - 必需,规定输入的数组。
2. > offset - 必需。数值。规定取出元素的开始位置
   > - 如果是正数，则从前往后开始取
   > - 如果是负值，从后向前取 offset 绝对值
3. > length - 可选。数值。规定被返回数组的长度
   > - 如果 length 为正，则返回该数量的元素
   > - 如果 length 为负，则序列将终止在距离数组末端这么远的地方。如果省略，则序列将从 offset 开始直到 array 的末端
4. > preserve 
   > - 可选。可能的值：
   > - true - 保留键
   > - false - 默认 - 重置键


- 例子 1

        $a=array(0=>"Dog",1=>"Cat",2=>"Horse",3=>"Bird");
        print_r(array_slice($a,1,2));
        
        输出：Array ( [0] => Cat [1] => Horse )


- 例子 2 带有负的 offset 参数：

        <?php
        $a=array(0=>"Dog",1=>"Cat",2=>"Horse",3=>"Bird");
        print_r(array_slice($a,-2,1));
        
        输出：Array ( [0] => Horse )


- 例子 3 preserve 参数设置为 true：

        $a=array(0=>"Dog",1=>"Cat",2=>"Horse",3=>"Bird");
        print_r(array_slice($a,1,2,true));
        
        输出：Array ( [1] => Cat [2] => Horse )


- 例子 4 带有字符串键：

        $a=array("a"=>"Dog","b"=>"Cat","c"=>"Horse","d"=>"Bird");
        print_r(array_slice($a,1,2));
        
        输出：Array ( [b] => Cat [c] => Horse )




-------------------------------------------------------------------
### MYSQL 

####分组统计金额
 - ai_balance 统计的字段 
    
      SELECT type,sum(ai_balance) as sum FROM users_asset where user_id in($total_ids) and ai_balance > 0 group by type

#### 分组统计并排序
- amount 统计的字段 ORDER BYamounts 排序的方式 也可以以写为sum(amount)

      SELECT user_id,id,sum(amount) as amounts FROM `xx_orders` WHERE agent_id=201966668 and status=5 GROUP BY user_id ORDER BY amounts DESC


-------------------------------------------------------------------
### PHP 创建一个指定长度的指定值的数组
      
    //从下标0开始到100,值为0的数组
     $pad_arr = array_fill(0, 100, 0);



-------------------------------------------------------------------



-------------------------------------------------------------------



-------------------------------------------------------------------




-------------------------------------------------------------------



-------------------------------------------------------------------



-------------------------------------------------------------------




