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

    public function target($id=0) {
        $target = model\Target::get(['id' => $id]);
        if($id && (!$target || (session('power') && $target->user_id != session('id'))))
            return $this->redirect('/target');
        if(input('post.id')) {
            $target = model\Target::get(input('post.id'));
            if($target) {
                if(session('power') && $target->user_id != session('id'))
                    return $this->redirect('/target');
                $target->title = input('post.title');
                $target->start_time = input('post.start_time');
                $target->achieve_time = input('post.achieve_time');
                $target->detail = input('post.detail');
                $target->type_id = input('post.type_id');
                if($target->save()) {
                    Session::flash('message', 'update_success');
                    $this->redirect('/target/' . $target->id);
                }
            } else {
                $target = new model\Target();
                $target->title = input('post.title');
                $target->start_time = input('post.start_time');
                $target->achieve_time = input('post.achieve_time');
                $target->detail = input('post.detail');
                $target->type_id = input('post.type_id') ? input('post.type_id') : 1;
                $target->user_id = session('id');
                if($target->save()) {
                    Session::flash('message', 'add_success');
                    $this->redirect('/target/' . $target->id);
                }
            }
        }
        $types = model\Type::select();
        $this->assign('types', $types);
        $this->assign('target', $target);
        $this->assign('title', '我的目标');

        return $this->fetch();
    }


    public function delete($id=0) {
        $target = model\Target::get(['id' => $id]);
        if($target && $target->user_id == session('id'))
            $target->delete();
        return $this->redirect('/targets');
    }
}
