<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EbookModel;
use App\Models\CategoriesModel;

class Ebooks extends BaseController
{
    protected $ebookModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->ebookModel = new EbookModel();
        $this->categoryModel = new CategoriesModel();
    }

    // Menampilkan daftar ebook
    public function index()
{
    $ebooks = $this->ebookModel->findAll();

    $categories = $this->categoryModel->findAll();

    foreach ($ebooks as &$ebook) {
        $category = array_filter($categories, function ($cat) use ($ebook) {
            return $cat['id'] == $ebook['category_id'];
        });
        $ebook['category'] = !empty($category) ? reset($category)['category_name'] : 'Tidak ada kategori';
    }

    $data['ebooks'] = $ebooks; 
    return view('ebooks/index', $data);
}


    // Menampilkan form untuk menambah ebook
    public function create()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('ebooks/create', $data);
    }

    // Proses penyimpanan data ebook
    public function store()
    {
        $file = $this->request->getFile('file');
    
        // Validasi file
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau tidak ditemukan.');
        }
    
        // Tetapkan batas ukuran file (contoh: 2MB)
        $maxSize = 2 * 1024 * 1024; // 2MB
        if ($file->getSize() > $maxSize) {
            return redirect()->back()->with('error', 'File terlalu besar. Maksimal 2MB.');
        }
    
        // Tetapkan folder upload
        $uploadPath = 'uploads/ebooks/';
        $newName = $file->getRandomName();
    
        // Pindahkan file ke folder tujuan
        if ($file->move($uploadPath, $newName)) {
            // Simpan data ebook ke database (hanya menyimpan nama file, bukan path lengkap)
            $this->ebookModel->save([
                'title' => $this->request->getPost('title'),
                'author' => $this->request->getPost('author'),
                'publisher' => $this->request->getPost('publisher'),
                'year_of_publication' => $this->request->getPost('year_of_publication'),
                'isbn' => $this->request->getPost('isbn'),
                'description' => $this->request->getPost('description'),
                'category_id' => $this->request->getPost('category_id'),
                'file_name' => $newName, // Simpan hanya nama file
                'file_size' => $file->getSize(),
                'status' => 'available',
            ]);
    
            return redirect()->to('/ebooks')->with('success', 'Ebook berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengunggah file.');
        }
    }
    

    // Menampilkan form untuk mengedit ebook
    public function edit($id)
    {
        $data['ebook'] = $this->ebookModel->find($id);
        $data['categories'] = $this->categoryModel->findAll();

        if (!$data['ebook']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Ebook dengan ID $id tidak ditemukan.");
        }

        return view('ebooks/edit', $data);
    }

    // Proses penyimpanan perubahan data ebook
    public function update($id)
{
    $file = $this->request->getFile('file');
    $ebook = $this->ebookModel->find($id);

    if (!$ebook) {
        return redirect()->back()->with('error', 'Ebook tidak ditemukan.');
    }

    // File lama (untuk dihapus jika ada file baru)
    $filePath = 'uploads/ebooks/' . $ebook['file_name'];

    if ($file && $file->isValid()) {
        // Tetapkan batas ukuran file
        $maxSize = 2 * 1024 * 1024; // 2MB
        if ($file->getSize() > $maxSize) {
            return redirect()->back()->with('error', 'File terlalu besar. Maksimal 2MB.');
        }

        // Hapus file lama jika ada file baru
        if (file_exists($filePath)) {
            unlink($filePath); // Menghapus file lama
        }

        // Upload file baru
        $uploadPath = 'public/uploads/ebooks/';
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        // Update file path untuk file yang baru
        $filePath = $newName;
    }

    // Simpan perubahan data ke database (update nama file, bukan path lengkap)
    $this->ebookModel->update($id, [
        'title' => $this->request->getPost('title'),
        'author' => $this->request->getPost('author'),
        'publisher' => $this->request->getPost('publisher'),
        'year_of_publication' => $this->request->getPost('year_of_publication'),
        'isbn' => $this->request->getPost('isbn'),
        'description' => $this->request->getPost('description'),
        'category_id' => $this->request->getPost('category_id'),
        'file_name' => $filePath, // Simpan nama file baru
        'file_size' => $file->getSize(),
        'status' => $this->request->getPost('status'),
    ]);

    return redirect()->to('/ebooks')->with('success', 'Ebook berhasil diperbarui.');
}
public function delete($id)
{
    $ebook = $this->ebookModel->find($id);
    
    if (!$ebook) {
        return redirect()->back()->with('error', 'Ebook tidak ditemukan.');
    }

    // Delete the file from the file system
    if (file_exists($ebook['file_name'])) {
        unlink($ebook['file_name']);
    }

    // Delete the record from the database
    $this->ebookModel->delete($id);

    return redirect()->to('/ebooks')->with('success', 'Ebook berhasil dihapus.');
}

}
