<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\ReservationModel;
class Reservation extends BaseController
{
    protected $reservationModel;

    public function __construct()
    {
        $this->reservationModel = new ReservationModel();
    }

    public function index()
    {
        $data['reservations'] = $this->reservationModel->findAll();
        return view('reservations/index', $data);
    }

    public function create()
    {
        return view('reservations/create');
    }

    public function store()
    {
        $this->reservationModel->save([
            'member_id' => $this->request->getPost('member_id'),
            'book_id' => $this->request->getPost('book_id'),
            'reservation_date' => $this->request->getPost('reservation_date'),
        ]);
        return redirect()->to('/reservations');
    }

    public function edit($id)
    {
        $data['reservation'] = $this->reservationModel->find($id);
        return view('reservations/edit', $data);
    }

    public function update($id)
    {
        $this->reservationModel->update($id, [
            'status' => $this->request->getPost('status'),
        ]);
        return redirect()->to('/reservations');
    }

    public function delete($id)
    {
        $this->reservationModel->delete($id);
        return redirect()->to('/reservations');
    }
}
