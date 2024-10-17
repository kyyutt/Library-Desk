<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Data Buku</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Data Buku
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="/admin/books/create" class="btn btn-primary">Tambah Buku</a>
        </div>
    </div>
</div>

<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Daftar Buku</h4>
    </div>
    <div class="pb-20">
        <table class="checkbox-datatable table nowrap">
            <thead>
                <tr>
                    <th>
                        <div class="dt-checkbox">
                            <input
                                type="checkbox"
                                name="select_all"
                                value="1"
                                id="example-select-all" />
                            <span class="dt-checkbox-label"></span>
                        </div>
                    </th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Tanggal Terbit</th>
                    <th class="datatable-nosort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td>
                            <div class="dt-checkbox">
                                <input type="checkbox" name="book_ids[]" value="<?= esc($book['id']); ?>" id="book-<?= esc($book['id']); ?>" />
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </td>
                        <td><?= esc($book['title']); ?></td>
                        <td><?= esc($book['author']); ?></td>
                        <td><?= esc($book['category']); ?></td>
                        <td><?= esc($book['year']); ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="/admin/books/edit/<?= esc($book['id']); ?>" data-color="#265ed7">
                                    <i class="icon-copy dw dw-edit2"></i>
                                </a>
                                <a href="/admin/books/delete/<?= esc($book['id']); ?>" data-color="#e95959">
                                    <i class="icon-copy dw dw-delete-3"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
