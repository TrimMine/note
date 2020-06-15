### 阿里云RDS数据库备份恢复到自检数据库
- 简单的方法一个是通过阿里云备份恢复到某一时间节点 但是需要新建一个RDS实例 需要花钱 
- 本文讲的是下载备份恢复到本地或自己的数据库 因为可能是部分数据错误 不能全部恢复内容 
1. 数据库要是新的数据 否则数据库的其他内容可能不能使用 建议用空的数据库来恢复此备份
2. 我使用的是我服务器中的一台 京东的服务器 装的宝塔面板
>链接
>附上官方恢复物理备份连接 [RDS物理备份恢复](https://help.aliyun.com/knowledge_detail/41817.html)
>博客园 - Mr.zou [讲解的有如何安装 innobackupex](https://www.cnblogs.com/zoulixiang/p/9395382.html)
1. 将物理备份下载到服务器内 
2. 下载后解压文件 普通的解压方式就可以 tar -zxvf 
3. 关停现在的数据库进程 避免覆盖后无法杀死数据库进程
4. 将内容复制到 /www/server/data/ 目录下(根据个人情况选择路径,此处是mysql的数据目录)
5.  安装xtrabakcup工具

         获取yum源
         yum install http://www.percona.com/downloads/percona-release/redhat/0.1-4/percona-release-0.1-4.noarch.rpm
         安装xtrabackup需要依赖其他包（这里用的是阿里云的epel源）
         wget -O /etc/yum.repos.d/epel.repo http://mirrors.aliyun.com/repo/epel-6.repo
         安装工具
         yum install percona-xtrabackup
- 如果安装过 直接执行

         #执行命令 前后两个路径是一直的 (innobackupex 执行前要安装)
         innobackupex --defaults-file=/www/server/data/backup-my.cnf --apply-log /www/server/data 

         chown -R mysql:mysql /www/server/data/
         chmod -R 700 /www/server/data/
         启动数据库即可
-----
###### 以下下内容本次没有使用   

6. 修改文件 
         
         vi /www/server/data/backup-my.cnf

         将以下内容注释
         #innodb_fast_checksum
         #innodb_page_size
         #innodb_log_block_size


         #说明 如果本地使用的是MyISAM引擎，和阿里云的InnoDB不兼容，需要多注释掉如下参数并增加skip-grant-tables参数：

         #注释掉下面两行 没有就不用注释
         #innodb_log_checksum_algorithm=strict_crc32
         #redo_log_version=1
         #新增
         skip-grant-tables


7. 修改权限
   
         chown -R mysql:mysql /www/server/data/
         chmod -R 700 /www/server/data/

8. 启动 

         我是直接在宝塔上启动的mysql 或者 /etc/init.d/mysqld start

         官方的启动方式 不建议这么启动 这是官方给的推荐方式我试的没有生效
         /www/server/mysql/bin/mysqld_safe --defaults-file=/www/server/data/backup-my.cnf --user=mysql --datadir=/www/server/data/
9. 连接上数据库就能看到数据了
------------------------------
### cpu100%的原因查询

- 通过如下方式定位效率低的查询：

1. 通过 `show processlist`; 或 `show full processlist`; 命令查看当前执行的查询，
2. 对于查询时间长、运行状态（`State` 列）是 `Sending data`,`Copying to tmp table`、`Copying to tmp table on disk`、`Sorting result`、`Using filesort`等都可能是有性能问题的查询（SQL）。


3. 若在 QPS 高导致 CPU 使用率高的场景中，查询执行时间通常比较短，`show processlist`; 命令或实例会话中可能会不容易捕捉到当前执行的查询。您可以通过执行如下命令进行查询：
   
         explain select b.* from perf_test_no_idx_01 a, perf_test_no_idx_02 b where a.created_on >= 2015-01-01 and a.detail = b.detai
         或者 用\G显示
         explain select b.* from perf_test_no_idx_01 a, perf_test_no_idx_02 b where a.created_on >= 2015-01-01 and a.detail = b.detai \G
- 阿里云地址--https://help.aliyun.com/knowledge_detail/51587.html
登录rds查看实例会话
------------------------------ 
### cpu 100%的原因查询

1. cpu消耗过大有慢sql造成,慢sql包括全表扫描，扫描数据量太大，内存排序，磁盘排序，锁争用等；
```mysql
mysql> show processlist;
```
查看所有连接
现象sql执行状态为:`sending data`,`copying to tmp table`,`copying to tmp table on disk`,`sorting result`,`using filesort,locked`;就有问题了。

所有状态说明在mysql官网有http://dev.mysql.com/doc/refman/5.0/en/show-processlist.html

a.sending data:sql正从表中查询数据，如果查询条件没有适当索引，会导致sql执行时间过长

b.copying to tmp table on disk:因临时结果集太大，超过数据库规定的临时内存大小,需要拷贝临时结果集到磁盘上

c.sorting result,using filesort:sql正在执行排序操作，排序操作会引起较多的cpu消耗，可以通过添加索引，或
减小排序结果集

不同的实例规格iops能力不同，如，iops为150个，也就是每秒能够提供150次的随机磁盘io操作，所以如果用户的数据量
很大，内存很小，因iops的限制，一条慢sql就有可能消耗掉所有io资源，而影响其他sql查询，对于数据库就是所有的sql
需要执行很长时间才返回结果集，对于应用会造成整体响应变慢。
临时表最大所需内存需要通过 `tmp_table_size=1024M`设定

----------------------------

### mysql  分析sql  profile 和 explain 
```sql
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
```
----------------------------

### mysql加入索引
```sql

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
```
---------------------------
### mysql innodb事物产生死锁 事物超时-

- innodb_lock_wait_timeout 默认时间是50s 

- 可以调到150s 或者300s

----------------------------
###   mysql 获取表结构 
- `$this->model->getTableName()` 为表名 实在`think下Model`下添加的方法返回当前表名 `$this->name`
```php
$sql = 'SHOW COLUMNS FROM `' . $this->model->getTableName() . '`';
$res = Db::query($sql);
```
----------------------------

### mysql innodb事物产生死锁
1. 查看是否存在物阻塞

         表：information_schema.innodb_trx

2. 通过实时查询实例锁会话信息。查看锁信息。

         show engine innodb status\G;

- 需要找到对应死锁产生的会话，是否事物间存在锁争用或者异常慢查询等。

- 转自：https://help.aliyun.com/knowledge_detail/41705.html

----------------------------
### mysql 联合索引执行规则
- 解决方案
   - 针对数据空间过大，可以删除无用的历史表数据进行释放空间（DROP或TRUNCATE操作，如果是执行DELETE操作，需要使用OPTIMIZE TABLE来释放空间）；如果没有可删除的历史数据，需要升级实例的磁盘空间。
- 此方案只能用于磁盘占用很高 但是没有被锁定

----------------------------

### mysql innodb事物产生死锁 事物超时

- 查询时使用联合索引的一个字段，如果这个字段在联合索引中所有字段的第一个，那就会用到索引，否则就无法使用到索引。
- 例如联合索引 IDX(字段A,字段B,字段C,字段D)，当仅使用字段A查询时，索引IDX就会使用到；如果仅使用字段B或字段C或字段D查询，则索引IDX都不会用到。  
- 这个规则在oracle和mysql数据库中均成立。

----------------------------

### mysql COUNT(*) 和 count(col) 区别件建议
-
优化总结：
1.任何情况下SELECT COUNT(*) FROM tablename是最优选择；
2.尽量减少SELECT COUNT(*) FROM tablename WHERE COL = ‘value’ 这种查询；
3.杜绝SELECT COUNT(COL) FROM tablename WHERE COL2 = ‘value’ 的出现。


在不加WHERE限制条件的情况下，COUNT(*)与COUNT(COL)基本可以认为是等价的；
但是在有WHERE限制条件的情况下，COUNT(*)会比COUNT(COL)快非常多；

好文要顶 关注我 收藏该文 

----------------------------

### mysql table_open_cache cache 
```sql
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
```
----------------------------
### mysql 查看索引信息 

```sql
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
```
----------------------------
### mysql 索引操作 上面还有一处索引解释
```sql
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
```
----------------------------

### mysql information_schema 解释 动态表和静态表 

  ```sql
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
```
----------------------------

### mysql 清除mysqlbin 文件  

- 不建议使用rm命令删除，这样有可能会不安全 最好用mysql 命令
```sql 
mysql> reset master;

mysql> reset slave;
```
- 其实关键的命令就是`reset master;`这个命令会清空mysql-bin文件。


- 另外如果你的mysql服务器不需要做主从复制的话，建议通过修改`my.cnf`文件，来设置不生成这些文件，只要删除`my.cnf`中的下面一行就可以了。

```sql

log-bin=mysql-bin   

```
- 宝塔的配置文件在 `/etc/my.cnf` 使用命令  `whereis my.cnf` 查找

- 如果你需要复制，最好控制一下这些日志文件保留的天数，可以通过下面的配置设定日志文件保留的天数：
 ```SQL

expire_logs_days = 3  
```
- 表示保留3天的日志，这样老日志会自动被清理掉


- 转自 https://blog.csdn.net/zhengfeng2100/article/details/52858946

----------------------------

### mysql instr  

- INSTR(STR,SUBSTR) 在一个字符串(STR)中搜索指定的字符(SUBSTR),返回发现指定的字符的位置(INDEX); 
   - STR 被搜索的字符串 
   - SUBSTR 希望搜索的字符串 
- 结论：在字符串STR里面,字符串SUBSTR出现的第一个位置(INDEX)，INDEX是从1开始计算，如果没有找到就直接返回0，没有返回负数的情况。
- 查询字符串存在的情况下：
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

----------------------------
### mysql 利用instr 整理wherein是否排序  
- 不进行默认排序 
```SQL

select * from xx_shop_user  where id in (59,77,95,35) and  ISNULL(deletetime)  order by instr(',59,77,95,35,',CONCAT(',',id,','))

select * From 表 Where id in (1,5,3) order by instr(',1,5,3,',CONCAT(',',id,','))
```
- 排序  默认主键排序
```SQL
select  *  from table where id in (59,77,95,35)

//wherein 关联 拼接域名 DOMAIN为域名常量 *******
public function goodOrder($ids,$offset,$limit)
{
 	//商品排序
    $sql = "select g.id,title,shop_id,pay_type,CONCAT('".DOMAIN."' ,g.image) as image,price,g.sales_num,CONCAT('".DOMAIN."' ,s.image) as shop_image,s.name as shop_name from xx_goods as g LEFT JOIN xx_shop_user as s ON g.shop_id=s.id where g.status=1 and g.type=4 and  g.id in ($ids) and  ISNULL(g.deletetime)  order by instr(',$ids,',CONCAT(',',g.id,',')) LIMIT $offset,$limit";
    $result = Db::query($sql);
    return $result;
}
```
----------------------------
### mysql ISNULL  

- 查询mysql数据库表中字段为null的记录:

      select * 表名 where 字段名 ISNULL(字段)

- 查询mysql数据库表中字段不为null的记录:

      select * 表名 where 字段名 is not null

----------------------------

### mysql 修改可以远程访问的权限 gateway 

mysql 5.6
1. `mysql -u root -p`
2. `use mysql;`
3. `select  User,authentication_string,Host from user;`
4.` GRANT ALL PRIVILEGES ON *.* TO `root`@`%` IDENTIFIED BY '123456';` 
	这里的123456为你给新增权限用户设置的密码，%代表所有主机，也可以具体到你的主机ip地址
   123456这个密码和你本机原来的root密码不一样 不要弄混了 登录mysql命令行还需要那个root密码
5. `flush privileges;`          这一步一定要做，不然无法成功！ 这句表示从mysql数据库的grant表中重新加载权限数据
                             因为MySQL把权限都放在了cache中，所以在做完更改后需要重新加载。
6. `select  User,authentication_string,Host from user`  再次查看  发现多了一个用户，该用户所有的主机都可以访问，此时再次用sqlyog访问连接成功！
7. 此方法不止针对root用户  可以将root换成你想要的用户

#### 新版本的mysql 8.0 目前使用的 不确定mysql 5.7是否是此方法  无外乎这两种

- 新版本的mysql 将创建用户和赋予权限分开执行  否则报错 syntax to use near 'IDENTIFIED BY

 - 加入另一个root用户

         CREATE USER 'root'@'%' IDENTIFIED BY '123456'
- 赋予权限
      
         grant all privileges on  *.* to 'root'@'%' with grant option

%代表所有人
----------------------------
### mysql 迁移服务器或第二次安装 报错 
`
Starting MySQL. ERROR! The server quit without updating PID file (/www/server/data/1c2a7179f8bd.pid).`
 
- 删除 目录下 server/data/下面的pid (a04890ffe464.pid 前缀不一样)  
- 删除 mysql-bin.index 然后启动 ok

使用 mysqkd status 检查 
删除 锁 /var/lock/subsys/mysql

----------------------------

### mysql 导入原5.6版本sql文件报错 
`Table storage engine for 'xx_table' doesn't have this option`
删除文件中所有
`ROW_FORMAT=FIXED `
在执行就可以了

----------------------------

### mysql 启用mysql日志记录执行过的sql 

在mysql命令行或者客户端管理工具中执行：
`SHOW VARIABLES LIKE "general_log%";`

结果：
```
general_log OFF

general_log_file /var/lib/mysql/localhost.log
```
OFF说明没有开启日志记录

分别执行开启日志以及日志路径和日志文件名
```
SET GLOBAL general_log_file = '/var/lib/mysql/localhost.log';
SET GLOBAL general_log = 'ON';
```
还要注意

这时执行的所有sql都会别记录下来，方便查看，但是如果重启mysql就会停止记录需要重新设置
 
```
SHOW VARIABLES LIKE "log_output%";

默认值是‘FILE‘，如果是NONE，需要设置

SET GLOBAL log_output='TABLE,FILE'

log_output=‘FILE‘表示将日志存入文件,默认值是‘FILE‘　

log_output=‘TABLE‘表示将日志存入数据库,这样日志信息就会被写入到mysql.slow_log表中.

mysql数据库支持同时两种日志存储方式,配置的时候以逗号隔开即可,如:log_output=‘FILE,TABLE‘.日志记录到系统专用日志表中,要比记录到文件耗费更多的系统资源,因此对于需要启用慢查日志,又需要比够获得更高的系统性能,那么建议优先记录到文件.
```
----------------------------


### 数据库设计

数据库的规范设计说明
#### 数据库命名规范

1. 所有数据库名 表名 字段名 都必须使用小写字母并用下划线分割
2. 名称等禁止使用mysql关键字 from,select,delete等
3. 名称最好不要超过32个字符
4. 命名规范一眼能看出来是什么表 
    比如: 
    user_account 用户账户表 
    临时表以 tem为前缀 日期为后缀
    备份表以 bak为前缀 日期为后缀
5. 不同表存储相同的数据 命名和类型必须一致 为了性能和关联使用
    例如:
    order表 user_id int
    account_log 表 user_id int

#### 数据库基本设计规范
1. 表的存储引擎Myisam 更改为innodb 老版本5.5以前的是
    innodb 支持事物 行级锁 恢复性好 高性能
2. 字符集选用utf8 
    统一字符集可以避免字符集转换产生乱码
3. 所有的表和字段都要添加注释
4. 维护数据库字典,以便维护和读取表和字段的含义
5. 数据存储大小最好不要超过500万条
6. 谨慎使用分区表 跨分区查询效率要比一个很大的数据表效率更低
7. 冷热数据分离,减小表的宽度 利用缓存避免读入无用的冷数据 
8. 经常使用的列放到一个表中 其他的字段放到另一个表
9. 表中不要预留字段
10. 禁止在数据库中存储二进制图片或文件
11. 禁止在线上做压力测试
12. 开发环境更不要连接生成环境的数据库 可能会破坏数据完整性

#### 数据库索引设计规范
1. 不要滥用索引,限制每张表的索引数量,建议单张表索引不超过5个,索引会减少查询效率但是会增加插入和修改效率
2. innodb表必须要有一个主键,
    不使用频繁更新的列作为主键
    不使用多个列主键
    不使用uuid,md5,hash等字符串作为主键
    最好使用mysql自增id字段作为主键
3. 常见索引列
    select update delete 语句的where条件列
    order by group by distinct 中的列
    多表join的关联列
4. 选择索引列的顺序
    索引是从左到右的顺序来使用的
    放在联合索引的最左侧 下面是依次的优先级
        区分度最高的列 (指每行的该列的区分度,比如id每行都不一样,区分度为1,区分度很高)
        字段长度小的列 
        使用最频繁的列 (以上两种都满足就看哪个使用的多)
5. 避免建立重复索引和冗余索引 
    重复索引 是指在同一个字段上建立多个索引
    冗余索引 指一个字段出现在多个索引中  index(abc) index(ab) index(a)
6. 避免使用外键月数 但是关联的外键需要建立索引
7. 覆盖索引 查询的字段条件和结果是统一字段


#### 数据库字段设计规范
1. 优先选择符合存储需要最小的数据类型
    有些情况下字符串可以转化为数字类型存储 例:
    INET_ATON('255.255.255.255') = 42964967295
    INET_NTOA(4294967295)='255.255.255.255'
2. 对于非负值的数据 尽量采用无符号整形进行存储 这样数据范围会变小很多
3. varchar(N)中的N代表的是字符数,而不是字节数
    使用UTF存储汉字varchar(255)=765个字节 可存储255个汉字
    虽然写入到磁盘是根据内容多少定义的,但是读取到内存的时候是根据定义的字段长度大小决定的,所以用多少定义多少是会节省很多内存空间的
4. 避免使用TEXT,BLOB字段类型 会造成二次查询
    建议把这类单独分离到扩展表中 查询中不要使用 `*` 只查询需要的字段 不需要text或者blob这类不要查询
    mysql对索引字段长度有限制 所以这类只能使用前缀索引,而且text不能使用默认值
5. 避免使用enum类型
    修改enum值需要使用alter语句 这是修改表结构的语句 修改期间会造成表锁 从而造成阻塞
    enum类型的order by效率很低 mysql内部需要额外的操作(整形转为字符串再排序)才能获得排序结果
    尽量不要使用数字作为enum的数据值 很容易混淆 如果是整型尽量使用整形类型存储
    优点: 因为是字符串类型但是存储时时整形来存储的 会节省空间 
6. 尽可能把所有列定义为NOT NULL
    如果此字段建立的有索引时 会增加额外的空间来保存
    进行列的比较和计算时会做mysql多余的判断操作
7. 日期型数据不要使用字符串存储
    无法用日期函数进行比较
    会占用更多的空间 字符串16个字节 datetime 8个字节 timestamp 4个字节
    timestamp 存储范围和int一样 占用空间和int也一样 1970-01-01 ~ 2038-01-19 03:14:07 但可读性要比int高 超出此范围的用 datetime存储
8. 财务相关金额数据 必须使用decimal类型
    decimal为精准浮点数 计算是不会丢失精度
    占用的空间由定义的宽度决定
    可用于村粗比bigint的更大的整数数据

#### 数据库sql开发规范
1. 使用预编译语句进行数据库操作
    只传参数,比传递sql语句更高效
2. 避免使用类型的隐式转换
    当列类型和参数类型不一样时会出现 会导致索引无效
3. 充分利用表上已存在的索引 不要盲目加索引
    避免使用双 `%` 好的条件查询 `LIKE '%123%'` 这样无法利用到索引
    一个sql只能用到符合索引中的一列进行范围查询时 应该把他放到索引的最右侧
    使用left join 或 not exists 来优化not in 操作 not in 会使索引失效


#### 查询规范

1. 查询中不要使用 `*` 只查询需要的字段 

2. 避免使用子查询 可以把子查询优化为join操作
    子查询结果集无法使用索引
    子查询会产生临时表操作,如果子查询数据量大则严重影响效率 消耗过多的cpu及io资源
3. join是避免关联太多的表(不多就行)
    每join一个表就会多占用一部分内存(join_buffer_size控制内存大小)
    会产生临时表,影响查询效率 临时表内没有索引 所以会降低效率
    mysql最多允许关联61个表  建议不要超过5个
4. 减少通数据库的交互次数 (要看数据量 太大必须要分开)
    数据库更适合处理批量操作 提高效率,减少连接次数
5. 使用in 代替or 操作 in可以使用索引
6. 禁止使用order by rand()进行随机排序
    这样会把所有符合条件的数据 装载到内存中进行排序 
    消耗大量的cpu和io 内存
    应该在程序中获取好随机值 再从数据库从查找这些值
7. where从从句中禁止进对列进行函数转换和计算 会导致无法使用索引
8. 拆分复杂的sql为多个小sql
    mysql一个sql只能使用一个cpu进行计算 多个sql可以使用多个


#### 数据库操作行为规范

1. 超过100万行的批量写操作 要分批次多次进行操作 否则会造成表锁和拥堵













