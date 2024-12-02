<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Laporan Peminjaman Per Member</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Laporan Peminjaman Per Member
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <form action="<?= base_url('reports/loan-reports-by-member'); ?>" method="get">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="member_id">Pilih Member:</label>
                    <select id="member_id" name="member_id" class="form-control" onchange="updateMemberName()">
                        <option value="">Semua Member</option>
                        <?php foreach ($members as $member): ?>
                            <option value="<?= $member['id']; ?>" <?= $member_id == $member['id'] ? 'selected' : ''; ?>>
                                <?= esc($member['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p id="selected-member" class="mt-2"></p> <!-- Elemen untuk menampilkan nama member -->
                </div>
                <div class="col-md-6 mb-3 mt-3 d-flex align-items-center justify-content-start">
                    <!-- Align the button properly -->
                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php if (!empty($loans)): ?> <!-- Hanya tampilkan tabel jika data pinjaman ditemukan -->
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Data Peminjaman</h4>
    </div>
    <div class="pb-20">
        <table class="table hover nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Kembali</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; foreach ($loans as $loan): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= esc($loan['book_title']); ?></td>
                        <td><?= esc($loan['loan_date']); ?></td>
                        <td><?= isset($loan['return_date']) ? esc($loan['return_date']) : 'Belum Kembali'; ?></td>
                        <td><?= isset($loan['fine_amount']) ? esc($loan['fine_amount']) : 'Tidak Ada'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
    <!-- Menampilkan pesan jika tidak ada data -->
    <p class="text-center">Tidak ada data peminjaman.</p>
<?php endif; ?>

<?= $this-> endSection(); ?>