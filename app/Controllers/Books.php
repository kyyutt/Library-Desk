<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BooksModel;
use App\Models\CategoriesModel;
use App\Models\RacksModel;

class Books extends BaseController
{
    protected $bookModel;
    protected $categoryModel;
    protected $rackModel;

    public function __construct()
    {
        $this->bookModel = new BooksModel();
        $this->categoryModel = new CategoriesModel();
        $this->rackModel = new RacksModel();
    }

    public function index()
{
    // Ambil semua buku
    $books = $this->bookModel->findAll();

    // Ambil semua kategori
    $categories = $this->categoryModel->findAll();

    // Ambil semua rak
    $racks = $this->rackModel->findAll();

    // Gabungkan nama kategori dan rak dengan buku
    foreach ($books as &$book) {
        // Mendapatkan kategori
        $category = array_filter($categories, function ($cat) use ($book) {
            return $cat['id'] == $book['category_id'];
        });
        $book['category'] = !empty($category) ? reset($category)['category_name'] : 'Tidak ada kategori';

        // Mendapatkan rak
        $rack = array_filter($racks, function ($rack) use ($book) {
            return $rack['id'] == $book['rack_id'];
        });
        $book['rack'] = !empty($rack) ? reset($rack)['rack_number'] : 'Tidak ada rak';
    }

    $data['books'] = $books;
    return view('books/index', $data);
}


    public function create()
    {
        // Ambil semua kategori untuk ditampilkan di form
        $data['categories'] = $this->categoryModel->findAll();
        $data['racks'] = $this->rackModel->findAll();
        return view('books/create', $data);
    }

    public function store()
    {
        $this->bookModel->save([
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'publisher' => $this->request->getPost('publisher'),
            'year' => $this->request->getPost('year'),
            'isbn' => $this->request->getPost('isbn'),
            'category_id' => $this->request->getPost('category_id'),
            'rack_id' => $this->request->getPost('rack_id')
        ]);
        return redirect()->to('admin/books');
    }

    public function detail($id) {
        $book = $this->bookModel->find($id);
        
        if (!$book) {
            return redirect()->to('admin/books')->with('error', 'Buku tidak ditemukan.');
        }
        
        $category = $this->categoryModel->find($book['category_id']);
        $book['category'] = $category ? $category['category_name'] : 'Tidak ada kategori';
        
        $rack = $this->rackModel->find($book['rack_id']);
        $book['rack'] = $rack && isset($rack['rack_number']) ? $rack['rack_number'] : 'Tidak ada rak';
    
        return view('books/detail', [
            'book' => $book, 
            'category' => $book['category'], 
            'rack' => $book['rack']
        ]);
    }
    
    public function edit($id)
    {
        // Ambil data buku dan kategori untuk ditampilkan di form
        $data['book'] = $this->bookModel->find($id);
        $data['categories'] = $this->categoryModel->findAll();
        $data['racks'] = $this->rackModel->findAll();
        return view('books/edit', $data);
    }

    public function update($id)
    {
        $this->bookModel->update($id, [
            'title' => $this->request->getPost('title'),
            'author' => $this->request->getPost('author'),
            'publisher' => $this->request->getPost('publisher'),
            'year' => $this->request->getPost('year'),
            'isbn' => $this->request->getPost('isbn'),
            'category_id' => $this->request->getPost('category_id'),
            'rack_id' => $this->request->getPost('rack_id')
        ]);
        return redirect()->to('admin/books');
    }

    public function delete($id)
    {
        $this->bookModel->delete($id);
        return redirect()->to('admin/books');
    }
}
