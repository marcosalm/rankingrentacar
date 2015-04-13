(function($) {
    $.fn.extend({
        destaque: function(settings) {
            var config = {
                start: 0,
                btn: '.contMarcador',
                next: '.next',
                prev: '.previous',
                curr: '.ativo',
                show: 0,
                onChange: function() {},
                onStart: function() {}
            };

            if (settings) {
                $.extend(config, settings);
            }

            return this.each(function() {
                var $me = $(this);
                var $items = $me.find('li:not(:has(' + config.next + ', ' + config.prev + '))');
                var $next = $(config.next);
                var $prev = $(config.prev);
                var $btn = $(config.btn);
                var item = config.start;
                var max = $items.size();
                var timer;

                var width = $items.eq(0).outerWidth(true);

                var methods = {
                    init: function() {
                        methods.normalize();
                        methods.bindClick();
                        methods.buildButtons();
                        methods.bindBtnClick();
                        methods.setActive();
                        methods.start();
                    },

                    normalize: function() {
                        $me.css('position', 'relative');

                        $items.css({
                            'position': 'absolute',
                            'top': 0,
                            'left': 0
                        });

                        $next.css('z-index', 1);
                        $prev.css('z-index', 1);
                    },

                    bindClick: function() {
                        $next.bind('click.destaque', methods.moveNext);
                        $prev.bind('click.destaque', methods.movePrev);
                    },

                    bindBtnClick: function() {
                        $btn.find('li').bind('click.destaque', function() {
                            methods.moveTo($(this).index());
                        });
                    },

                    buildButtons: function() {
                        var nav = '<ol>';
                        for (i = 0; i < max; i++) {
                            nav += '<li><a class="marcador" href="javascript:void(0);"></a></li>';
                        }
                        nav += '</ol>';

                        $btn.append(nav);
                    },
                    
                    startTimer: function() {
                        timer = setTimeout(function() {
                            index = item+1;
                            
                            if (index >= max) {
                                index = 0;
                            }
                            
                            config.onChange(index);
                            methods.moveTo(index);
                            
                        }, config.show);
                    },

                    moveNext: function() {
                        clearTimeout(timer);
                        
                        if (item < max - 1) {
                            item++;
                        } else {
                            item = 0;
                        }

                        $items.eq(item).fadeIn('slow');
                        $items.eq(item - 1).fadeOut('slow', function() {
                            methods.startTimer();
                            config.onChange(item);
                        });

                        methods.setActive();
                        
                    },

                    movePrev: function() {
                        clearTimeout(timer);
                        
                        if (item != 0) {
                            item--;
                        } else {
                            item = max - 1;
                        }

                        $items.eq(item).fadeIn('slow');
                        $items.eq(item + 1).fadeOut('slow', function() {
                            methods.startTimer();
                            config.onChange(item);
                        });

                        methods.setActive();
                        
                    },

                    moveTo: function(index, duration) {
                        clearTimeout(timer);
                        
                        if (duration) { duration = parseInt(duration / 2); }
                        else { duration = 'slow'; }
                        
                        if (index != item) {
                            $items.eq(index).fadeIn(duration);
                            $items.eq(item).fadeOut(duration, methods.moveAuto);
                            config.onChange(index);
                        }

                        item = index;
                        
                        methods.setActive();
                    },

                    moveAuto: function() {
                        if (config.show > 0) {
                            methods.startTimer();
                        }
                    },

                    setActive: function() {
                        var clss = config.curr.replace('.', '');
                        $btn.find('li > a').removeClass(clss).eq(item).addClass(clss);
                    },

                    start: function() {
                        $items.hide();
                        $items.eq(item).show();
                        config.onStart(item);

                        methods.moveAuto();
                    }
                };

                methods.init();
            });
        }
    });
})(jQuery);