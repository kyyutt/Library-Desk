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

class Laporan extends Controller
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
        return view('coba/welcome_message', $data);
    }

    // Method for Loan Report
    public function loanReports()
    {
        // Fetch loans data with member names, book titles, and fine details
        $data['loans'] = $this->loansModel->getLoansWithDetails();

        // Load the view with the data
        return view('laporan /loan_reports', $data);
    }


    public function memberReports()
    {
        $members = $this->memberModel->findAll();
        foreach ($members as &$member) {
            $membershipDate = strtotime($member['membership_date']);
            $currentDate = time();
            $member['status'] = ($currentDate - $membershipDate > 365 * 24 * 60 * 60) ? 'inactive' : 'active';
        }

        return view('laporan/member_reports', ['members' => $members]);
    }

    // Method untuk export ke Excel
    public function exportMemberToExcel()
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
    public function exportMemberToPdf()
{
    // Fetch members data
    $members = $this->memberModel->findAll();

    // Define the HTML content with inline CSS for member report styling
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Member</title>
        <style>
            /* Member Report styles */
            .member-report-wrap { overflow: auto; }
            .member-report-box { background: #ffffff; width: 800px; margin: 0 auto; padding: 20px; }
            .report-header { padding-bottom: 30px; text-align: center; }
            .report-desc .report-member { width: 25%; float: left; padding: 8px 15px; }
            .report-desc .report-id { width: 15%; float: left; padding: 8px 15px; }
            .report-desc .report-issue, .report-desc .report-return { width: 20%; float: left; padding: 8px 15px; }
            .report-desc .report-status { width: 20%; float: right; padding: 8px 15px; }
            .report-desc .report-desc-head { background: #eaeaea; font-weight: 500; padding: 10px 0; text-align: center; }
            .report-desc .report-desc-body { padding-top: 15px; min-height: 400px; }
            .report-desc .report-desc-body ul li { border-bottom: 1px solid #eaeaea; padding-bottom: 5px; overflow: auto; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #000; padding: 8px; text-align: center; }
            th { background-color: #eaeaea; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="member-report-wrap">
            <div class="member-report-box">
                <div class="report-header">
                    <h4 class="text-center mb-30 weight-600">Laporan Perpustakaan</h4>
                    <h2>Laporan Member</h2>
                </div>
                <div class="report-desc">
                    <div class="report-desc-head">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>';

    // Loop through members and add to the table
    foreach ($members as $index => $member) {
        $html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . htmlspecialchars($member['name']) . '</td>
                    <td>' . htmlspecialchars($member['email']) . '</td>
                    <td>' . htmlspecialchars($member['phone']) . '</td>
                    <td>' . htmlspecialchars($member['address']) . '</td>
                    <td>' . htmlspecialchars($member['membership_date']) . '</td>
                    <td>' . htmlspecialchars($member['status']) . '</td>
                </tr>';
    }

    $html .= '</tbody></table>
                </div>
            </div>
        </div>
    </body>
    </html>';

    // Initialize DomPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    // Load HTML content into DomPDF
    $dompdf->loadHtml($html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render PDF
    $dompdf->render();

    // Stream the PDF to the browser
    $dompdf->stream('laporan_member.pdf', ['Attachment' => 0]);
}

}
