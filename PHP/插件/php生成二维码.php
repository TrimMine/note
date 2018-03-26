<?php 
        
        #路径
        $nologo_code = 'nologo'.$QrcodeName.'.png';
        $logo_code   = 'logo'.$QrcodeName.'.png';
        $code        = $QrcodeName.'.png';
        $bgcode      = 'Public/home/codeBg.png';
        $path        = 'Public/home/qrcode/';
        $url         =  $user['url'];
        $nickname    =  $userinfo['nickname'];
        if (strlen($nickname) >15) {
            $nickname = mb_substr($nickname,0,5).'....';
        }
        #去除 /
        $head_img = substr($userinfo['head_img'],1);
        #**********************  生成二维码 *******************************
        public static function MakeQrcode($nologo_code,$logo_code,$code,$bgcode,$path,$url,$head_img,$nickname)
        {   
            #引入包
            Vendor('phpqrcode.phpqrcode');
            $object = new \QRcode();
            #二维码内容
            $url = $url;
            #容错级别
            $errorCorrectionLevel = 'H';  #容错级别 H级别大小要7以上能识别  H级别 大小4以上
            #生成图片大小
            $matrixPointSize = 4 ;
            #生成一个无logo二维码图片
            $object->png($url,$path.$nologo_code, $errorCorrectionLevel, $matrixPointSize, 2);
           #*****************************  下面为带logo的二维码 并且保存到背景图上 ***************************************
            #logo图片路径 头像路径
            $logo = $head_img; 
            #无logo二维码图路径
            $qrcode = $path.$nologo_code;
            #$qrcode = 'Public/home/qrcode/Nologo'.$CodeName.'.png';
            #如果logo图片存在  生成带logo的二维码
            if ($logo !== FALSE) {
                $qrcode = imagecreatefromstring(file_get_contents($qrcode));
                $logo = imagecreatefromstring(file_get_contents($logo));
                $qrcode_width = imagesx($qrcode);   #二维码图片宽度
                $qrcode_height = imagesy($qrcode);  #二维码图片高度
                $logo_width = imagesx($logo);       #logo图片宽度
                $logo_height = imagesy($logo);      #logo图片高度
                $logo_qr_width = $qrcode_width / 5;
                $scale = $logo_width / $logo_qr_width;
                $logo_qr_height = $logo_height / $scale;
                $from_width = ($qrcode_width - $logo_qr_width) / 2;
                #重新组合图片并调整大小
                imagecopyresampled($qrcode, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                    $logo_qr_width, $logo_width, $logo_height);
           #此处原先是logo_qr_height  现改为logo_qr_width把头像调整为正方形
            }
            #输出图片并保存 带logo的二维码
            imagepng($qrcode,$path.$logo_code); #输出图片   
            #header('Content-Type: image/gif 或者png 或者 jpeg');
            #imagejpeg($file,$path,100)   #imagepng()    #imagegif() 
            #1.文件 2.路径 存在则保存图片$path可写为null 3.表示保存的质量度0-100质量 100最高  

           #*****************************  下面为处理头像 按比例缩小头像 ***************************************
          
            $dst_path = $path.$bgcode;  #底图  背景图
            $src_path = $path.$logo_code; #二维码
            $head_path = $head_img; #头像路径
            #创建图片的实例
            $dst  = imagecreatefromstring(file_get_contents($dst_path));#背景
            $src  = imagecreatefromstring(file_get_contents($src_path));#二维码
            $head = imagecreatefromstring(file_get_contents($head_path));#头像

            #获取图片的宽高  
            list($src_w, $src_h) = getimagesize($src_path);
            list($head_w, $head_h) = getimagesize($head_path);

           #*****************************  下面为处理头像 按比例缩小头像 ***************************************
           
            $newwidth  = $head_w * 0.1; #新头像图片的宽  手机上固定大小 100 以免位置错误 昵称最多不大于5位
            $newheight = $head_h * 0.1; #新头像图片的高  手机上固定大小 100 以免位置错误 昵称最多不大于5位
            #创建新头像文件
            $newhead = imagecreatetruecolor($newwidth, $newheight);
            #生成新头像
            imagecopyresampled($newhead, $head, 0, 0, 0, 0, $newwidth, $newheight, $head_w, $head_h);
           #*****************************  下面将 logo二维码 头像 昵称 放到背景图上 ***************************************
           
            #字体颜色
            $red = imagecolorallocate($dst, 255, 0, 0);
            
            #字内容
            $str =$nickname;
            #字体样式  需要时转换 #$str = iconv("gbk","utf-8","北京 hello!");   
            $str = str_pad($str, 13, " ", STR_PAD_BOTH);    #填充字符串 STR_PAD_BOTH从两边填充
            $font = './Aura.ttf'; #*************一定要引入字体样式#*************

            #*******将文字复制到图片（底图）上   *******
            #能输出汉字  画布资源 字大小 旋转  X轴  Y轴  颜色  字体样式  内容   
            imagefttext($dst,   12 ,  0  , 290, 350, $red, $font, $str);
           
            #只能输出英文 背景图 字体大小 x轴 Y轴 字内容 颜色 imagestring文件格式为gbk  
            #imagestring($dst, 5, 50, 50, "php hello word", $red);

            #*******将图片复制到目标图片（底图）上 *******
            #二维码         背景  图片文件 X轴  Y轴         图片宽    高      透明度
            imagecopymerge($dst, $src,  230, 485, 0, 0, $src_w, $src_h, 100);
            #头像                                   调整头像为正方形 原先为newheight
            imagecopymerge($dst, $newhead, 290, 240, 0, 0, $newwidth, $newwidth, 100);

            #如果水印图片本身带透明色，则使用imagecopy方法
            # imagecopy($dst, $src, 10, 10, 0, 0, $src_w, $src_h);
            
            #生成图片  宽   高       类型
            list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
            #而后用switch判断一下图片的类型
            switch ($dst_type) {
                    case 1:#GIF
                        header('Content-Type: image/gif');
                        imagegif($dst); #输出图片
                        #imagegif($dst,$path.$code,100); #输出图片并保存  
                        break;
                    case 2:#JPG
                        header('Content-Type: image/jpeg');  #如果无法生成则用 gif 或jpeg
                        imagejpeg($dst);  
                        break;
                    case 3:#PNG
                        header('Content-Type: image/png');   #如果无法生成则用 gif 或jpeg
                        imagepng($dst);  
                        break;
                    default:
                        break;
                }
            #将图片释放
            imagedestroy($dst);imagedestroy($src); imagedestroy($head);
           
        }

      #html 页面接收  <img src="方法路径">

      /*  创建图片
      bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h ,int $src_w , int $src_h )
      $dst_image：新建的图片
      $src_image：需要载入的图片
      $dst_x：设定需要载入的图片在新图中的x坐标
      $dst_y：设定需要载入的图片在新图中的y坐标
      $src_x：设定载入图片要载入的区域x坐标
      $src_y：设定载入图片要载入的区域y坐标
      $dst_w：设定载入的原图的宽度（在此设置缩放）
      $dst_h：设定载入的原图的高度（在此设置缩放）
      $src_w：原图要载入的宽度
      $src_h：原图要载入的高度*/

      /*  复制图片
      bool imagecopymerge( resource dst_im, resource src_im, int dst_x, int dst_y, int src_x, int src_y,int src_w, int src_h, int pct )
      dst_im  目标图像
      src_im  被拷贝的源图像
      dst_x   目标图像开始 x 坐标
      dst_y   目标图像开始 y 坐标，x,y同为 0 则从左上角开始
      src_x   拷贝图像开始 x 坐标
      src_y   拷贝图像开始 y 坐标，x,y同为 0 则从左上角开始拷贝
      src_w   （从 src_x 开始）拷贝的宽度
      src_h   （从 src_y 开始）拷贝的高度
      pct 图像合并程度，取值 0-100 ，当 pct=0 时，实际上什么也没做，反之完全合并。*/




