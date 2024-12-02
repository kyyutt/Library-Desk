<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Tambah eBook</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/ebooks'); ?>">eBook</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tambah eBook
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Tambah eBook</h4>
            <p class="mb-30">Lengkapi data eBook di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('/ebooks/store'); ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="title">Judul eBook</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Judul eBook" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="author">Penulis</label>
                    <input type="text" id="author" name="author" class="form-control" placeholder="Nama Penulis" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="publisher">Penerbit</label>
                    <input type="text" id="publisher" name="publisher" class="form-control" placeholder="Nama Penerbit" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="year_of_publication">Tahun Terbit</label>
                    <input type="number" id="year_of_publication" name="year_of_publication" class="form-control" placeholder="Tahun Terbit (contoh: 2024)" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="form-control" placeholder="Nomor ISBN" required>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Deskripsi singkat eBook"></textarea>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id']; ?>"><?= $category['category_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <label for="file">File eBook (PDF)</label>
                    <input type="file" id="file" name="file" class="form-control-file form-control" accept=".pdf" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('/ebooks'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
