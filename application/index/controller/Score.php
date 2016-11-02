<?php
namespace app\index\controller;
use think\Controller;
use app\index\model;
use think\Session;

class Score extends Controller
{
    public function scores($id=0) {
        if(session('power'))
            $id = session('id');

        $cj = get_model($id)->cj;
        $scores = $cj::where("学号=$id")->select();

        $this->assign('user', $scores[0]);
        $this->assign('scores', $scores);
        $this->assign('title', '规划列表');
        return $this->fetch();
    }

    public function score($id=0, $number=0) {

        $cj = get_model($id)->cj;


        return $this->fetch();
    }

}
