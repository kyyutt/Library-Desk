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
      <img src="https://via.placeholder.com/100" alt="Member Photo">
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

<script>
    function printMemberCard() {
        var printContents = document.getElementById('member-card').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<?= $this->endSection(); ?>
