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
            "iDisplayLength" : 5,
            "oLanguage": {
                "sUrl": "/assets/dataTable-zh.txt"
            },
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [-1] }
            ]
        });
    }

    if($('.marketing_log_date').length>0){
        initDatePicker($('.marketing_log_date'));
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
    $('#marketing_logs').append($('<div class="form-group marketing_log_row" id="ml_row_'+current_row+'">').append(tpl));
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