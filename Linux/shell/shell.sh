#------------------------- shell echo  ---------------------------
echo(选项)(参数)选项

-e：激活转义字符。使用-e选项时，若字符串中出现以下字符，则特别加以处理，而不会将它当成一般文字输出：

\a 发出警告声；
\b 删除前一个字符；
\c 最后不加上换行符号；
\f 换行但光标仍旧停留在原来的位置；
\n 换行且光标移至行首；
\r 光标移至行首，但不换行；
\t 插入tab；
\v 与\f相同；
\\ 插入\字符；
\nnn 插入nnn（八进制）所代表的ASCII字符；

$echo -e "a\bdddd"  //前面的a会被擦除(\b)
dddd


-n: 不换行输出
$echo -n "123"
$echo "456"

最终输出 123456 而不是
123
456
#------------------------- shell read命令  ---------------------------

1.接收用户的输入

echo -n '请输入用户名'
read $REPLY #在read命令行中也可以不指定变量.如果不指定变量，那么read命令会将接收到的数据放置在环境变量REPLY中。
也可以 read username #赋值到变量中

简化版
read -p "请输入用户名:" username #直接赋值给了 username

2.计时输入
使用read命令存在着潜在危险。脚本很可能会停下来一直等待用户的输入。如果无论是否输入数据脚本都必须继续执行，那么可以使用-t选项指定一个计时器。
-t选项指定read命令等待输入的秒数。当计时满时，read命令返回一个非零退出状态

if read -t 5 -p "please enter your name:" name
then
    echo "hello $name ,welcome to my script"
else
    echo "sorry,too slow"
fi
exit 0
3.读文件

最后，还可以使用read命令读取Linux系统上的文件。
每次调用read命令都会读取文件中的"一行"文本。当文件没有可读的行时，read命令将以非零状态退出。
读取文件的关键是如何将文本中的数据传送给read命令。
最常用的方法是对文件使用cat命令并通过管道将结果直接传送给包含read命令的while命令
例子::
count=1    //赋值语句，不加空格
cat test.txt | while read line        //cat 命令的输出作为read命令的输入,read读到的值放在line中
do
   echo "Line $count:$line"
   count=$[ $count + 1 ]          //注意中括号中的空格。
done
echo "finish"
exit 0

参考 https://www.cnblogs.com/lottu/p/3962921.html

#------------------------- shell 判断grep返回值  ---------------------------

xml_path=`grep -l -F -i 'yes' "${i}"`

判断为空 

if [ -z $xml_path ]

或

if [  $? == 1 ]

判断不为空

if [ ！ -z $xml_path ]

或

if [  $? == 0 ]



对于grep 的返回结果  -n 与 ！ -z 并不是一回事，也就是判断 不为空时 使用 -n 不准确。
--------------------- 
作者：keidoekd2345 
来源：CSDN 
原文：https://blog.csdn.net/keidoekd2345/article/details/45502245 
版权声明：本文为博主原创文章，转载请附上博文链接！


