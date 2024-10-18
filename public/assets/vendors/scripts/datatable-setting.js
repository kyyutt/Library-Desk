$(document).ready(function() {
    // Inisialisasi DataTable untuk checkbox-datatable
    var checkboxTable = $('.checkbox-datatable').DataTable({
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

    // Event listener untuk checkbox "Select All"
    $('#example-select-all').on('click', function() {
        var rows = checkboxTable.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Event listener untuk checkbox individu
    $('.checkbox-datatable tbody').on('change', 'input[type="checkbox"]', function() {
        // Update checkbox "Select All"
        var allCheckboxes = $('.checkbox-datatable tbody input[type="checkbox"]');
        var checkedCheckboxes = allCheckboxes.filter(':checked');
        $('#example-select-all').prop('checked', checkedCheckboxes.length === allCheckboxes.length);
    });

    // Inisialisasi DataTable untuk data-table
    $('.data-table').DataTable({
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        columnDefs: [{
            targets: "datatable-nosort",
            orderable: false,
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
            targets: "datatable-nosort",
            orderable: false
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
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'pdf', 'print'
        ]
    });

    // Inisialisasi DataTable untuk select-row (pilihan satu baris)
    var selectRowTable = $('.select-row').DataTable();
    $('.select-row tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
    });

    // Inisialisasi DataTable untuk multiple-select-row (pilihan banyak baris)
    var multipleSelectRowTable = $('.multiple-select-row').DataTable();
    $('.multiple-select-row tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
    });
});
