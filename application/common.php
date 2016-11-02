<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


function i_sau_validate($username, $password) {

    $login_url  = 'http://cas.sau.edu.cn:8080/cas/login';
    $ch = curl_init($login_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
    $content = curl_exec($ch);
    $csrf_token_matches = [];
    $csrf_token = '';
    preg_match('/<input type="hidden" name="lt" value="(.*?)" \/>/i' ,$content, $csrf_token_matches);
    if($csrf_token_matches)
        $csrf_token = $csrf_token_matches[1];
    $login_url  = 'http://cas.sau.edu.cn:8080/cas/login';
    $password = md5($password);
    $post_fields = "serviceName=0&loginErrCnt=0&username=$username&password=$password&lt=$csrf_token";
    $ch = curl_init($login_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
    $content = curl_exec($ch);
    curl_close($ch);

    return 'ok';
    if(!$content) {
        return "timeout";
    } else if(preg_match('/mistake_notice/i', $content)){
        return 'denied';
    } else if(preg_match('/window\.location="cas\.sau\.edu\.cn:8080\/cas"/i', $content)) {
        return "ok";
    } else {
        return "unknow";
    }
}


function hash_crypt($password) {
    $__SALT__ = 'Author:netcon';
    return md5($password . $__SALT__);
}

use app\index\model;

class CsModel {

}

function get_model($id) {
    $model = new CsModel();
    if(model\jsj\Jsjcj::where("学号=$id")->select()) {
        $model->bxk = new model\jsj\Jsjbxk;
        $model->cj = new model\jsj\Jsjcj;
        $model->xwk = new model\jsj\Jsjxwk;
        $model->yxxk = new model\jsj\Jsjyxxk;

        return $model;
    }

    if(model\rjgc\Rjgccj::where("学号=$id")->select()) {
        $model->bxk = new model\rjgc\Rjgcbxk;
        $model->cj = new model\rjgc\Rjgccj;
        $model->xwk = new model\rjgc\Rjgcxwk;
        $model->yxxk = new model\rjgc\Rjgcyxxk;

        return $model;
    }

    if(model\wlgc\Wlgccj::where("学号=$id")->select()) {
        $model->bxk = new model\wlgc\Wlgcbxk;
        $model->cj = new model\wlgc\Wlgccj;
        $model->xwk = new model\wlgc\Wlgcxwk;
        $model->yxxk = new model\wlgc\Wlgcyxxk;

        return $model;
    }

    if(model\wlw\Wlwcj::where("学号=$id")->select()) {
        $model->bxk = new model\wlw\Wlwbxk;
        $model->cj = new model\wlw\Wlwcj;
        $model->xwk = new model\wlw\Wlwxwk;
        $model->yxxk = new model\wlw\Wlwyxxk;

        return $model;
    }

    return NULL;
}

function is_pass($score) {
    $s1 = $score->getAttr('总评成绩');
    $s2 = $score->getAttr('补考成绩');

    if(is_numeric($s1) && $s1 < 60 && $s2 < 60)
        return false;

    if($s1 == '不及格')
        return false;

    if($s1 == '不通过')
        return false;

    return true;
}

function no_pass($id) {
    $model = get_model($id);
    
}
























