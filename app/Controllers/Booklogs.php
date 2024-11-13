<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\BookLogsModel;
class Booklogs extends BaseController
{
    protected $bookLogModel;

    public function __construct()
    {
        $this->bookLogModel = new BookLogsModel();
    }

    public function index()
{
        return view('coba/welcome_message');
    }
}
