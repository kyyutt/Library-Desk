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
            return redirect()->to('/categories')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/categories/create')->with('error', 'Unable to create category: ' . $e->getMessage());
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
            return redirect()->to('/categories')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/categories/' . $id . '/edit')->with('error', 'Unable to update category: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        if ($this->categoryModel->hasRelatedRecords($id)) {
            return redirect()->to('/categories')->with('error', 'Unable to delete category. It has associated books.');
        }

        try {
            $this->categoryModel->delete($id);
            return redirect()->to('/categories')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/categories')->with('error', 'Unable to delete category: ' . $e->getMessage());
        }
    }
}
