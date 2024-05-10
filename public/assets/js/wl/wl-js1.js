/*
 Override of ctools jump-menu to accommodate cross domain tracking.
 */

(function($) {
    Drupal.behaviors.CToolsJumpMenu = {
        attach: function(context) {
            $('.ctools-jump-menu-hide')
                .once('ctools-jump-menu')
                .hide();

            $('.ctools-jump-menu-change')
                .once('ctools-jump-menu')
                .change(function() {
                    var loc = $(this).val();
                    var urlArray = loc.split('::');
                    if (urlArray[1]) {
                        location.href = buildUrl($(this), urlArray[1]);
                    } else {
                        location.href = buildUrl($(this), loc);
                    }
                    return false;
                });

            $('.ctools-jump-menu-button')
                .once('ctools-jump-menu')
                .click(function() {
                    // Instead of submitting the form, just perform the redirect.

                    // Find our sibling value.
                    var $select = $(this).parents('form').find('.ctools-jump-menu-select');
                    var loc = $select.val();
                    var urlArray = loc.split('::');
                    if (urlArray[1]) {
                        location.href = buildUrl($(this), urlArray[1]);
                    } else {
                        location.href = buildUrl($(this), loc);
                    }
                    return false;
                });

            function buildUrl(el, location) {
                // If this jump menu is a country listing add the ga querystring.
                if ($(el).closest('.view-country-sites, .view-country-list').length > 0) {
                    return decorateUrl(location);
                }
                return location;
            }
        }
    }
})(jQuery);

function decorateUrl(location) {
    var ga = window[window['GoogleAnalyticsObject']];
    var tracker;
    if (ga && typeof ga.getAll === 'function') {
        tracker = ga.getAll()[0]; // Uses the first tracker created on the page
        if (window.gaplugins !== undefined) {
            urlString = (new window.gaplugins.Linker(tracker)).decorate(location);
            return urlString;
        }
    }
    return location;
};

(function($) {
    /**
     * Attaches 'open in new window' behavior to links with the 'target-blank'
     * class. This is used as a replacement of the regular 'target' attribute
     * which is deprecated since XHTML 1.1.
     */
    Drupal.behaviors.targetBlank = {
        attach: function(context, settings) {
            $('a.target-blank', context).once('target-blank', function() {
                $(this).append('<span>' + settings.menu_target.openTargetMessage + '</span>');
                $(this).click(function() {
                    window.open(this.href);
                    return false;
                });
            });
        }
    };

})(jQuery);;

