<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Data Reservasi</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Reservasi
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="<?= base_url('/reservations/create'); ?>" class="btn btn-primary">Tambah Reservasi</a>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Daftar Reservasi</h4>
    </div>
    <div class="pb-20">
        <table class="checkbox-datatable table nowrap">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Nama Anggota</th>
                    <th>Tanggal Reservasi</th>
                    <th>Status</th>
                    <th class="datatable-nosort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td><?= esc($reservation['book_title']); ?></td>
                        <td><?= esc($reservation['member_name']); ?></td>
                        <td><?= esc($reservation['reservation_date']); ?></td>
                        <td>
                            <span class="badge rounded-pill text-white 
        <?= $reservation['status'] == 'active' ? 'bg-warning' : ($reservation['status'] == 'completed' ? 'bg-success' : 'bg-danger'); ?>">
                                <?= esc(ucfirst($reservation['status'])); ?>
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <?php if ($reservation['status'] == 'active'): ?>
                                    <!-- Complete action -->
                                    <a href="<?= base_url('/reservations/complete/' . esc($reservation['id'])); ?>" title="Complete Reservation">
                                        <i class="icon-copy ion-checkmark-round text-success"></i>
                                    </a>
                                    <!-- Cancel action -->
                                    <a href="<?= base_url('/reservations/cancel/' . esc($reservation['id'])); ?>" title="Cancel Reservation">
                                        <i class="icon-copy ion-close-round text-danger"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>
