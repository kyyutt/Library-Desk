<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use Exception;

use App\Models\CategoriesModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoriesModel();
    }

    public function index()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('categories/index', $data);
    }

    public function create()
    {
        return view('categories/create');
    }

    public function store()
    {
        try {
            $this->categoryModel->save([
                'category_name' => $this->request->getPost('category_name'),
            ]);
            return redirect()->to('/categories')->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->to('/categories/create')->with('error', 'Tidak dapat menambah kategori: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['category'] = $this->categoryModel->find($id);
        return view('categories/edit', $data);
    }

    public function update($id)
    {
        try {
            $this->categoryModel->update($id, [
                'category_name' => $this->request->getPost('category_name'),
            ]);
            return redirect()->to('/categories')->with('success', 'Kategori berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->to('/categories/' . $id . '/edit')->with('error', 'Tidak dapat mengupdate kategori: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        if ($this->categoryModel->hasRelatedRecords($id)) {
            return redirect()->to('/categories')->with('error', 'Tidak dapat menghapus kategori. Kategori ini digunakan di buku');
        }

        try {
            $this->categoryModel->delete($id);
            return redirect()->to('/categories')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/categories')->with('error', 'Tidak dapat menghapus kategori: ' . $e->getMessage());
        }
    }
}
