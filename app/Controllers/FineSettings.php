<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FineSettingsModel;

class FineSettings extends BaseController
{
    protected $fineSettingsModel;

    public function __construct()
    {
        // Inisialisasi model untuk pengaturan denda
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
            // Mendapatkan status aktif saat ini dari pengaturan
            $currentStatus = $this->fineSettingsModel->find($id)['is_active'];

            // Mengecek apakah sudah ada pengaturan yang aktif (status 1)
            $activeSetting = $this->fineSettingsModel->where('is_active', 1)->first();

            if ($currentStatus == 1) {
                // Jika pengaturan sudah aktif, ubah menjadi tidak aktif
                $this->fineSettingsModel->update($id, ['is_active' => 0]);
                return redirect()->to('/finesettings')->with('success', 'Pengaturan denda berhasil dinonaktifkan.');
            }

            // Jika ada pengaturan lain yang aktif, tampilkan pesan kesalahan
            if ($activeSetting) {
                // Kesalahan: Sudah ada pengaturan yang aktif
                return redirect()->to('/finesettings')->with('error', 'Pengaturan denda lainnya sudah aktif. Nonaktifkan terlebih dahulu.');
            }

            // Jika tidak ada pengaturan lain yang aktif, aktifkan pengaturan ini
            $this->fineSettingsModel->update($id, ['is_active' => 1]);
            return redirect()->to('/finesettings')->with('success', 'Pengaturan denda berhasil diaktifkan.');
        } catch (\Exception $e) {
            // Log error untuk tujuan debugging
            log_message('error', 'Kesalahan saat mengubah status pengaturan denda: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan untuk pengguna
            return redirect()->to('/finesettings')->with('error', 'Gagal mengubah status pengaturan denda. Silakan coba lagi.');
        }
    }

    public function create()
    {
        // Menampilkan halaman untuk menambahkan pengaturan denda baru
        return view('finesettings/create');
    }

    public function store()
    {
        try {
            // Menyimpan pengaturan denda ke dalam database
            $this->fineSettingsModel->save([
                'fine_per_day' => $this->request->getPost('fine_per_day'),
                'is_active' => 0  // Default tidak aktif
            ]);

            // Pesan sukses
            return redirect()->to('/finesettings')->with('success', 'Pengaturan denda berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Log error jika diperlukan
            log_message('error', 'Kesalahan saat menyimpan pengaturan denda: ' . $e->getMessage());

            // Pesan kesalahan untuk pengguna
            return redirect()->back()->with('error', 'Gagal menambahkan pengaturan denda. Silakan coba lagi.');
        }
    }
}
