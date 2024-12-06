<?php

namespace App\Controllers;

use App\Models\BookLogsModel;
use App\Models\LoansModel;
use App\Models\MembersModel;
use CodeIgniter\Controller;

class Laporan extends Controller
{
    protected $loansModel;
    protected $memberModel;

    public function __construct()
    {
        $this->loansModel = new LoansModel();
        $this->memberModel = new MembersModel();
    }

    public function loanReports()
    {
        // Ambil parameter tanggal dari GET request
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Kirim data tanggal ke view
        $data = [
            'start_date' => $startDate,
            'end_date'   => $endDate
        ];

        // Jika filter tanggal diberikan, gunakan filter tersebut, jika tidak ambil semua data
        if ($startDate && $endDate) {
            // Filter berdasarkan tanggal
            $data['loans'] = $this->loansModel->getLoansWithDetailsFiltered($startDate, $endDate);
        } else {
            // Jika tidak ada filter, ambil semua data
            $data['loans'] = $this->loansModel->getLoansWithDetails();
        }

        return view('laporan/loan_reports', $data);
    }



    public function memberReports()
    {
        $members = $this->memberModel->findAll();

        return view('laporan/member_reports', ['members' => $members]);
    }
    public function loanReportsByMember()
    {
        $members = $this->memberModel->findAll();

        // Ambil member_id yang dipilih dari request
        $member_id = $this->request->getVar('member_id');

        // Jika member_id dipilih, ambil data pinjaman untuk member tersebut
        if ($member_id) {
            $loans = $this->loansModel->getLoansByMember($member_id);
        } else {
            // Jika tidak ada member_id yang dipilih, tampilkan semua pinjaman
            $loans = $this->loansModel->getLoansWithDetails();
        }

        return view('laporan/loan_reports_by_member', [
            'members' => $members,
            'loans' => $loans,
            'member_id' => $member_id,
        ]);
    }
}
