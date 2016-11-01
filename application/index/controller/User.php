<?php
namespace app\index\controller;
use think\Session;
use app\index\model;

class User extends Access
{
    private function check($score) {
        return true;
    }

    private function update() {

    }

    public function admin() {
        $this->assign('title', '管理');
        return $this->fetch();
    }

    public function user($id=0) {
        if(session('power'))
            $id = session('id');
        else if($id == 0 || !get_model($id)) {
            return $this->redirect('/admin');
        }

        $cj = get_model($id)->cj;
        $users = $cj::where("学号=$id")->select();
        $this->assign('user', $users[0]);
        $this->assign('title', '个人信息');
        return $this->fetch();
    }

    public function users($page=0, $team=0, $type=0) {
        if(session('power')) return $this->redirect('/user');
        if($page < 0) $page = 0;

        $users = new model\jsj\Jsjcj();
        if($type) $users = $users->alias('u')->join('cs_target t', 'u.id=t.user_id')->where(['type_id' => $type]);
        $users = $users->group('学号')->limit($page * 20, 20)->select('distinct 学号');
        //$users = $users

        $this->assign('users', $users);
        $this->assign('page', $page);
        $this->assign('team', $team);
        $this->assign('type', $type);
        $this->assign('title', '用户列表');

        return $this->fetch();
    }

    public function delete($id=0) {
        if(session('power'))
            return $this->redirect('/user');
        $user = model\User::get(['id' => $id]);
        if($user) $user->delete();
        return $this->redirect('/users');
    }

}
