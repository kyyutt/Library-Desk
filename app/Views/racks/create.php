<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Tambah Rak</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Rak
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Tambah Rak</h4>
            <p class="mb-30">Lengkapi data Rak di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('/racks/store'); ?>" method="POST">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="rack_number">Nomor Rak</label>
                    <input type="text" id="rack_number" name="rack_number" class="form-control" placeholder="Nomor rak" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('/racks'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
