// GLOBAL jQuery
(function($) {
    // Add behaviours for refiring JS component init method after ajax calls.
    Drupal.behaviors.suiTheme = {
        attach: function(context, settings) {
            if (typeof bcSui !== "undefined") {
                $("body")
                    .once("suiTheme-ajax")
                    .ajaxComplete(function(e, xhr, settings) {
                        /* Show / Hides */
                        bcSui.components.tabs.init();
                        /* Mobile Tables */
                        bcSui.components.mobileTables.init();
                    });
            }
        }
    };
})(jQuery);;
/**
 * Copied Bootstrap theme js/misc.ajax.js
 */
(function($) {

    /**
     * Override Bootstraps's override of Drupal's AJAX prototype so we can override 
     * the throbber HTML used.
     */

    /**
     * Override Drupal's AJAX prototype beforeSend function so it can append the
     * throbber inside the pager links.
     */

    if (typeof Drupal !== undefined && Drupal.ajax) {

        Drupal.ajax.prototype.beforeSend = function(xmlhttprequest, options) {
            // For forms without file inputs, the jQuery Form plugin serializes the form
            // values, and then calls jQuery's $.ajax() function, which invokes this
            // handler. In this circumstance, options.extraData is never used. For forms
            // with file inputs, the jQuery Form plugin uses the browser's normal form
            // submission mechanism, but captures the response in a hidden IFRAME. In this
            // circumstance, it calls this handler first, and then appends hidden fields
            // to the form to submit the values in options.extraData. There is no simple
            // way to know which submission mechanism will be used, so we add to extraData
            // regardless, and allow it to be ignored in the former case.
            if (this.form) {
                options.extraData = options.extraData || {};

                // Let the server know when the IFRAME submission mechanism is used. The
                // server can use this information to wrap the JSON response in a TEXTAREA,
                // as per http://jquery.malsup.com/form/#file-upload.
                options.extraData.ajax_iframe_upload = '1';

                // The triggering element is about to be disabled (see below), but if it
                // contains a value (e.g., a checkbox, textfield, select, etc.), ensure that
                // value is included in the submission. As per above, submissions that use
                // $.ajax() are already serialized prior to the element being disabled, so
                // this is only needed for IFRAME submissions.
                var v = $.fieldValue(this.element);
                if (v !== null) {
                    options.extraData[this.element.name] = v;
                }
            }

            var $element = $(this.element);

            // Disable the element that received the change to prevent user interface
            // interaction while the Ajax request is in progress. ajax.ajaxing prevents
            // the element from triggering a new request, but does not prevent the user
            // from changing its value.
            $element.addClass('progress-disabled').attr('disabled', true);

            // Insert progressbar or throbber.
            if (this.progress.type == 'bar') {
                var progressBar = new Drupal.progressBar('ajax-progress-' + this.element.id, eval(this.progress.update_callback), this.progress.method, eval(this.progress.error_callback));
                if (this.progress.message) {
                    progressBar.setProgress(-1, this.progress.message);
                }
                if (this.progress.url) {
                    progressBar.startMonitoring(this.progress.url, this.progress.interval || 500);
                }
                this.progress.element = $(progressBar.element).addClass('ajax-progress ajax-progress-bar');
                this.progress.object = progressBar;
                $element.closest('.file-widget,.form-item').after(this.progress.element);
            } else if (this.progress.type == 'throbber') {

                if ((this.element_settings.submit || {}).view_name &&
                    this.element_settings.submit.view_name === 'product_finder_ielts_test_dates' &&
                    (this.element_settings.submit || {}).view_display_id &&
                    this.element_settings.submit.view_display_id === 'block_pf_ielts_test_dates'
                ) {
                    this.progress.element = $('<span class="bc-loader"></span>');
                } else {
                    this.progress.element = $('<span class="bc-notify-badge"><span class="bc-loader"></span></span>');
                }

                if (this.progress.message) {
                    $('.throbber', this.progress.element).after('<div class="message">' + this.progress.message + '</div>');
                }

                // If element is an input type, append after.
                if ($element.is('input')) {
                    $element.after(this.progress.element);
                } else if ($element.is('select')) {
                    var $inputGroup = $element.closest('.form-item').find('.input-group-addon, .input-group-btn');
                    if (!$inputGroup.length) {
                        $element.wrap('<div class="input-group">');
                        $inputGroup = $('<span class="input-group-addon">');
                        $element.after($inputGroup);
                    }
                    $inputGroup.append(this.progress.element);
                }
                // Otherwise append the throbber inside the element.
                else {
                    $element.append(this.progress.element);
                }
            }
        };
    }

})(jQuery);;
/**
 * Listings
 * Adds classes for the full width hero for listings
 */

