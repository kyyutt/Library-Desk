<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\LoansModel;
use App\Models\MembersModel;
use App\Models\BooksModel;

class Loans extends BaseController
{
    protected $loanModel;
    protected $memberModel;
    protected $bookModel;

    public function __construct()
    {
        $this->loanModel = new LoansModel();
        $this->memberModel = new MembersModel();
        $this->bookModel = new BooksModel();
    }

    public function index()
    {
        $loans = $this->loanModel->findAll();
        $members = $this->memberModel->findAll();
        $books = $this->bookModel->findAll();

        foreach ($loans as &$loan) {
            // Find the corresponding member
            $member = array_filter($members, function ($m) use ($loan) {
                return $m['id'] === $loan['member_id'];
            });
            $loan['member_name'] = !empty($member) ? reset($member)['name'] : 'Tidak ada anggota';

            // Find the corresponding book
            $book = array_filter($books, function ($b) use ($loan) {
                return $b['id'] === $loan['book_id'];
            });
            $loan['book_title'] = !empty($book) ? reset($book)['title'] : 'Tidak ada buku';
        }

        // Prepare the data for the view
        $data['loans'] = $loans; // Pass the modified loans array to the view
        return view('loans/index', $data); // Make sure the view is named correctly
    }

    public function create()
    {
        return view('loans/create');
    }

    public function store()
    {
        $this->loanModel->save([
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'loan_date' => $this->request->getPost('loan_date'),
            'due_date' => $this->request->getPost('due_date'),
        ]);
        return redirect()->to('/loans');
    }

    public function edit($id)
    {
        $data['loan'] = $this->loanModel->find($id);
        return view('loans/edit', $data);
    }

    public function update($id)
    {
        $this->loanModel->update($id, [
            'return_date' => $this->request->getPost('return_date'),
        ]);
        return redirect()->to('/loans');
    }

    public function delete($id)
    {
        $this->loanModel->delete($id);
        return redirect()->to('/loans');
    }
}
