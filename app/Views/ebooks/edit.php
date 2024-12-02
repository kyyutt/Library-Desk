<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Edit eBook</h4>
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
                        Edit eBook
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Edit eBook</h4>
            <p class="mb-30">Perbarui data eBook di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('/ebooks/update/' . $ebook['id']); ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label for="ebook_title">Judul eBook</label>
                <input type="text" id="title" name="title" class="form-control" value="<?= esc($ebook['title']); ?>" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="author">Penulis</label>
                <input type="text" id="author" name="author" class="form-control" value="<?= esc($ebook['author']); ?>" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="publisher">Penerbit</label>
                <input type="text" id="publisher" name="publisher" class="form-control" value="<?= esc($ebook['publisher']); ?>" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="year_of_publication">Tahun Terbit</label>
                <input type="number" id="year_of_publication" name="year_of_publication" class="form-control" value="<?= esc($ebook['year_of_publication']); ?>" required>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn" class="form-control" value="<?= esc($ebook['isbn']); ?>" required>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" class="form-control" rows="4"><?= esc($ebook['description']); ?></textarea>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id']; ?>" <?= $category['id'] == $ebook['category_id'] ? 'selected' : ''; ?>>
                                <?= $category['category_name']; ?>
                            </option>
                        <?php endforeach; ?>
                </select>
            </div>
        </div>
       <div class="col-md-12 col-sm-12">
    <div class="form-group">
        <label for="file">File eBook (PDF)</label>
        <input type="file" id="file" name="file" class="form-control-file" accept=".pdf">
        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file eBook.</small>
    </div>

    <!-- Menampilkan file eBook lama jika ada -->
    <?php if (!empty($ebook['file_name'])): ?>
        <div class="form-group">
            <label>File eBook Lama</label><br>
            <a href="<?= base_url('/uploads/ebooks/' . $ebook['file_name']); ?>" target="_blank"><?= $ebook['file_name'] ; ?>
            </a>
        </div>
    <?php endif; ?>
</div>

        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
    <option value="available" <?= ($ebook['status'] == 'available') ? 'selected' : ''; ?>>Tersedia</option>
    <option value="unavailable" <?= ($ebook['status'] == 'unavailable') ? 'selected' : ''; ?>>Tidak Tersedia</option>
</select>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="<?= base_url('/ebooks'); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</form>

</div>

<?= $this->endSection(); ?>
