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

###### 追加合并
    array_merge()

-------------------------------------------------------------------
### 正则
>###### 匹配手机号
    /^1[34578]{1}\d{9}$/
#### 常用的验证规则
>##### 验证手机号
       public static function CheckPhone($phone){
          if (!preg_match("/^1[34578]{1}\d{9}$/", I('phone'))) {
          return '手机号不合法';
          }
       }
>###### 验证姓名
       public static function CheckName($str){
          if (!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',$str)) {
              return '姓名最少两个最多4个汉字';
            }
       }

>##### 验证密码
       public static function CheckPassword($str){
       if (!preg_match('/^[a-zA-Z0-9_]{6,16}$/',$str)) {
             return '密码必须大于6位少于16位的字母或数字';
         }
      }
>##### 验证交易密码
        public static function CheckDealPass($str){
          if (!preg_match('/^[0-9]{6}$/',$str)) {
             return '交易密码必须为6位数字';
          }
       }
>#####  生成随机数
     public static function RandNumber($user_id)
     {
        $str = '';
        do {
          $str =mt_rand()(1,100).mt_rand(200,900);
        } while (sql_result);
         return $str;
     }
>#####  生成随机数
       public static  function RandPass()
       {
        $str = md5(mt_rand(0,99)*(substr(time(),0,3)).mt_rand(100,200)*(substr(time(),4,7)));
        return $str;
       }

>##### 邮箱验证        
    public function check_email($email)
    {
      if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email)) {
        return '邮箱格式不正确!';
      }
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


-------------------------------------------------------------------


-------------------------------------------------------------------


-------------------------------------------------------------------


-------------------------------------------------------------------


-------------------------------------------------------------------
