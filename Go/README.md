
# go

### *`go`*  `string`和`int`类型相互转换

1. int转成string
    ```go
    string := strconv.Itoa(int)
    ```
2. int64转成string
    ```go
    string := strconv.FormatInt(int64,10)
    ```
3. string转成int
    ```go
    int, err := strconv.Atoi(string)
    ```
4. string转成int64
    ```go
    int64, err := strconv.ParseInt(string, 10, 64)
    ```
-------

### 打开通过homebrew安装的软件

1. /usr/local/Cellar 安装的软件都在这里
2. 能通过命令行进入 通常无法直接通过finder进入文件夹
3. 打开finder 按下 command+shift+g 弹出输入路径框 输入即可


------------------------------


### go 时间戳转时间 time to datetime


1. 时间戳转时间
```go
dateInt64 := 1561097533
dateTimes := time.Unix(dateInt64, 0).Format(config.TimeFormat)
fmt.PrintLn(dateTimes)
// config.TimeFormat 
// TimeFormat = "2006-01-02 15:04:05"

```
2. 时间转时间戳
```
payTimes, _ := time.Parse(TimeFormat, "时间格式")
payTimes.Unix() //时间戳
```

------------------------------

### go 获取当期那时间戳

```go
time := time.Now().Unix()
```

------------------------------


### go 定时任务cron

1. 需要下载包 `"import "github.com/robfig/cron"`
2. 代码引入自动拉取
3. 代码实操
    ```go
    //官方列子
    c := cron.New()
    c.AddFunc("0 30 * * * *", func() { fmt.Println("Every hour on the half hour") })
    c.AddFunc("@hourly",      func() { fmt.Println("Every hour") })
    c.AddFunc("@every 1h30m", func() { fmt.Println("Every hour thirty") })
    c.Start()
    ..
    // Funcs are invoked in their own goroutine, asynchronously.
    ...
    // Funcs may also be added to a running Cron
    c.AddFunc("@daily", func() { fmt.Println("Every day") })
    ..
    // Inspect the cron job entries' next and previous run times.
    inspect(c.Entries())
    ..
    c.Stop()  // Stop the scheduler (does not stop any jobs already running).
    ```
4. 自己用的
    ```go
        func SetCron() {
            c := cron.New()
            err := c.AddFunc("0 /1 * * *", crons.UpdateData)
            //也可以这么写
            setTime:="*/5 * * * *"
            err := c.AddFunc(setTime, crons.UpdateData)
            if err != nil {
                fmt.println(err)
            }
            c.Start()
        }
    ```
5. cron特定字符说明
- 星号(*)
　　　　表示 cron 表达式能匹配该字段的所有值。如在第5个字段使用星号(month)，表示每个月
- 斜线(/)
　　　　表示增长间隔，如第1个字段(minutes) 值是 3-59/15，表示每小时的第3分钟开始执行一次，之后每隔 15 分钟执行一次（即 3、18、33、48 这些时间点执行），这里也可以表示为：3/15

- 逗号(,)
　　　　用于枚举值，如第6个字段值是 MON,WED,FRI，表示 星期一、三、五 执行

- 连字号(-)
　　　　表示一个范围，如第3个字段的值为 9-17 表示 9am 到 5pm 直接每个小时（包括9和17）

- 问号(?)
　　　　只用于 日(Day of month) 和 星期(Day of week)，表示不指定值，可以用于代替 *

- L，W，#
　　　　Go中没有L，W，#的用法，下文作解释。

6. cron举例说明
```
　　　　     每隔5秒执行一次：*/5 * * * * ?

            每隔1分钟执行一次：0 */1 * * * ?

            每天23点执行一次：0 0 23 * * ?

            每天凌晨1点执行一次：0 0 1 * * ?

            每月1号凌晨1点执行一次：0 0 1 1 * ?

            在26分、29分、33分执行一次：0 26,29,33 * * * ?

            每天的0点、13点、18点、21点都执行一次：0 0 0,13,18,21 * * ?
```

7.定时器检测网站 能看到自己写的执行时间测试
    
