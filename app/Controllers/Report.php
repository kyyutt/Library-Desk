<?php

namespace App\Controllers;

use App\Models\BookLogsModel;
use App\Models\LoansModel;
use App\Models\MembersModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class Report extends Controller
{
    protected $bookLogsModel;
    protected $loansModel;
    protected $memberModel;

    public function __construct()
    {
        // Initialize models
        $this->bookLogsModel = new BookLogsModel();
        $this->loansModel = new LoansModel();
        $this->memberModel = new MembersModel();
    }

    // Method for Book Logs report
    public function bookLogs()
    {
        // Fetch book logs data
        $data['bookLogs'] = $this->bookLogsModel->getLogsWithDetails(); // Assuming the method in BookLogsModel is updated with join queries

        // Load the view with the data
        return view('reports/book_logs', $data);
    }

    // Method for Loan Report
    public function loanReports()
    {
        // Fetch loans data
        $data['loans'] = $this->loansModel->findAll();

        // Load the view with the data
        return view('reports/loan_reports', $data);
    }

   
    public function memberReports()
    {
        $members = $this->memberModel->findAll();
        foreach ($members as &$member) {
            $membershipDate = strtotime($member['membership_date']);
            $currentDate = time();
            $member['status'] = ($currentDate - $membershipDate > 365 * 24 * 60 * 60) ? 'inactive' : 'active';
        }

        return view('reports/member_reports', ['members' => $members]);
    }

    // Method untuk export ke Excel
    public function exportToExcel()
    {
        $members = $this->memberModel->findAll();
        
        // Membuat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Menambahkan header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Nomor Telepon');
        $sheet->setCellValue('E1', 'Alamat');
        $sheet->setCellValue('F1', 'Tanggal Bergabung');
        $sheet->setCellValue('G1', 'Status');

        // Mengisi baris dengan data member
        $rowNum = 2;
        foreach ($members as $index => $member) {
            $sheet->setCellValue('A' . $rowNum, $index + 1);
            $sheet->setCellValue('B' . $rowNum, $member['name']);
            $sheet->setCellValue('C' . $rowNum, $member['email']);
            $sheet->setCellValue('D' . $rowNum, $member['phone']);
            $sheet->setCellValue('E' . $rowNum, $member['address']);
            $sheet->setCellValue('F' . $rowNum, $member['membership_date']);
            $sheet->setCellValue('G' . $rowNum, $member['status']);
            $rowNum++;
        }

        // Menulis ke file output
        $writer = new Xlsx($spreadsheet);
        
        // Set response header untuk mendownload file
        return $this->response->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                               ->setHeader('Content-Disposition', 'attachment; filename="members_report.xlsx"')
                               ->setBody($writer->save('php://output'));
    }
    public function exportToPdf()
    {
        // Fetch members data
        $members = $this->memberModel->findAll();
        
        // Load the HTML content for the PDF
        $html = '<h1 style="text-align:center">Laporan Perpustakaan</h1>';
        $html .= '<h2 style="text-align:center">Laporan Member</h2>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">';
        $html .= '<thead><tr><th>No</th><th>Nama</th><th>Email</th><th>Nomor Telepon</th><th>Alamat</th><th>Tanggal Bergabung</th><th>Status</th></tr></thead>';
        $html .= '<tbody>';

        // Loop through members and add to the table
        foreach ($members as $index => $member) {
            $html .= '<tr>';
            $html .= '<td>' . ($index + 1) . '</td>';
            $html .= '<td>' . $member['name'] . '</td>';
            $html .= '<td>' . $member['email'] . '</td>';
            $html .= '<td>' . $member['phone'] . '</td>';
            $html .= '<td>' . $member['address'] . '</td>';
            $html .= '<td>' . $member['membership_date'] . '</td>';
            $html .= '<td>' . $member['status'] . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Initialize DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Load HTML content into DomPDF
        $dompdf->loadHtml($html);
        
        // Set paper size (A4 is default)
        $dompdf->setPaper('A4', 'portrait');
        
        // Render PDF (first pass)
        $dompdf->render();
        
        // Stream the PDF to the browser
        $dompdf->stream('laporan_member.pdf', ['Attachment' => 0]); // Set Attachment to 1 if you want to force download
    }
}




