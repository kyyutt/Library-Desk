<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

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
        $this->categoryModel->save([
            'category_name' => $this->request->getPost('category_name'),
        ]);
        return redirect()->to('/categories');
    }

    public function edit($id)
    {
        $data['category'] = $this->categoryModel->find($id);
        return view('categories/edit', $data);
    }

    public function update($id)
    {
        $this->categoryModel->update($id, [
            'category_name' => $this->request->getPost('category_name'),
        ]);
        return redirect()->to('/categories');
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/categories');
    }
}
