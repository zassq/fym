$(function(){
    'use strict';
    var lang = new $.lang({lang_file: '/assets/js/lang/zh-cn.json'});
    $.ajax({
        url: '/user_get_client',
        context: $('#user_client'),
        dataType: 'json',
        statusCode: {
            404: function(){
                ajaxShow('e', '404error', $(this));
            }
        },
        success: function(data){
            if('error' == data.type){
                ajaxShow('e', 'transmission_error', $(this));
            }else{
                if(0 == data.msg) ajaxShow('e', 'no_clients', $(this));
                else ajaxShow('g', 'clients', $(this), data.clients);
            }
        },
        fail: function(){
            ajaxShow('e', 'transmission_error', $(this));
        }
    });
    $.ajax({
        url: '/user_get_history',
        context: $('#user_history'),
        dataType: 'json',
        statusCode: {
            404: function(){
                ajaxShow('e', '404error', $(this));
            }
        },
        success: function(data){
            if('error' == data.type){
                ajaxShow('e', 'transmission_error', $(this));
            }else{
                if(0 == data.msg) ajaxShow('e', 'no_histories', $(this));
                else ajaxShow('g', 'histories', $(this), data.histories);
            }
        },
        fail: function(){
            ajaxShow('e', 'transmission_error', $(this));
        }
    });

    function ajaxShow(t, m, o, d){
        'use strict';
        var msg,
            dd = new Object(),
            display = o.find('.displayTable'),
            loading = o.find('.loading');
        d = d || null;
        if('e' == t){
            msg = $('<div class="col-md-12"><p><img src="/assets/images/warning.png" alt="not found"/>&nbsp;&nbsp;<span class="text-danger">'+lang.show(m)+'</span></p></div>');
            loading.fadeOut(function(){display.empty().append(msg).fadeIn();});
        }else if('g' == t){
            var tables = display.find('tbody');
            if(null != d){
                dd[m] = d;
                tables.append(Handlebars.templates[m](dd));
                loading.fadeOut(function(){display.fadeIn();});
            }else{
                ajaxShow('e', 'transmission_error', o);
            }
        }
    }
});


