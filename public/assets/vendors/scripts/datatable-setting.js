$(document).ready(function() {
	// Inisialisasi DataTable untuk checkbox-datatable
	var table = $('.checkbox-datatable').DataTable({
		scrollCollapse: true,
		autoWidth: false,
		responsive: true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"language": {
			"info": "_START_-_END_ of _TOTAL_ entries",
			searchPlaceholder: "Search",
			paginate: {
				next: '<i class="ion-chevron-right"></i>',
				previous: '<i class="ion-chevron-left"></i>'
			}
		},
		'columnDefs': [
			{
				'targets': 0, // Kolom pertama (checkbox)
				'searchable': false,
				'orderable': false,
				'className': 'dt-body-center',
				'render': function (data, type, full, meta) {
					return '<div class="dt-checkbox"><input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '"><span class="dt-checkbox-label"></span></div>';
				}
			},
			{
				'targets': -1, // Kolom terakhir (Action)
				'orderable': false // Menonaktifkan sorting pada kolom Action
			}
		],
		'order': [[1, 'asc']] // Mengurutkan berdasarkan kolom kedua secara default
	});

	// Event listener untuk 'Select All' checkbox
	$('#example-select-all').on('click', function(){
		var rows = table.rows({ 'search': 'applied' }).nodes();
		$('input[type="checkbox"]', rows).prop('checked', this.checked);
	});

	// Event listener untuk checkbox individu
	$('.checkbox-datatable tbody').on('change', 'input[type="checkbox"]', function(){
		if (!this.checked) {
			var el = $('#example-select-all').get(0);
			if (el && el.checked && ('indeterminate' in el)) {
				el.indeterminate = true;
			}
		}
	});

	// Inisialisasi DataTable untuk data-table
	$('.data-table').DataTable({
		scrollCollapse: true,
		autoWidth: false,
		responsive: true,
		columnDefs: [{
			targets: "datatable-nosort", // Target kolom dengan class 'datatable-nosort'
			orderable: false, // Menonaktifkan sorting pada kolom tersebut
		}],
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"language": {
			"info": "_START_-_END_ of _TOTAL_ entries",
			searchPlaceholder: "Search",
			paginate: {
				next: '<i class="ion-chevron-right"></i>',
				previous: '<i class="ion-chevron-left"></i>'
			}
		}
	});

	// Inisialisasi DataTable untuk data-table-export
	$('.data-table-export').DataTable({
		scrollCollapse: true,
		autoWidth: false,
		responsive: true,
		columnDefs: [{
			targets: "datatable-nosort", // Target kolom dengan class 'datatable-nosort'
			orderable: false // Menonaktifkan sorting pada kolom tersebut
		}],
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"language": {
			"info": "_START_-_END_ of _TOTAL_ entries",
			searchPlaceholder: "Search",
			paginate: {
				next: '<i class="ion-chevron-right"></i>',
				previous: '<i class="ion-chevron-left"></i>'
			}
		},
		dom: 'Bfrtip', // Menambahkan elemen DOM untuk tombol ekspor
		buttons: [
			'copy', 'csv', 'pdf', 'print' // Tombol ekspor untuk menyalin, CSV, PDF, dan cetak
		]
	});

	// Inisialisasi DataTable untuk select-row (pilihan satu baris)
	var table = $('.select-row').DataTable();
	$('.select-row tbody').on('click', 'tr', function () {
		if ($(this).hasClass('selected')) {
			$(this).removeClass('selected');
		} else {
			table.$('tr.selected').removeClass('selected');
			$(this).addClass('selected');
		}
	});

	// Inisialisasi DataTable untuk multiple-select-row (pilihan banyak baris)
	var multipletable = $('.multiple-select-row').DataTable();
	$('.multiple-select-row tbody').on('click', 'tr', function () {
		$(this).toggleClass('selected');
	});
});
