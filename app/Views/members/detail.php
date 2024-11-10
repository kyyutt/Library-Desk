<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Detail Member</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Member
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Informasi Member</h4>
        </div>
    </div>
    
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>No Member:</strong> <?= esc($member['no_member']); ?></li>
        <li class="list-group-item"><strong>Nama:</strong> <?= esc($member['name']); ?></li>
        <li class="list-group-item"><strong>Email:</strong> <?= esc($member['email']); ?></li>
        <li class="list-group-item"><strong>Telepon:</strong> <?= esc($member['phone']); ?></li>
        <li class="list-group-item"><strong>Alamat:</strong> <?= esc($member['address']); ?></li>
        <li class="list-group-item"><strong>Tanggal Bergabung:</strong> <?= esc($member['membership_date']); ?></li>
    </ul>

    <!-- Display related loans (if any) -->
    <?php if (count($loans) > 0): ?>
        <div class="mt-4">
            <h5 class="text-blue">Peminjaman Buku</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td><?= esc($loan['book_title']); ?></td>
                            <td><?= esc($loan['loan_date']); ?></td>
                            <td><?= esc($loan['return_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary mt-4" role="alert">Tidak ada peminjaman buku untuk member ini.
									
								</div>
    <?php endif; ?>

    <!-- Display related reservations (if any) -->
    <?php if (count($reservations) > 0): ?>
        <div class="mt-4">
            <h5 class="text-blue">Reservasi Buku</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Reservasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?= esc($reservation['book_title']); ?></td>
                            <td><?= esc($reservation['reservation_date']); ?></td>
                            <td><?= esc($reservation['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="mt-4">Tidak ada reservasi buku untuk member ini.</p>
    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="<?= base_url('/members'); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
