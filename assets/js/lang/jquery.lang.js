(function($){
    'use strict';
    $.lang = function(o){
        var lang_strings,
        defaults = {
            lang: 'zh-cn',
            lang_file: 'zh-cn.json'
        };

        var p = this;
        p.s = {};

        var init = function(){
            p.s = $.extend({}, defaults, o);
            $.getJSON(p.s.lang_file, function(g){
                p.lang_strings = g.language[p.s.lang];
            })
        };

        p.show = function(string){
            return p.lang_strings[string];
        };

        init();
    }
}(jQuery));