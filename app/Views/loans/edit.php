<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Edit Peminjaman</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Peminjaman
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Edit Peminjaman</h4>
            <p class="mb-30">Ubah data peminjaman di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('admin/loans/update/' . esc($loan['id'])); ?>" method="POST">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="member_id">Anggota</label>
                    <select class="form-control" id="member_id" name="member_id" required>
                        <?php foreach ($members as $member): ?>
                            <option value="<?= esc($member['id']); ?>" <?= $member['id'] == $loan['member_id'] ? 'selected' : ''; ?>>
                                <?= esc($member['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="book_id">Buku</label>
                    <select class="form-control" id="book_id" name="book_id" required>
                        <?php foreach ($books as $book): ?>
                            <option value="<?= esc($book['id']); ?>" <?= $book['id'] == $loan['book_id'] ? 'selected' : ''; ?>>
                                <?= esc($book['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="loan_date">Tanggal Peminjaman</label>
                    <input type="date" id="loan_date" name="loan_date" class="form-control" value="<?= esc($loan['loan_date']); ?>" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="due_date">Tanggal Jatuh Tempo</label>
                    <input type="date" id="due_date" name="due_date" class="form-control" value="<?= esc($loan['due_date']); ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="return_date">Tanggal Pengembalian</label>
                    <input type="date" id="return_date" name="return_date" class="form-control" value="<?= esc($loan['return_date']); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" onclick="history.back();">Kembali</button>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
