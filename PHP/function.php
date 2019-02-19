<?php














//====================  PHP 获取ip 格式化ip ============================

/*


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

