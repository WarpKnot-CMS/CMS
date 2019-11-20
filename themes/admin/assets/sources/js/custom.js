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
     * Title to slug
     */
    $(document).slugGenerator({
        'title': 'document_title',
        'slug': 'document_slug'
    });

    /**
     * Hide or display the left menu
     */
    $(document).on("click", ".left-menu-action", function () {
        $('body').toggleClass("left-menu-show-hide");
        if ($('body').hasClass("left-menu-show-hide")) {
            setCookie('left-menu-show-hide', true, 31);
        } else {
            deleteCookie('left-menu-show-hide');
        }
    });

    $(document).on("click", ".mobile-menu", function () {
        $("#mobile-menu-burger").toggleClass("open");
        $('.overlay').toggleClass('open');
    });

    /**
     * Cookie Read
     */
    function getCookie(name) {
        var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
        return v ? v[2] : null;
    }

    /**
     * Cookie Set
     */
    function setCookie(name, value, days) {
        var d = new Date();
        d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
        document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
    }

    /**
     * Delete Cookie
     */
    function deleteCookie(name) {
        setCookie(name, '', -1);
    }

    //bold italic strikethrough
    tinymce.init({
        selector: '.editor',
        plugins: 'print preview searchreplace autolink directionality  visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount  imagetools textpattern help code',
        toolbar: 'formatselect | forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        image_advtab: true,

        images_upload_url: window.location.protocol + '//' + window.location.hostname + '/' + 'filesmanagement/upload/images?location=editor',
        images_upload_base_path: '',
        image_list: window.location.protocol + '//' + window.location.hostname + '/' + 'filesmanagement/load',
        automatic_uploads: false,
        relative_urls: false,
        remove_script_host: false,
        templates: [],
        height: 300,
        statusbar: false,
        branding: false
    });
});