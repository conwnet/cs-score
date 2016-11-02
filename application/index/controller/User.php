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


    public function users($page=0, $major=0, $team=0) {
        if(session('power')) return $this->redirect('/user');
        if($page < 0) $page = 0;

        $Jsj = new model\jsj\Jsjcj();
        $Wlgc = new model\wlgc\Wlgccj();
        $Rjgc = new model\rjgc\Rjgccj();
        $Wlw = new model\wlw\Wlwcj();

        if($major == 1) $users = $Jsj;
        else if($major == 2) $users = $Wlgc;
        else if($major == 3) $users = $Rjgc;
        else if($major == 4) $users = $Wlw;
        else $users = $Jsj;
        if($major && $team) $users = $users->where("班级='$team'");
        $users = $users->group('学号')->limit($page * 20, 20)->select('distinct 学号');

        $this->assign('jsj_teams', $Jsj->group('班级')->select('班级'));
        $this->assign('wlgc_teams', $Wlgc->group('班级')->select('班级'));
        $this->assign('rjgc_teams', $Rjgc->group('班级')->select('班级'));
        $this->assign('wlw_teams', $Wlw->group('班级')->select('班级'));

        $this->assign('users', $users);
        $this->assign('major', $major);
        $this->assign('page', $page);
        $this->assign('team', $team);
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
