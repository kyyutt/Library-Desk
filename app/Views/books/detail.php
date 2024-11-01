<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Detail Buku</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Buku
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Informasi Buku</h4>
        </div>
    </div>
    
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Judul:</strong> <?= esc($book['title']); ?></li>
        <li class="list-group-item"><strong>Pengarang:</strong> <?= esc($book['author']); ?></li>
        <li class="list-group-item"><strong>Penerbit:</strong> <?= esc($book['publisher']); ?></li>
        <li class="list-group-item"><strong>Tahun:</strong> <?= esc($book['year']); ?></li>
        <li class="list-group-item"><strong>ISBN:</strong> <?= esc($book['isbn']); ?></li>
        <li class="list-group-item"><strong>Kategori:</strong> <?= esc($book['category']); ?></li>
        <li class="list-group-item"><strong>Rak:</strong> <?= esc($book['rack']); ?></li>
        <li class="list-group-item"><strong>Status:</strong> <?= esc($book['status']); ?></li>
    </ul>

    <div class="row mt-4">
        <div class="col-md-12">
            <a href="<?= base_url('/books'); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