(function($) {

    /**
     * Visual Listing page.
     * Adds classes to the hero item based on image type.
     */

    // Portrait.
    if ($('.node-type-visual-landing-page .bc-list-item--width2 .bc-portrait').length > 0) {
        $('.node-type-visual-landing-page .bc-list-item--width2').addClass('bc-list-item--width2-portrait');
    }
    // Square.
    if ($('.node-type-visual-landing-page .bc-list-item--width2 .bc-square').length > 0) {
        $('.node-type-visual-landing-page .bc-list-item--width2').addClass('bc-list-item--width2-square');
    }
    // Landscape.
    if ($('.node-type-visual-landing-page .bc-list-item--width2 .bc-landscape').length > 0) {
        $('.node-type-visual-landing-page .bc-list-item--width2').addClass('bc-list-item--width2-landscape');
    }

    /**
     * Listing page.
     * This will only fire once so as soon as pagination or filters are
     * used this will not happen - by design.
     */

    if ($('.node-type-listing-page').length > 0) {
        // Portrait.
        if ($('.bc-masonry-sizer + .bc-masonry-item .bc-portrait').length > 0) {
            $('.bc-masonry-sizer + .bc-masonry-item').addClass('bc-list-item--width2 bc-list-item--width2-portrait')
        }
        // Square.
        else if ($('.bc-masonry-sizer + .bc-masonry-item .bc-square').length > 0) {
            $('.bc-masonry-sizer + .bc-masonry-item').addClass('bc-list-item--width2 bc-list-item--width2-square')
        }
        // Landscape.
        else if ($('.bc-masonry-sizer + .bc-masonry-item .bc-landscape').length > 0) {
            $('.bc-masonry-sizer + .bc-masonry-item').addClass('bc-list-item--width2 bc-list-item--width2-landscape')
        }
    }

})(jQuery);;
(function($) {

    if (!$('html').hasClass('lt-ie9')) {

        $('.bc-filter').on('click', '.btn', function(e) {
            var $clickedButton = $(this);
            e.preventDefault();
            $clickedButton.removeClass('btn-has-loaded');
            $clickedButton.addClass('btn-is-loading');
            renderFilters($clickedButton.attr('href'), false);
        });

        $('.bc-filter').on('click', '.facet-link', function(e) {
            var $clickedButton = $(this);
            e.preventDefault();
            $clickedButton.removeClass('facet-active');
            $clickedButton.addClass('btn-is-loading');
            renderFilters($clickedButton.attr('href'), false);
        });

        // Only attach event handlers to pagination on a page with bc-masonry.
        if ($('.bc-masonry').length !== 0 && $('.bc-filter').length !== 0) {
            $('.pagination').on('click', 'a', function(e) {
                var $clickedButton = $(this);
                $clickedButton.append('<span class="bc-notify-badge"><span class="bc-loader"></span></span>');
                e.preventDefault();
                renderFilters($clickedButton.attr('href'), true);
            });
        }

        // Insert the following icons in JS as Drupal is a pain to theme to this level.
        function iconMarkup($iconName, $dir, $ariaText) {
            $dir = $dir ? ' bc-dir' : '';
            var $aria = $ariaText ? ' aria-label="' + $ariaText + '"' : ' aria-hidden="true"';
            return '<svg class="bc-svg bc-svg-' + $iconName + $dir + '"' + $aria + '>' +
                '<use xlink:href="#icon-' + $iconName + '"></use>' +
                '</svg>';
        }

        function renderFilters($filterLink, $scroll) {
            var $filterURL = location.protocol + '//' + location.host + $filterLink;

            $.get($filterURL, function(data) {
                var $filterList = $(data).find('.bc-show-hide-content');
                var $filteredContent = $(data).find('article[data-type="listing"]');
                var $pagination = $(data).find('.pagination li');
                $('.bc-show-hide-content').replaceWith($filterList);
                $('article[data-type="listing"]').replaceWith($filteredContent);
                if ($pagination.length) {
                    $('.pagination li').remove();
                    $('.pagination').append($pagination);
                    $('.pagination').show();

                    $('.pagination .prev a').prepend(iconMarkup('left-open-mini', true));
                    $('.pagination .next a').prepend(iconMarkup('right-open-mini', true));

                } else {
                    $('.pagination').hide();
                }

                if ($scroll) {
                    $(window).scrollTop($('#main-content').offset().top);
                }
                $('.bc-masonry').trigger('reload');
            });
        }

    }

})(jQuery);;
(function($) {

    // Plugging a hole with Bootstrap and webforms, patch unsucessful.
    // @todo: Remove after upgrade: @see https://www.drupal.org/node/2244441
    var emailFields = $('.email.form-text.form-email')
    if ($('.email.form-text.form-email').length > 0) {
        $('.email.form-text.form-email').addClass('form-control');
    }

    // Enable the close button on alerts so users (including devs :-) can close the all alerts.
    $('.alert').on('click', '.close', function(e) {
        $(this).parent().remove();
        e.preventDefault();
    });

})(jQuery);;
// maps.js is for custom google maps not the Drupal module provided ones!
// Purpose of this file is to find a google map inserted on the page with the id #bc-geo-rss and
// create a script tag in the head and pull js from google api
var map = (function(m, $, Drupal) {
    var m = {};

    m.init = function() {
        var mapAPI, scriptPos, key;
        // Create and inject map AP and fire the callback function map.haldleApiReady(data).
        key = Drupal.settings.googleMapsApi.key;
        mapAPI = document.createElement("script");
        mapAPI.async = true;
        mapAPI.src =
            "https://maps.googleapis.com/maps/api/js?key=" +
            key +
            "&callback=map.handleGoogleMapApiReady";
        scriptPos = document.getElementsByTagName("script")[0];
        scriptPos.parentNode.insertBefore(mapAPI, scriptPos);
    };

    // Handle response and create the map
    m.handleGoogleMapApiReady = function(data) {
        var geoRssContainer = $("#bc-geo-rss");
        var georss = geoRssContainer.find("a").attr("href");
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        };
        var map = new google.maps.Map(
            document.getElementById("bc-geo-rss"),
            mapOptions
        );
        var georssLayer = new google.maps.KmlLayer({
            url: georss
            // For local testing uncomment the following url and comment out the preceding.
            //url: 'http://www.bgs.ac.uk/feeds/MhSeismology.xml'
        });
        // Show container
        geoRssContainer.addClass("bc-show");
        // Set the map
        georssLayer.setMap(map);
        // Reset the stupid target attribute that Google forces in the info bubble.
        geoRssContainer.delegate("a", "click", function(event) {
            window.location.href = $(this).attr("href");
            return false;
        });
    };

    // Maps inside show hides need some fixes.
    if (
        $("body").find(".bc-show-hides").length ||
        $("body").find(".bc-show-hide-title").length
    ) {
        // Resize and recentre Google maps hidden on load as they are shown.
        // http://stackoverflow.com/questions/13635903/google-map-in-bootstrap-tab
        var mapResize = function() {
            var maps, map, mapCenter, key;

            if (
                typeof Drupal !== undefined &&
                typeof google !== undefined &&
                Drupal.geolocationGooglemaps &&
                google.maps
            ) {
                maps = Drupal.geolocationGooglemaps.maps;
                // Iterate through all Drupal geolocation maps on the page
                for (key in maps) {
                    map = maps[key];
                    // Get the current centre point for the map.
                    mapCenter = map.getCenter();
                    // Trigger the resize event
                    google.maps.event.trigger(map, "resize");
                    // Reset the map centre to the previously saved value.
                    map.setCenter(mapCenter);
                }
            }
        };

        // Maps within Show/Hide
        $(".bc-show-hide-title").on("click", function() {
            // This needs a timeout of a milisecond so that when fired it has the new dimensions.
            setTimeout(mapResize, 1);
        });
        // Maps within Tabs: Note the additional timeout due to SUI generated tab navigation which
        // we need on the page when we set the event handler.
        setTimeout(function() {
            $(".bc-show-hides").on("click", function() {
                setTimeout(mapResize, 1);
            });
        }, 10);
    }

    return m;
})(map || {}, jQuery, Drupal);

