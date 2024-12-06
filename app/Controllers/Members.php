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
            $validationRules = [
                'photo' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[photo]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]|max_size[photo,2048]' // Maksimal ukuran 2MB, tipe yang diperbolehkan jpg, jpeg, png
                ],
                'no_member' => [
                    'label' => 'Nomor Anggota',
                    'rules' => 'required|is_unique[members.no_member]' // Pastikan no_member unik
                ]
            ];

            // Validasi data yang dimasukkan
            if (!$this->validate($validationRules)) {
                return redirect()->to('/members/create')->withInput()->with('error', $this->validator->getError('photo') ?: $this->validator->getError('no_member'));
            }

            // Proses file foto yang diunggah
            $photo = $this->request->getFile('photo');
            $newPhotoName = null;

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                // Buat nama unik untuk foto
                $newPhotoName = uniqid('photo_', true) . '.' . $photo->getExtension();

                // Pindahkan file ke direktori public/uploads/members
                $photo->move(FCPATH . 'uploads/members', $newPhotoName);
            }

            // Simpan data anggota ke dalam database
            $this->memberModel->save([
                'no_member' => $this->request->getPost('no_member'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'membership_date' => $this->request->getPost('membership_date'),
                'photo' => $newPhotoName, // Simpan nama foto ke dalam database
            ]);

            return redirect()->to('/members')->with('success', 'Anggota berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->to('/members')->with('error', 'Tidak dapat menambahkan anggota: ' . $e->getMessage());
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
            // Validasi input anggota, termasuk keunikan no_member
            $validationRules = [
                'photo' => [
                    'label' => 'Foto',
                    'rules' => 'is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]|max_size[photo,2048]'  // Maksimal ukuran 2MB, tipe yang diperbolehkan jpg, jpeg, png
                ],
                'no_member' => [
                    'label' => 'Nomor Anggota',
                    'rules' => 'required|is_unique[members.no_member,id,' . $id . ']'  // Pastikan no_member unik, tetapi izinkan ID anggota saat ini untuk memperbarui dirinya sendiri
                ]
            ];

            if (!$this->validate($validationRules)) {
                return redirect()->to("/members/edit/{$id}")->withInput()->with('error', $this->validator->getError('photo') ?: $this->validator->getError('no_member'));
            }

            // Pproses foto yang diunggah
            $photo = $this->request->getFile('photo');
            $existingMember = $this->memberModel->find($id); // Ambil data anggota yang ada

            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                // buat nama unik untuk foto baru
                $newPhotoName = uniqid('photo_', true) . '.' . $photo->getExtension();

                // Pindahkan file ke direktori public/uploads/members
                $photo->move(FCPATH . 'uploads/members', $newPhotoName);

                // papus foto lama jika ada
                if (!empty($existingMember['photo']) && file_exists(FCPATH . 'uploads/members/' . $existingMember['photo'])) {
                    unlink(FCPATH . 'uploads/members/' . $existingMember['photo']);
                }
            } else {
                // Gunakan foto lama jika tidak ada file baru yang diunggah
                $newPhotoName = $existingMember['photo'];
            }

            // perbarui data anggota di database
            $this->memberModel->update($id, [
                'no_member' => $this->request->getPost('no_member'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'address' => $this->request->getPost('address'),
                'photo' => $newPhotoName, // Perbarui foto
            ]);

            return redirect()->to('/members')->with('success', 'Anggota berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->to('/members')->with('error', 'Tidak dapat memperbarui anggota: ' . $e->getMessage());
        }
    }


    public function printCard($id)
    {
        $member = $this->memberModel->find($id);

        if (!$member) {
            return redirect()->to('/members')->with('error', 'Member tidak ditemukan.');
        }

        $data['member'] = $member;
        return view('members/printCard', $data);
    }

    public function delete($id)
    {
        // dicek apakah anggota memiliki catatan terkait pinjaman atau reservasi
        if ($this->memberModel->hasRelatedRecords($id)) {
            return redirect()->to('/members')->with('error', 'Tidak dapat menghapus anggota. Anggota ini memiliki pinjaman atau reservasi terkait.');
        }

        try {
            // Hapus anggota dari database
            $this->memberModel->delete($id);
            return redirect()->to('/members')->with('success', 'Anggota berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/members')->with('error', 'Tidak dapat menghapus anggota: ' . $e->getMessage());
        }
    }
}
