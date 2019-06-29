
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
----
### go 时间戳转时间 time to datetime


1. 时间戳转时间
```go
dateInt64 := 1561097533
dateTimes := datetimetime.Unix(dateInt64, 0).Format(config.TimeFormat)
fmt.PrintLn(dateTimes)
// config.TimeFormat 
// TimeFormat = "2006-01-02 15:04:05"

```
----
### go 获取当期那时间戳

```go
time := time.Now().Unix()
```

----

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