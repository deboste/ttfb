$( document ).ready(function() {
    table = $('#table_results').DataTable( {
        paging: false
    } );
});

$("#check").click(function(){
    if ($.trim($("#ndd").val())) {
        $(this).prop('disabled', true);
        $("#ndd").prop('disabled', true);
        $(this).spin('large', '#000000');

        $.ajax({
            type: "GET",
            url: "api.php",
            data: {
                url: $('#ndd').val()
            },
            success: function(results) {
                table.destroy();
                table = $('#table_results').DataTable( {
                    data: [
                        jQuery.parseJSON(results)
                    ],
                    columns: [
                        { "data": "ndd" },
                        { "data": "url" },
                        { "data": "nl" },
                        { "data": "ttfb" },
                        { "data": "host" },
                        { "data": "dns" },
                        { "data": "ttl" }
                    ],
                    paging: false
                } );

            }
        });

        $(this).spin(false);
        $(this).prop('disabled', false);
        $("#ndd").prop('disabled', false);
    }
});