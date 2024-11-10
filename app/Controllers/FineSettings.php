<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FineSettingsModel;

class FineSettings extends BaseController
{
    protected $fineSettingsModel;

    public function __construct()
    {
        $this->fineSettingsModel = new FineSettingsModel();
    }

    public function index()
    {
        $data['fineSettings'] = $this->fineSettingsModel->findAll();
        return view('finesettings/index', $data);
    }

    public function create()
    {
        return view('finesettings/create');
    }

    public function store()
    {
        $this->fineSettingsModel->save([
            'fine_per_day' => $this->request->getPost('fine_per_day'),
            'is_active' => 0,  // New settings start as inactive
        ]);

        return redirect()->to('/finesettings')->with('success', 'Fine setting created successfully.');
    }

    public function activate($id)
    {
        // First, deactivate all settings
        $this->fineSettingsModel->update(['is_active' => 1], ['is_active' => 0]);

        // Then, activate the selected setting
        $this->fineSettingsModel->update($id, ['is_active' => 1]);

        return redirect()->to('/finesettings')->with('success', 'Fine setting activated successfully.');
    }
}
