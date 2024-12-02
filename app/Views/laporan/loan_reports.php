<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Laporan Peminjaman</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Laporan Peminjaman
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <form action="<?= base_url('reports/loan-reports'); ?>" method="get">
            <div class="row">
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for="start_date">Tanggal Mulai:</label>
                    <input id="start_date" class="form-control" type="date" name="start_date" value="<?= esc($start_date); ?>">
                </div>
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for="end_date">Tanggal Akhir:</label>
                    <input id="end_date" class="form-control" type="date" name="end_date" value="<?= esc($end_date); ?>">
                </div>
                <div class="col-md-4 col-sm-12 mb-3 d-flex align-items-end justify-content-start">
                    <button type="submit" class="btn btn-primary w-auto">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Laporan Peminjaman</h4>
    </div>
    <div class="pb-20">
        <!-- Data Table -->
        <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <table class="table hover multiple-select-row data-table-export nowrap dataTable no-footer dtr-inline" id="DataTables_Table_2" role="grid">
                <thead>
                    <tr role="row">
                        <th class="table-plus datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="Name">No</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Nama Member</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Book Title: activate to sort column ascending">Judul Buku</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Loan Date: activate to sort column ascending">Tanggal Peminjaman</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Due Date: activate to sort column ascending">Jatuh Tempo</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Return Date: activate to sort column ascending">Tanggal Kembali</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Fine: activate to sort column ascending">Denda</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Fine Status: activate to sort column ascending">Status Denda</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($loans as $loan): ?>
                    <tr role="row">
                        <td class="table-plus"><?= $i++; ?></td>
                        <td><?= esc($loan['member_name']); ?></td>
                        <td><?= esc($loan['book_title']); ?></td>
                        <td><?= esc($loan['loan_date']); ?></td>
                        <td><?= esc($loan['due_date']); ?></td>
                        <td><?= isset($loan['return_date']) ? esc($loan['return_date']) : 'Belum dikembalikan'; ?></td>
                        <td><?= isset($loan['fine_amount']) ? esc($loan['fine_amount']) : 'Tidak ada'; ?></td>
                        <td><?= isset($loan['fine_status']) ? esc($loan['fine_status']) : 'Tidak ada'; ?></td>
                        <td><?= esc($loan['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination
            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_2_paginate">
                <ul class="pagination">
                    <li class="paginate_button page-item previous disabled" id="DataTables_Table_2_previous">
                        <a href="#" aria-controls="DataTables_Table_2" data-dt-idx="0" tabindex="0" class="page-link"><i class="ion-chevron-left"></i></a>
                    </li>
                    <li class="paginate_button page-item active"><a href="#" aria-controls="DataTables_Table_2" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>
                    <li class="paginate_button page-item"><a href="#" aria-controls="DataTables_Table_2" data-dt-idx="2" tabindex="0" class="page-link">2</a></li>
                    <li class="paginate_button page-item next" id="DataTables_Table_2_next">
                        <a href="#" aria-controls="DataTables_Table_2" data-dt-idx="3" tabindex="0" class="page-link"><i class="ion-chevron-right"></i></a>
                    </li>
                </ul>
            </div> -->
        </div>
    </div>
</div>

<?= $this->endSection(); ?>


