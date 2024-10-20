<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Tambah/Edit Denda</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/admin/fines">Denda</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah/Edit
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Form Tambah/Edit Denda</h4>
    </div>
    <div class="pb-20">
        <form action="<?= isset($fine) ? '/admin/fines/update/' . esc($fine['id']) : '/admin/fines/store'; ?>" method="post">
            <div class="form-group">
                <label for="loan_id">ID Peminjaman</label>
                <input type="number" name="loan_id" class="form-control" value="<?= isset($fine) ? esc($fine['loan_id']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="fine_amount">Jumlah Denda</label>
                <input type="number" name="fine_amount" class="form-control" value="<?= isset($fine) ? esc($fine['fine_amount']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status Denda</label>
                <select name="status" class="form-control" required>
                    <option value="unpaid" <?= isset($fine) && $fine['status'] === 'unpaid' ? 'selected' : ''; ?>>Unpaid</option>
                    <option value="paid" <?= isset($fine) && $fine['status'] === 'paid' ? 'selected' : ''; ?>>Paid</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
