$(function () {
  $('#datasets-table').DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#datasets-table_wrapper .col-md-6:eq(0)');
});
