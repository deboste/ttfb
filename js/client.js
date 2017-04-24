$( document ).ready(function() {
    table = $('#table_results').DataTable( {
        columns: [
            { "data": "ndd" },
            { "data": "url" },
            { "data": "ttfb" },
            { "data": "host" },
            { "data": "dns" },
            { "data": "ttl" }
        ],
        paging: true,
        order: [[ 2, "asc" ]],
        colReorder: true,
        //responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
});

$(document).ajaxStart(function () {
    $("#check").prop('disabled', true);
    $("#ndd").prop('disabled', true);
    $('#table_results').spin('large', '#000000');
});

$(document).ajaxStop(function () {
    $("#check").prop('disabled', false);
    $("#ndd").prop('disabled', false);
    $('#table_results').spin(false);
});

$("#reset").click(function(){
    $("#ndd").val("");
    table.clear().draw();
});

$("#check").click(function(){
    if ($.trim($("#ndd").val())) {
        table.clear().draw();
        nddList = $('#ndd').val();
        nddList = nddList.replace(/(?:(?:\r\n|\r|\n)\s*){2}/gm, "");
        var arrayOfLines = nddList.split('\n');
        $.each(arrayOfLines, function(index, item) {
            item.replace(/\s/g,'');
            $.ajax({
                type: "GET",
                url: "api.php",
                data: {
                    url: item
                },
                success: function(results) {
                    table.row.add(results).draw( false );
                }
            });
        });
    }
});