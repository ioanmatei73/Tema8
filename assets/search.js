(function($) {
    $('#wpr-filter select').on('change', function(){
        var hobby = $('#wpr-filter select').val();
        var keyw = $('#wpr-filter input').val();
        data = {
            action: 'search',
            hobby: hobby,
            keyw: keyw
        };
        $.ajax({
            url: WPR.ajax_url,
            type: 'GET',
            data: data,
            success: function(response){
                console.log(response);
                $('#archive-engineers').empty();
                if (response && response.length) {
                    var html = '<table>';
                    for (var i = 0; i < response.length; i++) {
                        var engineer = response[i];
                        html += '<tr><td width=20% style="border: outset"><img src="' + engineer.img_src[0] + '"></td>';
                        html += '<td style="border: none"><h3>' + engineer.title + '</h3><br><br>' + engineer.content + '</td></tr>';
                    }
                    $('#archive-engineers').append(html);
                }
            }
        });
    });

    $('#wpr-filter input').on('keyup', function(){
        if ($('#wpr-filter input').val().length > 1) {
            var hobby = $('#wpr-filter select').val();
            var keyw = $('#wpr-filter input').val();
            data = {
                action: 'search',
                hobby: hobby,
                keyw: keyw
            };
            $.ajax({
                url: WPR.ajax_url,
                type: 'GET',
                data: data,
                success: function(response){
                    console.log(response);
                    $('#archive-engineers').empty();
                    if (response && response.length) {
                        var html = '<table>';
                        for (var i = 0; i < response.length; i++) {
                            var engineer = response[i];
                            html += '<tr><td width=20% style="border: outset"><img src="' + engineer.img_src[0] + '"></td>';
                            html += '<td style="border: none"><h3>' + engineer.title + '</h3><br><br>' + engineer.content + '</td></tr>';
                        }
                        $('#archive-engineers').append(html);
                    }
                }
            });
        }
    });
} ) (jQuery);
