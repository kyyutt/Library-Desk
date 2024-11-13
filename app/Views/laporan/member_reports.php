<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Laporan Member</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Laporan Member
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
    <a href="<?= base_url('member-reports/export-excel'); ?>" class="btn btn-success">
        <i class="icon-copy fa fa-file-excel-o" aria-hidden="true"></i> Export to Excel
    </a>
    <a href="<?= base_url('member-reports/export-pdf'); ?>" class="btn btn-primary">
        <i class="icon-copy fa fa-file-pdf-o" aria-hidden="true"></i> Export to PDF
    </a>
</div>

    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Daftar Member</h4>
    </div>

    <!-- Success Alert -->
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
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Alamat</th>
                    <th>Tanggal Bergabung</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?= esc($no++); ?></td>
                        <td><?= esc($member['name']); ?></td>
                        <td><?= esc($member['email']); ?></td>
                        <td><?= esc($member['phone']); ?></td>
                        <td><?= esc($member['address']); ?></td>
                        <td><?= esc($member['membership_date']); ?></td>
                        <td><?= esc($member['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?= $this->endSection(); ?>
