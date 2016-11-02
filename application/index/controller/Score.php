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

        $model = get_model($id);
        if(!$model) return $this->redirect('/user');
        $cj = $model->cj;
        $scores = $cj::where("学号=$id")->select();

        $this->assign('user', $scores[0]);
        $this->assign('scores', $scores);
        $this->assign('title', '规划列表');
        return $this->fetch();
    }

    public function score($id=0, $number=0) {
        if(session('power'))
            $id = session('id');

        $model = get_model($id);
        if(!$model) return $this->redirect('/user');
        $scores = $model->cj->where("`学号`='$id' and `选课课号`='$number'")->select();
        if($scores) $score = $scores[0];
        else return $this->redirect('/user');
        $this->assign('score', $score);
        $this->assign('title', '详细信息');
        return $this->fetch();
    }

}
