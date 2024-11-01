<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        $admin = new \App\Models\AdminsModel();
        if ($admin->countAllResults() == 0)
            $admin->insert(['username' => 'Admin', 'password' => password_hash('admin123', PASSWORD_DEFAULT)]);
        if (session()->get('isLogin'))
            return redirect()->to(base_url());
        return view('auth/login');
    }

    public function login()
    {
        $param = $this->request->getPost();
        $admin = new \App\Models\AdminsModel();
        $item = $admin->where('username', $param['username'])->orWhere('email', $param['username'])->first();
        if(!is_null($item)){
            if(password_verify($param['password'], $item['password'])){
                session()->set(['uid'=>$item['id'] ,'nama'=>'Rizqiah', 'isLogin'=>true]);
                return redirect()->to(base_url());
            }else{
    
            }
        }else{

        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth'));
    }
}
