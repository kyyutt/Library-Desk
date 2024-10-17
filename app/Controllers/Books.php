<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\BooksModel;
use App\Models\CategoriesModel;
class Books extends BaseController
{
    protected $bookModel;
    protected $categoryModel;
    public function __construct()
    {
        $this->bookModel = new BooksModel();
        $this->categoryModel = new CategoriesModel();
    }

    public function index()
    {
        // Ambil semua buku
        $books = $this->bookModel->findAll();

        // Ambil semua kategori
        $categories = $this->categoryModel->findAll();

        // Gabungkan nama kategori dengan buku
        foreach ($books as &$book) {
            $category = array_filter($categories, function ($cat) use ($book) {
                return $cat['id'] == $book['category_id'];
            });
            $book['category'] = !empty($category) ? reset($category)['category_name'] : 'Tidak ada kategori'; // Mengambil nama kategori
        }

        $data['books'] = $books;
        return view('books/index', $data);
    }

    public function create()
    {
        return view('books/create');
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
            'location' => $this->request->getPost('location'),
        ]);
        return redirect()->to('/books');
    }

    public function edit($id)
    {
        $data['book'] = $this->bookModel->find($id);
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
            'location' => $this->request->getPost('location'),
        ]);
        return redirect()->to('/books');
    }

    public function delete($id)
    {
        $this->bookModel->delete($id);
        return redirect()->to('/books');
    }
}
