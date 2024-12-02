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
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20 pb-0">
        <h4 class="text-blue h4">Laporan Member</h4>
    </div>
    <div class="pd-10">
        <!-- Data Table -->
        <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <table class="table hover multiple-select-row data-table-export nowrap dataTable no-footer dtr-inline" id="DataTables_Table_2" role="grid">
                <thead>
                    <tr role="row">
                        <th class="table-plus datatable-nosort sorting_disabled" rowspan="1" colspan="1" aria-label="No">No</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Nama</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Email</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending">Nomor Telepon</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Alamat</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Join Date: activate to sort column ascending">Tanggal Bergabung</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_2" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($members as $member): ?>
                        <tr role="row">
                            <td class="table-plus"><?= esc($no++); ?></td>
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
</div>

<?= $this->endSection(); ?>
