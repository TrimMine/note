
# 安全小知识
----


### 越权名词解释

- 水平越权: 值相同权限下不同的用户可以互相访问
	
>测试方法: 主要通过看看能否通过A用户操作影响到B用户

<!--more-->
- 垂直越权: 指使用权限低的用户可以访问到权限比较高的用户

>水平越权测试方法: 看看低权限用户是否能够能越权使用高权限用户的功能,比如普通用户可以使用管理员的功能