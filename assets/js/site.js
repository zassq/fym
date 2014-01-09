var lang = lang || new $.lang({lang_file: site_url+'assets/js/lang/zh-cn.json'});

$(function(){
    'use strict';
    if($('#site_message').length > 0){
        $('#site_message > .modal').modal();
    }

    if($('#is_hightech_yes').length > 0 && $('#is_hightech_no').length > 0){
        $('#is_hightech_yes').on('change', function(){
            if($(this).is(':checked')){
                $('#high_tech_cert_info').stop(true,true).slideDown();
            }
        });
        $('#is_hightech_no').on('change', function(){
            if($(this).is(':checked')){
                $('#high_tech_cert_info').stop(true,true).slideUp();
            }
        });
    }

    if($('#is_soft_comp_yes').length > 0 && $('#is_soft_comp_no').length > 0){
        $('#is_soft_comp_yes').on('change', function(){
            if($(this).is(':checked')){
                $('#soft_comp_cert_info').stop(true,true).slideDown();
            }
        });
        $('#is_soft_comp_no').on('change', function(){
            if($(this).is(':checked')){
                $('#soft_comp_cert_info').stop(true,true).slideUp();
            }
        });
    }
    if($('.sorting_table').length > 0){
        $('.sorting_table').dataTable({
            "iDisplayLength" : 10,
            "oLanguage": {
                "sUrl": site_url+"assets/dataTable-zh.txt"
            },
            "bFilter" : true,
            "bAutoWidth": false,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [-1] }
            ],
            "sDom" : "<'row'W><'row'<'col-xs-5 col-sm-6'l><'col-xs-7 col-sm-6 text-right'f>r>t<'row'<'col-xs-3 col-sm-4 col-md-5'i><'col-xs-9 col-sm-8 col-md-7 text-right'p>>",
            "oColumnFilterWidgets" : {
                "bGroupTerms" : true,
                "iMaxSelections" : 1,
                "aiExclude": [ 0, 8,9 ]
            }
        });
    }

    if($('.marketing_log_date').length>0){
        initDatePicker($('.marketing_log_date'));
    }

    if($('select#pp').length > 0){
        var pp = $('select#pp'),
            origin_val;
        pp.focus(function(){
            origin_val = this.value;
        }).change(function(){
                var origin_p = $('#project_'+origin_val),
                    new_p = $('#project_'+this.value);
                origin_p.prop('checked', false);
                new_p.prop('checked', true);
                origin_val = this.value;
            });
    }

    if($('#client_list_table').length > 0){
        $('#client_list_table').dataTable({
            "iDisplayLength" : 10,
            "oLanguage": {
                "sUrl": site_url+"assets/dataTable-zh.txt"
            },
            "bFilter" : true,
            "bAutoWidth": false,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [-1] }
            ],
            "sDom" : "<'row'W><'row'<'col-xs-5 col-sm-6'l><'col-xs-7 col-sm-6 text-right'f>r>t<'row'<'col-xs-3 col-sm-4 col-md-5'i><'col-xs-9 col-sm-8 col-md-7 text-right'p>>",
            "oColumnFilterWidgets" : {
                "bGroupTerms" : true,
                "iMaxSelections" : 1,
                "aiExclude": [ 0, 8,9 ]
            },
            "bProcessing": true,
            "bServerSide" : true,
            "sAjaxSource" : site_url+'client_list_ajax',
            "sServerMethod" : "POST"
        });
    }

});

function initDatePicker(obj){
    'use strict';
    obj.datetimepicker({
        language: 'zh-CN',
        pickTime: false
    });
}

function add_new_ml(){
    'use strict';
    var current_row = $('.marketing_log_row').length + 1;
    var tpl = $('.marketing_log_row').first().html().replace(/_1/g, '_'+current_row);
    $('#marketing_logs').append($('<div class="marketing_log_row" id="ml_row_'+current_row+'">').append(tpl));
    initDatePicker($('#ml_date_'+current_row).parent('.marketing_log_date'));
    if($('#ls_sales_rep_'+current_row).length > 0) $('#ml_staff_name_'+current_row).val($('#ls_sales_rep_'+current_row).find('option:selected').text());
}

function delet_ml_row(id){
    'use strict';
    if('ml_row_1' == id){
        $('#ml_date_1').val('');
        $('#ls_sales_rep_1').val('');
        $('#ml_log_1').val('');
    }else{
        $('#'+id).remove();
    }
}

function form_check(t){
    'use strict';
    switch(t){
        case 'client_add':
        case 'client_update':
            if(1 > $('.project_type_check:checked').length){
                alert(lang.show('need_at_least_one_project'));
                return false;
            }
            for(var i = 0, l = $('.project_type_check:checked').length; i < l; i++){
                var pid = $('.project_type_check:checked')[i].id.slice(-1),
                      py = $('#project_year_'+pid)[0];
                if(0 == py.value){
                    $('html, body').animate({
                        scrollTop: $("#proj_type_row").offset().top-50
                    }, 2000);
                    alert(lang.show('need_project_year'));
                    return false;
                }
            }
        break;
    }
    return true;
}