(function($) {

    /**
     * Drupal FieldGroup object.
     */
    Drupal.FieldGroup = Drupal.FieldGroup || {};
    Drupal.FieldGroup.Effects = Drupal.FieldGroup.Effects || {};
    Drupal.FieldGroup.groupWithfocus = null;

    Drupal.FieldGroup.setGroupWithfocus = function(element) {
        element.css({
            display: 'block'
        });
        Drupal.FieldGroup.groupWithfocus = element;
    }

    /**
     * Implements Drupal.FieldGroup.processHook().
     */
    Drupal.FieldGroup.Effects.processFieldset = {
        execute: function(context, settings, type) {
            if (type == 'form') {
                // Add required fields mark to any fieldsets containing required fields
                $('fieldset.fieldset', context).once('fieldgroup-effects', function(i) {
                    if ($(this).is('.required-fields') && $(this).find('.form-required').length > 0) {
                        $('legend span.fieldset-legend', $(this)).eq(0).append(' ').append($('.form-required').eq(0).clone());
                    }
                    if ($('.error', $(this)).length) {
                        $('legend span.fieldset-legend', $(this)).eq(0).addClass('error');
                        Drupal.FieldGroup.setGroupWithfocus($(this));
                    }
                });
            }
        }
    }

    /**
     * Implements Drupal.FieldGroup.processHook().
     */
    Drupal.FieldGroup.Effects.processAccordion = {
        execute: function(context, settings, type) {
            $('div.field-group-accordion-wrapper', context).once('fieldgroup-effects', function() {
                var wrapper = $(this);

                // Get the index to set active.
                var active_index = false;
                wrapper.find('.accordion-item').each(function(i) {
                    if ($(this).hasClass('field-group-accordion-active')) {
                        active_index = i;
                    }
                });

                wrapper.accordion({
                    heightStyle: "content",
                    active: active_index,
                    collapsible: true,
                    changestart: function(event, ui) {
                        if ($(this).hasClass('effect-none')) {
                            ui.options.animated = false;
                        } else {
                            ui.options.animated = 'slide';
                        }
                    }
                });

                if (type == 'form') {

                    var $firstErrorItem = false;

                    // Add required fields mark to any element containing required fields
                    wrapper.find('div.field-group-accordion-item').each(function(i) {

                        if ($(this).is('.required-fields') && $(this).find('.form-required').length > 0) {
                            $('h3.ui-accordion-header a').eq(i).append(' ').append($('.form-required').eq(0).clone());
                        }
                        if ($('.error', $(this)).length) {
                            // Save first error item, for focussing it.
                            if (!$firstErrorItem) {
                                $firstErrorItem = $(this).parent().accordion("activate", i);
                            }
                            $('h3.ui-accordion-header').eq(i).addClass('error');
                        }
                    });

                    // Save first error item, for focussing it.
                    if (!$firstErrorItem) {
                        $('.ui-accordion-content-active', $firstErrorItem).css({
                            height: 'auto',
                            width: 'auto',
                            display: 'block'
                        });
                    }

                }
            });
        }
    }

    /**
     * Implements Drupal.FieldGroup.processHook().
     */
    Drupal.FieldGroup.Effects.processHtabs = {
        execute: function(context, settings, type) {
            if (type == 'form') {
                // Add required fields mark to any element containing required fields
                $('fieldset.horizontal-tabs-pane', context).once('fieldgroup-effects', function(i) {
                    if ($(this).is('.required-fields') && $(this).find('.form-required').length > 0) {
                        $(this).data('horizontalTab').link.find('strong:first').after($('.form-required').eq(0).clone()).after(' ');
                    }
                    if ($('.error', $(this)).length) {
                        $(this).data('horizontalTab').link.parent().addClass('error');
                        Drupal.FieldGroup.setGroupWithfocus($(this));
                        $(this).data('horizontalTab').focus();
                    }
                });
            }
        }
    }

    /**
     * Implements Drupal.FieldGroup.processHook().
     */
    Drupal.FieldGroup.Effects.processTabs = {
        execute: function(context, settings, type) {
            if (type == 'form') {

                var errorFocussed = false;

                // Add required fields mark to any fieldsets containing required fields
                $('fieldset.vertical-tabs-pane', context).once('fieldgroup-effects', function(i) {
                    if ($(this).is('.required-fields') && $(this).find('.form-required').length > 0) {
                        $(this).data('verticalTab').link.find('strong:first').after($('.form-required').eq(0).clone()).after(' ');
                    }
                    if ($('.error', $(this)).length) {
                        $(this).data('verticalTab').link.parent().addClass('error');
                        // Focus the first tab with error.
                        if (!errorFocussed) {
                            Drupal.FieldGroup.setGroupWithfocus($(this));
                            $(this).data('verticalTab').focus();
                            errorFocussed = true;
                        }
                    }
                });
            }
        }
    }

    /**
     * Implements Drupal.FieldGroup.processHook().
     *
     * TODO clean this up meaning check if this is really
     *      necessary.
     */
    Drupal.FieldGroup.Effects.processDiv = {
        execute: function(context, settings, type) {

            $('div.collapsible', context).once('fieldgroup-effects', function() {
                var $wrapper = $(this);

                // Turn the legend into a clickable link, but retain span.field-group-format-toggler
                // for CSS positioning.

                var $toggler = $('span.field-group-format-toggler:first', $wrapper);
                var $link = $('<a class="field-group-format-title" href="#"></a>');
                $link.prepend($toggler.contents());

                // Add required field markers if needed
                if ($(this).is('.required-fields') && $(this).find('.form-required').length > 0) {
                    $link.append(' ').append($('.form-required').eq(0).clone());
                }

                $link.appendTo($toggler);

                // .wrapInner() does not retain bound events.
                $link.click(function() {
                    var wrapper = $wrapper.get(0);
                    // Don't animate multiple times.
                    if (!wrapper.animating) {
                        wrapper.animating = true;
                        var speed = $wrapper.hasClass('speed-fast') ? 300 : 1000;
                        if ($wrapper.hasClass('effect-none') && $wrapper.hasClass('speed-none')) {
                            $('> .field-group-format-wrapper', wrapper).toggle();
                        } else if ($wrapper.hasClass('effect-blind')) {
                            $('> .field-group-format-wrapper', wrapper).toggle('blind', {}, speed);
                        } else {
                            $('> .field-group-format-wrapper', wrapper).toggle(speed);
                        }
                        wrapper.animating = false;
                    }
                    $wrapper.toggleClass('collapsed');
                    return false;
                });

            });
        }
    };

    /**
     * Behaviors.
     */
    Drupal.behaviors.fieldGroup = {
        attach: function(context, settings) {
            settings.field_group = settings.field_group || Drupal.settings.field_group;
            if (settings.field_group == undefined) {
                return;
            }

            // Execute all of them.
            $.each(Drupal.FieldGroup.Effects, function(func) {
                // We check for a wrapper function in Drupal.field_group as
                // alternative for dynamic string function calls.
                var type = func.toLowerCase().replace("process", "");
                if (settings.field_group[type] != undefined && $.isFunction(this.execute)) {
                    this.execute(context, settings, settings.field_group[type]);
                }
            });

            // Fixes css for fieldgroups under vertical tabs.
            $('.fieldset-wrapper .fieldset > legend').css({
                display: 'block'
            });
            $('.vertical-tabs fieldset.fieldset').addClass('default-fallback');

            // Add a new ID to each fieldset.
            $('.group-wrapper .horizontal-tabs-panes > fieldset', context).once('group-wrapper-panes-processed', function() {
                // Tats bad, but we have to keep the actual id to prevent layouts to break.
                var fieldgroupID = 'field_group-' + $(this).attr('id');
                $(this).attr('id', fieldgroupID);
            });
            // Set the hash in url to remember last userselection.
            $('.group-wrapper ul li').once('group-wrapper-ul-processed', function() {
                var fieldGroupNavigationListIndex = $(this).index();
                $(this).children('a').click(function() {
                    var fieldset = $('.group-wrapper fieldset').get(fieldGroupNavigationListIndex);
                    // Grab the first id, holding the wanted hashurl.
                    var hashUrl = $(fieldset).attr('id').replace(/^field_group-/, '').split(' ')[0];
                    window.location.hash = hashUrl;
                });
            });

        }
    };

})(jQuery);;
/**
 * @file
 * The RRSSB Drupal Behavior to configure settings.
 */

