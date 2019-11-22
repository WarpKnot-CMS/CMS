$(function () {
    "use strict";

    /**
     * Ajax submit
     */
    $(".form-post").ajaxSubmit({
        ajax_error: function () {
        },
        ajax_ok: function () {
        }
    });

    /**
     * Slider(s) Init
     */
    $(document).ready(function () {
        var sliderInit = [];
        $('.slider-init').each(function (index, slider) {
            sliderInit['_slider_' + $(slider).attr("id")] = new Swiper("#" + $(slider).attr("id"), {
                slidesPerView: $(slider).attr("data-slidesPerView") ? parseInt($(slider).attr("data-slidesPerView")) : 1,
                loop: !!$(slider).attr("data-loop"),
                effect: $(slider).attr("data-fade") ? 'fade' : '',
                autoHeight: true,
                // If we need pagination
                pagination: {
                    el: $("#" + $(slider).attr("id") + ' .swiper-pagination').length = 1 ? "#" + $(slider).attr("id") + ' .swiper-pagination' : false,
                    clickable: true,
                },
                spaceBetween: 30,
                autoplay: $(slider).attr("data-autoplay") ? {
                    delay: $(slider).attr("data-autoplay"),
                    disableOnInteraction: false,
                } : false,

                // Navigation arrows
                navigation: {
                    nextEl: "#" + $(slider).attr("id") + ' .swiper-button-next',
                    prevEl: "#" + $(slider).attr("id") + ' .swiper-button-prev',
                },
                breakpoints: $(slider).attr("data-slidesPerView") ? {
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    }
                } : '',
                on: {
                    slideChangeTransitionEnd: function () {
                        /**
                         * Remove the first active status
                         */
                        $("#" + $(slider).attr("id") + " .slide_action").removeClass("active");
                        /**
                         * Set the new active status
                         */
                        $("#" + $(slider).attr("id") + " #slide_action__" + this.activeIndex).addClass("active");
                    },
                    slideNextTransitionStart: function () {
                    },
                }
            });

            $(document).on("click", "#" + $(slider).attr("id") + " .slide_action", function () {
                var goToSlide = $(this).attr("slide_index");
                sliderInit['_slider_' + $(slider).attr("id")].slideTo(goToSlide);
                $(".slide-headline").removeClass("active");
                $(this).addClass("active");
            });
        });

        /**
         * Gallery Slider Init
         */
        var gallerySliderInit = [];
        $('.gallery-slider-init').each(function (index, gallery) {
            gallerySliderInit['_slider_' + $(gallery).attr("id")] = new Swiper("#" + $(gallery).attr("id") + '_thumbs', {
                spaceBetween: 5,
                slidesPerView: 5,
                freeMode: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
            });
            new Swiper("#" + $(gallery).attr("id"), {
                spaceBetween: 5,
                navigation: {
                    nextEl: '#' + $(gallery).attr("id") + ' .swiper-button-next',
                    prevEl: '#' + $(gallery).attr("id") + ' .swiper-button-prev',
                },
                thumbs: {
                    swiper: gallerySliderInit['_slider_' + $(gallery).attr("id")]
                }
            });
        });
    });

    /**
     * Gallery INIT
     */
    $(document).ready(function () {
        var galleryInit = [];
        $('.gallery-init').each(function (index, object) {
            $('#' + $(object).attr("id")).rebox({selector: 'a'});
        });
    });

    /**
     * Chart INIT
     */
    $(document).ready(function () {

        // Line Chart
        $('.lineChart').each(function (index, chart) {
            var labels = $(this).attr("labels").split(","),
                label = $(this).attr("label"),
                data = $(this).attr("data").split(","),
                borderColor = $(this).attr("borderColor");

            new Chart($(chart).find(".lineChart__canvas"), {
                "type": "line",
                "data": {
                    "labels": labels,
                    "datasets": [{
                        "label": label,
                        "data": data,
                        "fill": false,
                        "borderColor": borderColor,
                        "lineTension": 0.1
                    }]
                },
                "options": {}
            });
        });

        // Bar Chart
        $('.barChart').each(function (index, chart) {
            var labels = $(this).attr("labels").split(","),
                label = $(this).attr("label"),
                data = $(this).attr("data").split(","),
                background = $(this).attr("background").split(","),
                chartStyle = $(this).attr("chartStyle").split(",");
            new Chart($(chart).find(".barChart__canvas"), {
                "type": chartStyle,
                "data": {
                    "labels": labels,
                    "datasets": [{
                        "label": label,
                        "data": data,
                        "fill": false,
                        "backgroundColor": background,
                        "borderWidth": 1
                    }]
                },
                "options": {"scales": {"yAxes": [{"ticks": {"beginAtZero": true}}]}}
            });
        });

        // Doughnut & Pie Chart
        $('.doughnutPieChart').each(function (index, chart) {
            var labels = $(this).attr("labels").split(","),
                label = $(this).attr("label"),
                data = $(this).attr("data").split(","),
                background = $(this).attr("background").split(","),
                type = $(this).attr("chart-type");

            new Chart($(chart).find(".doughnutPieChart__canvas"), {
                "type": type,
                "data": {
                    "labels": labels,
                    "datasets": [{
                        "label": label,
                        "data": data,
                        "backgroundColor": background
                    }]
                }
            });
        });

    });

    $(document).on("click", ".search-controller", function () {
        $(this).closest(".blog-search-form").find(".search-form").toggleClass("active");
        $(this).closest(".blog-search-form").find("#s").focus();
    });
});