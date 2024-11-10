<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<h2>Create Fine Setting</h2>

<form action="<?= base_url('finesettings/store'); ?>" method="post">
    <div class="form-group">
        <label for="fine_per_day">Fine Per Day (in currency units)</label>
        <input type="number" name="fine_per_day" id="fine_per_day" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Save Fine Setting</button>
</form>

<?= $this->endSection(); ?>
