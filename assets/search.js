(function($) {
    $('#wpr-filter select').on('change', function(){
        var hobby = $('#wpr-filter select').val();
        data = {
            action: 'search',
            hobby: hobby,
        };
        $.ajax({  
            url: WPR.ajax_url, 
            type: 'GET', 
            data: data,
            success: function(response){
                $('#archive-engineers').empty();
                if (response && response.length) {
                    var html = '<table>';
                    for (var i = 0; i < response.length; i++) {
                        var engineer = response[i];
                        html += '<tr><td><img src="' + engineer.img_src[0] + '"></td><td>' + engineer.title + '</td></tr>';
                    }
                    $('#archive-engineers').append(html);
                 }
            }
        });
    });
} ) (jQuery); 