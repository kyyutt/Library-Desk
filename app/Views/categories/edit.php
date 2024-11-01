<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Edit Kategori</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Kategori
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Edit Kategori</h4>
            <p class="mb-30">Ubah data kategori di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('/categories/update/' . $category['id']); ?>" method="POST">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="category_name">Nama Kategori</label>
                    <input type="text" id="category_name" name="category_name" class="form-control" placeholder="Nama kategori" value="<?= $category['category_name']; ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('/categories'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
