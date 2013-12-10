var on_unload,
    lang = new $.lang({lang_file: site_url+'assets/js/lang/zh-cn.json', afterInit: function(){on_unload = this.show('before_unload');}});


$(function(){
    'use strict';
    var client_data;
    $(document).on('uploadStateChange', stateChangeHandler);
    $(window).on('beforeunload', function(){
        return on_unload;
    });
    $(window).on('unload', function(){
        // delete exist upload list?
    });
    $('#new_client_list').fileupload({
        url: '/client_filter_upload',
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(csv)$/i,
        maxFileSize: 5000000, // 5MB
        paramName: 'clist',
        formAcceptCharset: 'utf-8',
        message: {
            acceptFileTypes: "file type error!!",
            maxFileSize: 'File toooooo big!'
        }
    }).on('fileuploadadd', function(e, data){
            $.event.trigger({type:'uploadStateChange',currentState: 'file_loaded', filename: data.files[0].name});
        }).on('fileuploadprocessalways', function(e, data){
            var index = data.index,
                file = data.files[index];
            if(file.error){
                $.event.trigger({type:'uploadStateChange',currentState: 'file_type_error', filename: file.name});
            }else{
                // good to upload now
                data.submit();
            }
        }).on('fileuploadsubmit', function(e,data){
            $.event.trigger({type:'uploadStateChange',currentState: 'uploading'});
        }).on('fileuploaddone', function (e, data) {
            $.event.trigger({type:'uploadStateChange',currentState: 'analysing'});
            $('#upload_file_name_outer').stop(true,true).fadeOut();
            data.context = $('#client_filter_list_table > tbody');
            if(typeof data.result.error != "undefined" && data.result.error != ''){
                $.event.trigger({type:'uploadStateChange',currentState: data.result.error});
            }else if(typeof data.result.files != "undefined" && data.result.files != ''){
                client_data = data.result.files;
                $.event.trigger({type:'uploadStateChange',currentState: 'analyse_done'});
                data.context = $('#client_filter_list_table').find('tbody');
                data.context.prepend(Handlebars.templates['row'](data.result));
                $('#client_filter_list').fadeIn();
            }else{
                $.event.trigger({type:'uploadStateChange',currentState: 'error'});
            }
        }).on('fileuploadfail', function (e, data) {
            $.event.trigger({type:'uploadStateChange',currentState: 'error', error: data.errorThrown});
        });

    Handlebars.registerHelper('compare', function(lvalue, rvalue, options) {
        if (arguments.length < 3)
            throw new Error("Handlerbars Helper 'compare' needs 2 parameters");
        var operator = options.hash.operator || "==";

        var operators = {
            '==':		function(l,r) { return l == r; },
            '===':	function(l,r) { return l === r; },
            '!=':		function(l,r) { return l != r; },
            '<':		function(l,r) { return l < r; },
            '>':		function(l,r) { return l > r; },
            '<=':		function(l,r) { return l <= r; },
            '>=':		function(l,r) { return l >= r; },
            'typeof':	function(l,r) { return typeof l == r; }
        }

        if (!operators[operator])
            throw new Error("Handlerbars Helper 'compare' doesn't know the operator "+operator);

        var result = operators[operator](lvalue,rvalue);

        if( result ) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }

    });

    Handlebars.registerHelper('lang_call', function(lang_string1){
        if (arguments.length < 2)
            throw new Error("Handlerbars Helper 'lang' needs 1 parameters");

        if ('' == lang)
            throw new Error("Handlerbars Helper 'lang' needs jQuery Lang library");

        return lang.show(lang_string1);
    });

    Handlebars.registerHelper('site_url', function(){
        if(typeof site_url == 'undefined' || '' == site_url)
            throw new Error("Handlerbars Helper 'lang' needs site_url parameter");
        return site_url;
    });

    $('#export_submit').click(function(e){
        e.preventDefault();
        var cs = $('input:checkbox:checked');
        if(cs.length > 0){
            on_unload = '';
            console.log(on_unload);
            $('form').submit();
        }else{
            alert(lang.show('no_select'));
        }
    });
});

