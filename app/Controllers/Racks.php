<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\RacksModel;
class Racks extends BaseController
{
    protected $rackModel;

    public function __construct()
    {
        $this->rackModel = new RacksModel();
    }

    public function index()
    {
        $data['racks'] = $this->rackModel->findAll();
        return view('racks/index', $data);
    }

    public function create()
    {
        return view('racks/create');
    }

    public function store()
    {
        $this->rackModel->save([
            'rack_number' => $this->request->getPost('rack_number'),
        ]);
        return redirect()->to('admin/racks');
    }

    public function edit($id)
    {
        $data['rack'] = $this->rackModel->find($id);
        return view('racks/edit', $data);
    }

    public function update($id)
    {
        $this->rackModel->update($id, [
            'rack_number' => $this->request->getPost('rack_number'),
        ]);
        return redirect()->to('admin/racks');
    }

    public function delete($id)
    {
        $this->rackModel->delete($id);
        return redirect()->to('admin/racks');
    }
}
