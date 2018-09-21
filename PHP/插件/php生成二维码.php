<?php 
        
#我的二维码
    public function index()
    {
        $userinfo = UsersModel::where(['id' => self::$user_id])->find();
        #判断是否是https
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        #二维码内容
        $user['url'] = $protocol . $_SERVER['HTTP_HOST'] . '/index/Login/register?upCode=' . $userinfo['push_code'];
        #路径
        $QrcodeName = $userinfo['phone'];
        $nologo_code = 'nologo' . $QrcodeName . '.png';
        $logo_code = 'logo' . $QrcodeName . '.png';
        $bgcode = 'static/codeBg.jpg';
        $path = 'static/qrcode/';
        $url = $user['url'];
        $nickname = $userinfo['web_nickname'];
        $head_img = $userinfo['web_avatar'];
        if (strlen($nickname) > 15) {
            $nickname = mb_substr($nickname, 0, 5) . '....';
        }
        #生成二维码
        self::MakeQrcode($nologo_code, $logo_code, $bgcode, $path, $url, $nickname, $head_img);
    }

     /**
     * 只有背景图和二维码
     * @param $nologo_code 无头像二维码名字
     * @param $bgcode      背景图片地址
     * @param $path        保存路径
     * @param $url         跳转url
     */
    public static function myQrcode($nologo_code, $bgcode, $path, $url)
    {
        #引入包
        $object = new Qrcode();
        #容错级别
        $errorCorrectionLevel = 'G';
        #生成图片大小H
        $matrixPointSize = 6;
        #生成一个无logo二维码图片
        $object->png($url, $path . $nologo_code, $errorCorrectionLevel, $matrixPointSize, 2);
        $dst_path = $bgcode;  #底图  背景图
        $src_path = $path . $nologo_code; #二维码
        #创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));#背景
        $src = imagecreatefromstring(file_get_contents($src_path));#二维码
        #获取图片的宽高
        list($src_w, $src_h) = getimagesize($src_path);
        imagecopymerge($dst, $src, 266, 487, 0, 0, $src_w, $src_h, 100);#二维码
        #生成图片  宽   高       类型
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        #判断一下图片的类型
        switch ($dst_type) {
            case 1:#GIF
                header('Content-type: image/gif');
                imagegif($dst, $path . $nologo_code);
                break;
            case 2:#JPG
                header('Content-type: image/png');
                imagejpeg($dst, $path . $nologo_code);
                break;
            case 3:#PNG
                header('Content-type: image/jpeg');
                imagejpeg($dst, $path . $nologo_code);
                break;
            default:
                break;
        }
        #将图片释放
        imagedestroy($dst);
        imagedestroy($src);
        return $path . $nologo_code;
    }

    #生成二维码
    public static function MakeQrcode($nologo_code, $logo_code, $bgcode, $path, $url, $nickname, $head_img)
    {
        #引入包
        $object = new Qrcode();
        #二维码内容
        $url = $url;
        #容错级别
        $errorCorrectionLevel = 'M';
        #生成图片大小H
        $matrixPointSize = 4;
        #生成一个无logo二维码图片 6个参数 第二个参数决定是否要显示图片 false为直接显示 填写则为保存路径
        $object->png($url, $path . $nologo_code, $errorCorrectionLevel, $matrixPointSize, 2);
        #logo图片路径 头像路径
        $logo = $head_img;
        #无logo二维码图路径L
        $qrcode = $path . $nologo_code;
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
        imagepng($qrcode, $path . $logo_code); #输出图片

        $dst_path = $bgcode;  #底图  背景图
        $src_path = $path . $logo_code; #二维码
        $head_path = $head_img; #头像路径
        #创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));#背景
        $src = imagecreatefromstring(file_get_contents($src_path));#二维码
        $head = imagecreatefromstring(file_get_contents($head_path));#头像
        #获取图片的宽高
        list($src_w, $src_h) = getimagesize($src_path);
        list($head_w, $head_h) = getimagesize($head_path);
        $newwidth = $head_w * 1.4; #新头像图片的宽
        $newheight = $head_h * 1.4; #新头像图片的高
        $newwidth = 100; #新头像图片的宽
        $newheight = 100; #新头像图片的高
        #创建新头像文件
        $newhead = imagecreatetruecolor($newwidth, $newheight);
        #生成新头像
        imagecopyresampled($newhead, $head, 0, 0, 0, 0, $newwidth, $newheight, $head_w, $head_h);
        #字体颜色
        $red = imagecolorallocate($dst, 0, 0, 0);
        #字内容
        $str = $nickname;
        $font = 'static/kaiti.ttf';
        $str = str_pad($str, 13, " ", STR_PAD_BOTH);    #填充字符串
        imagefttext($dst, 25, 0, 278, 210, $red, $font, $str); #字体
        imagecopymerge($dst, $newhead, 112, 142, 0, 0, $newwidth, $newwidth, 100);#头像
        imagecopymerge($dst, $src, 248, 687, 0, 0, $src_w, $src_h, 100);#二维码
        #生成图片  宽   高       类型
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        #判断一下图片的类型
        switch ($dst_type) {
            case 1:#GIF
                header('Content-type: image/gif');
                imagegif($dst);
                break;
            case 2:#JPG
                header('Content-type: image/jpeg');
                imagejpeg($dst);
                break;
            case 3:#PNG
                header('Content-type: image/jpeg');
                imagejpeg($dst);
                break;
            default:
                break;
        }
        #将图片释放
        imagedestroy($dst);
        imagedestroy($src);
        imagedestroy($head);
        die;
    }
      

