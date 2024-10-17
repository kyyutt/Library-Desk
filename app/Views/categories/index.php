<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>DataTable</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Kategori
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="/admin/categories/create" class="btn btn-primary">Tambah Kategori</a>
        </div>
    </div>
</div>
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Daftar Kategori</h4>
    </div>
    <div class="pb-20">
        <table class="checkbox-datatable table nowrap">
            <thead>
                <tr>
                    <th>
                        <div class="dt-checkbox">
                            <input type="checkbox" name="select_all" value="1" id="example-select-all" />
                            <span class="dt-checkbox-label"></span>
                        </div>
                    </th>
                    <th>Nama Kategori</th>
                    <th class="datatable-nosort">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td>
                            <div class="dt-checkbox">
                                <input type="checkbox" name="category_ids[]" value="<?= esc($category['id']); ?>" id="category-<?= esc($category['id']); ?>" />
                                <span class="dt-checkbox-label"></span>
                            </div>
                        </td>
                        <td><?= esc($category['category_name']); ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="/admin/categories/edit/<?= esc($category['id']); ?>" data-color="#265ed7">
                                    <i class="icon-copy dw dw-edit2"></i>
                                </a>
                                <a href="/admin/categories/delete/<?= esc($category['id']); ?>" data-color="#e95959">
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
