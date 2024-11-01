<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Edit Reservasi</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/reservations'); ?>">Data Reservasi</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Reservasi
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Form Edit Reservasi</h4>
    </div>
    <div class="pb-20">
        <form action="<?= base_url('/reservations/update/' . esc($reservation['id'])); ?>" method="POST">
            <div class="form-group">
                <label for="book_id">Judul Buku</label>
                <select name="book_id" id="book_id" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php foreach ($books as $book): ?>
                        <option value="<?= esc($book['id']); ?>" <?= $book['id'] == $reservation['book_id'] ? 'selected' : ''; ?>>
                            <?= esc($book['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="member_id">Nama Anggota</label>
                <select name="member_id" id="member_id" class="form-control" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php foreach ($members as $member): ?>
                        <option value="<?= esc($member['id']); ?>" <?= $member['id'] == $reservation['member_id'] ? 'selected' : ''; ?>>
                            <?= esc($member['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="reservation_date">Tanggal Reservasi</label>
                <input type="date" name="reservation_date" id="reservation_date" class="form-control" value="<?= esc($reservation['reservation_date']); ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="active" <?= $reservation['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="completed" <?= $reservation['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Reservasi</button>
            <a href="<?= base_url('/reservations'); ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
