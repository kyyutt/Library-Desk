<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MembersModel;
use App\Models\LoansModel;
use App\Models\ReservationModel;
use App\Models\BooksModel;

class Members extends BaseController
{
    protected $memberModel;
    protected $loanModel;
    protected $reservationModel;
    protected $bookModel;

    public function __construct()
    {
        $this->memberModel = new MembersModel();
        $this->loanModel = new LoansModel();
        $this->reservationModel = new ReservationModel();
        $this->bookModel = new BooksModel();
    }

    public function index()
    {
        $data['members'] = $this->memberModel->findAll();
        return view('members/index', $data);
    }
    public function detail($id)
    {
        $member = $this->memberModel->find($id);

        if (!$member) {
            return redirect()->to('/members')->with('error', 'Member not found.');
        }

        $reservations = $this->reservationModel
        ->select('reservations.*, books.title AS book_title')
        ->join('books', 'books.id = reservations.book_id')
        ->where('reservations.member_id', $id)
        ->findAll();
        $loans = $this->loanModel
        ->select('loans.*, books.title AS book_title')
        ->join('books', 'books.id = loans.book_id')
        ->where('loans.member_id', $id)
        ->findAll();

    // Pass the member data and reservations to the view
    return view('members/detail', [
        'member' => $member,
        'loans' => $loans,
        'reservations' => $reservations,
    ]);
    }

    public function create()
    {
        $data['no_member'] = $this->memberModel->generateUniqueMemberNumber();
        return view('members/create', $data);
    }

    public function store()
    {
        try {
            $this->memberModel->save([
                'no_member' => $this->request->getPost('no_member'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'membership_date' => $this->request->getPost('membership_date'),
            ]);
            return redirect()->to('/members')->with('success', 'Member added successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/members')->with('error', 'Unable to add member: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['member'] = $this->memberModel->find($id);
        return view('members/edit', $data);
    }

    public function update($id)
    {
        try {
            $this->memberModel->update($id, [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
            ]);
            return redirect()->to('/members')->with('success', 'Member updated successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/members')->with('error', 'Unable to update member: ' . $e->getMessage());
        }
    }

    public function printCard($id)
    {
        $member = $this->memberModel->find($id);

        if (!$member) {
            return redirect()->to('/members')->with('error', 'Member not found.');
        }

        $data['member'] = $member;
        return view('members/printCard', $data);
    }

    public function delete($id)
    {
        if ($this->memberModel->hasRelatedRecords($id)) {
            return redirect()->to('/members')->with('error', 'Unable to delete member. It has associated loans or reservations.');
        }

        try {
            $this->memberModel->delete($id);
            return redirect()->to('/members')->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->to('/members')->with('error', 'Unable to delete member: ' . $e->getMessage());
        }
    }
}
