(function ($) {
    "use strict";
    $.fn.cookieNotice = function () {
        /**
         * Set Cookie
         *
         * @param name
         * @param value
         * @param days
         */
        function setCookie(name, value, days) {
            console.log(name, value, days);

            var d = new Date();
            d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
            document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
        }

        /**
         * Read Cookie
         *
         * @param name
         * @returns {string}
         */
        function getCookie(name) {
            var b = document.cookie.match('(^|[^;]+)\\s*' + name + '\\s*=\\s*([^;]+)');
            return b ? b.pop() : '';
        }

        /**
         * Cookie Notice Init
         *
         * @private
         */
        function _init() {
            var $cookieNotice = $("#cookie-notice"),
                $cookieName = $cookieNotice.attr("cookie") ? $cookieNotice.attr("cookie") : '__cookie_notice',
                $cookieExpireDays = $cookieNotice.attr("days") ? parseInt($cookieNotice.attr("days")) : 30;

            /**
             * Set the cookie
             */
            $(document).on("click", ".cookie-policy-agree", function () {
                $cookieNotice.slideUp("slow");
                setCookie($cookieName, 'true', $cookieExpireDays);
            });

            /**
             * Validate the cookie
             */
            if ($cookieNotice.length) {
                console.log(getCookie($cookieNotice));
                if (!getCookie($cookieNotice)) {
                    $cookieNotice.slideDown("slow");
                }
            }
        }

        /**
         * Cookie Notice Init
         */
        _init();
    };
}(jQuery));

console.log('cookie?');
$(document).cookieNotice();