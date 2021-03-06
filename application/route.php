<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '/' => 'index/index/login',
    '/login' => 'index/index/login',
    '/ilogin' => 'index/index/i_sau_login',
    '/logout' => 'index/index/logout',

    '/admin' => 'index/user/admin',
    '/user/[:id]' => 'index/user/user',
    '/users/[:page]/[:major]/[:team]' => 'index/user/users',
    '/delete/user/:id' => 'index/user/delete',

    '/teams' => 'index/team/teams',
    '/team/[:id]' => 'index/team/team',
    '/delete/team/[:id]' => 'index/team/delete',

    '/types' => 'index/type/types',
    '/type/[:id]' => 'index/type/type',
    '/delete/type/[:id]' => 'index/type/delete',

    '/scores/[:id]' => 'index/score/scores',
    '/score/[:id]/[:number]' => 'index/score/score'
];
