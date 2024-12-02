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

        return view('members/detail', [
            'member' => $member,
            'loans' => $loans,
            'reservations' => $reservations,
        ]);
    }

    public function create()
    {
        return view('members/create');
    }

    public function store()
    {
        try {
            // Validate the member input, including uniqueness of no_member
            $validationRules = [
                'photo' => [
                    'label' => 'Photo',
                    'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]|max_size[photo,2048]'  // Max size 2MB, allowed types jpg, jpeg, png
                ],
                'no_member' => [
                    'label' => 'Member Number',
                    'rules' => 'required|is_unique[members.no_member]'  // Ensure no_member is unique
                ]
            ];

            if (!$this->validate($validationRules)) {
                return redirect()->to('/members/create')->withInput()->with('error', $this->validator->getError('photo') ?: $this->validator->getError('no_member'));
            }

            // Process the uploaded photo
            $photo = $this->request->getFile('photo');
            $newPhotoName = null;

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                // Generate unique name for the photo
                $newPhotoName = uniqid('photo_', true) . '.' . $photo->getExtension();

                // Move the file to the public/uploads/members directory
                $photo->move(FCPATH . 'uploads/members', $newPhotoName);
            }

            // Save member data into the database
            $this->memberModel->save([
                'no_member' => $this->request->getPost('no_member'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'membership_date' => $this->request->getPost('membership_date'),
                'photo' => $newPhotoName, // Save photo name in database
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
            // Validate the member input, including uniqueness of no_member
            $validationRules = [
                'photo' => [
                    'label' => 'Photo',
                    'rules' => 'is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]|max_size[photo,2048]'  // Max size 2MB, allowed types jpg, jpeg, png
                ],
                'no_member' => [
                    'label' => 'Member Number',
                    'rules' => 'required|is_unique[members.no_member,id,' . $id . ']'  // Ensure no_member is unique, but allow current member ID to update itself
                ]
            ];

            if (!$this->validate($validationRules)) {
                return redirect()->to("/members/edit/{$id}")->withInput()->with('error', $this->validator->getError('photo') ?: $this->validator->getError('no_member'));
            }

            // Process the uploaded photo
            $photo = $this->request->getFile('photo');
            $existingMember = $this->memberModel->find($id); // Get existing member data

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                // Generate a unique name for the new photo
                $newPhotoName = uniqid('photo_', true) . '.' . $photo->getExtension();

                // Move the file to the public/uploads/members directory
                $photo->move(FCPATH . 'uploads/members', $newPhotoName);

                // Delete the old photo if it exists
                if (!empty($existingMember['photo']) && file_exists(FCPATH . 'uploads/members/' . $existingMember['photo'])) {
                    unlink(FCPATH . 'uploads/members/' . $existingMember['photo']);
                }
            } else {
                // Use the old photo if no new file is uploaded
                $newPhotoName = $existingMember['photo'];
            }

            // Update the member data in the database
            $this->memberModel->update($id, [
                'no_member' => $this->request->getPost('no_member'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'photo' => $newPhotoName, // Update photo
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
