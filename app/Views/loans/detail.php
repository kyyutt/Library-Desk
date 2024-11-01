<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Detail Peminjaman</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Peminjaman
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Informasi Peminjaman</h4>
        </div>
    </div>

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Nama Member:</strong> <?= esc($loan['member_name']); ?></li>
        <li class="list-group-item"><strong>Judul Buku:</strong> <?= esc($loan['book_title']); ?></li>
        <li class="list-group-item"><strong>Tanggal Peminjaman:</strong> <?= esc($loan['loan_date']); ?></li>
        <li class="list-group-item"><strong>Tangggal Jatuh Tempo:</strong> <?= esc($loan['due_date']); ?></li>
        <li class="list-group-item"><strong>Tanggal Pengembalian:</strong>
            <?= $loan['return_date'] ? esc($loan['return_date']) : '<span class="badge badge-warning">Belum dikembalikan</span>'; ?>
        </li>
    </ul>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="<?= base_url('/loans'); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>