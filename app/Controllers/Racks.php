<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;

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
        try {
            $this->rackModel->save([
            'rack_number' => $this->request->getPost('rack_number'),
        ]);
        return redirect()->to('/racks')->with('success', 'Rak berhasil ditambahkan .');
        } catch (\Exception $e) {
            return redirect()->to('/racks/create')->with('error', 'Tidak dapat menambah rak: ' . $e->getMessage());
        }
        
    }

    public function edit($id)
    {
        $data['rack'] = $this->rackModel->find($id);
        return view('racks/edit', $data);
    }

    public function update($id)
    {
        try {
            $this->rackModel->update($id, [
            'rack_number' => $this->request->getPost('rack_number'),
        ]);
        return redirect()->to('/racks')->with('success', 'Rak berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->to('/racks/' . $id . '/edit')->with('error', 'Tidak dapat menghapus rak: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        if ($this->rackModel->hasRelatedRecords($id)) {
            return redirect()->to('/racks')->with('error', 'Tidak dapat menghapus rak. Rak ini digunakan di buku.');
        }

        try {
            $this->rackModel->delete($id);
            return redirect()->to('/racks')->with('success', 'Rak berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/racks')->with('error', 'Tidak bisa menghapus rak: ' . $e->getMessage());
        }
    }
}
