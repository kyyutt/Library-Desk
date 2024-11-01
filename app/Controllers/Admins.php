<?php

namespace App\Controllers;

use App\Models\AdminsModel;

class Admins extends BaseController
{
    protected $adminsModel;

    public function __construct()
    {
        $this->adminsModel = new AdminsModel();
    }

    public function index()
    {
        $data['admins'] = $this->adminsModel->findAll();
        return view('admins/index', $data);
    }

    public function create()
    {
        return view('admins/create');
    }

    public function store()
    {
        $this->adminsModel->save([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'email'    => $this->request->getPost('email'),
            'nama'     => $this->request->getPost('nama'),
        ]);

        return redirect()->to('/admins')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['admin'] = $this->adminsModel->find($id);
        return view('admins/edit', $data);
    }

    public function update($id)
    {
        $this->adminsModel->update($id, [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'nama'     => $this->request->getPost('nama'),
        ]);

        return redirect()->to('/admins')->with('success', 'Admin berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->adminsModel->delete($id);
        return redirect()->to('/admins')->with('success', 'Admin berhasil dihapus.');
    }
}
