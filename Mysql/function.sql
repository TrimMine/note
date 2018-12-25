/*
------------------------------cpu100%的原因查询-----------------------------------

通过如下方式定位效率低的查询：

通过 show processlist; 或 show full processlist; 命令查看当前执行的查询，
对于查询时间长、运行状态（State 列）是“Sending data”、“Copying to tmp table”、“Copying to tmp table on disk”、“Sorting result”、“Using filesort”等都可能是有性能问题的查询（SQL）。


若在 QPS 高导致 CPU 使用率高的场景中，查询执行时间通常比较短，show processlist; 命令或实例会话中可能会不容易捕捉到当前执行的查询。您可以通过执行如下命令进行查询：

explain select b.* from perf_test_no_idx_01 a, perf_test_no_idx_02 b where a.created_on >= 2015-01-01 and a.detail = b.detai
或者 用\G显示
explain select b.* from perf_test_no_idx_01 a, perf_test_no_idx_02 b where a.created_on >= 2015-01-01 and a.detail = b.detai \G
阿里云地址--https://help.aliyun.com/knowledge_detail/51587.html
登录rds查看实例会话
------------------------------ cpu 100%的原因查询-----------------------------------

cpu消耗过大有慢sql造成,慢sql包括全表扫描，扫描数据量太大，内存排序，磁盘排序，锁争用等；
mysql>show processlist;

查看所有连接
现象sql执行状态为:sending data,copying to tmp table,copying to tmp table on disk,sorting result,using filesort,locked;就有问题了。

所有状态说明在mysql官网有http://dev.mysql.com/doc/refman/5.0/en/show-processlist.html

a.sending data:sql正从表中查询数据，如果查询条件没有适当索引，会导致sql执行时间过长

b.copying to tmp table on disk:因临时结果集太大，超过数据库规定的临时内存大小,需要拷贝临时结果集到磁盘上

c.sorting result,using filesort:sql正在执行排序操作，排序操作会引起较多的cpu消耗，可以通过添加索引，或
减小排序结果集

不同的实例规格iops能力不同，如，iops为150个，也就是每秒能够提供150次的随机磁盘io操作，所以如果用户的数据量
很大，内存很小，因iops的限制，一条慢sql就有可能消耗掉所有io资源，而影响其他sql查询，对于数据库就是所有的sql
需要执行很长时间才返回结果集，对于应用会造成整体响应变慢。
临时表最大所需内存需要通过tmp_table_size=1024M设定



----------------------------mysql  分析sql  profile 和 explain ----------------------------

mysql可以通过profiling命令查看到执行查询SQL消耗的时间。
select @@profiling;  
0：表示profiling功能是关闭；

1：表示打开的。

可以通过命令打开/关闭profiling功能。

打开命令：
set profiling=1;  
关闭命令：
set profiling=0;  
例子
select * from employee limit 1,10;

show profiles;  
+----------------+-----------------+-------------------------------------------------------------+

| Query_ID        | Duration         | Query                                                                     |

+----------------+-----------------+--------------------------------------------------------------+

|             1       | 0.00083225      | select * from employee limit 1,10                              |

+----------------+-----------------+--------------------------------------------------------------+

1 row in set ( 0.00 sec)

使用explain来分析是否命中索引

mysql> explain select * from user where username = 'a';  
或者
mysql> explain select * from user where username = 'a'\G;  

+----+-------------+-------+------+---------------+------------+---------+-------+------+-------------+  
| id | select_type | table | type | possible_keys | key        | key_len | ref   | rows | Extra       |  
+----+-------------+-------+------+---------------+------------+---------+-------+------+-------------+  
|  1 | SIMPLE      | user  | ref  | user_index    | user_index | 62      | const |    1 | Using where |  
+----+-------------+-------+------+---------------+------------+---------+-------+------+-------------+  
1 row in set (0.00 sec)  

可以看出已经命中索引user_index
需要注意为了明确看到查询性能，我们启用profiling并关闭query cache：

>SET profiling = 1;
>SET query_cache_type = 0;
>SET GLOBAL query_cache_size = 0;

根据query_id 查看某个查询的详细时间耗费
> show profile for query 3;
ALL
显示所有性能信息

>show profile all for query 3;

ALL
显示所有性能信息
BLOCK IO
显示块IO（块的输入输出）的次数
CONTEXT SWITCHES
显示自动和被动的上下文切换数量
IPC
显示发送和接收的消息数量。
MEMORY
MySQL5.6中还未实现，只是计划实现。
SWAPS
显示swap的次数。


----------------------------mysql加入索引----------------------------
mysql添加索引命令
创建脚本
1.PRIMARY  KEY（主键索引）
mysql>ALTER  TABLE  `table_name`  ADD  PRIMARY  KEY (  `column`  ) 
2.UNIQUE(唯一索引)
mysql>ALTER  TABLE  `table_name`  ADD  UNIQUE (`column` ) 
3.INDEX(普通索引)
mysql>ALTER  TABLE  `table_name`  ADD  INDEX index_name (  `column`  )
4.FULLTEXT(全文索引)
mysql>ALTER  TABLE  `table_name`  ADD  FULLTEXT ( `column` )
5.多列索引 复合索引 只有在按照复合索引顺序的时候才会用到 可以建立多个复合索引 
mysql>ALTER  TABLE  `table_name`  ADD  INDEX index_name (  `column1`,  `column2`,  `column3`  )

比如建立复合索引cc
KEY `cc` (`dd`,`aa`) USING BTREE
那么语句：
select * from test where dd=5   -----有用到索引
select * from test where aa=5   ------没有用到索引


描述：
PRIMARY, INDEX, UNIQUE 这3种是一类
PRIMARY 主键。 就是 唯一 且 不能为空。
INDEX 索引，普通的
UNIQUE 唯一索引。 不允许有重复。
FULLTEXT 是全文索引，用于在一篇文章中，检索文本信息的

。
命令行添加索引 ----------
ALTER TABLE `shenghui`.`release_record` ADD INDEX rds_idx_0 (`user_id`, `created_at`);
ALTER TABLE `shenghui`.`release_record` ADD INDEX rds_idx_0 (`user_id`, `release_money`);


/*

一、B-Tree
B-Tree是最常见的索引类型，所有值（被索引的列）都是排过序的，每个叶节点到跟节点距离相等。所以B-Tree适合用来查找某一范围内的数据，而且可以直接支持数据排序（ORDER BY）

B-Tree在MyISAM里的形式和Innodb稍有不同：
MyISAM表数据文件和索引文件是分离的，索引文件仅保存数据记录的磁盘地址
InnoDB表数据文件本身就是主索引，叶节点data域保存了完整的数据记录

二、Hash索引
1.仅支持"=","IN"和"<=>"精确查询，不能使用范围查询：
由于Hash索引比较的是进行Hash运算之后的Hash值，所以它只能用于等值的过滤，不能用于基于范围的过滤，因为经过相应的Hash算法处理之后的Hash

2.不支持排序：
由于Hash索引中存放的是经过Hash计算之后的Hash值，而且Hash值的大小关系并不一定和Hash运算前的键值完全一样，所以数据库无法利用索引的数据来避免任何排序运算

3.在任何时候都不能避免表扫描：
由于Hash索引比较的是进行Hash运算之后的Hash值，所以即使取满足某个Hash键值的数据的记录条数，也无法从Hash索引中直接完成查询，还是要通过访问表中的实际数据进行相应的比较，并得到相应的结果

4.检索效率高，索引的检索可以一次定位，不像B-Tree索引需要从根节点到枝节点，最后才能访问到页节点这样多次的IO访问，所以Hash索引的查询效率要远高于B-Tree索引

5.只有Memory引擎支持显式的Hash索引，但是它的Hash是nonunique的，冲突太多时也会影响查找性能。Memory引擎默认的索引类型即是Hash索引，虽然它也支持B-Tree索引

三、R-Tree索引
R-Tree在MySQL很少使用，仅支持geometry数据类型，支持该类型的存储引擎只有MyISAM、BDb、InnoDb、NDb、Archive几种。*/


