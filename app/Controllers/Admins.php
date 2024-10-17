<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\AdminsModel;
class Admins extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminsModel();
    }

    public function index()
    {
        $data['admins'] = $this->adminModel->findAll();
        return view('admins/index', $data);
    }

    public function create()
    {
        return view('admins/create');
    }

    public function store()
    {
        $this->adminModel->save([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'email' => $this->request->getPost('email'),
        ]);
        return redirect()->to('/admins');
    }

    public function edit($id)
    {
        $data['admin'] = $this->adminModel->find($id);
        return view('admins/edit', $data);
    }

    public function update($id)
    {
        $this->adminModel->update($id, [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
        ]);
        return redirect()->to('/admins');
    }

    public function delete($id)
    {
        $this->adminModel->delete($id);
        return redirect()->to('/admins');
    }
}
