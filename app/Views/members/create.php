<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Tambah Member</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Member
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Tambah Member</h4>
            <p class="mb-30">Lengkapi data member di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('/members/store'); ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="no_member">Nomor Member</label>
                    <!-- Input terlihat yang tidak bisa diubah -->
                    <input type="text" id="no_member" name="no_member" class="form-control" placeholder="NPM / NIP / NIDN" required pattern="\d{9}|\d{18}|\d{10}" title="Masukkan NPM (10 digit), NIP (18 digit), atau NIDN (10 digit)">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nama lengkap" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                </div>
            </div>

            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Nomor telepon" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Alamat" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="photo">Upload Foto</label>
                    <input type="file" id="photo" name="photo" class="form-control-file form-control" accept="image/*">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="membership_date">Tanggal Bergabung</label>
                    <input type="date" id="membership_date" name="membership_date" class="form-control" value="<?= date('Y-m-d'); ?>" disabled>
                    <input type="hidden" name="membership_date" value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
        </div>


<div class="row">
    <div class="col-md-12 col-sm-12">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('/members'); ?>" class="btn btn-secondary">Kembali</a>
    </div>
</div>
</form>
</div>

<?= $this->endSection(); ?>