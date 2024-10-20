<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
        // Get members and books to display in the create view
        $data['members'] = $this->memberModel->findAll();
        $data['books'] = $this->bookModel->findAll();

        return view('loans/create', $data);
    }

    public function store()
    {
        // Get the loan date from the form input
        $loanDate = $this->request->getPost('loan_date');

        // Calculate the due date as one week from the loan date
        $dueDate = date('Y-m-d', strtotime($loanDate . ' +7 days'));

        // Save the loan data
        $this->loanModel->save([
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'loan_date' => $loanDate,
            'due_date' => $dueDate, // Automatically set the due date
        ]);

        // Update the book status to borrowed
        $this->bookModel->update($this->request->getPost('book_id'), [
            'status' => 'borrowed',
        ]);

        return redirect()->to('admin/loans');
    }
    public function returnLoan($id)
    {
        $this->loanModel->update($id, [
            'return_date' => date('Y-m-d'), // Set the return date to today
        ]);
        return redirect()->to('admin/loans')->with('message', 'Buku berhasil dikembalikan.'); // Optional flash message
    }


    // public function edit($id)
    // {
    //     $data['loan'] = $this->loanModel->find($id);
    //     // Get members and books for the edit view
    //     $data['members'] = $this->memberModel->findAll();
    //     $data['books'] = $this->bookModel->findAll();

    //     return view('loans/edit', $data);
    // }

    // public function update($id)
    // {
    //     $this->loanModel->update($id, [
    //         'return_date' => $this->request->getPost('return_date'),
    //     ]);

    //     // Assuming the book ID is retrieved from the loan record
    //     $loan = $this->loanModel->find($id);
    //     $this->bookModel->update($loan['book_id'], [
    //         'status' => 'available',
    //     ]);

    //     return redirect()->to('admin/loans');
    // }

    public function delete($id)
    {
        $loan = $this->loanModel->find($id);
        $this->loanModel->delete($id);

        // Update the book status back to available when the loan is deleted
        if ($loan) {
            $this->bookModel->update($loan['book_id'], [
                'status' => 'available',
            ]);
        }

        return redirect()->to('admin/loans');
    }
}
