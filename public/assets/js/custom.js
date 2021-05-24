$(document).ready(function() {
    // $(".datatable").DataTable();
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    CKEDITOR.replace('editor');
    $(".select2").select2();
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd"
    });
    $(".datepickerDate").datepicker({
        format: "yyyy-mm-dd",
    });
    $("form").submit(function() {
        $(".loading").addClass("show");
    });
    
    function formatRupiah(angka) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        return rupiah;
    }

    $('.showDetailData').click(function (e) { 
        let imageSrc = $(this).data('image');
        $('.modal-body #showDetail').attr('src', imageSrc);
      });
});
