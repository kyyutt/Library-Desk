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
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Denda
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="/admin/fines/create" class="btn btn-primary">Tambah Denda</a>
        </div>
    </div>
</div>
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Daftar Denda</h4>
    </div>
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
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Denda</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fines as $fine): ?>
                    <tr>
                        <td>
                            <div class="dt-checkbox">
                                <input type="checkbox" name="fine_ids[]" value="<?= esc($fine['id']); ?>" id="fine-<?= esc($fine['id']); ?>" />
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </td>
                        <td><?= esc($fine['member_name']); ?></td>
                        <td><?= esc($fine['book_title']); ?></td>
                        <td><?= esc($fine['loan_date']); ?></td>
                        <td><?= esc($fine['fine_amount']); ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="#" data-toggle="modal" data-target="#pay-modal-<?= esc($fine['id']); ?>" data-color="#28a745" title="Tandai Lunas">
                                    <i class="fa fa-check"></i>
                                </a>
                            </div>

                            <!-- Modal for confirming payment -->
                            <div class="modal fade" id="pay-modal-<?= esc($fine['id']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Pembayaran Denda</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center font-18">
                                            <p class="padding-top-30 mb-30">
                                                Apakah Anda yakin sudah membayar denda ini?
                                            </p>
                                            <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-secondary border-radius-100 btn-block" data-dismiss="modal">
                                                        NO
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <a href="<?= base_url('admin/fines/pay/' . esc($fine['id'])); ?>" class="btn btn-primary border-radius-100 btn-block">
                                                        YES
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
