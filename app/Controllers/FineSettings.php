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

    public function toggleActiveStatus($id)
{
    // Get the current status of the setting
    $currentStatus = $this->fineSettingsModel->find($id)['is_active'];

    // Check if there's already an active setting (status 1)
    $activeSetting = $this->fineSettingsModel->where('is_active', 1)->first();

    if ($currentStatus == 1) {
        // If the setting is already active, deactivate it
        $this->fineSettingsModel->update($id, ['is_active' => 0]);
        return redirect()->to('/finesettings')->with('success', 'Fine setting deactivated successfully.');
    }

    // If another setting is active, show an error message
    if ($activeSetting) {
        // Error: There is already an active setting
        return redirect()->to('/finesettings')->with('error', 'Another fine setting is already active. Please deactivate it first.');
    }

    // Otherwise, activate the setting and deactivate any other active setting
    $this->fineSettingsModel->update($id, ['is_active' => 1]);
    return redirect()->to('/finesettings')->with('success', 'Fine setting activated successfully.');
}

}