----------------------------mysql innodb事物产生死锁 事物超时----------------------------

-- innodb_lock_wait_timeout 默认时间是50s 

-- 可以调到150s 或者300s

--=================================  mysql 获取表结构 ====================================
--$this->model->getTableName() 为表名 实在think下Model下添加的方法返回当前表明 $this->name

$sql = 'SHOW COLUMNS FROM `' . $this->model->getTableName() . '`';
$res = Db::query($sql);

----------------------------mysql innodb事物产生死锁----------------------------
/*1、查看是否存在物阻塞

表：information_schema.innodb_trx

2、通过实时查询实例锁会话信息。查看锁信息。
show engine innodb status\G;

需要您找到对应死锁产生的会话，是否事物间存在锁争用或者异常慢查询等。

参考：https://help.aliyun.com/knowledge_detail/41705.html
*/

----------------------------mysql 联合索引执行规则----------------------------
/*解决方案
针对数据空间过大，可以删除无用的历史表数据进行释放空间（DROP或TRUNCATE操作，如果是执行DELETE操作，需要使用OPTIMIZE TABLE来释放空间）；如果没有可删除的历史数据，需要升级实例的磁盘空间。
此方案只能用于磁盘占用很高 但是没有被锁定
*/
----------------------------mysql innodb事物产生死锁 事物超时----------------------------
/*
查询时使用联合索引的一个字段，如果这个字段在联合索引中所有字段的第一个，那就会用到索引，否则就无法使用到索引。
   例如联合索引 IDX(字段A,字段B,字段C,字段D)，当仅使用字段A查询时，索引IDX就会使用到；如果仅使用字段B或字段C或字段D查询，则索引IDX都不会用到。  
   这个规则在oracle和mysql数据库中均成立。
*/
----------------------------mysql COUNT(*) 和 count(col) 区别件建议----------------------------
/*
优化总结：
1.任何情况下SELECT COUNT(*) FROM tablename是最优选择；
2.尽量减少SELECT COUNT(*) FROM tablename WHERE COL = ‘value’ 这种查询；
3.杜绝SELECT COUNT(COL) FROM tablename WHERE COL2 = ‘value’ 的出现。


在不加WHERE限制条件的情况下，COUNT(*)与COUNT(COL)基本可以认为是等价的；
但是在有WHERE限制条件的情况下，COUNT(*)会比COUNT(COL)快非常多；

好文要顶 关注我 收藏该文 
*/