function addToMyClientList(item_id){
    var el = $('#add_to_link_'+item_id),
        cname = $('#client_name_'+item_id),
        eclient = $('#existed_client_'+item_id),
        ht = $('#high_tech_'+item_id);
        //lang_display = new $.lang({lang_file: site_url+'assets/js/lang/zh-cn.json'});
    el.text(lang.show('adding'));
    el.prop('disabled', true);
    $.get(site_url+'add_to_my_client', {item_id: item_id}, function(res){
        if(res.msg == 'success'){
            el.text(lang.show('added'));
            cname.empty().append('<a href="'+site_url+'client/'+res.data.client_id+'">'+res.data.company_name+'</a>');
            eclient.empty().append('<span class="text-success">'+lang.show('yes')+'</span>');
            ht.empty().append('<span class="'+(res.data.is_is_high_tech == 'Y' ? 'text-success' : 'text-danger')+'">'+(res.data.is_is_high_tech == 'Y' ? lang.show('yes') : lang.show('no'))+'</span>');
        }else{
            el.text(lang.show('upload_error'));
        }
    }, 'json');
}

(function($){
    'use strict';
    $.fn.resetStatusClass = function(){
        this.removeClass('text-warning text-primary text-info text-success text-danger');
        return this;
    };
    $.fn.updateStatus = function(options){
        var setting = $.extend({
            msg_content: '',
            msg_type: ''
        }, options);
        return this.resetStatusClass().addClass('text-'+setting.msg_type).text(setting.msg_content);
    };
}(jQuery));

function stateChangeHandler(e){
    'use strict';
    var upload_status = {
            await:'等待上传中...',
            uploading: '上传中...',
            file_type_error:'文件格式错误！',
            analysing:'分析名单中...',
            analyse_done: '分析完成！',
            error: '上传错误！',
            error_cols: 'CSV文件格式错误！'
        },
        uploadBtn = $('#new_client_list'),
        uploadBtn_outer = $('#client_upload'),
        uploadFileName_outer = $('#upload_file_name_outer'),
        display_status = $('#filter_status');
    switch(e.currentState){
        case 'error':
            uploadFileName_outer.addClass($(this).hasClass('has-error') ? undefined : 'has-error').find('#upload_file_name').addClass('error');
            uploadBtn.removeProp('disabled');
            uploadBtn_outer.removeClass('disabled');
            display_status.updateStatus({msg_content: e.error, msg_type: 'danger'});
            break;
        case 'analyse_done':
            //display_status.resetStatusClass().addClass('text-success').text(upload_status.done);
            display_status.updateStatus({msg_content: upload_status.analyse_done, msg_type: 'success'});
            break;
        case 'analysing':
            display_status.updateStatus({msg_content: upload_status.analysing, msg_type: 'info'});
            break;
        case 'uploading':
            uploadFileName_outer.removeClass('has-error').find('#upload_file_name').removeClass('error');
            display_status.updateStatus({msg_content: upload_status.uploading, msg_type: 'info'});
            break;
        case 'file_loaded':
            uploadBtn.prop('disabled', true);
            uploadBtn_outer.addClass($(this).hasClass('disabled') ? undefined : 'disabled');
            uploadFileName_outer.removeClass('has-error').stop(true,true).fadeIn().find('#upload_file_name').text(e.filename);
            break;
        case 'file_type_error':
            uploadFileName_outer.addClass($(this).hasClass('has-error') ? undefined : 'has-error').find('#upload_file_name').addClass('error').text(e.filename+' ('+upload_status.file_type_error+')');
            uploadBtn.removeProp('disabled');
            uploadBtn_outer.removeClass('disabled');
            display_status.updateStatus({msg_content: upload_status.file_type_error, msg_type: 'danger'});
            break;
        case 'error_cols':
            //uploadFileName_outer.addClass($(this).hasClass('has-error') ? undefined : 'has-error').find('#upload_file_name').addClass('error').text(e.filename+' ('+upload_status.error_cols+')');
            uploadBtn.removeProp('disabled');
            uploadBtn_outer.removeClass('disabled');
            display_status.updateStatus({msg_content: upload_status.error_cols, msg_type: 'danger'});
            break;
    }
}



/*
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
            '//jquery-file-upload.appspot.com/' : 'server/php/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    node
                        .append('<br>')
                        .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
*/