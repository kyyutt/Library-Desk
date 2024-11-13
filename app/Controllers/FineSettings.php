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
        try {
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
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            log_message('error', 'Error toggling fine setting: ' . $e->getMessage());

            // Redirect back with an error message for the user
            return redirect()->to('/finesettings')->with('error', 'Failed to toggle fine setting. Please try again.');
        }
    }

    public function create()
    {
        return view('finesettings/create');
    }

    public function store()
    {
        try {
            // Save fine setting to the database
            $this->fineSettingsModel->save([
                'fine_per_day' => $this->request->getPost('fine_per_day'),
                'is_active' => 0  // Default to inactive
            ]);

            // Success message
            return redirect()->to('/finesettings')->with('success', 'Fine setting added successfully.');
        } catch (\Exception $e) {
            // Log the error if needed
            log_message('error', 'Error saving fine setting: ' . $e->getMessage());

            // Error message for the user
            return redirect()->back()->with('error', 'Failed to add fine setting. Please try again.');
        }
    }
}
