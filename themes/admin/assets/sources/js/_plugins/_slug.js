$(function () {
    "use strict";
    $.fn.slugGenerator = function (options) {
        function string_to_slug(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        }

        /**
         * This is the easiest way to have default options.
         * @type {jQuery|void}
         */
        var settings = $.extend({}, options);

        /**
         * Title to slug
         */
        // See if there is an object id on the page

        if (parseFloat($(".object_id").length) > 0) {
            $("." + settings.title).each(function (i, obj) {
                var field = $("#" + $(obj).attr("id")),
                    field_slug = $("#" + $(obj).attr("slug"));
                $(field).keyup(function () {
                    var field_value = $("#" + $(field).attr("id")).val();
                    if (!$(field_slug).attr("overwrite")) {
                        $(field_slug).val(string_to_slug(field_value));
                    }
                });
            });
        }

        /**
         * Manually rewrite the slug
         */
        $("." + settings.slug).each(function (i, slug) {
            $(slug).change(function () {
                $(slug).val(string_to_slug($(slug).val()));
            });
        });
    };
}(jQuery));