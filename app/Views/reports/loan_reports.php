<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Laporan Peminjaman</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Laporan Peminjaman
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Daftar Peminjaman</h4>
        </div>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Member</th>
                <th>Judul Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Jatuh Tempo</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
                <th>Status Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($loans as $loan): ?>
                <tr>
                <td><?= esc($no++); ?></td>
<td><?= esc($loan['member_name']); ?></td>
<td><?= esc($loan['book_title']); ?></td>
<td><?= esc($loan['loan_date']); ?></td>
<td><?= esc($loan['due_date']); ?></td>
<td><?= isset($loan['return_date']) ? esc($loan['return_date']) : 'Belum dikembalikan'; ?></td>
<td><?= isset($loan['fine_amount']) ? esc($loan['fine_amount']) : 'Tidak ada'; ?></td>
<td><?= isset($loan['fine_status']) ? esc($loan['fine_status']) : 'Tidak ada'; ?></td>
<td><?= esc($loan['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="<?= base_url('/dashboard'); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
