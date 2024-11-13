<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Setting Denda</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Setting Denda
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="/finesettings/create" class="btn btn-primary">Tambah Setting Denda</a>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Denda per hari</h4>
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
                    <!-- Checkbox for selecting all rows -->
                    <th>
                        <div class="dt-checkbox">
                            <input type="checkbox" name="select_all" value="1" id="example-select-all" />
                            <span class="dt-checkbox-label"></span>
                        </div>
                    </th>
                    <th>Denda per hari</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fineSettings as $setting): ?>
                    <tr>
                        <!-- Checkbox for individual row selection -->
                        <td>
                            <div class="dt-checkbox">
                                <input type="checkbox" name="fine_setting_ids[]" value="<?= esc($setting['id']); ?>" id="setting-<?= esc($setting['id']); ?>" />
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </td>
                        <td><?= esc($setting['fine_per_day']); ?></td>

                        <!-- Toggle switch for status -->
                        <td>
                            <form action="<?= base_url('finesettings/toggleActiveStatus/' . $setting['id']); ?>" method="post">
                                <?= csrf_field(); ?> <!-- CSRF protection -->

                                <label class="switch">
                                    <input type="checkbox" class="primary" name="is_active" <?= $setting['is_active'] ? 'checked' : ''; ?> onclick="this.form.submit();">
                                    <span class="slider round"></span>
                                </label>
                            </form>
                        </td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection(); ?>