<?php 
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FinesModel;

class Fines extends BaseController
{
    protected $finesModel;

    public function __construct()
    {
        $this->finesModel = new FinesModel();
    }

    public function index()
    {
        $data['fines'] = $this->finesModel->findAll();
        return view('fines/index', $data);
    }

    public function create()
    {
        return view('fines/create');
    }

    public function store()
    {
        $this->finesModel->save([
            'loan_id' => $this->request->getPost('loan_id'),
            'fine_amount' => $this->request->getPost('fine_amount'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/fines')->with('success', 'Denda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['fine'] = $this->finesModel->find($id);
        return view('fines/create', $data);
    }

    public function update($id)
    {
        $this->finesModel->update($id, [
            'loan_id' => $this->request->getPost('loan_id'),
            'fine_amount' => $this->request->getPost('fine_amount'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/admin/fines')->with('success', 'Denda berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->finesModel->delete($id);
        return redirect()->to('/admin/fines')->with('success', 'Denda berhasil dihapus.');
    }
}

?>
