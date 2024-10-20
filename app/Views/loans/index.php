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
                        Peminjaman
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="/admin/loans/create" class="btn btn-primary">Tambah Peminjaman</a>
        </div>
    </div>
</div>
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Daftar Peminjaman</h4>
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
                    <th>Tanggal Jatuh Tempo</th>
                    <th>Tanggal Pengembalian</th>
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
                                    <a href="/admin/loans/return/<?= esc($loan['id']); ?>" data-color="#28a745" title="Tandai Terkembalikan">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                <?php endif; ?>
                                <!-- <a href="/admin/loans/edit/<?= esc($loan['id']); ?>" data-color="#265ed7">
                                    <i class="icon-copy dw dw-edit2"></i>
                                </a> -->
                                <a href="/admin/loans/delete/<?= esc($loan['id']); ?>" data-color="#e95959">
                                    <i class="icon-copy dw dw-delete-3"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>