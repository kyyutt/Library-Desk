<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Tambah Admin</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah Admin
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Tambah Admin</h4>
            <p class="mb-30">Lengkapi data Admin di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('/admins/store'); ?>" method="POST">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('/admins'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
