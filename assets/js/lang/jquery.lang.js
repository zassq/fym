(function($){
    'use strict';
    $.lang = function(o){
        var defaults = {
            lang: 'zh-cn',
            lang_file: 'zh-cn.json',
            afterInit : null
        };

        var p = this;
        p.s = {};
        p.lang_strings = '';

        var init = function(){
            p.s = $.extend({}, defaults, o);
            $.getJSON(p.s.lang_file, function(g){
                p.lang_strings = g.language[p.s.lang];
                if('function' == typeof p.s.afterInit) p.s.afterInit.call(p);
            });
        };

        p.show = function(string){
            return p.lang_strings[string];
        };

        init();
    }
}(jQuery));