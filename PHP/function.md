## 时间设置
##### 初始时间
    $beginToday=mktime(0,0,0,date('m'),date('d'),date('Y'));
##### 结束时间
    $endToday=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;