(function($) {
    if ($("#bc-geo-rss").length) {
        map.init();
    }
})(jQuery);;
var bcBookeo = (function(a, $) {
    a = {};

    // Time to wait for analytics before giving up and loading Bookeo anyway
    var ANALYTICS_TIMEOUT = 5000;

    a.init = function() {
        var $bookeoNode = $('#bookeo_position');
        var hasBookeo = $bookeoNode.length;
        var scriptUrl = $bookeoNode.attr('data-url') + '&waitMobile=true';

        if (hasBookeo) {
            this.$bookeoNode = $bookeoNode;
            this.waitForAnalytics(function(trackerName) {
                a.loadBookeo(scriptUrl, trackerName);
            });
        }
    };

    /*
     * Waits for and invokes the callback as soon as
     * Universal Analytics/Google Analytics kick in
     */
    a.waitForAnalytics = function(callback) {
        var finalTimeout = setTimeout(callback, ANALYTICS_TIMEOUT);

        function checkIfAnalyticsLoaded() {
            var trackerName;
            var hasUA = window.ga && window.ga.getAll; // Universal Analytics (better)
            var hasGA = window._gat && window._gat._getTrackers; // Google Analytics (previous version)

            // Extract tracker name for Universal Analytics
            trackerName = hasUA ? ga.getAll()[0].get('name') : trackerName;

            // Extract tracker name for Classic Google Analytics
            trackerName = hasGA ? _gat._getTrackers()[0]._getName() : trackerName;

            if (trackerName) {
                // Stop here if a tracker has been found
                clearTimeout(finalTimeout);
                callback(trackerName);
            } else {
                // ...otherwise wait a little bit and check again
                setTimeout(checkIfAnalyticsLoaded, 500);
            }
        }

        // Start checking for presence of analytics
        checkIfAnalyticsLoaded();
    };

    /*
     * Load the Bookeo JS on the page
     */
    a.loadBookeo = function(scriptUrl, trackerName) {
        // Set global variable for bookeo to pick up
        window.bookeo_GATrackerName = trackerName;

        $.ajax({
            cache: true,
            dataType: 'script',
            url: scriptUrl,
            success: function() {
                // Wait a little bit before checking if Bookeo has loaded
                setTimeout(a.ensureBookeoLoaded, 500);
            }
        });
    };

    /*
     * Checks if the widget has loaded or started loading, otherwise
     * force load it
     */
    a.ensureBookeoLoaded = function() {
        if (a.$bookeoNode.is(':empty')) {
            axiomct_onready();
        }
        // Add button styles to bookeo div and make accessible with a tabindex of 0.
        $('#bookeoStartMobile')
            .addClass('btn btn-primary btn-lg bc-btn-square bc-btn-block')
            .removeAttr('style');
    };

    return a;

}(bcBookeo || {}, jQuery));

