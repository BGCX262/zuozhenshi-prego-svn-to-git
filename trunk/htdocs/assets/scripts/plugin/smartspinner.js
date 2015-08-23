(function($) {
    $.fn.extend({
        spinit: function(options) {
            var settings = $.extend({ min: 0, max: 9999999, initValue: 0, callback: null, stepInc: 1, pageInc: 10, width: 50, height: 15, btnWidth: 10, mask: '' }, options);
            return this.each(function() {
                var UP = 38;
                var DOWN = 40;
                var PAGEUP = 33;
                var PAGEDOWN = 34;
                var mouseCaptured = false;
                var mouseIn = false;
                var interval;
                var direction = 'none';
                var isPgeInc = false;
                var value = ($(this).val()) ? $(this).val() : 0;
                var el = $(this).val(value).addClass('smartspinner');
                raiseCallback(value);
                $.fn.reset = function(val) {
                    if (isNaN(val)) val = 0;
                    value = Math.max(val, settings.min);
                    $(this).val(value);
                    raiseCallback(value);
                };
                function setDirection(dir) {
                    direction = dir;
                    isPgeInc = false;
                    switch (dir) {
                        case 'up':
                            setClass('up');
                            break;
                        case 'down':
                            setClass('down');
                            break;
                        case 'pup':
                            isPgeInc = true;
                            setClass('up');
                            break;
                        case 'pdown':
                            isPgeInc = true;
                            setClass('down');
                            break;
                        case 'none':
                            setClass('');
                            break;
                    }
                }
                el.click(function(e) {
                    mouseCaptured = true;
                    isPgeInc = false;
                    clearInterval(interval);
                    onValueChange();
                });
                el.mousemove(function(e) {

                    if (e.pageX > (el.offset().left + settings.width) - settings.btnWidth - 4) {
                        if (e.pageY < el.offset().top + settings.height / 2)
                            setDirection('up');
                        else
                            setDirection('down');
                    }
                    else
                        setDirection('none');
                });
                el.mousedown(function(e) {
                    isPgeInc = false;
                    clearInterval(interval);
                    interval = setInterval(onValueChange, 100);
                });
                el.mouseup(function(e) {
                    mouseCaptured = false;
                    isPgeInc = false;
                    clearInterval(interval);

                });
                el.mouseleave(function(e) {
                    setDirection('none');
                    if (settings.mask != '') el.val(settings.mask);
                }); el.keydown(function(e) {
                    switch (e.which) {
                        case UP:
                            setDirection('up');
                            onValueChange();
                            break; // Arrow Up
                        case DOWN:
                            setDirection('down');
                            onValueChange();
                            break; // Arrow Down
                        case PAGEUP:
                            setDirection('pup');
                            onValueChange();
                            break; // Page Up
                        case PAGEDOWN:
                            setDirection('pdown');
                            onValueChange();
                            break; // Page Down
                        default:
                            setDirection('none');
                            break;
                    }
                });

                el.keyup(function(e) {
                    setDirection('none');
                });
                el.keypress(function(e) {
                    if (el.val() == settings.mask) el.val(value);
                    var sText = getSelectedText();
                    if (sText != '') {
                        sText = el.val().replace(sText, '');
                        el.val(sText);
                    }
                    if (e.which >= 48 && e.which <= 57) {
                        var temp = parseFloat(el.val() + (e.which - 48));
                        if (temp >= settings.min && temp <= settings.max) {
                            value = temp;
                            raiseCallback(value);
                        }
                        else {
                            e.preventDefault();
                        }
                    }
                });
                el.blur(function() {
                    if (settings.mask == '') {
                        if (el.val() == '')
                            el.val(settings.min);
                    }
                    else {
                        el.val(settings.mask);
                    }
                });
                el.bind("mousewheel", function(e,d) {
					
                    if (e.originalEvent.wheelDelta >= 120) {
                        setDirection('up');
                        onValueChange();
                    }
                    else if (e.originalEvent.wheelDelta <= -120) {
                        setDirection('down');
                        onValueChange();
                    }

                    e.preventDefault();
                });
                if (this.addEventListener) {
                    this.addEventListener('DOMMouseScroll', function(e) {
                        if (e.detail > 0) {
                            setDirection('down');
                            onValueChange();
                        }
                        else if (e.detail < 0) {
                            setDirection('up');
                            onValueChange();
                        }
                        e.preventDefault();
                    }, false);
                }

                function raiseCallback(val) {
                    if (settings.callback != null) settings.callback(val);
                }
                function getSelectedText() {

                    var startPos = el.get(0).selectionStart;
                    var endPos = el.get(0).selectionEnd;
                    var doc = document.selection;

                    if (doc && doc.createRange().text.length != 0) {
                        return doc.createRange().text;
                    } else if (!doc && el.val().substring(startPos, endPos).length != 0) {
                        return el.val().substring(startPos, endPos);
                    }
                    return '';
                }
                function setValue(a, b) {
                    if (a >= settings.min && a <= settings.max) {
                        value = b;
                    } el.val(value);
                }
                function onValueChange() {
					
					value = el.val();
					
                    if (direction == 'up') {
                        value = Number(value)+settings.stepInc;
                        if (value > settings.max) value = settings.max;
                    }
                    if (direction == 'down') {
                        value -= settings.stepInc;
                        if (value < settings.min) value = settings.min;
                    }
                    if (direction == 'pup') {
                        value += settings.pageInc;
                        if (value > settings.max) value = settings.max;
                    }
                    if (direction == 'pdown') {
                        value -= settings.pageInc;
                        if (value < settings.min) value = settings.min;
                    }
					
					if(el.hasClass("spin_month")){
						if(value == 0){value = 12;}
						else if(value == 13){value = 1;}
					}
					
					if(el.hasClass("spin_time")){
						if(value == 25){value = 1;}
						else if(value == 0){value = 24;}
					}
					
					if(el.hasClass("spin_minute")){
						if(value == 60){value = 59;}
						else if(value == -1){value = 59;}
					}
					
                    setValue(parseFloat(el.val()), value);
					
                    raiseCallback(value);
                }
                function setClass(name) {
                    el.removeClass('up').removeClass('down');
                    if (name != '') el.addClass(name);
                }
            });
        }
    });
})(jQuery);