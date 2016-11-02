<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use app\index\model;

class Index extends Controller
{
    public function login() {
        if(input('post.username')) {
            $username = input('post.username');
            $password = input('post.password');
            if(!$username && !$password) {
                Session::flash('message', 'denied');
                return $this->fetch();
            }
            $user = model\User::get(['username' => $username]);
            if($user && hash_crypt($password) == $user->password) {
                session('id', $user->username);
                session('power', $user->power);
                return $this->redirect('/user');
            } else {
                Session::flash('message', 'denied');
            }
        }
        return $this->fetch();
    }

    public function i_sau_login() {
        if(input('post.username')) {
            $id = input('post.username');
            $password = input('post.password');
            $result = i_sau_validate($id, $password);
            if($result == 'ok') {
                $model = get_model($id);
                if(!$model) {
                    Session::flash('message', 'notfound');
                    return $this->redirect('/ilogin');
                }
                if(!model\User::get(['username' => $id])) {
                    $this->add_user($id);
                }
                session('id', $id);
                session('power', 1);
                return $this->redirect('/user');


            } else if($result == 'denied') {
                Session::flash('message', 'denied');
                return $this->redirect('/ilogin');
            } else if($result == 'timeout') {
                Session::flash('message', 'timeout');
                return $this->redirect('/ilogin');
            } else {
                Session::flash('message', 'unknow');
                return $this->redirect('/ilogin');
            }
        } else {
            return $this->fetch();
        }
    }

    private function add_user($id) {
        $user = new model\User();
        $user->username = $id;
        $user->power = 1;
        $user->save();
    }

    public function logout() {
        Session::set('id', 0);
        return $this->redirect('/');
    }

}
