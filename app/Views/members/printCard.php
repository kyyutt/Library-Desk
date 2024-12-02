<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Print Member</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('/dashboard'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Print Member
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="javascript:void(0);" onclick="printMemberCard()" class="btn btn-primary">Print</a>
            <a href="javascript:void(0);" onclick="downloadMemberCard()" class="btn btn-success">Unduh JPG</a>
        </div>
    </div>
</div>

<!-- Card Member Section -->
<div class="pd-20 card-box mb-30" id="member-card">
    <div class="card-member">
        <div class="header-card">
            LIBRARY DESK
        </div>
        <div class="sub-header">
            MEMBER ID CARD
        </div>
        <div class="photo">
            <?php if (!empty($member['photo']) && file_exists(FCPATH . 'uploads/members/' . $member['photo'])): ?>
                <img src="<?= base_url('uploads/members/' . $member['photo']); ?>" alt="Foto Member" class="border-radius-100 shadow" width="40" height="40">
            <?php else: ?>
                <img src="https://via.placeholder.com/100" class="border-radius-100 shadow" width="40" height="40" alt="Foto Default">
            <?php endif; ?>
        </div>
        <div class="info">
            <div>Name: <?= esc($member['name']) ?></div>
            <div>Email: <?= esc($member['email']) ?></div>
            <div>Phone: <?= esc($member['phone']) ?></div>
            <div>Address: <?= esc($member['address']) ?></div>
        </div>
        <div class="id-section">
            ID NO <?= esc($member['no_member']) ?>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<script>
    function printMemberCard() {
        var printContents = document.getElementById('member-card').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    function downloadMemberCard() {
        var element = document.getElementById('member-card');
        
        html2canvas(element, {
            useCORS: true, // CORS untuk gambar
            allowTaint: true,
            scale: 2 // Meningkatkan kualitas gambar
        }).then(function(canvas) {
            // Mengonversi canvas ke data URL JPG
            var imageData = canvas.toDataURL('image/jpeg', 1.0);
            var link = document.createElement('a');
            link.href = imageData;
            link.download = 'Member-ID-Card.jpg'; // Nama file yang akan diunduh
            link.click();
        });
    }
</script>

<?= $this->endSection(); ?>
