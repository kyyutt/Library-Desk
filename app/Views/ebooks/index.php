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
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Ebook
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="<?= base_url('/ebooks/create'); ?>" class="btn btn-primary">Tambah Ebook</a>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Daftar Ebook</h4>
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
        <table class="checkbox-datatable table nowrap">
            <thead>
                <tr>
                    <th>
                        <div class="dt-checkbox">
                            <input type="checkbox" name="select_all" value="1" id="example-select-all" />
                            <span class="dt-checkbox-label"></span>
                        </div>
                    </th>
                    <th>Judul Ebook</th>
                    <th>Kategori</th>
                    <th>File</th>
                    <th>File Size</th>
                    <th>Status</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ebooks as $ebook): ?>
                    <tr>
                        <td>
                            <div class="dt-checkbox">
                                <input type="checkbox" name="ebook_ids[]" value="<?= esc($ebook['id']); ?>" id="ebook-<?= esc($ebook['id']); ?>" />
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </td>
                        <td><?= esc($ebook['title']); ?></td>
                        <td><?= esc($ebook['category']); ?></td>
                        <td>
                            <!-- Link untuk membuka file PDF -->
                            <a href="<?= base_url('uploads/ebooks/' . esc($ebook['file_name'])); ?>" target="_blank" class="text-info">


                                Lihat Ebook
                            </a>
                        </td>

                        <td>
                            <!-- Convert file size to a more readable format -->
                            <?= number_format($ebook['file_size'] / 1024, 2); ?> KB
                        </td>
                        <td>
                            <?= esc($ebook['status'] === 'available' ? 'Tersedia' : 'Tidak Tersedia'); ?>
                        </td>

                        <td>
                            <div class="table-actions">
                                <a href="<?= base_url('/ebooks/edit/' . esc($ebook['id'])); ?>" data-color="#265ed7" title="Edit">
                                    <i class="icon-copy fa fa-edit"></i>
                                </a>
                                <a href="#" data-toggle="modal" data-target="#confirmation-modal-<?= esc($ebook['id']); ?>" data-color="#e95959" title="Delete">
                                    <i class="icon-copy fa fa-trash-o"></i>
                                </a>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="confirmation-modal-<?= esc($ebook['id']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body text-center font-18">
                                            <p class="padding-top-30 mb-30">
                                                Apakah Anda yakin ingin menghapus ebook ini?
                                            </p>
                                            <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-secondary border-radius-100 btn-block" data-dismiss="modal">
                                                        NO
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <a href="<?= base_url('/ebooks/delete/' . esc($ebook['id'])); ?>" class="btn btn-primary border-radius-100 btn-block">
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

<?= $this->endSection(); ?>