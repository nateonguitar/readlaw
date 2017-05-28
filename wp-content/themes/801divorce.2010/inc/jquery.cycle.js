/*
 * jQuery Cycle Plugin for light-weight slideshows
 * Examples and documentation at: http://malsup.com/jquery/cycle/
 *
 * @author: M. Alsup
 * @version: 1.0.2 (7/24/2007)
 * @requires jQuery v1.1.2 or later
 *
 * Based on the work of:
 *  1) Matt Oakes (http://portfolio.gizone.co.uk/applications/slideshow/)
 *  2) Torsten Baldes (http://medienfreunde.com/lab/innerfade/)
 */
(function($) {

$.fn.cycle = function(options) {
    return this.each(function() {
        if (options && options == 'stop') {
            if (this.cycleTimeout) clearTimeout(this.cycleTimeout);
            this.cycleTimeout = 0;
            return;
        }
        var $this = $(this), els = $this.children();
        if (els.length < 2) return; // don't bother

        var opts = $.extend({}, $.fn.cycle.defaults, options || {}, $.meta ? $this.data() : {});
        if (opts.autostop) opts.countdown = els.length-1;

        // allow shorthand overrides of width, height and timeout
        var cls = this.className;
        var w = parseInt((cls.match(/w:(\d+)/)||[])[1]) || opts.width
        var h = parseInt((cls.match(/h:(\d+)/)||[])[1]) || opts.height;
        opts.timeout = parseInt((cls.match(/t:(\d+)/)||[])[1]) || opts.timeout;

        // make sure the timeout and speed settings are sane
        if (opts.speed.constructor == String)
            opts.speed = {slow: 600, fast: 200}[opts.speed] || 400;
        while((opts.timeout - opts.speed) < 250)
            opts.timeout += opts.speed;

        if ($this.css('position') == 'static') $this.css('position', 'relative');
        if (w) $this.width(w);
        if (h && h != 'auto') $this.height(h);

        var $els = $(els).each(function(i){$(this).css('z-index', els.length-i);}).css('position','absolute').hide();
        if (opts.fit && w) $els.width(w);
        if (opts.fit && h && h != 'auto') $els.height(h);
        $(els[0]).show();

        if (opts.pause)
            $this.hover(function(){opts.paused=1;}, function(){opts.paused=0;});

        opts.current = opts.random ? (Math.floor(Math.random() * (els.length-1)))+1 : 1;
        opts.last = 0;
        this.cycleTimeout = setTimeout(function(){$.fn.cycle.go(els, opts)}, opts.timeout);
    });
};

$.fn.cycle.go = function (els, opts) {
    if (els[0].parentNode.cycleTimeout === 0) return;
    if (!opts.paused) {
        if (opts.fade) {
            $.fn.cycle.fadeToggle(els[opts.last], opts.speed);
            $.fn.cycle.fadeToggle(els[opts.current], opts.speed);
        }
        else {
            $(els[opts.last]).slideUp(opts.speed);
            $(els[opts.current]).slideDown(opts.speed);
        }

        if (opts.random) {
            opts.last = opts.current;
            while (opts.current == opts.last)
                opts.current = Math.floor(Math.random() * els.length);
        }
        else { // sequence
            var roll = (opts.current + 1) == els.length;
            opts.current = roll ? 0 : opts.current+1;
            opts.last    = roll ? els.length-1 : opts.current-1;
        }
    }
    if (opts.autostop && --opts.countdown == 0) return;
    setTimeout(function() { $.fn.cycle.go(els, opts) }, opts.timeout);
};

// this allows more flexibility than the core fade methods
$.fn.cycle.fadeToggle = function(el, speed){
   var $el = $(el);
   var to = $el.is(':visible') && $el.css('opacity') > 0 ? 0 : 1;
   if (to) $el.css('opacity',0).show();
   $el.fadeTo(speed, to, function() {
       to ? $(this).show() : $(this).hide();
   });
};

$.fn.cycle.defaults = {
    height:  'auto',   // container height
    fade:     1,       // true for fade, false for slide
    speed:    400,     // any valid fx speed value
    timeout:  4000,    // ms duration for each slide
    random:   0,       // true for random, false for sequence
    fit:      0,       // force slides to fit container
    pause:    0,       // true to enable "pause on hover"
    autostop: 0        // true to end slideshow after X slides have been shown (where X == slide count)
                       // (note that if random == true not all slides are guaranteed to have been shown)
};

})(jQuery);
