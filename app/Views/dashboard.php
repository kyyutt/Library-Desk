<?= $this->extend('layout/pages-layout'); ?>
<?= $this->section('content'); ?>
<div class="title pb-20">
	<h2 class="h3 mb-0">Library Overview</h2>
</div>

<div class="row pb-10">
	<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
		<div class="card-box height-100-p widget-style3">
			<div class="d-flex flex-wrap">
				<div class="widget-data">
					<div class="weight-700 font-24 text-dark"><?= $totalBooks ?></div>
					<div class="font-14 text-secondary weight-500">Total Books</div>
				</div>
				<div class="widget-icon">
					<div class="icon" data-color="#fff">
						<i class="icon-copy fa fa-book"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
		<div class="card-box height-100-p widget-style3">
			<div class="d-flex flex-wrap">
				<div class="widget-data">
					<div class="weight-700 font-24 text-dark"><?= $booksOnLoan ?></div>
					<div class="font-14 text-secondary weight-500">Books on Loan</div>
				</div>
				<div class="widget-icon">
					<div class="icon" data-color="orange">
						<i class="icon-copy fa fa-address-book"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
		<div class="card-box height-100-p widget-style3">
			<div class="d-flex flex-wrap">
				<div class="widget-data">
					<div class="weight-700 font-24 text-dark"><?= $overdueBooks ?></div>
					<div class="font-14 text-secondary weight-500">Overdue Books</div>
				</div>
				<div class="widget-icon">
					<div class="icon" data-color="#ff5b5b">
						<i class="icon-copy fa fa-clock-o"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
		<div class="card-box height-100-p widget-style3">
			<div class="d-flex flex-wrap">
				<div class="widget-data">
					<div class="weight-700 font-24 text-dark"><?= $totalMembers ?></div>
					<div class="font-14 text-secondary weight-500">Total Members</div>
				</div>
				<div class="widget-icon">
					<div class="icon" data-color="#09cc06">
						<i class="icon-copy fa fa-users"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row pb-10">
	<div class="col-md-8 mb-20">
		<div class="card-box height-100-p pd-20">
			<div
				class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
				<div class="h5 mb-md-0">Hospital Activities</div>
				<div class="form-group mb-md-0">
					<div class="h6">Last Month</div>
				</div>
			</div>
			<div id="activities-chart"></div>
		</div>
	</div>
	<div class="col-lg-4 col-md-6 mb-20">
    <div class="card-box height-100-p pd-20 min-height-200px">
        <div class="d-flex justify-content-between pb-10">
            <div class="h5 mb-0">Latest Book</div>
            <div class="dropdown">
                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" data-color="#1b3133" href="#" role="button" data-toggle="dropdown">
                    <i class="dw dw-more"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="<?= base_url('/books') ?>"><i class="dw dw-eye"></i> View</a>
                </div>
            </div>
        </div>
        <div class="user-list">
            <ul>
                <?php foreach ($books as $book): ?>
                    <li class="d-flex align-items-center justify-content-between">
                        <div class="name-avatar d-flex align-items-center pr-2">
                            <div class="txt">
                                <div class="font-14 weight-600"><?= $book['title'] ?></div> <!-- Nama Buku -->
                                <div class="font-12 weight-500" data-color="#b2b1b6">
                                    Author: <?= $book['author'] ?> <!-- Penulis Buku -->
                                </div>
                            </div>
                        </div>
                        <div class="cta flex-shrink-0">
                            <span class="btn btn-sm 
							<?= $book['status'] == 'available' ? 'btn-outline-succes' : ($book['status'] == 'borrowed' ? 'btn-outline-danger' : 'btn-outline-warning'); ?>">
							<?= esc(ucfirst($book['status'])); ?>
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

</div>
<div class="card-box pb-10 mb-4">
	<div class="h5 pd-20 mb-0">Recent Members</div>
	<table class="table nowrap">
		<thead>
			<tr>
				<th class="table-plus">Member No</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Address</th>
				<th class="datatable-nosort">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($members as $member): ?>
				<tr>
					<td class="table-plus"><?= $member['no_member']; ?></td>
					<td><?= $member['name']; ?></td>
					<td><?= $member['email']; ?></td>
					<td><?= $member['phone']; ?></td>
					<td><?= $member['address']; ?></td>
					<td>
						<span class="badge badge-pill" data-bgcolor="#e7ebf5" data-color="#265ed7">
							<?= $member['status']; ?>
						</span>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<script>
	var loanData = <?= json_encode($loanData) ?>;
	var reservationData = <?= json_encode($reservationData) ?>;
	var categories = <?= json_encode($categories) ?>;
</script>


<?= $this->endSection(); ?>