$(function () {
    "use strict";
    $.fn.machineName = function (options) {
        function string_to_machine(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '_') // collapse whitespace and replace by -
                .replace(/-+/g, '_'); // collapse dashes

            return str;
        }

        /**
         * This is the easiest way to have default options.
         * @type {jQuery|void}
         */
        var settings = $.extend({}, options);

        /**
         * Name
         */
        // See if there is an object id on the page

        if (parseFloat($(".object_id").length) > 0) {
            $("." + settings.name).each(function (i, obj) {
                var field = $("#" + $(obj).attr("id")),
                    field_machine = $("#" + $(obj).attr("machine"));
                $(field).keyup(function () {
                    var field_value = $("#" + $(field).attr("id")).val();
                    if (!$(field_machine).attr("overwrite")) {
                        $(field_machine).val(string_to_machine(field_value));
                    }
                });
            });
        }

        /**
         * Manually rewrite the machine
         */
        $("." + settings.machine).each(function (i, machine) {
            $(machine).change(function () {
                $(machine).val(string_to_machine($(machine).val()));
            });
        });
    };
}(jQuery));