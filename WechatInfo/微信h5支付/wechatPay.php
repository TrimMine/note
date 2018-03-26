<?php 
# 微信支付  生成的二维码
    protected static function QRCode($id){
        # 判断用户是否登录
        if($_SESSION['home']['user']['id'] < 1){
            redirect('/Home/Auth/login.html');
        }
        # 查询订单信息
        $order = Order::where(['id'=>$id]) -> first();
        # 定义订单号
        do {
            $str =  getOrderNum();
        } while (Order::where(['pay_order_num'=>$str]) -> first());
        # 更新订单号
        Order::where(['id'=>$order -> id]) -> update(['pay_order_num'=>$str]);
        $data = [
            # 订单名称
            'body'=> $order -> name,
            # 订单价格
            'total_fee'=> $order -> price ,
            # 测试价格价格
            'total_fee'=> 1 ,
            # 支付方式(扫码支付)
            'trade_type'=>'NATIVE',
            # 支付订单号
            'out_trade_no'=> $str,
            # 异步通知地址
            'notify_url'=>'https://www.xiegongwang.com/Home/Pay/wx_callback.html'
        ];
        $result = Wechat::Unifiedorder($data) -> toArray();
        # 微信扫码支付URL(JS生成二维码即可)
        return $result['code_url'];
    }