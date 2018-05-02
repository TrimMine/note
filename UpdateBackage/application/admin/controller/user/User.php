<?php

namespace app\admin\controller\user;

use app\common\controller\Backend;

/**
 * 会员管理
 *
 * @icon fa fa-user
 */
class User extends Backend
{

    protected $relationSearch = true;

    /**
     * User模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('User');
    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with('group')
                ->where($where)
                ->order($sort, $order)
                ->count();
            $list = $this->model
                ->with('group')
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            foreach ($list as $k => $v) {
                $v->password = '';
                $v->salt = '';
            }
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }

        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $this->view->assign('groupList', build_select('row[group_id]', \app\admin\model\UserGroup::column('id,name'), $row['group_id'], ['class' => 'form-control selectpicker']));
        return parent::edit($ids);
    }

    /**
     * 导入数据
     */
    public function import_data($v)
    {
        foreach ($v as $key => $value) {
            if ($value == '') {
                continue;
            }
            if ($key == 0) {
                $data['username'] = $value;
            }
            if ($key == 1) {
                $data['mobile'] = $value;
                //密码为手机号后6位
                $password = substr($value, 5);
                //生成密码盐
                $data['salt'] = $this->make_str('salt');
                //生成密码
                $data['password'] = md5(md5($password).$data['salt']);
            }
            if ($key == 2) {
                $data['frozen_pool'] = $value;
                $data['pool'] = $value;
            }
        }
        //生成推荐码
        $data['push_code'] = $this->make_str('push_code');
        $data['token_address'] = $this->make_str('token_address',42);
        $data['is_older'] = 2;
        $data['createtime'] = time();
        $data['jointime'] = time();
        return $data;

    }

    /**
     * salt 生成字段
     */
    public function make_str($type='salt',$length='6')
    {
        $str = "";
        $salt = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';   #字符串可用下标的方式取值
        do {
            for ($i = 0; $i < $length; $i++) {
                $str .= $salt[rand(0, strlen($salt) - 1)];
            }
        } while (db('user')->where(['salt' => $type])->find());
        return $str;
    }
}
