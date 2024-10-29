<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Tambah Reservasi</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Reservasi
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Tambah Reservasi</h4>
            <p class="mb-30">Lengkapi data reservasi di bawah ini</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('admin/reservations/store'); ?>" method="POST">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="member_id">Anggota</label>
                    <select id="member_id" name="member_id" class="form-control" required>
                        <?php foreach ($availableMembers as $member): ?>
                            <option value="<?= $member['id']; ?>"><?= $member['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="book_id">Buku yang Sedang Dipinjam</label>
                    <select id="book_id" name="book_id" class="form-control" required>
                        <?php foreach ($activeLoans as $loan): ?>
                            <option value="<?= $loan['book_id']; ?>"><?= $loan['book_title']; ?> (Dipinjam oleh <?= $loan['member_name']; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="reservation_date">Tanggal Reservasi</label>
                    <input type="date" id="reservation_date" name="reservation_date" class="form-control" value="<?= date('Y-m-d'); ?>" disabled>
                    <!-- Hidden field to submit reservation_date -->
                    <input type="hidden" name="reservation_date" value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/reservations'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