----------------------------mysql table_open_cache cache ----------------------------
/*
table_open_cache 指定表高速缓存的大小。每当MySQL访问一个表时，如果在表缓冲区中还有空间，该表就被打开并放入其中，这样可以更快地访问表内容。


通过检查峰值时间的状态值Open_tables和Opened_tables，可以决定是否需要增加table_open_cache的值。

如果你发现open_tables等于table_open_cache，并且opened_tables在不断增长，那么你就需要增加table_open_cache的值了(上述状态值可甀show status like 'open%tables';获得)。

注意，不能盲目地把table_open_cache设置成很大的值。如果设置得太高，可能会造成文件描述符不足，从而造成性能不稳定或者连接失败。


show status like 'open%tables';

看以下几个值:
| Variable_name            | Value  |
+--------------------------+--------+
| Open_tables              | 512    |
| Opened_tables            | 0      |
+--------------------------+--------+

发现open_tables等于table_open_cache，也是512
表明需要增加table_open_cache的值，可设为：table_open_cache＝1024 根据具体的服务器配置决定


二、如何修改
vi /etc/my.cnf 配置文件，[mysqld] 下 
table_open_cache＝1024

别忘了需mysql重启 service mysql restart 或 /etc/rc.d/init.d/mysql restart 后才生效！

*/

----------------------------mysql 查看索引信息 ----------------------------

