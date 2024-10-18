<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\MembersModel;

class Members extends BaseController
{
    protected $memberModel;

    public function __construct()
    {
        $this->memberModel = new MembersModel();
    }

    public function index()
    {
        $data['members'] = $this->memberModel->findAll();
        return view('members/index', $data);
    }

    public function create()
    {
        return view('members/create');
    }

    public function store()
    {
        $this->memberModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'membership_date' => $this->request->getPost('membership_date'),
        ]);
        return redirect()->to('admin/members');
    }

    public function edit($id)
    {
        $data['member'] = $this->memberModel->find($id);
        return view('members/edit', $data);
    }

    public function update($id)
    {
        $this->memberModel->update($id, [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ]);
        return redirect()->to('admin/members');
    }

    public function delete($id)
    {
        $this->memberModel->delete($id);
        return redirect()->to('admin/members');
    }
}