[点击进入](https://www.matools.com/crontab)

------------------------------


### go 中接收参数示例

1. 字符串参数 + post 表单
    ```
    POST /post?id=1234&page=1 HTTP/1.1
    Content-Type: application/x-www-form-urlencoded

    name=manu&message=this_is_great
    ```

    ```go
    func main() {
        router := gin.Default()

        router.POST("/post", func(c *gin.Context) {

            id := c.Query("id") /获取url参数id
            page := c.DefaultQuery("page", "0") // 默认值的方式获取
            name := c.PostForm("name") //post 表单获取
            message := c.PostForm("message") 

            fmt.Printf("id: %s; page: %s; name: %s; message: %s", id, page, name, message)
        })
        router.Run(":8080")
    }
    //输出
    //id: 1234; page: 1; name: manu; message: this_is_great

    ```
2. 上传文件 
- 单文件
    ```go
        // 单文件 接收
        file, _ := c.FormFile("file")
        log.Println(file.Filename)

        // 上传文件到指定的 dst 。
         c.SaveUploadedFile(file, dst)
    ```
- 多文件
    ```go
        form, _ := c.MultipartForm()
        files := form.File["upload[]"]

        for _, file := range files {
            log.Println(file.Filename)

            // 上传文件到指定的 dst.
             c.SaveUploadedFile(file, dst)
        }
    ```
------------------------------

### go 配置nginx伪静态

```
//socket升级
location /socket {
  proxy_set_header X-Forward-For $remote_addr;
  proxy_set_header X-Real-Ip $remote_addr;
  proxy_set_header Host $host;
  proxy_http_version 1.1;
  proxy_set_header Upgrade $http_upgrade;
  proxy_set_header Connection 'upgrade';
  proxy_read_timeout 3600s;
  proxy_pass http://127.0.0.1:3010;
  rewrite "^/socket/(.*)$" /$1 break; 
}
//接口请求
location /goapi {
  proxy_set_header X-Forward-For $remote_addr;
  proxy_set_header X-Real-Ip $remote_addr;
  proxy_set_header Host $host;
  proxy_http_version 1.1;
  proxy_read_timeout 3600s;
  proxy_pass http://127.0.0.1:3010;
  rewrite "^/goapi/(.*)$" /$1 break; 
}

location /admin {
 if (!-e $request_filename){
  rewrite  ^(.*)$  /index.php?s=$1  last;   break;
 }
}
    #访问加了/admin 
    #需要在配置里面加入 // woff2|ttf|woff|ico 这几个
    location ~ .*\.(gif|jpg|jpeg|png|bmp|swf|woff2|ttf|woff|ico)$
    {
        expires      30d;
        error_log off;
        access_log /dev/null;
    }
```
------------------------------

### go 截取字符串

```go
 str:= "abcde"
 fmt.Println(str[1:3])
 // bc

```
------------------------------

### go 生成随机码

```
//生成随机码 n是生成的尾数
func RandStr(n int) string {
    var str = []rune("abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789")
    b := make([]rune, n)
    for i := range b {
        b[i] = str[rand.New(rand.NewSource(time.Now().UnixNano())).Intn(len(str))]
    }
    var user model.User
    if !model.Db.Where("number = ?", string(b)).First(&user).RecordNotFound() {
        return RandStr(n)
    }
    return string(b)
}
```

### go post和get请求及结果处理

#### 调用和处理结果
    ```
    /**
     *连接
     */
    func Connect(method string, param interface{}) (map[string]interface{}, error) {
        url := "http://47.56.85.206:8545"
        data := map[string]interface{}{
            "id":      1,
            "jsonrpc": "2.0",
            "method":  method,
            "params":  param,
        }
        contentType := "application/json"
        res := Post(url, data, contentType)
        //定义结果类型 此处是map[string]
        var result map[string]interface{}
        //处理转换结果 转换后可取值为result["id"]
        err := json.Unmarshal(res, &result)
        return result, err
    }
    ```

#### GET 请求

    ```
    // 发送GET请求
    // url：         请求地址
    // response：    请求返回的内容
    func Get(url string) string {

        // 超时时间：5秒
        client := &http.Client{Timeout: 5 * time.Second}
        resp, err := client.Get(url)
        if err != nil {
            panic(err)
        }
        defer resp.Body.Close()
        var buffer [512]byte
        result := bytes.NewBuffer(nil)
        for {
            n, err := resp.Body.Read(buffer[0:])
            result.Write(buffer[0:n])
            if err != nil && err == io.EOF {
                break
            } else if err != nil {
                panic(err)
            }
        }
        return result.String()
    }
    ```

#### post请求

    ```
    // 发送POST请求
    // url：         请求地址
    // data：        POST请求提交的数据
    // contentType： 请求体格式，如：application/json
    // content：     请求放回的内容
    func Post(url string, data interface{}, contentType string) []byte {

        // 超时时间：5秒
        client := &http.Client{Timeout: 5 * time.Second}
        jsonStr, _ := json.Marshal(data)
        resp, err := client.Post(url, contentType, bytes.NewBuffer(jsonStr))
        if err != nil {
            panic(err)
        }
        defer resp.Body.Close()

        result, _ := ioutil.ReadAll(resp.Body)
        return result
        //return string(result)
    }
    ```

------------------------------

### 判断文件是否存在
    ```
    _, err := os.Stat("./image/qrcode/1.png")

    if err==nil{
        //文件存在
    }else{
        文件不存在
    }
    ```
------------------------------

### GO grom数据库加锁操作

#### 示例
    ```
    tx := model.Db.Begin()
    //捕捉系统异常
    defer func() {
        if r := recover(); r != nil {
            tx.Rollback()
        }
    }()
    //增加余额
    if err := model.Db.Set("gorm:query_option", "FOR UPDATE").Where("user_id =?", UserAccount.UserID).Update(
        "available_asset",
        gorm.Expr("available_asset + ?", money)).Error; err != nil {
        tx.Rollback()
        return
    }
    tx.commit()
    ```

#### recover 操作是为了防止系统其它错误没有捕捉到,导致事务没有结束,造成了表锁 要先开启
    ```
    defer func() {
        if err := recover(); err != nil {
            fmt.Println(err)
            tx.Rollback()
        }
    }()
    //下方可直接抛出异常 这样不影响程序运行
    panic("可以在这里将异常直接抛出去,不用来回接返回错误值,这样recover能直接接到错误")
    ```
#### 加锁

`Set("gorm:query_option", "FOR UPDATE")`

------------------------------

### go  grom 原生操作

- 有些操作需要用到原生语句(自增自减,统计之类的) 下面列举出两种方法

#### 修改操作

```
db.Exec("UPDATE orders SET num=num+? WHERE id IN (?)", 11, []int64{11,22,33})
//字符串操作用'%s'
db.Exec(fmt.Sprintf("update %v set stock=stock+%d ,update_time ='%s' where good_id =%d and sku=%v", s.table(), s.Stock, s.UpdateTime, s.GoodId, s.Sku)).Error

```
#### 查询操作
```
//赋值
type Result struct {
    Name string
    Age  int
}

var result Result

db.Raw("SELECT name, age FROM users WHERE name = ?", 3).Scan(&result)

//统计赋值
type Total struct {
    Total float64
}

var Totals Total

db.Raw("SELECT sum(num) as total FROM users WHERE name = ?", 3).Scan(&Totals)

```
- 操作不要使用全局变量图省事 查不到值不会对Totals赋值 从而使上次的值 使用局部变量 结构体可以全局使用

------------------------------

### go ETH连接 生成地址/查询余额等
```
package usdt

import (
    "bytes"
    "encoding/json"
    "fmt"
    "io/ioutil"
    "net/http"
    "strconv"
    "time"
)


/**
 *连接
 *在调用的时候最好使用 revocer捕捉一下异常 避免超时报错
 */
func Connect(method string, param []interface{}) (result map[string]interface{}, err error) {
    url := "http://47.51.85.216:8545"
    data := map[string]interface{}{
        "id":      1,
        "jsonrpc": "2.0",
        "method":  method,
        "params":  param,
    }
    contentType := "application/json"
    res := Post(url, data, contentType)
    err = json.Unmarshal(res, &result)
    return
}

/*
发送POST请求
url：         请求地址
data：        POST请求提交的数据
contentType： 请求体格式，如：application/json
content：     请求放回的内容
*/
func Post(url string, data interface{}, contentType string) []byte {

    // 超时时间：5秒
    client := &http.Client{Timeout: 5 * time.Second}
    jsonStr, _ := json.Marshal(data)
    resp, err := client.Post(url, contentType, bytes.NewBuffer(jsonStr))
    if err != nil {
        //需要调用时捕捉一下错误
        panic(err)
    }
    defer resp.Body.Close()
    result, _ := ioutil.ReadAll(resp.Body)
    return result
    //return string(result)
}

/**
 *生成地址
 */
func NewAddress() (address string, err error) {
    var result map[string]interface{}
    result, err = Connect("personal_newAccount", []interface{}{"alpha2020//.."})
    if err != nil {
        return
    }
    address = result["result"].(string)
    return
}

/**
 * 获取账户列表
 */
func GetAccounts() (lists []interface{}, err error) {
    var result map[string]interface{}
    result, err = Connect("personal_listAccounts", []interface{}{})
    if err != nil {
        return
    }
    lists = result["result"].([]interface{})
    return
}

/**
 * 查询余额
 */
func GetBalance(address interface{}) (balance float64, err error) {
    var (
        result map[string]interface{}
        n      uint64
    )
    result, err = Connect("eth_getBalance", []interface{}{address, "latest"})
    if err != nil {
        return
    }
    hex := (result["result"].(string))[2:]
    if n, err = strconv.ParseUint(hex, 16, 32); err != nil {
        return
    }
    balance = float64(n)
    return
}

/**
 *查询代币余额
 */
func GetCoinBalance(address interface{}) (balance float64, err error) {
    var (
        result map[string]interface{}
        n      uint64
    )
    result, err = Connect("eth_call", []interface{}{map[string]interface{}{
        "from": address,
        "to":   "0xdac17f958d2ee523a2206206994597c13d831ec7",
        "data": "0x70a08231000000000000000000000000" + (address.(string))[2:],
    },
        "latest",
    })
    if err != nil {
        return
    }
    hex := (result["result"].(string))[2:]
    if n, err = strconv.ParseUint(hex, 16, 32); err != nil {
        return
    }
    balance = float64(n)
    return
}
```

-----------------------

### go 阿里云短信

1. 下载安装包
```
go get -u github.com/aliyun/alibaba-cloud-sdk-go/sdk
```
<!--more-->
2. 发送短信例子:
```golang
/*
* @param phone string 手机号
* @param message string 消息
*/
func SendAliSms(phone string, message string) {
    client, err := dysmsapi.NewClientWithAccessKey("cn-hongkong", "LTAI4FwApahJpbceYM1CcQFZ", "px0HsyppVIseqDdQvJ7Jnag5jgLKTa")  //参数一:区域 https://developer.aliyun.com/endpoints区域表 参数二:key-ID 参数三:key-Secret
    request := dysmsapi.CreateSendSmsRequest()
    request.Scheme = "https"
    request.PhoneNumbers = phone //手机号
    request.SignName = "短信签名" //签名名称
    request.TemplateCode = "SMS_187750759" //短信模板编号
    request.TemplateParam = `{"code":` + message + `}` //模板填充的变量 此处是验证码
    response, err := client.SendSms(request)
    if err != nil {
        fmt.Print(err.Error())
        return
    }
    fmt.Printf("response is %#v\n", response)
}
```

------------------

### go mod使用 

1. `go mod 1 wserver` （go mod init 后面需要跟一个名字，这里叫wserver）
<!--more-->
2. 输出
    ```
    go: creating new go.mod: module wserver
    ```
- 有此说明 go mod 初始化成功了，会在当前目录下生成一个 go.mod 文件。


----------------

### go 生成随机数
```golang
    //生成12次0-50的随机数
    rad := rand.New(rand.NewSource(time.Now().UnixNano()))
    for i := 0; i < 12; i++ {
        fmt.Println(rad.Intn(50))
    }
```



--------------------------------

### go 打包文件

#### 打包语句
```sh
CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build main.go
CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build -o coin_coin_api main.go
```

- GOOS指的是目标操作系统，它的可用值为：
```
darwin freebsd linux windows android dragonfly netbsd openbsd plan9 solaris
```

- GOARCH指的是目标处理器的架构，目前支持的有：
```
arm arm64 386 amd64 ppc64 ppc64le mips64 mips64le s390x
```

- CGO_ENABLED
```
你的程序用了哪些标准库包？如果仅仅是非net、os/user等的普通包，那么你的程序默认将是纯静态的，不依赖任何c lib等外部动态链接库；
如果使用了net这样的包含cgo代码的标准库包，那么CGO_ENABLED的值将影响你的程序编译后的属性：是静态的还是动态链接的；
CGO_ENABLED=0的情况下，Go采用纯静态编译；
如果CGO_ENABLED=1，但依然要强制静态编译，需传递-linkmode=external给cmd/link。

此内容摘自 https://johng.cn/cgo-enabled-affect-go-static-compile/
```
--------------------------------

### go 设置代理 (下载不了包 访问不了golang.org)

##### 设置代理
- linux 
```golang
go env -w GOPROXY=https://goproxy.cn
```
- win 
```golang
SET GOPROXY=https://goproxy.cn
```
--------------------------------


### redis 连接池和相关操作

- 连接文件内容
<!--more-->
```golang
import (
    "fmt"
    "service/conf"
    "service/public/logs"
    "time"

    "github.com/gomodule/redigo/redis"
)

//调用关键词
var Redis RedisConn

//调用结构体
type RedisConn struct{}

//连接池
var RedisPool *redis.Pool

//初始化
func RedisInit() error {
    var redisConf = conf.Redis
    RedisPool = &redis.Pool{
        MaxIdle:     redisConf.MaxIdleConn,
        MaxActive:   redisConf.MaxOpenConn,
        IdleTimeout: 240 * time.Second,
        Wait:        false, //超过最大连接数处理方式(true=等待,false=抛异常)
        Dial: func() (redis.Conn, error) {
            conn, err := redis.Dial(
                "tcp",
                fmt.Sprintf("%s:%d", redisConf.Host, redisConf.Port),
                redis.DialReadTimeout(time.Duration(1000)*time.Millisecond),
                redis.DialWriteTimeout(time.Duration(1000)*time.Millisecond),
                redis.DialConnectTimeout(time.Duration(3000)*time.Millisecond), //超时时间
                redis.DialDatabase(0),
                //redis.DialPassword(""), //放到了下面进行密码验证
            )
            if err != nil {
                return nil, err
            }
            if redisConf.Password != "" {
                if _, err := conn.Do("AUTH", redisConf.Password); err != nil {
                    conn.Close()
                    return nil, err
                }
            }
            return conn, err
        },
    }
    return nil
}

```

#### 操作方法封装

```golang

//Set 插入k,v值
func (r RedisConn) Set(k, v interface{}, expire ...int) (err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if _, err = conn.Do("SET", k, v); err != nil {
        logs.Log.Println("插入失败", err)
        return
    }
    if len(expire) > 0 {
        if _, err = conn.Do("EXPIRE", k, expire[0]); err != nil {
            logs.Log.Println("设置超时时间失败", err)
            return
        }
    }
    return
}

//Get
func (r RedisConn) Get(k interface{}) (value string, err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if value, err = redis.String(conn.Do("GET", k)); err != nil {
        logs.Log.Println("查询失败", err)
        return
    }
    return
}

//Del
func (r RedisConn) Del(k interface{}) (err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if _, err = conn.Do("DEL", k); err != nil {
        fmt.Println("删除失败", err)
        return err
    }
    return
}

//HSet
func (r RedisConn) HSet(name, k, v interface{}) (err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if _, err = conn.Do("HSET", name, k, v); err != nil {
        return
    }
    return
}

//HGet
func (r RedisConn) HGet(name, k interface{}) (value interface{}, err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if value, err = conn.Do("HGet", name, k); err != nil {
        return
    }
    return
}

//HGetAll
func (r RedisConn) HGetAll(name interface{}) (value map[string]string, err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if value, err = redis.StringMap(conn.Do("hgetall", name)); err != nil {
        return
    }
    return
}

//HDel 删除hName表里的k下表数据
func (r RedisConn) HDel(name, k interface{}) (err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if _, err = redis.String(conn.Do("HDEL", name, k)); err != nil {
        return
    }
    return
}

//HKeys 获取hash表的所有下表
func (r RedisConn) HKeys(hName interface{}) (value []string, err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if value, err = redis.Strings(conn.Do("HKEYS", hName)); err != nil {
        return
    }
    return
}

//推入
func (r RedisConn) LPush(k string, v interface{}) (err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if _, err = conn.Do("lpush", k, v); err != nil {
        return
    }
    return
}

//取出
func (r RedisConn) RPop(k string) (reply string, err error) {
    conn := RedisPool.Get()
    defer conn.Close()
    if reply, err = redis.String(conn.Do("rpop", k)); err != nil {
        return
    }
    return
}
```

##### 如果设置的值是json (json.Marshal()处理过或是json) 值
1. 使用 redis.Bytes(reply,err)获取 
2. 或者直接断言处理
```golang
   var result map[string]interface{}
   errs := json.Unmarshal(reply.([]byte), &result)
   if errs != nil {
     fmt.Println(errs)
   }
```
3. 字符串获取 redis.String(reply,err)


--------------------------------


### go mysql数据库连接池

- 连接文件
<!--more-->
```golang
package model

import (
    "fmt"
    "service/conf"
    _ "github.com/go-sql-driver/mysql"
    "github.com/jinzhu/gorm"
)

//Mysql mysql数据库操作实例
var Mysql *gorm.DB

//MysqlInit 初始化数据库
func MysqlInit() error {
    db, err := gorm.Open(
        "mysql",
        fmt.Sprintf(
            "%s:%s@(%s:%d)/%s?charset=utf8&parseTime=False&loc=Local",
            conf.Mysql.User,
            conf.Mysql.Password,
            conf.Mysql.Host,
            conf.Mysql.Port,
            conf.Mysql.Database,
        ),
    )
    if err != nil {
        return err
    }
    /*连接池信息*/
    db.DB().SetMaxIdleConns(conf.Mysql.MaxIdleConn) //设置最大空闲数
    db.DB().SetMaxOpenConns(conf.Mysql.MaxOpenConn) //设置最大连接数

    db.SingularTable(true)

    //请求日志
    db.LogMode(true)
    Mysql = db
    return nil
}
```


--------------------------------

### go 舍去式保留小数位

```golang
// 0.1*0.00122浮点相乘可能会出现精度问题用字符串再转换成float64
floatNumber, _ = strconv.ParseFloat(fmt.Sprintf("%.4f", 0.1*0.00122), 64)
```

--------------------------------


### go 获取汇率(USD转CNY)
- 通过爬去接口获取的汇率值 usd to cny

<!--more-->

```golang
//获取美元兑换CNY汇率
func SetRatio(c *gin.Context) {
    var url = "https://webapi.huilv.cc/api/exchange?num=1&chiyouhuobi=USD&duihuanhuobi=CNY&type=1&callback=jisuanjieguo&_=1588350972990"
    apiStr := Get(url)
    apiStr = apiStr[13 : len(apiStr)-2]
    fmt.Println(apiStr)
    resByte := []byte(apiStr)
    var result map[string]interface{}
    err := json.Unmarshal(resByte, &result)
    if err != nil {
        fmt.Println(err)
        return
    }
    var ratio = result["dangqianhuilv"].(string)
    //写入到redis或其他操作
}


// 发送GET请求
// url：         请求地址
// response：    请求返回的内容
func Get(url string) string {

    // 超时时间：5秒
    client := &http.Client{Timeout: 5 * time.Second}
    resp, err := client.Get(url)
    if err != nil {
        panic(err)
    }
    defer resp.Body.Close()
    var buffer [512]byte
    result := bytes.NewBuffer(nil)
    for {
        n, err := resp.Body.Read(buffer[0:])
        result.Write(buffer[0:n])
        if err != nil && err == io.EOF {
            break
        } else if err != nil {
            panic(err)
        }
    }
    return result.String()
}

```

- 此处是通过网上的查询页面获取的汇率 如果对应站改了参数或者变动 将不能使用

----------------

### go 16进制转10进制

```golang
    gas := "0x186a0"
    hex:=gas[2:]
    gasInt, err := strconv.ParseUint(gas, 16, 64)
    if err != nil {
        response.Error(c, 293, "请稍后重试")
        return
    }
    fmt.Println(gasInt) //100000
```

-------------------


### go 常用的正则表达式

- 用户名：
```
/^[a-z0-9_-]{3,16}$/
```
- 密码：
```
/^[a-z0-9_-]{6,18}$/
```
- 十六进制值：
```
/^#?([a-f0-9]{6}|[a-f0-9]{3})$/
```
- 电子邮箱：
```
/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/
```
```
/^[a-z\d]+(\.[a-z\d]+)*@([\da-z](-[\da-z])?)+(\.{1,2}[a-z]+)+$/
```
- URL：
```
/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/
```
- IP 地址：
```
/((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?)/
```
```
/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/
```
HTML 标签：
```
/^<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)$/
```

------------------------------


### 制作时间 

//获取时间昨天59分59秒时间
```golang
currentTime := time.Now()
endTime := time.Date(currentTime.Year(), currentTime.Month(), currentTime.Day()-1, 23, 59, 59, 0, currentTime.Location())
times := endTime.Format(config.TimeFormatYear)
```
------------------------------

### go 时间获取大集合

- 此处获取的都是前一天 前一小时 或者前一个月的 用于统计的不包含本分钟本月本小时 
- 需要获取本月的只需要将 -1去掉即可

```golang
type NowTime struct {
    Year     int
    Month    time.Month
    Day      int
    Hour     int
    Minute   int
    Second   int
    Location *time.Location
}

var NowDate NowTime

func (n *NowTime) TimeValue(t *time.Time) {
    n.Year = t.Year()
    n.Month = t.Month()
    n.Day = t.Day()
    n.Hour = t.Hour()
    n.Minute = t.Minute()
    n.Second = t.Second()
    n.Location = t.Location()
}

type BetweenTime struct {
    Begin     time.Time
    End       time.Time
    BeginTime string
    EndTime   string
}

//定时任务 1min 5min 15min 30min 1hour 4hour 1day 1week 1mon
func GetTime(min string) BetweenTime {
    var (
        currentTime = time.Now()
        Between     BetweenTime
    )
    NowDate.TimeValue(&currentTime)
    switch min {
    case "1min":
        Between.GetMin(1, &currentTime)
        break
    case "5min":
        Between.GetMin(5, &currentTime)
        break
    case "15min":
        Between.GetMin(15, &currentTime)
        break
    case "30min":
        Between.GetMin(30, &currentTime)
        break
    case "1hour":
        Between.GetHour(1, &currentTime)
        break
    case "4hour":
        Between.GetHour(4, &currentTime)
        break
    case "1day":
        Between.GetDay(1, &currentTime)
        break
    case "1week":
        Between.GetWeek(1, &currentTime)
        break
    case "1mon":
        Between.GetMonth(1, &currentTime)
        break
    default:
        Between.GetMin(1, &currentTime)
        break
    }
    // config.TimeFormat "2006-01-02 15:04:05"
    Between.BeginTime = Between.Begin.Format(config.TimeFormat)
    Between.EndTime = Between.End.Format(config.TimeFormat)
    return Between
}
```
### 重要部分
```golang
//前N分钟时间区间获取
func (b *BetweenTime) GetMin(min int, currentTime *time.Time) {
    b.Begin = time.Date(NowDate.Year, NowDate.Month, NowDate.Day, NowDate.Hour, NowDate.Minute-min, 0, 0, NowDate.Location)
    b.End = time.Date(NowDate.Year, NowDate.Month, NowDate.Day, NowDate.Hour, NowDate.Minute-1, 59, 0, NowDate.Location)
}

//前N小时时间区间获取
func (b *BetweenTime) GetHour(Hour int, currentTime *time.Time) {
    b.Begin = time.Date(NowDate.Year, NowDate.Month, NowDate.Day, NowDate.Hour-Hour, 0, 0, 0, NowDate.Location)
    b.End = time.Date(NowDate.Year, NowDate.Month, NowDate.Day, NowDate.Hour-1, 59, 59, 0, NowDate.Location)
}

//前N天时间区间获取
func (b *BetweenTime) GetDay(Day int, currentTime *time.Time) {
    b.Begin = time.Date(NowDate.Year, NowDate.Month, NowDate.Day-Day, 0, 0, 0, 0, NowDate.Location)
    b.End = time.Date(NowDate.Year, NowDate.Month, NowDate.Day-1, 23, 59, 59, 0, NowDate.Location)
}

//前N星期时间区间获取
func (b *BetweenTime) GetWeek(Week int, currentTime *time.Time) {
    offset := int(time.Monday - currentTime.Weekday())
    if offset > 0 {
        offset = -6
    }
    //NowDate.Day+offset 本周一时间
    b.Begin = time.Date(NowDate.Year, NowDate.Month, NowDate.Day+offset-7, 0, 0, 0, 0, NowDate.Location)
    b.End = time.Date(NowDate.Year, NowDate.Month, NowDate.Day+offset-1, 23, 59, 59, 0, NowDate.Location)
}

//前N月时间区间获取
func (b *BetweenTime) GetMonth(Month int, currentTime *time.Time) {
    //天数设置为0就是上个月末时间
    b.Begin = time.Date(NowDate.Year, NowDate.Month-1, 1, 0, 0, 0, 0, NowDate.Location)
    b.End = time.Date(NowDate.Year, NowDate.Month, 0, 23, 59, 59, 0, NowDate.Location)
}
```
------------------------------

### go goto讲解

- `goto` 跳转到指定的标签
- `label` 上文中指定标签(名字自定义) 可以出现在goto的下面 也可以在goto之上

#### 注意
- `goto` 中间不能有新的变量声明 

```golang
End:
    fmt.Println("结束")
fmt.Println("开始")
goto End 
```

```golang
fmt.Println("开始")
goto End 
End:
    fmt.Println("结束")
```
------------------------------


### 协程配合管道使用和管道取值的三种方式

```golang
//数据结构体
type ChData struct {
    Total int
    Error error //方便业务逻辑内容错误做判断
}

// 构建一个通道
var SumCh chan ChData
//任务等待
var Wait sync.WaitGroup
//计算余额
func taskDo() {
    //一定要初始化管道 否则写不进去值
    SumCh = make(chan ChData, 4)
    var total int
    Wait.Add(4) //设置4个任务 如果使用wait包的话任务会从最后一个先执行 然后再从第一个开始执行

    //开始任务
    go func() {
        fmt.Println(1)
        time.Sleep(time.Second * 2)
        SumCh <- ChData{Total: 1}
        Wait.Done()
    }()
    go func() {
        fmt.Println(2)
        time.Sleep(time.Second * 2)
        SumCh <- ChData{Total: 2}
        Wait.Done()
    }()
    go func() {
        fmt.Println(3)
        time.Sleep(time.Second * 2)
        SumCh <- ChData{Total: 3}
        Wait.Done()
    }()
    go func() {
        fmt.Println(4)
        time.Sleep(time.Second * 2)
        SumCh <- ChData{Total: 4}
        Wait.Done()
    }()

    //等待执行完毕才会向下面执行
    Wait.Wait()

    //如果不关闭管道 下面的for会一直循环直到管道关闭
    close(SumCh)

    // 遍历接收通道数据
    for data := range SumCh {
        //判断自己业务逻辑向管道输出的错误
        if data.Error != nil {
            fmt.Println(data.Error)
            return
        }
        fmt.Println(data.Total)
        total += data.Total
    }
    //结束循环
    fmt.Println("循环结束输出总数:", total)

    //上面协程任务输出 4 1 2 3  用了wait包先执行最后一个
    //for遍历管道输出 3 1 2 4  循环结束输出总数: 10
    //
}

```
#### 循环取管道值的另一种方式

- 这种方案适合单管道取值 持久任务和上面的等待短任务都可以使用 
- 这种持久任务,关闭管道需要单独判断 比如 data.Total ==0 的时候 关闭 close(SumCh)

```golang
for {
        if data, ok := <-SumCh; ok {
            if data.Error != nil {
                fmt.Println(data.Total)
                return
            }
            total += data.Total
        } else {
            break
        }
    }
```

- 这种更适合不确定任务数,不会停掉,持久性的任务

```golang
    for{
        select {
            case data:=<-SumCh:
                fmt.Println(data)
            case data:=<-CloseCh: //另一个用来关闭其他管道的管道,需要关闭时发送一个信号
                close(SumCh)
                close(CloseCh)
                break//跳出循环
        default:
            //fmt.Println("没有值")
        }
    }
```


------------------------------


### golang 邮箱/手机号/参数/正则验证

- 邮箱验证
```golang
func Email(Email string) (result bool) {
    //pattern := `^[0-9a-z][_.0-9a-z-]{0,31}@([0-9a-z][0-9a-z-]{0,30}[0-9a-z]\.){1,4}[a-z]{2,4}$`
    pattern := `^[0-9a-z][_.0-9a-z-]{0,31}@(163|qq|gmail)\.com$`
    reg := regexp.MustCompile(pattern)
    result = reg.MatchString(Email)
    return
}
```
- 手机号码验证
```golang
func CnMobile(Mobile string) bool {
    pattern := `^1([38][0-9]|14[579]|5[^4]|16[6]|7[1-35-8]|9[189])\d{8}$`
    reg := regexp.MustCompile(pattern)
    return reg.MatchString(Mobile)
}
```

- sql参数检查
```golang
func CheckStr(str string) bool {
    pattern := `(?i)and|or|select|insert|update|CR|document|LF|eval|delete|script|alert|\'|\/\*|\#|\--|\ --|\/|\*|\-|\+|\=|\~|\*@|\*!|\$|\%|\^|\&|\(|\)|\/|\/\/|\.\.\/|\.\/|union|into|load_file|outfile`
    reg := regexp.MustCompile(pattern)
    return reg.MatchString(str)
}
```

------------------------------


### go 获取汇率(USD转CNY)
- 通过爬去接口获取的汇率值 usd to cny

<!--more-->

```golang
//获取美元兑换CNY汇率
func SetRatio(c *gin.Context) {
    var url = "https://webapi.huilv.cc/api/exchange?num=1&chiyouhuobi=USD&duihuanhuobi=CNY&type=1&callback=jisuanjieguo&_=1588350972990"
    apiStr := Get(url)
    apiStr = apiStr[13 : len(apiStr)-2]
    fmt.Println(apiStr)
    resByte := []byte(apiStr)
    var result map[string]interface{}
    err := json.Unmarshal(resByte, &result)
    if err != nil {
        fmt.Println(err)
        return
    }
    var ratio = result["dangqianhuilv"].(string)
    //写入到redis或其他操作
}


