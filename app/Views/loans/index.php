<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>DataTable</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('index.html'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Peminjaman</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="<?= base_url('//loans/create'); ?>" class="btn btn-primary">Tambah Peminjaman</a>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Daftar Peminjaman</h4>
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
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tgl Peminjaman</th>
                    <th>Tgl Jatuh Tempo</th>
                    <th>Tgl Pengembalian</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?>
                    <tr>
                        <td>
                            <div class="dt-checkbox">
                                <input type="checkbox" name="loan_ids[]" value="<?= esc($loan['id']); ?>" id="loan-<?= esc($loan['id']); ?>" />
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </td>
                        <td><?= esc($loan['member_name']); ?></td>
                        <td><?= esc($loan['book_title']); ?></td>
                        <td><?= esc($loan['loan_date']); ?></td>
                        <td><?= esc($loan['due_date']); ?></td>
                        <td>
                            <?= $loan['return_date'] ? esc($loan['return_date']) : '<span class="badge badge-warning">Belum dikembalikan</span>'; ?>
                        </td>
                        <td>
                            <div class="table-actions">
                                <?php if (!$loan['return_date']): ?>
                                    <a href="#" data-toggle="modal" data-target="#return-confirmation-modal-<?= esc($loan['id']); ?>" title="Tandai Terkembalikan" style="color: orange;">
                                    <i class="icon-copy fa fa-arrow-circle-down"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="#" data-toggle="modal" data-target="#extend-confirmation-modal-<?= esc($loan['id']); ?>" title="Perpanjang Jatuh Tempo" style="color: #28a745;">
                                <i class="icon-copy fa fa-arrow-circle-o-up"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Return Confirmation Modal -->
                    <div class="modal fade" id="return-confirmation-modal-<?= esc($loan['id']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Pengembalian</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center font-18">
                                    <p class="padding-top-30 mb-30">
                                        Apakah Anda yakin ingin mengembalikan buku ini?
                                    </p>
                                    <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-secondary border-radius-100 btn-block" data-dismiss="modal">
                                                NO
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="<?= base_url('//loans/return/' . esc($loan['id'])); ?>" class="btn btn-primary border-radius-100 btn-block">
                                                YES
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Extend Due Date Confirmation Modal -->
                    <div class="modal fade" id="extend-confirmation-modal-<?= esc($loan['id']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Perpanjangan Jatuh Tempo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center font-18">
                                    <p class="padding-top-30 mb-30">
                                        Apakah Anda yakin ingin memperpanjang jatuh tempo buku ini?
                                    </p>
                                    <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-secondary border-radius-100 btn-block" data-dismiss="modal">
                                                NO
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="<?= base_url('//loans/extendDueDate/' . esc($loan['id'])); ?>" class="btn btn-primary border-radius-100 btn-block">
                                                YES
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
