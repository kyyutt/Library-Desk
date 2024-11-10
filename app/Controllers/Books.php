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
        $books = $this->bookModel->findAll();

        $categories = $this->categoryModel->findAll();

        $racks = $this->rackModel->findAll();

        foreach ($books as &$book) {
            $category = array_filter($categories, function ($cat) use ($book) {
                return $cat['id'] == $book['category_id'];
            });
            $book['category'] = !empty($category) ? reset($category)['category_name'] : 'Tidak ada kategori';

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
        $data['categories'] = $this->categoryModel->findAll();
        $data['racks'] = $this->rackModel->findAll();
        return view('books/create', $data);
    }

    public function store()
    {
        try {
            $this->bookModel->save([
                'title' => $this->request->getPost('title'),
                'author' => $this->request->getPost('author'),
                'publisher' => $this->request->getPost('publisher'),
                'year' => $this->request->getPost('year'),
                'isbn' => $this->request->getPost('isbn'),
                'category_id' => $this->request->getPost('category_id'),
                'rack_id' => $this->request->getPost('rack_id')
            ]);
            return redirect()->to('/books')->with('success', 'Book added successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/books/create')->with('error', 'Unable to add book: ' . $e->getMessage());
        }
    }

    public function detail($id)
    {
        $book = $this->bookModel->find($id);

        if (!$book) {
            return redirect()->to('/books')->with('error', 'Buku tidak ditemukan.');
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
        $data['book'] = $this->bookModel->find($id);
        $data['categories'] = $this->categoryModel->findAll();
        $data['racks'] = $this->rackModel->findAll();
        return view('books/edit', $data);
    }

    public function update($id)
    {
        try {
            $this->bookModel->update($id, [
                'title' => $this->request->getPost('title'),
                'author' => $this->request->getPost('author'),
                'publisher' => $this->request->getPost('publisher'),
                'year' => $this->request->getPost('year'),
                'isbn' => $this->request->getPost('isbn'),
                'category_id' => $this->request->getPost('category_id'),
                'rack_id' => $this->request->getPost('rack_id')
            ]);
            return redirect()->to('/books')->with('success', 'Book updated successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/books/edit/' . $id)->with('error', 'Unable to update book: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        if ($this->bookModel->hasRelatedRecords($id)) {
            return redirect()->to('/books')->with('error', 'Unable to delete book. It has associated loans or reservations.');
        }

        try {
            $this->bookModel->delete($id);
            return redirect()->to('/books')->with('success', 'Book deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/books')->with('error', 'Unable to delete book: ' . $e->getMessage());
        }
    }
}