// 发送GET请求
// url：         请求地址
// response：    请求返回的内容
func Get(url string) string {

    // 超时时间：5秒
    client := &http.Client{Timeout: 5 * time.Second}
    resp, err := client.Get(url)
    if err != nil {
        panic(err)
    }
    defer resp.Body.Close()
    var buffer [512]byte
    result := bytes.NewBuffer(nil)
    for {
        n, err := resp.Body.Read(buffer[0:])
        result.Write(buffer[0:n])
        if err != nil && err == io.EOF {
            break
        } else if err != nil {
            panic(err)
        }
    }
    return result.String()
}

```

- 此处是通过网上的查询页面获取的汇率 如果对应站改了参数或者变动 将不能使用

------------------------------

### go 合并数组


```golang
    var CoinUsers [] int
    var GoldUsers [] int
    Users := append(CoinUsers, GoldUsers...)
    fmt.Println(Users)
```
<!--more-->

------------------------------


### go struct获取不到值

- 定义好结构体之后获取不到里面的值
- 检查结构体里面的变量名是否是小写 小写外部是获取不到里面的值的
<!--more-->

------------------------------

### gorm 修改语句

- 不要使用where(user).update(user)
- 因为user内容已经被修改 会匹配不到记录而且还不会报错
- 修改为 where("id=?",user.Id).update(user)

 - 修改数据语句中有空值 执行这样的语句时 不会对空值进行修改 
```
 tx.Table(o.TableName()).Where("id=?",o.Id).Update(&o).Error
 如果里面有个字段是 balance 数据库现值是100 改为0 则不会修改该字段 
 ```
<!--more-->

------------------------------

### go json转byte
```golang
    type Product struct {
        Name      string  `json:"name"`
        ProductID int64   `json:"product_id,string"`
        Number    int     `json:"number,string"`
        Price     float64 `json:"price,string"`
        IsOnSale  bool    `json:"is_on_sale,string"`
    }
    var data = `{"name":"Xiao mi 6","product_id":"10","number":"10000","price":"2499","is_on_sale":"true"}`
    p := &Product{}
    err := json.Unmarshal([]byte(data), p)
