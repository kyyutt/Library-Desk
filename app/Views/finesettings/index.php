<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <h4>Fine Settings</h4>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fine per Day</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fineSettings as $setting): ?>
                <tr>
                    <td><?= esc($setting['fine_per_day']); ?></td>
                    <td>
                    <label class="switch">
    <input type="checkbox" class="primary">
    <span class="slider round"></span>
</label>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<?= $this->endSection(); ?>
