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
            <a id="download-btn" class="btn btn-success">Download</a>
            <a id="print-btn" class="btn btn-warning">Print</a>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-30" id="member-card">
    <div class="card-member" id="card">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
    document.getElementById('download-btn').addEventListener('click', function () {
            const card = document.getElementById('card');
            html2canvas(card).then(canvas => {
                const link = document.createElement('a');
                link.download = 'member_card.png'; // Nama file unduhan
                link.href = canvas.toDataURL(); // Data gambar
                link.click();
            });
        });
        document.getElementById('print-btn').addEventListener('click', function () {
        const card = document.getElementById('card');
        
        html2canvas(card).then(canvas => {
            // konvert canvas menjadi URL gambar
            const imageData = canvas.toDataURL('image/png');
            
            // buka jendela baru untuk print gambar
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                <head>
                    <title>Print Member Card</title>
                    <style>
                        body {
                            margin: 0;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            background-color: #fff;
                        }
                        img {
                            max-width: 100%;
                            height: auto;
                        }
                    </style>
                </head>
                <body>
                    <img src="${imageData}" alt="Member Card">
                </body>
                </html>
            `);
            printWindow.document.close();

            printWindow.onload = function () {
                printWindow.print();
                printWindow.close();
            };
        }).catch(error => {
            console.error('html2canvas error:', error);
        });
    });
</script>

<?= $this->endSection(); ?>