```
<!--more-->

------------------------------


### go win 打包linux平台的下运行的go文件

1. cd到main.go目录下 
2. 必须用windows的cmd，不能使用powershell或者git bash 和 cmder等工具
```sh
set GOARCH=amd64   //设置目标可执行程序操作系统构架，包括 386，amd64，arm
set GOOS=linux     //设置可执行程序运行操作系统，支持 darwin，freebsd，linux，windows
go build           //打包
```

<!--more-->

------------------------------

# TODO blog更新至此


### go gin swag


1. 引入包文件
```sh
go get -u github.com/swaggo/swag/cmd/swag
go get -u github.com/swaggo/gin-swagger
go get -u github.com/swaggo/gin-swagger/swaggerFiles
```
2. `main`文件设置`docs`文件目录 
```golang
import(
  _ "item/app/apiv1/docs" //docs文件目录
  swaggerFiles "github.com/swaggo/files"
  ginSwagger "github.com/swaggo/gin-swagger"
 )
```
3. `main`文件设置`swagger`访问路由
```
r.GET("/swagger/*any", ginSwagger.WrapHandler(swaggerFiles.Handler))
```
4. 文件方法的备注
```golang
// @Tags 用户
// @Summary 用户列表
// @Produce json
// @Param token header string true "token验证"
// @Param page query string true "当前页数"   //get 使用query
// @Param limit query string true "每页数量" 
// @param rules formData string true "权限组" //post 使用formData
// @Failure -999 {string} err "参数错误"
// @Success 200  {object} model.User //此处返回的是model里面的结构体 结构体要在字段后面加 (//备注) 才能显示出来
// @Router /user/list [get] //路由地址和请求方法
```

5. 生成命令
```sh
swag init -g ./admin/cmd/main.go -o ./admin/docs/
```
- `-g`参数是指定要生成main文件路径 默认本文件夹
- `-o` 参数是生成到指定的文件下 默认本文件夹
- 生成的时候要在model等文件在命令执行的下面 否则model的备注无法生成

6. 官方参数
- (github地址)[https://github.com/swaggo/swag/blob/master/README_zh-CN.md]
```
swag init -h
NAME:
   swag init - Create docs.go

USAGE:
   swag init [command options] [arguments...]

OPTIONS:
   --generalInfo value, -g value       API通用信息所在的go源文件路径，如果是相对路径则基于API解析目录 (默认: "main.go")
   --dir value, -d value               API解析目录 (默认: "./")
   --propertyStrategy value, -p value  结构体字段命名规则，三种：snakecase,camelcase,pascalcase (默认: "camelcase")
   --output value, -o value            文件(swagger.json, swagger.yaml and doc.go)输出目录 (默认: "./docs")
   --parseVendor                       是否解析vendor目录里的go源文件，默认不
   --parseDependency                   是否解析依赖目录中的go源文件，默认不
   --markdownFiles value, --md value   指定API的描述信息所使用的markdown文件所在的目录
   --generatedTime                     是否输出时间到输出文件docs.go的顶部，默认是
```

---- 

### go bind: Cannot assign requested address

- 在使用 udp建立连接的时候报的错误原因如下
<!--more-->
```
These errors could be issued when the hostname defined to Websphere is not the hostname used by the system
#翻译: 当为Websphere定义的主机名不是系统使用的主机名时，可能会发出这些错误
```
- 一般都是你自定义了主机的host或ip请求导致的这个错误