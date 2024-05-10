(function($) {
    $(document).ready(function() {
        /**
         * Show/hide venue/location/url based on event type. Style 'required' fields when shown.
         */
        /* Offline checkbox interaction. */
        if (!$('#edit-field-event-type-und-offline').is(":checked")) {
            $("#edit-field-event-address").hide()
            $("#edit-field-event-location").hide()
            $("#edit-field-event-location-name").hide()
            $("#edit-field-event-address span").removeClass("event-field-required")
            $("#edit-field-event-location-name label").removeClass("event-field-required")
        }
        if ($('#edit-field-event-type-und-offline').is(":checked")) {
            $("#edit-field-event-address span").addClass("event-field-required")
            $('#edit-field-event-location-name label').addClass('event-field-required')
        }
        $('#edit-field-event-type-und-offline').change(function() {
            $("#edit-field-event-address").toggle()
            $("#edit-field-event-location").toggle()
            $("#edit-field-event-location-name").toggle()
            $("#edit-field-event-address span").addClass("event-field-required")
            $('#edit-field-event-location-name label').toggleClass('event-field-required')
        });

        /* Online checkbox interaction. */
        if (!$('#edit-field-event-type-und-online').is(":checked")) {
            $("#edit-field-event-url").hide()
            $("#edit-field-event-url .form-type-link-field > label").removeClass("event-field-required")
        }
        if ($('#edit-field-event-type-und-online').is(":checked")) {
            $("#edit-field-event-url .form-type-link-field > label").addClass("event-field-required")
        }
        $('#edit-field-event-type-und-online').change(function() {
            $("#edit-field-event-url").toggle()
            $("#edit-field-event-url .form-type-link-field > label").toggleClass("event-field-required")
        });
    });
})(jQuery);;
(function($) {
    $(document).ready(function() {
        /**
         * Product finder widget country selection visibility.
         */
        if ($("#edit-pf-iso-exceptions") && ($("#edit-field-generic-pf-exam-data-und").val() === '_none')) {
            $(".form-item-pf-iso-exceptions").hide()
        }
        $("#edit-field-generic-pf-exam-data-und").on('change', function() {
            if (this.value === 'IELTS') {
                $(".form-item-pf-iso-exceptions").show()
            } else if (this.value === '_none') {
                $(".form-item-pf-iso-exceptions").hide()
            }
        });
    });
})(jQuery);;