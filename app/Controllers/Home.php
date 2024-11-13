<?php

namespace App\Controllers;

use App\Models\BooksModel;
use App\Models\LoansModel;
use App\Models\MembersModel;
use App\Models\ReservationModel;

class Home extends BaseController
{
    protected $booksModel;
    protected $loansModel;
    protected $membersModel;
    protected $reservationModel;

    public function __construct()
    {
        $this->booksModel = new BooksModel();
        $this->loansModel = new LoansModel();
        $this->membersModel = new MembersModel();
        $this->reservationModel = new ReservationModel();
    }

    public function index()
    {
        // Total counts
        $totalBooks = $this->booksModel->countAllResults();
        $booksOnLoan = $this->loansModel->where('status', 'On Loan')->countAllResults();
        $overdueBooks = $this->loansModel->where('status', 'Overdue')->countAllResults();
        $totalMembers = $this->membersModel->countAllResults();

        // Initialize arrays with 0 for each month (for monthly data)
        $loanData = array_fill(0, 12, 0);
        $reservationData = array_fill(0, 12, 0);

        // Fetch loans and group by month
        $loans = $this->loansModel->select("MONTH(loan_date) as month, COUNT(*) as count")
                                  ->groupBy("MONTH(loan_date)")
                                  ->findAll();

        // Assign the count to the appropriate month index for loans
        foreach ($loans as $loan) {
            $loanData[$loan['month'] - 1] = $loan['count']; // Zero-based index
        }

        // Fetch reservations and group by month
        $reservations = $this->reservationModel->select("MONTH(reservation_date) as month, COUNT(*) as count")
                                               ->groupBy("MONTH(reservation_date)")
                                               ->findAll();

        // Assign the count to the appropriate month index for reservations
        foreach ($reservations as $reservation) {
            $reservationData[$reservation['month'] - 1] = $reservation['count']; // Zero-based index
        }

        // Define month names for the x-axis categories
        $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $members = $this->membersModel->table('members')  // Nama tabel sesuai dengan yang ada di database kamu
        ->orderBy('membership_date', 'DESC')  // Urutkan berdasarkan tanggal terbaru
        ->limit(5)  // Batasi hanya 5 data
        ->get()
        ->getResultArray(); 

        $books = $this->booksModel->table('books')
        ->limit(4)
        ->get()
        ->getResultArray();

        // Pass all data to the view
        return view('dashboard', [
            'totalBooks' => $totalBooks,
            'booksOnLoan' => $booksOnLoan,
            'overdueBooks' => $overdueBooks,
            'totalMembers' => $totalMembers,
            'loanData' => $loanData,
            'reservationData' => $reservationData,
            'categories' => $categories,
            'members' => $members,
            'books' => $books
        ]);
    }
}
