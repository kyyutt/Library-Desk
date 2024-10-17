<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\FinesModel;
class Fines extends BaseController
{
    protected $fineModel;

    public function __construct()
    {
        $this->fineModel = new FinesModel();
    }

    public function index()
    {
        $data['fines'] = $this->fineModel->findAll();
        return view('fines/index', $data);
    }

    public function create()
    {
        return view('fines/create');
    }

    public function store()
    {
        $this->fineModel->save([
            'loan_id' => $this->request->getPost('loan_id'),
            'fine_amount' => $this->request->getPost('fine_amount'),
            'status' => $this->request->getPost('status'),
        ]);
        return redirect()->to('/fines');
    }

    public function edit($id)
    {
        $data['fine'] = $this->fineModel->find($id);
        return view('fines/edit', $data);
    }

    public function update($id)
    {
        $this->fineModel->update($id, [
            'status' => $this->request->getPost('status'),
        ]);
        return redirect()->to('/fines');
    }

    public function delete($id)
    {
        $this->fineModel->delete($id);
        return redirect()->to('/fines');
    }
}
