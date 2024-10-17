<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\BookLogsModel;
class Booklogs extends BaseController
{
    protected $bookLogModel;

    public function __construct()
    {
        $this->bookLogModel = new BookLogsModel();
    }

    public function index()
    {
        $data['book_logs'] = $this->bookLogModel->findAll();
        return view('book_logs/index', $data);
    }

    public function create()
    {
        return view('book_logs/create');
    }

    public function store()
    {
        $this->bookLogModel->save([
            'book_id' => $this->request->getPost('book_id'),
            'admin_id' => $this->request->getPost('admin_id'),
            'date' => $this->request->getPost('date'),
            'action' => $this->request->getPost('action'),
        ]);
        return redirect()->to('/book_logs');
    }

    public function edit($id)
    {
        $data['book_log'] = $this->bookLogModel->find($id);
        return view('book_logs/edit', $data);
    }

    public function update($id)
    {
        $this->bookLogModel->update($id, [
            'action' => $this->request->getPost('action'),
        ]);
        return redirect()->to('/book_logs');
    }

    public function delete($id)
    {
        $this->bookLogModel->delete($id);
        return redirect()->to('/book_logs');
    }
}
