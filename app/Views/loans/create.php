<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Tambah Peminjaman</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Peminjaman
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Tambah Peminjaman</h4>
            <p class="mb-30">Lengkapi data peminjaman di bawah ini</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('/loans/store'); ?>" method="POST">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="member_id">Anggota</label>
                    <select id="member_id" name="member_id" class="form-control" required>
                        <?php foreach ($members as $member): ?>
                            <option value="<?= $member['id']; ?>"><?= $member['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="book_id">Buku</label>
                    <select id="book_id" name="book_id" class="form-control" required>
                        <?php foreach ($books as $book): ?>
                            <option value="<?= $book['id']; ?>"><?= $book['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="loan_date">Tanggal Peminjaman</label>
                    <input type="date" id="loan_date" name="loan_date" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('/loans'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