(function($) {
    Drupal.behaviors.rrssb = {
        attach: function(context, settings) {
            rrssbConfigAll(settings.rrssb);
        }
    };
})(jQuery);; +
function(i, t, e) {
    "use strict";
    var s = {
            size: {
                min: .1,
                max: 10,
                default: 1
            },
            shrink: {
                min: .2,
                max: 1,
                default: .8
            },
            regrow: {
                min: .2,
                max: 1,
                default: .8
            },
            minRows: {
                min: 1,
                max: 99,
                default: 1
            },
            maxRows: {
                min: 1,
                max: 99,
                default: 2
            },
            prefixReserve: {
                min: 0,
                max: .8,
                default: .3
            },
            prefixHide: {
                min: .1,
                max: 10,
                default: 2
            },
            alignRight: {
                type: "boolean",
                default: !1
            }
        },
        n = function() {
            var i = t.fn.jquery.split(".");
            return 1 == i[0] && i[1] < 8
        }();
    i.rrssbConfigAll = function(i) {
        t(".rrssb").each(function() {
            t(this).rrssbConfig(i)
        })
    }, t.fn.rrssbConfig = function(i) {
        if (!t(this).data("settings") || i) {
            var e = {};
            for (var n in s) e[n] = s[n].default, i && ("boolean" == s[n].type ? e[n] = Boolean(i[n]) : isNaN(parseFloat(i[n])) || (e[n] = Math.min(s[n].max, Math.max(s[n].min, i[n]))));
            t(this).data("settings", e), h.call(this)
        }
    };
    var r, a = function() {
            t(".rrssb").each(h)
        },
        h = function() {
            var i = t(this).data("orig");
            i || (i = function() {
                var i = t(".rrssb-prefix", this),
                    e = i.length ? i.clone().css({
                        visibility: "hidden",
                        "white-space": "nowrap",
                        display: "inline"
                    }).appendTo(this) : null;
                t("ul").contents().filter(function() {
                    return this.nodeType === Node.TEXT_NODE
                }).remove();
                var s = {
                    width: 0,
                    buttons: 0,
                    height: t("li", this).innerHeight(),
                    fontSize: parseFloat(t(this).css("font-size")),
                    prefixWidth: e ? e.innerWidth() : 0
                };
                return t("li", this).each(function() {
                    s.width = Math.max(s.width, t(this).innerWidth()), s.buttons++
                }), t(this).data("orig", s), e && e.remove(), s
            }.call(this));
            var e = t(this).data("settings"),
                s = i.width * e.size,
                r = i.buttons,
                a = t(this).innerWidth() - 1,
                h = a < s * e.shrink ? "" : s;
            n ? t("li", this).width(h) : t("li", this).innerWidth(h);
            var o = a / e.shrink,
                l = i.prefixWidth * e.size;
            l > o * e.prefixHide ? (l = 0, t(".rrssb-prefix", this).css("display", "none")) : t(".rrssb-prefix", this).css("display", "");
            var c = l <= a * e.prefixReserve ? o - l : o,
                f = Math.floor(c / s);
            f * e.maxRows < r ? (t(this).addClass("no-label"), s = i.height * e.size, f = Math.max(1, Math.floor(c / s))) : t(this).removeClass("no-label");
            var d = e.minRows > 1 ? Math.max(1, Math.ceil(r / (e.minRows - 1)) - 1) : r;
            f = Math.min(f, d), f = Math.ceil(r / Math.ceil(r / f)), d = Math.ceil(r / Math.ceil(r / d));
            var u = Math.floor(1e4 / f) / 100;
            t("li", this).css("max-width", u + "%");
            var m = s * f + l;
            m > o && (m -= l, l = 0);
            var p = f < d ? e.regrow : 1,
                g = Math.min(p, a / m),
                b = i.fontSize * e.size * g * .98;
            if (t(this).css("font-size", b + "px"), l) {
                var x = Math.floor(1e4 * l / m) / 100;
                t(".rrssb-buttons", this).css("padding-left", x + "%"), t(".rrssb-prefix", this).css("position", "absolute");
                var v = Math.ceil(r / f) * i.height / i.fontSize;
                t(".rrssb-prefix", this).css("line-height", v + "em")
            } else t(".rrssb-buttons", this).css("padding-left", ""), t(".rrssb-prefix", this).css("position", ""), t(".rrssb-prefix", this).css("line-height", "");
            var w = e.alignRight ? "padding-left" : "padding-right";
            if (g >= .999 * p) {
                var M = Math.floor(1e4 * (a - m * g * 1.02) / a) / 100;
                t(this).css(w, M + "%")
            } else t(this).css(w, "")
        },
        o = function(i) {
            r && clearTimeout(r), r = setTimeout(a, i || 200)
        };
    t(document).ready(function() {
        t(".rrssb-buttons a.popup").click(function(e) {
            ! function(t, e, s, n) {
                var r = void 0 !== i.screenLeft ? i.screenLeft : screen.left,
                    a = void 0 !== i.screenTop ? i.screenTop : screen.top,
                    h = (i.innerWidth ? i.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width) / 2 - s / 2 + r,
                    o = (i.innerHeight ? i.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height) / 3 - n / 3 + a,
                    l = i.open(t, e, "scrollbars=yes, width=" + s + ", height=" + n + ", top=" + o + ", left=" + h);
                l && l.focus && l.focus()
            }(t(this).attr("href"), t(this).find(".rrssb-text").html(), 580, 470), e.preventDefault()
        }), t(i).resize(o), t(document).ready(function() {
            rrssbConfigAll()
        })
    })
}(window, jQuery);;