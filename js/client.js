$( document ).ready(function() {
    table = $('#table_results').DataTable( {
        columns: [
            { "data": "ndd" },
            { "data": "url" },
            { "data": "nl" },
            { "data": "ttfb" },
            { "data": "host" },
            { "data": "dns" },
            { "data": "ttl" }
        ],
        paging: false,
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

$("#check").click(function(){
    if ($.trim($("#ndd").val())) {
        $(this).prop('disabled', true);
        $("#ndd").prop('disabled', true);
        $(this).spin('large', '#000000');
        table.clear().draw();

        var arrayOfLines = $('#ndd').val().split('\n');
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
        $("#check").spin(false);
        $("#check").prop('disabled', false);
        $("#ndd").prop('disabled', false);
    }
});