/*
************************************************************************************************************************
*                                 方法                                                                          *
************************************************************************************************************************/
        
         #我的二维码
        public function MyQrcode()
        {  
            $users = D('Users');
            $userinfo = $users->where(['id' => $_SESSION['home']['user']['id']])->find();
            
            #二维码内容
            $user['url'] = 'http://zcdjk.ewtouch.com/Home/Auth/register?UserPid=' . $userinfo['id'];
            #查询记录头像和二维码是否改变
            $qrcodeinfo = M('qrcode_log')->where(['user_id'=> $_SESSION['home']['user']['id']])->order('created_at desc')->find();
            #判断是否生成二维码
            if ($userinfo['qrcode'] == '' || $qrcodeinfo['nickname'] != $userinfo['nickname'] ) {
                #生成名称
                $QrcodeName  = CheckServices::RandPass();
                #路径
                $nologo_code = 'nologo'.$QrcodeName.'.png';
                $logo_code   = 'logo'.$QrcodeName.'.png';
                $code        = $QrcodeName.'.png';
                $bgcode      = 'Public/home/codeBg.png';
                $path        = 'Public/home/qrcode/';
                $url         =  $user['url'];
                $nickname    =  $userinfo['nickname'];
                #去除 /
                $head_img = substr($userinfo['head_img'],1);
                #生成二维码
                $res = self::MakeQrcode($nologo_code,$logo_code,$code,$bgcode,$path,$url,$nickname,$head_img);
                if (!$res) {
                    $this->ajaxReturn(['status' => 'error', 'message' => '生成二维码失败']);
                }
                #保存路径
                $result = $users->where(['id' => $_SESSION['home']['user']['id']])->save(['qrcode' => '/'.$path.$code]);
                if (!$result) {
                    $this->ajaxReturn(['status' => 'error', 'message' => '保存失败']);
                }
                #插入记录
                $data = [
                    'user_id' => $userinfo['id'],
                    'nickname' => $userinfo['nickname'],
                    'head_img' => $userinfo['head_img'],
                    'qrcode' => '/'.$path.$code,
                    'nologo_code' => '/'.$path.$nologo_code,
                    'logo_code' => '/'.$path.$logo_code,
                    'created_at'=>date('YmdHis')
                ];
                if (!M('qrcode_log')->add($data)) {
                    $this->ajaxReturn(['status' => 'error', 'message' => '记录失败']);
                }

                $this->ajaxReturn(['status' => 'success', 'message' => '成功','data'=>'/'.$path.$code]);

            }else{

                $this->ajaxReturn(['status' => 'success', 'message' => '成功','data'=>$userinfo['qrcode']]);
            }
        }

          #**********************  生成二维码 *******************************
        public static function MakeQrcode($nologo_code,$logo_code,$code,$bgcode,$path,$url,$nickname,$head_img)
        {   
            #引入包
            Vendor('phpqrcode.phpqrcode');
            $object = new \QRcode();
            #二维码内容
            $url = $url;
            #容错级别
            $errorCorrectionLevel = 'L';
            #生成图片大小
            $matrixPointSize = 6 ;
            #生成一个无logo二维码图片
            $object->png($url,$path.$nologo_code, $errorCorrectionLevel, $matrixPointSize, 2);
            #logo图片路径 头像路径
            $logo = $head_img; 
            #无logo二维码图路径
            $qrcode = $path.$nologo_code;
            #如果logo图片存在  生成带logo的二维码
            if ($logo !== FALSE) {
                $qrcode = imagecreatefromstring(file_get_contents($qrcode));
                $logo = imagecreatefromstring(file_get_contents($logo));
                $qrcode_width = imagesx($qrcode);   #二维码图片宽度
                $qrcode_height = imagesy($qrcode);  #二维码图片高度
                $logo_width = imagesx($logo);       #logo图片宽度
                $logo_height = imagesy($logo);      #logo图片高度
                $logo_qr_width = $qrcode_width / 5;
                $scale = $logo_width / $logo_qr_width;
                $logo_qr_height = $logo_height / $scale;
                $from_width = ($qrcode_width - $logo_qr_width) / 2;
                #重新组合图片并调整大小
                imagecopyresampled($qrcode, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                    $logo_qr_width, $logo_width, $logo_height);
            }
            #输出图片并保存 带logo的二维码
            imagepng($qrcode,$path.$logo_code); #输出图片   
          
            $dst_path = $bgcode;  #底图  背景图
            $src_path = $path.$logo_code; #二维码
            $head_path = $head_img; #头像路径
            #创建图片的实例

            $dst  = imagecreatefromstring(file_get_contents($dst_path));#背景
            $src  = imagecreatefromstring(file_get_contents($src_path));#二维码
            $head = imagecreatefromstring(file_get_contents($head_path));#头像
            #获取图片的宽高  
            list($src_w, $src_h) = getimagesize($src_path);
            list($head_w, $head_h) = getimagesize($head_path);
            $newwidth  = $head_w * 0.1; #新头像图片的宽 100
            $newheight = $head_h * 0.1; #新头像图片的高 100 

            #创建新头像文件
            $newhead = imagecreatetruecolor($newwidth, $newheight);
            #生成新头像
            imagecopyresampled($newhead, $head, 0, 0, 0, 0, $newwidth, $newheight, $head_w, $head_h);
            #字体颜色
            $red = imagecolorallocate($dst, 255, 0, 0);
            #字内容
            $str =$nickname;
            $font = './Aura.ttf';

            imagefttext($dst,   12 ,  0  , 290, 350, $red, $font, $str);
            imagecopymerge($dst, $src,  230, 485, 0, 0, $src_w, $src_h, 100);
            imagecopymerge($dst, $newhead, 290, 240, 0, 0, $newwidth, $newwidth, 100);
            #生成图片  宽   高       类型
            list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
            #判断一下图片的类型
            switch ($dst_type) {
                    case 1:#GIF
                        $res = imagegif($dst,$path.$code,100);   
                        break;
                    case 2:#JPG
                        $res = imagejpeg($dst,$path.$code,100);   
                        break;
                    case 3:#PNG
                        $res = imagepng($dst,$path.$code,100);   
                        break;
                    default:
                        break;
                }
            #将图片释放
            imagedestroy($dst); imagedestroy($src); imagedestroy($head);
            if ($res) {
                return true;
            }else{
                return false;
            }
        }


      