(function() {
    bcBookeo.init();
})(jQuery);;
(function($) {
    Drupal.behaviors.addSuiIcons = {
        attach: function(context, settings) {
            "use strict";

            // Insert the following icons in JS as Drupal is a pain to theme to this level.
            function iconMarkup($iconName, $dir, $ariaText) {
                $dir = $dir ? " bc-dir" : "";
                var $aria = $ariaText ?
                    ' aria-label="' + $ariaText + '"' :
                    ' aria-hidden="true"';
                return (
                    '<svg class="bc-svg bc-svg-' +
                    $iconName +
                    $dir +
                    '"' +
                    $aria +
                    ">" +
                    '<use xlink:href="#icon-' +
                    $iconName +
                    '"></use>' +
                    "</svg>"
                );
            }

            $("body")
                .once("addSuiIcons-ajax")
                .ajaxComplete(function(e, xhr, settings) {
                    if (
                        ((settings || {}).extraData || {}).view_display_id &&
                        settings.extraData.view_display_id === "block_pf_ielts_test_dates" &&
                        ((settings || {}).extraData || {}).view_name &&
                        settings.extraData.view_name === "product_finder_ielts_test_dates"
                    ) {
                        $(".bc-icon-link-block-sm, .bc-icon-link-block-md, .bc-icon-link-block-lg").prepend(iconMarkup("right-open-mini", true));
                    }
                });

            // Load them only once or on ajax pages they will keep on loading to the page!
            $("body", context).once(function() {
                // Insert the icons.
                setTimeout(function() {
                    // Insert SVG icon markup where font awesome markup hasn't been used.
                    $(".bc-navbar-default .navbar-nav.bc-navbar-nav-has-home-icon > li:first-child > a").prepend(iconMarkup("home", false));
                    $(".navbar-microsite .navbar-nav > li:first-child > a").prepend(
                        iconMarkup("home", false, $(".navbar-microsite .navbar-title").text())
                    );
                    $(".bc-navbar-search .input-group-btn .btn").prepend(
                        iconMarkup("search", false)
                    );
                    $(".breadcrumb > li + li").prepend(
                        iconMarkup("right-open-mini", true) + "&nbsp;"
                    );
                    $(".bc-nav-title > a").prepend(
                        iconMarkup("up-open", false)
                    );
                    $(".bc-icon-link-block-sm, .bc-icon-link-block-md, .bc-icon-link-block-lg").prepend(
                        iconMarkup("right-open-mini", true)
                    );
                    $(".bc-icon-link-sm, .bc-icon-link-md, .bc-icon-link-lg").prepend(
                        iconMarkup("right-open-mini", true)
                    );
                    $(".bc-icon-link-list li > a").prepend(
                        iconMarkup("right-open-mini", true)
                    );
                    $(".bc-btn-has-icon.bc-icon-arrow").prepend(
                        iconMarkup("right-open-mini", true)
                    );
                    $('.bc-body-text a[target="_blank"]:not(".btn")')
                        .append(
                            " " +
                            iconMarkup(
                                "popup",
                                false,
                                Drupal.settings.addSuiIcons.accessibility_text
                            ) +
                            " "
                        )
                        .attr("title", Drupal.settings.addSuiIcons.accessibility_text);
                    $(".pagination .prev a").prepend(iconMarkup("left-open-mini", true));
                    $(".pagination .next a").prepend(iconMarkup("right-open-mini", true));
                    // Insert SVG icon markup to basket or cart link and copy it to the footer for mobile devices
                    var $basketLink = $(".bc-navbar-support li").find(
                        'a[href*="/basket"],[href*="/cart"]'
                    );
                    if ($basketLink.length) {
                        // Additional check to ensure this is actually the cart link not something
                        // just containing the "cart" word.
                        $basketLink.each(
                            function(index, element) {
                                var href = $(element).attr('href');
                                if (typeof(href) != 'undefined' && !href.match(/\/(cart$|basket$|cart\/|basket\/)/)) {
                                    $basketLink.splice(index, 1);
                                }
                            }
                        );
                        $basketLink.append("&nbsp;" + iconMarkup("basket", false));
                        var $basketLinkClone = $basketLink.parent().html();
                        $("footer > .container > .row").prepend(
                            '<div class="col-xs-12 hidden-md hidden-lg"><nav><ul class="bc-footer-nav"><li>' +
                            $basketLinkClone +
                            '</li></ul></nav><hr class="hidden-md hidden-lg"></div>'
                        );
                    }
                }, 10);
            });
        }
    };
})(jQuery);;
! function(t) {
    t.extend(t.fn, {
        validate: function(e) {
            if (!this.length) return void(e && e.debug && window.console && console.warn("Nothing selected, can't validate, returning nothing."));
            var i = t.data(this[0], "validator");
            return i ? i : (this.attr("novalidate", "novalidate"), i = new t.validator(e, this[0]), t.data(this[0], "validator", i), i.settings.onsubmit && (this.validateDelegate(":submit", "click", function(e) {
                i.settings.submitHandler && (i.submitButton = e.target), t(e.target).hasClass("cancel") && (i.cancelSubmit = !0), void 0 !== t(e.target).attr("formnovalidate") && (i.cancelSubmit = !0)
            }), this.submit(function(e) {
                function s() {
                    var s;
                    return i.settings.submitHandler ? (i.submitButton && (s = t("<input type='hidden'/>").attr("name", i.submitButton.name).val(t(i.submitButton).val()).appendTo(i.currentForm)), i.settings.submitHandler.call(i, i.currentForm, e), i.submitButton && s.remove(), !1) : !0
                }
                return i.settings.debug && e.preventDefault(), i.cancelSubmit ? (i.cancelSubmit = !1, s()) : i.form() ? i.pendingRequest ? (i.formSubmitted = !0, !1) : s() : (i.focusInvalid(), !1)
            })), i)
        },
        valid: function() {
            if (t(this[0]).is("form")) return this.validate().form();
            var e = !0,
                i = t(this[0].form).validate();
            return this.each(function() {
                e = e && i.element(this)
            }), e
        },
        removeAttrs: function(e) {
            var i = {},
                s = this;
            return t.each(e.split(/\s/), function(t, e) {
                i[e] = s.attr(e), s.removeAttr(e)
            }), i
        },
        rules: function(e, i) {
            var s = this[0];
            if (e) {
                var r = t.data(s.form, "validator").settings,
                    n = r.rules,
                    a = t.validator.staticRules(s);
                switch (e) {
                    case "add":
                        t.extend(a, t.validator.normalizeRule(i)), delete a.messages, n[s.name] = a, i.messages && (r.messages[s.name] = t.extend(r.messages[s.name], i.messages));
                        break;
                    case "remove":
                        if (!i) return delete n[s.name], a;
                        var u = {};
                        return t.each(i.split(/\s/), function(t, e) {
                            u[e] = a[e], delete a[e]
                        }), u
                }
            }
            var o = t.validator.normalizeRules(t.extend({}, t.validator.classRules(s), t.validator.attributeRules(s), t.validator.dataRules(s), t.validator.staticRules(s)), s);
            if (o.required) {
                var l = o.required;
                delete o.required, o = t.extend({
                    required: l
                }, o)
            }
            return o
        }
    }), t.extend(t.expr[":"], {
        blank: function(e) {
            return !t.trim("" + t(e).val())
        },
        filled: function(e) {
            return !!t.trim("" + t(e).val())
        },
        unchecked: function(e) {
            return !t(e).prop("checked")
        }
    }), t.validator = function(e, i) {
        this.settings = t.extend(!0, {}, t.validator.defaults, e), this.currentForm = i, this.init()
    }, t.validator.format = function(e, i) {
        return 1 === arguments.length ? function() {
            var i = t.makeArray(arguments);
            return i.unshift(e), t.validator.format.apply(this, i)
        } : (arguments.length > 2 && i.constructor !== Array && (i = t.makeArray(arguments).slice(1)), i.constructor !== Array && (i = [i]), t.each(i, function(t, i) {
            e = e.replace(new RegExp("\\{" + t + "\\}", "g"), function() {
                return i
            })
        }), e)
    }, t.extend(t.validator, {
        defaults: {
            messages: {},
            groups: {},
            rules: {},
            errorClass: "error",
            validClass: "valid",
            errorElement: "label",
            focusInvalid: !0,
            errorContainer: t([]),
            errorLabelContainer: t([]),
            onsubmit: !0,
            ignore: ":hidden",
            ignoreTitle: !1,
            onfocusin: function(t, e) {
                this.lastActive = t, this.settings.focusCleanup && !this.blockFocusCleanup && (this.settings.unhighlight && this.settings.unhighlight.call(this, t, this.settings.errorClass, this.settings.validClass), this.addWrapper(this.errorsFor(t)).hide())
            },
            onfocusout: function(t, e) {
                this.checkable(t) || !(t.name in this.submitted) && this.optional(t) || this.element(t)
            },
            onkeyup: function(t, e) {
                (9 !== e.which || "" !== this.elementValue(t)) && (t.name in this.submitted || t === this.lastElement) && this.element(t)
            },
            onclick: function(t, e) {
                t.name in this.submitted ? this.element(t) : t.parentNode.name in this.submitted && this.element(t.parentNode)
            },
            highlight: function(e, i, s) {
                "radio" === e.type ? this.findByName(e.name).addClass(i).removeClass(s) : t(e).addClass(i).removeClass(s)
            },
            unhighlight: function(e, i, s) {
                "radio" === e.type ? this.findByName(e.name).removeClass(i).addClass(s) : t(e).removeClass(i).addClass(s)
            }
        },
        setDefaults: function(e) {
            t.extend(t.validator.defaults, e)
        },
        messages: {
            required: "This field is required.",
            remote: "Please fix this field.",
            email: "Please enter a valid email address.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            dateISO: "Please enter a valid date (ISO).",
            number: "Please enter a valid number.",
            digits: "Please enter only digits.",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            maxlength: t.validator.format("Please enter no more than {0} characters."),
            minlength: t.validator.format("Please enter at least {0} characters."),
            rangelength: t.validator.format("Please enter a value between {0} and {1} characters long."),
            range: t.validator.format("Please enter a value between {0} and {1}."),
            max: t.validator.format("Please enter a value less than or equal to {0}."),
            min: t.validator.format("Please enter a value greater than or equal to {0}.")
        },
        autoCreateRanges: !1,
        prototype: {
            init: function() {
                function e(e) {
                    var i = t.data(this[0].form, "validator"),
                        s = "on" + e.type.replace(/^validate/, "");
                    i.settings[s] && i.settings[s].call(i, this[0], e)
                }
                this.labelContainer = t(this.settings.errorLabelContainer), this.errorContext = this.labelContainer.length && this.labelContainer || t(this.currentForm), this.containers = t(this.settings.errorContainer).add(this.settings.errorLabelContainer), this.submitted = {}, this.valueCache = {}, this.pendingRequest = 0, this.pending = {}, this.invalid = {}, this.reset();
                var i = this.groups = {};
                t.each(this.settings.groups, function(e, s) {
                    "string" == typeof s && (s = s.split(/\s/)), t.each(s, function(t, s) {
                        i[s] = e
                    })
                });
                var s = this.settings.rules;
                t.each(s, function(e, i) {
                    s[e] = t.validator.normalizeRule(i)
                }), t(this.currentForm).validateDelegate(":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'] ", "focusin focusout keyup", e).validateDelegate("[type='radio'], [type='checkbox'], select, option", "click", e), this.settings.invalidHandler && t(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler)
            },
            form: function() {
                return this.checkForm(), t.extend(this.submitted, this.errorMap), this.invalid = t.extend({}, this.errorMap), this.valid() || t(this.currentForm).triggerHandler("invalid-form", [this]), this.showErrors(), this.valid()
            },
            checkForm: function() {
                this.prepareForm();
                for (var t = 0, e = this.currentElements = this.elements(); e[t]; t++) this.check(e[t]);
                return this.valid()
            },
            element: function(e) {
                e = this.validationTargetFor(this.clean(e)), this.lastElement = e, this.prepareElement(e), this.currentElements = t(e);
                var i = this.check(e) !== !1;
                return i ? delete this.invalid[e.name] : this.invalid[e.name] = !0, this.numberOfInvalids() || (this.toHide = this.toHide.add(this.containers)), this.showErrors(), i
            },
            showErrors: function(e) {
                if (e) {
                    t.extend(this.errorMap, e), this.errorList = [];
                    for (var i in e) this.errorList.push({
                        message: e[i],
                        element: this.findByName(i)[0]
                    });
                    this.successList = t.grep(this.successList, function(t) {
                        return !(t.name in e)
                    })
                }
                this.settings.showErrors ? this.settings.showErrors.call(this, this.errorMap, this.errorList) : this.defaultShowErrors()
            },
            resetForm: function() {
                t.fn.resetForm && t(this.currentForm).resetForm(), this.submitted = {}, this.lastElement = null, this.prepareForm(), this.hideErrors(), this.elements().removeClass(this.settings.errorClass).removeData("previousValue")
            },
            numberOfInvalids: function() {
                return this.objectLength(this.invalid)
            },
            objectLength: function(t) {
                var e = 0;
                for (var i in t) e++;
                return e
            },
            hideErrors: function() {
                this.addWrapper(this.toHide).hide()
            },
            valid: function() {
                return 0 === this.size()
            },
            size: function() {
                return this.errorList.length
            },
            focusInvalid: function() {
                if (this.settings.focusInvalid) try {
                    t(this.findLastActive() || this.errorList.length && this.errorList[0].element || []).filter(":visible").focus().trigger("focusin")
                } catch (e) {}
            },
            findLastActive: function() {
                var e = this.lastActive;
                return e && 1 === t.grep(this.errorList, function(t) {
                    return t.element.name === e.name
                }).length && e
            },
            elements: function() {
                var e = this,
                    i = {};
                return t(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled]").not(this.settings.ignore).filter(function() {
                    return !this.name && e.settings.debug && window.console && console.error("%o has no name assigned", this), this.name in i || !e.objectLength(t(this).rules()) ? !1 : (i[this.name] = !0, !0)
                })
            },
            clean: function(e) {
                return t(e)[0]
            },
            errors: function() {
                var e = this.settings.errorClass.replace(" ", ".");
                return t(this.settings.errorElement + "." + e, this.errorContext)
            },
            reset: function() {
                this.successList = [], this.errorList = [], this.errorMap = {}, this.toShow = t([]), this.toHide = t([]), this.currentElements = t([])
            },
            prepareForm: function() {
                this.reset(), this.toHide = this.errors().add(this.containers)
            },
            prepareElement: function(t) {
                this.reset(), this.toHide = this.errorsFor(t)
            },
            elementValue: function(e) {
                var i = t(e).attr("type"),
                    s = t(e).val();
                return "radio" === i || "checkbox" === i ? t("input[name='" + t(e).attr("name") + "']:checked").val() : "string" == typeof s ? s.replace(/\r/g, "") : s
            },
            check: function(e) {
                e = this.validationTargetFor(this.clean(e));
                var i, s = t(e).rules(),
                    r = !1,
                    n = this.elementValue(e);
                for (var a in s) {
                    var u = {
                        method: a,
                        parameters: s[a]
                    };
                    try {
                        if (i = t.validator.methods[a].call(this, n, e, u.parameters), "dependency-mismatch" === i) {
                            r = !0;
                            continue
                        }
                        if (r = !1, "pending" === i) return void(this.toHide = this.toHide.not(this.errorsFor(e)));
                        if (!i) return this.formatAndAdd(e, u), !1
                    } catch (o) {
                        throw this.settings.debug && window.console && console.log("Exception occurred when checking element " + e.id + ", check the '" + u.method + "' method.", o), o
                    }
                }
                return r ? void 0 : (this.objectLength(s) && this.successList.push(e), !0)
            },
            customDataMessage: function(e, i) {
                return t(e).data("msg-" + i.toLowerCase()) || e.attributes && t(e).attr("data-msg-" + i.toLowerCase())
            },
            customMessage: function(t, e) {
                var i = this.settings.messages[t];
                return i && (i.constructor === String ? i : i[e])
            },
            findDefined: function() {
                for (var t = 0; t < arguments.length; t++)
                    if (void 0 !== arguments[t]) return arguments[t]
            },
            defaultMessage: function(e, i) {
                return this.findDefined(this.customMessage(e.name, i), this.customDataMessage(e, i), !this.settings.ignoreTitle && e.title || void 0, t.validator.messages[i], "<strong>Warning: No message defined for " + e.name + "</strong>")
            },
            formatAndAdd: function(e, i) {
                var s = this.defaultMessage(e, i.method),
                    r = /\$?\{(\d+)\}/g;
                "function" == typeof s ? s = s.call(this, i.parameters, e) : r.test(s) && (s = t.validator.format(s.replace(r, "{$1}"), i.parameters)), this.errorList.push({
                    message: s,
                    element: e
                }), this.errorMap[e.name] = s, this.submitted[e.name] = s
            },
            addWrapper: function(t) {
                return this.settings.wrapper && (t = t.add(t.parent(this.settings.wrapper))), t
            },
            defaultShowErrors: function() {
                var t, e;
                for (t = 0; this.errorList[t]; t++) {
                    var i = this.errorList[t];
                    this.settings.highlight && this.settings.highlight.call(this, i.element, this.settings.errorClass, this.settings.validClass), this.showLabel(i.element, i.message)
                }
                if (this.errorList.length && (this.toShow = this.toShow.add(this.containers)), this.settings.success)
                    for (t = 0; this.successList[t]; t++) this.showLabel(this.successList[t]);
                if (this.settings.unhighlight)
                    for (t = 0, e = this.validElements(); e[t]; t++) this.settings.unhighlight.call(this, e[t], this.settings.errorClass, this.settings.validClass);
                this.toHide = this.toHide.not(this.toShow), this.hideErrors(), this.addWrapper(this.toShow).show()
            },
            validElements: function() {
                return this.currentElements.not(this.invalidElements())
            },
            invalidElements: function() {
                return t(this.errorList).map(function() {
                    return this.element
                })
            },
            showLabel: function(e, i) {
                var s = this.errorsFor(e);
                s.length ? (s.removeClass(this.settings.validClass).addClass(this.settings.errorClass), s.html(i)) : (s = t("<" + this.settings.errorElement + ">").attr("for", this.idOrName(e)).addClass(this.settings.errorClass).html(i || ""), this.settings.wrapper && (s = s.hide().show().wrap("<" + this.settings.wrapper + "/>").parent()), this.labelContainer.append(s).length || (this.settings.errorPlacement ? this.settings.errorPlacement(s, t(e)) : s.insertAfter(e))), !i && this.settings.success && (s.text(""), "string" == typeof this.settings.success ? s.addClass(this.settings.success) : this.settings.success(s, e)), this.toShow = this.toShow.add(s)
            },
            errorsFor: function(e) {
                var i = this.idOrName(e);
                return this.errors().filter(function() {
                    return t(this).attr("for") === i
                })
            },
            idOrName: function(t) {
                return this.groups[t.name] || (this.checkable(t) ? t.name : t.id || t.name)
            },
            validationTargetFor: function(t) {
                return this.checkable(t) && (t = this.findByName(t.name).not(this.settings.ignore)[0]), t
            },
            checkable: function(t) {
                return /radio|checkbox/i.test(t.type)
            },
            findByName: function(e) {
                return t(this.currentForm).find("[name='" + e + "']")
            },
            getLength: function(e, i) {
                switch (i.nodeName.toLowerCase()) {
                    case "select":
                        return t("option:selected", i).length;
                    case "input":
                        if (this.checkable(i)) return this.findByName(i.name).filter(":checked").length
                }
                return e.length
            },
            depend: function(t, e) {
                return this.dependTypes[typeof t] ? this.dependTypes[typeof t](t, e) : !0
            },
            dependTypes: {
                "boolean": function(t, e) {
                    return t
                },
                string: function(e, i) {
                    return !!t(e, i.form).length
                },
                "function": function(t, e) {
                    return t(e)
                }
            },
            optional: function(e) {
                var i = this.elementValue(e);
                return !t.validator.methods.required.call(this, i, e) && "dependency-mismatch"
            },
            startRequest: function(t) {
                this.pending[t.name] || (this.pendingRequest++, this.pending[t.name] = !0)
            },
            stopRequest: function(e, i) {
                this.pendingRequest--, this.pendingRequest < 0 && (this.pendingRequest = 0), delete this.pending[e.name], i && 0 === this.pendingRequest && this.formSubmitted && this.form() ? (t(this.currentForm).submit(), this.formSubmitted = !1) : !i && 0 === this.pendingRequest && this.formSubmitted && (t(this.currentForm).triggerHandler("invalid-form", [this]), this.formSubmitted = !1)
            },
            previousValue: function(e) {
                return t.data(e, "previousValue") || t.data(e, "previousValue", {
                    old: null,
                    valid: !0,
                    message: this.defaultMessage(e, "remote")
                })
            }
        },
        classRuleSettings: {
            required: {
                required: !0
            },
            email: {
                email: !0
            },
            url: {
                url: !0
            },
            date: {
                date: !0
            },
            dateISO: {
                dateISO: !0
            },
            number: {
                number: !0
            },
            digits: {
                digits: !0
            },
            creditcard: {
                creditcard: !0
            }
        },
        addClassRules: function(e, i) {
            e.constructor === String ? this.classRuleSettings[e] = i : t.extend(this.classRuleSettings, e)
        },
        classRules: function(e) {
            var i = {},
                s = t(e).attr("class");
            return s && t.each(s.split(" "), function() {
                this in t.validator.classRuleSettings && t.extend(i, t.validator.classRuleSettings[this])
            }), i
        },
        attributeRules: function(e) {
            var i = {},
                s = t(e),
                r = s[0].getAttribute("type");
            for (var n in t.validator.methods) {
                var a;
                "required" === n ? (a = s.get(0).getAttribute(n), "" === a && (a = !0), a = !!a) : a = s.attr(n), /min|max/.test(n) && (null === r || /number|range|text/.test(r)) && (a = Number(a)), a ? i[n] = a : r === n && "range" !== r && (i[n] = !0)
            }
            return i.maxlength && /-1|2147483647|524288/.test(i.maxlength) && delete i.maxlength, i
        },
        dataRules: function(e) {
            var i, s, r = {},
                n = t(e);
            for (i in t.validator.methods) s = n.data("rule-" + i.toLowerCase()), void 0 !== s && (r[i] = s);
            return r
        },
        staticRules: function(e) {
            var i = {},
                s = t.data(e.form, "validator");
            return s.settings.rules && (i = t.validator.normalizeRule(s.settings.rules[e.name]) || {}), i
        },
        normalizeRules: function(e, i) {
            return t.each(e, function(s, r) {
                if (r === !1) return void delete e[s];
                if (r.param || r.depends) {
                    var n = !0;
                    switch (typeof r.depends) {
                        case "string":
                            n = !!t(r.depends, i.form).length;
                            break;
                        case "function":
                            n = r.depends.call(i, i)
                    }
                    n ? e[s] = void 0 !== r.param ? r.param : !0 : delete e[s]
                }
            }), t.each(e, function(s, r) {
                e[s] = t.isFunction(r) ? r(i) : r
            }), t.each(["minlength", "maxlength"], function() {
                e[this] && (e[this] = Number(e[this]))
            }), t.each(["rangelength", "range"], function() {
                var i;
                e[this] && (t.isArray(e[this]) ? e[this] = [Number(e[this][0]), Number(e[this][1])] : "string" == typeof e[this] && (i = e[this].split(/[\s,]+/), e[this] = [Number(i[0]), Number(i[1])]))
            }), t.validator.autoCreateRanges && (e.min && e.max && (e.range = [e.min, e.max], delete e.min, delete e.max), e.minlength && e.maxlength && (e.rangelength = [e.minlength, e.maxlength], delete e.minlength, delete e.maxlength)), e
        },
        normalizeRule: function(e) {
            if ("string" == typeof e) {
                var i = {};
                t.each(e.split(/\s/), function() {
                    i[this] = !0
                }), e = i
            }
            return e
        },
        addMethod: function(e, i, s) {
            t.validator.methods[e] = i, t.validator.messages[e] = void 0 !== s ? s : t.validator.messages[e], i.length < 3 && t.validator.addClassRules(e, t.validator.normalizeRule(e))
        },
        methods: {
            required: function(e, i, s) {
                if (!this.depend(s, i)) return "dependency-mismatch";
                if ("select" === i.nodeName.toLowerCase()) {
                    var r = t(i).val();
                    return r && r.length > 0
                }
                return this.checkable(i) ? this.getLength(e, i) > 0 : t.trim(e).length > 0
            },
            email: function(t, e) {
                return this.optional(e) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(t)
            },
            url: function(t, e) {
                return this.optional(e) || /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(t)
            },
            date: function(t, e) {
                return this.optional(e) || !/Invalid|NaN/.test(new Date(t).toString())
            },
            dateISO: function(t, e) {
                return this.optional(e) || /^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}$/.test(t)
            },
            number: function(t, e) {
                return this.optional(e) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(t)
            },
            digits: function(t, e) {
                return this.optional(e) || /^\d+$/.test(t)
            },
            creditcard: function(t, e) {
                if (this.optional(e)) return "dependency-mismatch";
                if (/[^0-9 \-]+/.test(t)) return !1;
                var i = 0,
                    s = 0,
                    r = !1;
                t = t.replace(/\D/g, "");
                for (var n = t.length - 1; n >= 0; n--) {
                    var a = t.charAt(n);
                    s = parseInt(a, 10), r && (s *= 2) > 9 && (s -= 9), i += s, r = !r
                }
                return i % 10 === 0
            },
            minlength: function(e, i, s) {
                var r = t.isArray(e) ? e.length : this.getLength(t.trim(e), i);
                return this.optional(i) || r >= s
            },
            maxlength: function(e, i, s) {
                var r = t.isArray(e) ? e.length : this.getLength(t.trim(e), i);
                return this.optional(i) || s >= r
            },
            rangelength: function(e, i, s) {
                var r = t.isArray(e) ? e.length : this.getLength(t.trim(e), i);
                return this.optional(i) || r >= s[0] && r <= s[1]
            },
            min: function(t, e, i) {
                return this.optional(e) || t >= i
            },
            max: function(t, e, i) {
                return this.optional(e) || i >= t
            },
            range: function(t, e, i) {
                return this.optional(e) || t >= i[0] && t <= i[1]
            },
            equalTo: function(e, i, s) {
                var r = t(s);
                return this.settings.onfocusout && r.unbind(".validate-equalTo").bind("blur.validate-equalTo", function() {
                    t(i).valid()
                }), e === r.val()
            },
            remote: function(e, i, s) {
                if (this.optional(i)) return "dependency-mismatch";
                var r = this.previousValue(i);
                if (this.settings.messages[i.name] || (this.settings.messages[i.name] = {}), r.originalMessage = this.settings.messages[i.name].remote, this.settings.messages[i.name].remote = r.message, s = "string" == typeof s && {
                        url: s
                    } || s, r.old === e) return r.valid;
                r.old = e;
                var n = this;
                this.startRequest(i);
                var a = {};
                return a[i.name] = e, t.ajax(t.extend(!0, {
                    url: s,
                    mode: "abort",
                    port: "validate" + i.name,
                    dataType: "json",
                    data: a,
                    success: function(s) {
                        n.settings.messages[i.name].remote = r.originalMessage;
                        var a = s === !0 || "true" === s;
                        if (a) {
                            var u = n.formSubmitted;
                            n.prepareElement(i), n.formSubmitted = u, n.successList.push(i), delete n.invalid[i.name], n.showErrors()
                        } else {
                            var o = {},
                                l = s || n.defaultMessage(i, "remote");
                            o[i.name] = r.message = t.isFunction(l) ? l(e) : l, n.invalid[i.name] = !0, n.showErrors(o)
                        }
                        r.valid = a, n.stopRequest(i, a)
                    }
                }, s)), "pending"
            }
        }
    }), t.format = t.validator.format
}(jQuery),
function(t) {
    var e = {};
    if (t.ajaxPrefilter) t.ajaxPrefilter(function(t, i, s) {
        var r = t.port;
        "abort" === t.mode && (e[r] && e[r].abort(), e[r] = s)
    });
    else {
        var i = t.ajax;
        t.ajax = function(s) {
            var r = ("mode" in s ? s : t.ajaxSettings).mode,
                n = ("port" in s ? s : t.ajaxSettings).port;
            return "abort" === r ? (e[n] && e[n].abort(), e[n] = i.apply(this, arguments), e[n]) : i.apply(this, arguments)
        }
    }
}(jQuery),
function(t) {
    t.extend(t.fn, {
        validateDelegate: function(e, i, s) {
            return this.bind(i, function(i) {
                var r = t(i.target);
                return r.is(e) ? s.apply(r, arguments) : void 0
            })
        }
    })
}(jQuery);;
(function($) {
    // Remove the context nav if their are no children of the active item, i.e nothing to render.
    if ($('.bc-context-nav .nav > li.active-trail').children().length === 1) {
        $('.bc-context-nav').remove();
    }
    // Remove the expanded subnev used on microsites when it's empty.
    if ($('.bc-subnav-microsite .nav').children().length === 0) {
        $('.bc-subnav-microsite').remove();
    }

})(jQuery);;