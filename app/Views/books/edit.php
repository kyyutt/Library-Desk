<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Edit Buku</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit Buku
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Form Edit Buku</h4>
            <p class="mb-30">Ubah data buku di bawah ini</p>
        </div>
    </div>
    <form action="<?= base_url('/books/update/' . esc($book['id'])); ?>" method="POST">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="title">Judul Buku</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Judul buku" value="<?= $book['title']; ?>" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="author">Pengarang</label>
                    <input type="text" id="author" name="author" class="form-control" placeholder="Nama pengarang" value="<?= $book['author']; ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="publisher">Penerbit</label>
                    <input type="text" id="publisher" name="publisher" class="form-control" placeholder="Nama penerbit" value="<?= $book['publisher']; ?>" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="year">Tahun Terbit</label>
                    <input type="number" id="year" name="year" class="form-control" placeholder="Tahun terbit" value="<?= $book['year']; ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" class="form-control" placeholder="ISBN" value="<?= $book['isbn']; ?>" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <!-- Loop through categories -->
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id']; ?>" <?= $category['id'] == $book['category_id'] ? 'selected' : ''; ?>>
                                <?= $category['category_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="rack_id">Rak</label>
                    <select id="rack_id" name="rack_id" class="form-control" required>
                        <?php foreach ($racks as $rack): ?>
                            <option value="<?= $rack['id']; ?>" <?= $rack['id'] == $book['rack_id'] ? 'selected' : ''; ?>>
                                <?= $rack['rack_number']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('/books'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
