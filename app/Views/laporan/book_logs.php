<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Log Aktivitas Buku</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Log Aktivitas Buku
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Daftar Log Aktivitas Buku</h4>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Buku</th>
                <th>Admin</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($bookLogs as $log): ?>
                <tr>
                    <td><?= esc($no++); ?></td>
                    <td><?= esc($log['book_id']); ?></td> <!-- Book ID, you can join with book data if necessary -->
                    <td><?= esc($log['admin_id']); ?></td> <!-- Admin ID, join with admin data if needed -->
                    <td><?= esc($log['date']); ?></td>
                    <td><?= esc($log['action']); ?></td>
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
