<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Edit Member</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/members'); ?>">Members</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Member
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Edit Member</h4>
            <p class="mb-30">Ubah data member di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('/members/update/' . esc($member['id'])); ?>" method="POST">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= esc($member['name']); ?>" placeholder="Nama lengkap" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= esc($member['email']); ?>" placeholder="Email" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="<?= esc($member['phone']); ?>" placeholder="Nomor telepon" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <input type="text" id="address" name="address" class="form-control" value="<?= esc($member['address']); ?>" placeholder="Alamat" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="membership_date">Tanggal Bergabung</label>
                    <input type="date" id="membership_date" name="membership_date" class="form-control" value="<?= esc($member['membership_date']); ?>" disabled>
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
