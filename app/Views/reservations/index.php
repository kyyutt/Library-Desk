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
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> <?= session()->getFlashdata('success'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Error Alert -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> <?= session()->getFlashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
    <div class="pb-20">
        <table class="checkbox-datatable table nowrap">
            <thead>
                <tr>
                <th>
                        <div class="dt-checkbox">
                            <input type="checkbox" name="select_all" value="1" id="example-select-all" />
                            <span class="dt-checkbox-label"></span>
                        </div>
                    </th>
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
                    <td>
                            <div class="dt-checkbox">
                                <input type="checkbox" name="reservation_ids[]" value="<?= esc($reservation['id']); ?>" id="reservation-<?= esc($reservation['id']); ?>" />
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </td>
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