/*

查看索引

mysql> show index from tblname;

mysql> show keys from tblname;

· Table

表的名称。

· Non_unique

如果索引不能包括重复词，则为0。如果可以，则为1。

· Key_name

索引的名称。

· Seq_in_index

索引中的列序列号，从1开始。

· Column_name

列名称。

· Collation

列以什么方式存储在索引中。在MySQL中，有值‘A’（升序）或NULL（无分类）。

· Cardinality

索引中唯一值的数目的估计值。通过运行ANALYZE TABLE或myisamchk -a可以更新。基数根据被存储为整数的统计数据来计数，所以即使对于小型表，该值也没有必要是精确的。基数越大，当进行联合时，MySQL使用该索引的机 会就越大。

· Sub_part

如果列只是被部分地编入索引，则为被编入索引的字符的数目。如果整列被编入索引，则为NULL。

· Packed

指示关键字如何被压缩。如果没有被压缩，则为NULL。

· Null

如果列含有NULL，则含有YES。如果没有，则该列含有NO。

· Index_type

用过的索引方法（BTREE, FULLTEXT, HASH, RTREE）。

· Commen

----------------------------mysql 索引操作 上面还有一处索引解释----------------------------

desc aws_user  查看表结构
show index from aws_user;  查看索引
show triggers like 'aws_user'; 查看触发器

1、重建索引命令

mysql> REPAIR TABLE tbl_name QUICK;

2、查询数据表索引

mysql> SHOW INDEX FROM tbl_name;
3、创建索引（PRIMARY KEY，INDEX，UNIQUE）支持创建主键索引，联合索引和普通索引命令

mysql>ALTER TABLE tbl_name ADD INDEX index_name (column list); --普通

mysql>ALTER TABLE tbl_name ADD UNIQUE index_name (column list); -- 唯一

mysql>ALTER TABLE tbl_name ADD PRIMARY KEY index_name (column list); --主键索引

4.删除索引（PRIMARY KEY，INDEX，UNIQUE）

支持删除主键索引，联合索引和普通索引命令

mysql>ALTER TABLE tbl_name DROP INDEX index_name (column list);
mysql>ALTER TABLE tbl_name DROP UNIQUE index_name (column list);
mysql>ALTER TABLE tbl_name DROP PRIMARY KEY index_name (column list);
其中 tbl_name 表示数据表名，index_name 表示索引名，column list 表示字段列表



----------------------------mysql information_schema 解释 动态表和静态表 ----------------------------

  
1. 获取所有表结构(TABLES)
SELECT  *  FROM information_schema.TABLES WHERE  TABLE_SCHEMA='数据库名';  TABLES表：提供了关于数据库中的表的信息（包括视图）。详细表述了某个表属于哪个schema，表类型，表引擎，创建时间等信息。各字段说明如下:
字段	含义
Table_catalog	数据表登记目录
Table_schema	数据表所属的数据库名
Table_name	表名称
Table_type	表类型[system view|base table]
Engine	使用的数据库引擎[MyISAM|CSV|InnoDB]
Version	版本，默认值10
Row_format	行格式[Compact|Dynamic|Fixed]
Table_rows	表里所存多少行数据
Avg_row_length	平均行长度
Data_length	数据长度
Max_data_length	最大数据长度
Index_length	索引长度
Data_free	空间碎片
Auto_increment	做自增主键的自动增量当前值
Create_time	表的创建时间
Update_time	表的更新时间
Check_time	表的检查时间
Table_collation	表的字符校验编码集
Checksum	校验和
Create_options	创建选项
Table_comment	表的注释、备注

详细说明:
row_format
若一张表里面不存在varchar、text以及其变形、blob以及其变形的字段的话，那么张这个表其实也叫静态表，即该表的row_format是fixed，就是说每条记录所占用的字节一样。其优点读取快，缺点浪费额外一部分空间。
若一张表里面存在varchar、text以及其变形、blob以及其变形的字段的话，那么张这个表其实也叫动态表，即该表的row_format是dynamic，就是说每条记录所占用的字节是动态的。其优点节省空间，缺点增加读取的时间开销。
所以，做搜索查询量大的表一般都以空间来换取时间，设计成静态表。
 row_format还有其他一些值：
DEFAULT | FIXED | DYNAMIC | COMPRESSED | REDUNDANT | COMPACT
修改行格式
ALTER TABLE table_name ROW_FORMAT = DEFAULT
修改过程导致：
fixed--->dynamic: 这会导致CHAR变成VARCHAR
dynamic--->fixed: 这会导致VARCHAR变成CHAR

data_free
每当MySQL从你的列表中删除了一行内容，该段空间就会被留空。而在一段时间内的大量删除操作，会使这种留空的空间变得比存储列表内容所使用的空间更大。
当MySQL对数据进行扫描时，它扫描的对象实际是列表的容量需求上限，也就是数据被写入的区域中处于峰值位置的部分。如果进行新的插入操作，MySQL将尝试利用这些留空的区域，但仍然无法将其彻底占用。
1.查询数据库空间碎片：
select table_name,data_free,engine from information_schema.tables where table_schema='yourdatabase';
2.对数据表优化：
optimeze table `table_name`;

参考：
http://wenku.baidu.com/link?url=MtPZrab7kbciXsBAjia4w0JUE3aFCtOj9fu_2zXVE5JW6k8UHaFCl6ppGE89HPMUFmLSMTjmp2rqbIMcSXBIJ11LIlxzDYJH1qLHZpNdqYu
http://blog.sina.com.cn/s/blog_70b9a0e90101cmdz.html
http://www.2cto.com/database/201208/14499


----------------------------mysql 清除mysqlbin 文件  ----------------------------

不建议使用rm命令删除，这样有可能会不安全 最好用mysql 命令

mysql> reset master;

mysql> reset slave;

其实关键的命令就是reset master;这个命令会清空mysql-bin文件。


另外如果你的mysql服务器不需要做主从复制的话，建议通过修改my.cnf文件，来设置不生成这些文件，只要删除my.cnf中的下面一行就可以了。


log-bin=mysql-bin   

宝塔的配置文件在 /etc/my.cnf  whereis my.cnf 查找

如果你需要复制，最好控制一下这些日志文件保留的天数，可以通过下面的配置设定日志文件保留的天数：
 

expire_logs_days = 3  

表示保留3天的日志，这样老日志会自动被清理掉


转自 https://blog.csdn.net/zhengfeng2100/article/details/52858946

----------------------------mysql instr  ----------------------------
INSTR(STR,SUBSTR) 在一个字符串(STR)中搜索指定的字符(SUBSTR),返回发现指定的字符的位置(INDEX); 
STR 被搜索的字符串 
SUBSTR 希望搜索的字符串 
结论：在字符串STR里面,字符串SUBSTR出现的第一个位置(INDEX)，INDEX是从1开始计算，如果没有找到就直接返回0，没有返回负数的情况。
--查询字符串存在的情况下：
SELECT INSTR("abcd",'b');



mysql中instr()的使用 
标签： 检索速度 mysql数据库 索引 字段 it	分类： 电脑网络
mysql数据库中记录数达到36万条了,检索速度慢了许多,怀疑是SQL query中

SELECT * FROM table WHERE title LIKE '%keyword%'的问题。
第一步：

在title字段上加索引：create index stock_title on stock(title)；
测试发现没什么效果,因为索引只对'keyword%'有效,对%开头的（'%keyword'，'%keyword%')起不了作用.mysql中instr()的使用

第二步：

改成SELECT * FROM table WHERE instr(title,'keyword')>0 后

检索速度快了不少,问题解决了mysql中instr()的使用

http://blog.sina.com.cn/s/blog_55d57a4601015rzl.html

----------------------------mysql 利用instr 整理wherein是否排序  ----------------------------
不进行默认排序 
select * from xx_shop_user  where id in (59,77,95,35) and  ISNULL(deletetime)  order by instr(',59,77,95,35,',CONCAT(',',id,','))
select * From 表 Where id in (1,5,3) order by instr(',1,5,3,',CONCAT(',',id,','))

排序  默认主键排序
select  *  from table where id in (59,77,95,35)


******* wherein 关联 拼接域名 DOMAIN为域名常量 *******
public function goodOrder($ids,$offset,$limit)
{
 	//商品排序
    $sql = "select g.id,title,shop_id,pay_type,CONCAT('".DOMAIN."' ,g.image) as image,price,g.sales_num,CONCAT('".DOMAIN."' ,s.image) as shop_image,s.name as shop_name from xx_goods as g LEFT JOIN xx_shop_user as s ON g.shop_id=s.id where g.status=1 and g.type=4 and  g.id in ($ids) and  ISNULL(g.deletetime)  order by instr(',$ids,',CONCAT(',',g.id,',')) LIMIT $offset,$limit";
    $result = Db::query($sql);
    return $result;
}
----------------------------mysql ISNULL  ----------------------------

查询mysql数据库表中字段为null的记录:

select * 表名 where 字段名 ISNULL(字段)

查询mysql数据库表中字段不为null的记录:

select * 表名 where 字段名 is not null
----------------------------mysql 修改可以远程访问的权限  ----------------------------


1.mysql -u root -p
2.use mysql；
3.select  User,authentication_string,Host from user
4.GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '123456'  
	这里的123456为你给新增权限用户设置的密码，%代表所有主机，也可以具体到你的主机ip地址
5.flush privileges;          这一步一定要做，不然无法成功！ 这句表示从mysql数据库的grant表中重新加载权限数据
                             因为MySQL把权限都放在了cache中，所以在做完更改后需要重新加载。
6.select  User,authentication_string,Host from user  再次查看  发现多了一个用户，该用户所有的主机都可以访问，此时再次用sqlyog访问连接成功！
7.此方法不止针对root用户  可以将root换成你想要的用户

----------------------------mysql 迁移服务器或第二次安装 报错 ----------------------------
Starting MySQL. ERROR! The server quit without updating PID file (/www/server/data/1c2a7179f8bd.pid).
 
删除 目录下 server/data/下面的pid (a04890ffe464.pid 前缀不一样)  删除 mysql-bin.index 然后启动 ok

