$(document).ready(function () {
    var input = $(".inputTable").dataTable({
        "sDom": 't',
        'bSort': false,
    });

    if (input.length) {
        var keys = new $.fn.dataTable.KeyTable(input);
        /* Event listener for all cells */
        keys.event.focus(null, null, function () {
            /* handler for focus events on all cells ... */
            $(keys.fnGetCurrentTD()).children().focus();
        });

        keys.event.blur(0, null, function () {
            /* handler for blur events on all cells ... */
            $(".datepicker").datepicker('hide');
        });

        keys.event.focus(1, null, function () {
            /* handler for focus events on all cells ... */
            $(keys.fnGetCurrentTD()).children("select").simulate("mousedown");
        });

        keys.event.focus(2, null, function () {
            /* handler for focus events on all cells ... */
            $(keys.fnGetCurrentTD()).children("select").simulate("mousedown");
        });
    }

    $(".autonummer").trigger("change");
});

/* 
 * ==================== BINDINGS ====================
 */

$(".autonummer").change(function () {
    var e = $(this).children(":selected");
    var id = e.attr("id");
    var target = e.attr("data-target");

    $.ajax({
        type: "GET",
        url: '/autos/get_kmstand/' + id,
        dataType: "json",
        success: function (data) {
            $("#" + target).val(data);
        }
    });
});

$(".ophaalpunt").change(function () {
    var e = $(this).children(":selected");
    var id = e.attr("id");
    var target = e.attr("data-target");

    $.ajax({
        type: "GET",
        url: '/ritregistratie/ophaalpunten/get_kosten/' + id,
        dataType: "json",
        success: function (data) {
            $("#" + target).val(data);
        }
    });
});

$(".auto_verbruik").change(function () {
    var b = parseFloat($("#beginstand").val().replace(',', '.'));
    var e = parseFloat($("#eindstand").val().replace(',', '.'));
    var l = parseFloat($("#liters").val().replace(',', '.'));

    if ((b > 0) && (e > b) && (l > 0)) {
        $("#verbruik").val(((e - b) / l));
    }
});

$(".verbruik").keyup(function () {
    $(this).val($(this).val().replace(',', '.'));
    var id = $(this).attr("data-id");
    var b = parseFloat($("#beginstand" + id).val().replace(',', '.'));
    var e = parseFloat($("#eindstand" + id).val().replace(',', '.'));
    var l = parseFloat($("#liters" + id).val().replace(',', '.'));

    if ((b > 0) && (e > b) && (l > 0)) {
        $("#verbruik" + id).val(((e - b) / l));
    }
});

/* 
 * ==================== PLUGINS ====================
 */


/*
 * jquery.simulate - simulate browser mouse and keyboard events
 *
 * Copyright (c) 2009 Eduardo Lundgren (eduardolundgren@gmail.com)
 * and Richard D. Worth (rdworth@gmail.com)
 *
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) 
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 */

