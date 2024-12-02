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
        try {
            $this->adminsModel->save([
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'email'    => $this->request->getPost('email'),
                'name'     => $this->request->getPost('name'),
            ]);

            return redirect()->to('/admins')->with('success', 'Admin berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->to('/admins')->with('error', 'An error occurred while saving: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $data['admin'] = $this->adminsModel->find($id);
        return view('admins/edit', $data);
    }

    public function update($id)
    {
        try {
            $this->adminsModel->update($id, [
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                'name'     => $this->request->getPost('name'),
            ]);

            return redirect()->to('/admins')->with('success', 'Admin berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->to('/admins')->with('error', 'An error occurred while updating: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Get the current logged-in admin's ID
            $currentAdminId = session()->get('uid');

            // Check if the admin is logged in and if session is set
            if (!$currentAdminId) {
                return redirect()->to('/login')->with('error', 'You are not logged in.');
            }

            // Check if the admin is trying to delete themselves
            if ($id == $currentAdminId) {
                return redirect()->to('/admins')->with('error', 'You cannot delete your own account.');
            }

            // Proceed with the deletion
            $this->adminsModel->delete($id);

            return redirect()->to('/admins')->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            // Catch any exceptions that occur during the deletion process
            return redirect()->to('/admins')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