;(function ($) {

    $.fn.extend({
        simulate: function (type, options) {
            return this.each(function () {
                var opt = $.extend({}, $.simulate.defaults, options || {});
                new $.simulate(this, type, opt);
            });
        }
    });

    $.simulate = function (el, type, options) {
        this.target = el;
        this.options = options;

        if (/^drag$/.test(type)) {
            this[type].apply(this, [this.target, options]);
        } else {
            this.simulateEvent(el, type, options);
        }
    };

    $.extend($.simulate.prototype, {
        simulateEvent: function (el, type, options) {
            var evt = this.createEvent(type, options);
            this.dispatchEvent(el, type, evt, options);
            return evt;
        },
        createEvent: function (type, options) {
            if (/^mouse(over|out|down|up|move)|(dbl)?click$/.test(type)) {
                return this.mouseEvent(type, options);
            } else if (/^key(up|down|press)$/.test(type)) {
                return this.keyboardEvent(type, options);
            }
        },
        mouseEvent: function (type, options) {
            var evt;
            var e = $.extend({
                bubbles: true, cancelable: (type != "mousemove"), view: window, detail: 0,
                screenX: 0, screenY: 0, clientX: 0, clientY: 0,
                ctrlKey: false, altKey: false, shiftKey: false, metaKey: false,
                button: 0, relatedTarget: undefined
            }, options);

            var relatedTarget = $(e.relatedTarget)[0];

            if ($.isFunction(document.createEvent)) {
                evt = document.createEvent("MouseEvents");
                evt.initMouseEvent(type, e.bubbles, e.cancelable, e.view, e.detail,
                    e.screenX, e.screenY, e.clientX, e.clientY,
                    e.ctrlKey, e.altKey, e.shiftKey, e.metaKey,
                    e.button, e.relatedTarget || document.body.parentNode);
            } else if (document.createEventObject) {
                evt = document.createEventObject();
                $.extend(evt, e);
                evt.button = {0: 1, 1: 4, 2: 2}[evt.button] || evt.button;
            }
            return evt;
        },
        keyboardEvent: function (type, options) {
            var evt;

            var e = $.extend({
                bubbles: true, cancelable: true, view: window,
                ctrlKey: false, altKey: false, shiftKey: false, metaKey: false,
                keyCode: 0, charCode: 0
            }, options);

            if ($.isFunction(document.createEvent)) {
                try {
                    evt = document.createEvent("KeyEvents");
                    evt.initKeyEvent(type, e.bubbles, e.cancelable, e.view,
                        e.ctrlKey, e.altKey, e.shiftKey, e.metaKey,
                        e.keyCode, e.charCode);
                } catch (err) {
                    evt = document.createEvent("Events");
                    evt.initEvent(type, e.bubbles, e.cancelable);
                    $.extend(evt, {
                        view: e.view,
                        ctrlKey: e.ctrlKey, altKey: e.altKey, shiftKey: e.shiftKey, metaKey: e.metaKey,
                        keyCode: e.keyCode, charCode: e.charCode
                    });
                }
            } else if (document.createEventObject) {
                evt = document.createEventObject();
                $.extend(evt, e);
            }
            if (($.browser !== undefined) && ($.browser.msie || $.browser.opera)) {
                evt.keyCode = (e.charCode > 0) ? e.charCode : e.keyCode;
                evt.charCode = undefined;
            }
            return evt;
        },

        dispatchEvent: function (el, type, evt) {
            if (el.dispatchEvent) {
                el.dispatchEvent(evt);
            } else if (el.fireEvent) {
                el.fireEvent('on' + type, evt);
            }
            return evt;
        },

        drag: function (el) {
            var self = this, center = this.findCenter(this.target),
                options = this.options, x = Math.floor(center.x), y = Math.floor(center.y),
                dx = options.dx || 0, dy = options.dy || 0, target = this.target;
            var coord = {clientX: x, clientY: y};
            this.simulateEvent(target, "mousedown", coord);
            coord = {clientX: x + 1, clientY: y + 1};
            this.simulateEvent(document, "mousemove", coord);
            coord = {clientX: x + dx, clientY: y + dy};
            this.simulateEvent(document, "mousemove", coord);
            this.simulateEvent(document, "mousemove", coord);
            this.simulateEvent(target, "mouseup", coord);
        },
        findCenter: function (el) {
            var el = $(this.target), o = el.offset();
            return {
                x: o.left + el.outerWidth() / 2,
                y: o.top + el.outerHeight() / 2
            };
        }
    });

    $.extend($.simulate, {
        defaults: {
            speed: 'sync'
        },
        VK_TAB: 9,
        VK_ENTER: 13,
        VK_ESC: 27,
        VK_PGUP: 33,
        VK_PGDN: 34,
        VK_END: 35,
        VK_HOME: 36,
        VK_LEFT: 37,
        VK_UP: 38,
        VK_RIGHT: 39,
        VK_DOWN: 40
    });

})(jQuery);