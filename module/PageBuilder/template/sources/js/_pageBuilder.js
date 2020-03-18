$(function () {
    "use strict";
    $.fn.pageBuilder = function (options) {

        /**
         * This is the easiest way to have default options.
         * @type {jQuery|void}
         */
        var settings = $.extend({}, options),
            $galleryImages = ".gallery-images",
            $sr = ".sortable-repeater";

        /**
         * Elements Rebuild
         */
        function pageBuilderElementsRefresh() {
            try {
                // only if it can be removed
                tinymce.remove();
            } catch (err) {
                console.log(err);
            }

            tinymce.init({
                selector: '.editor',
                plugins: 'print preview searchreplace autolink directionality  visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount  imagetools textpattern help code',
                toolbar: 'formatselect | forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
                image_advtab: true,

                images_upload_url: window.location.protocol + '//' + window.location.hostname + '/' + 'filesmanagement/upload/images?location=editor',
                images_upload_base_path: '',
                image_list: window.location.protocol + '//' + window.location.hostname + '/' + 'filesmanagement/load?request=tinymce',
                automatic_uploads: false,
                relative_urls: false,
                remove_script_host: false,
                templates: [],
                height: 300,
                statusbar: false,
                branding: false
            });

            $(".tox-tinymce").show();
            $("input.form-control").show();

            if ($($galleryImages).length) {
                $($galleryImages).sortable({});
            }

            if ($($sr).length) {
                $($sr).sortable({
                    beforeStop: pageBuilderElementsRefresh
                });
            }
        }

        /**
         * Machine Name Conversion
         */
        $(document).machineName({
            'name': 'object_name',
            'machine': 'machine_name'
        });

        /**
         * PageBuilder - Add Widgets
         */
        $("." + settings.widget).each(function (i, object) {
            /**
             * @type {*|jQuery|HTMLElement}
             */
            var $modal = $("#pageBuilderObject"),
                widgetManage = '#pageBuilderObject .widget-manage',
                widgetControl = '#pageBuilderObject .widget-control',
                widget = '#pageBuilderObject .widgets .widget',
                product_details = '#pageBuilderObject .objects .widget';

            /**
             * Sortable
             */
            $(".current-fields").sortable({
                beforeStop: pageBuilderElementsRefresh
            });
            pageBuilderElementsRefresh();

            /**
             * Galery Order Set
             */
            if ($($galleryImages).length) {
                $($galleryImages).sortable({});
            }

            /**
             * Modal Show
             */
            $(document).on("click", ".pagebuilder-add-widget", function () {
                $(widgetManage).attr("group", $(this).attr("group"));
                $($modal).modal('show');

                $modal.find(".widget-objects").hide();
                $modal.find(".current-element").html('');
                $modal.find(".elements").html("").hide();
                $modal.find(".field-manage").attr("item", '').attr("disabled", true);
                $(widget).show();
            });

            /**
             * Fields Repeat
             */
            $(document).on("click", ".repeater", function () {
                var timestamp = new Date().getUTCMilliseconds();
                var $html = $(this).closest(".repeater-container").find(".repeat-fields").html().replace('editor-object', 'editor').replace('timestamp', timestamp),
                    $insertBefore = $(this).closest(".widget-items-list").find(".repeater-container");
                $("<div class='wi'>" + $html + "</div>").insertBefore($insertBefore);
                pageBuilderElementsRefresh();
            });

            /**
             * Navigate thru groups
             */
            $(document).on("click", widget, function () {
                var $this = $(this),
                    object = $this.attr("object"),
                    object_id = $this.attr("object_id"),
                    postData = {};

                $(widgetManage).attr("widget", $(this).attr("object_id"));
                $("#pageBuilderObject .page-builder-title").addClass("back-active");

                /**
                 * Set the modal title
                 */
                $modal.find(".current-element").html(" - " + $(this).text());
                /**
                 * Hide the rest of the elements
                 */
                $(widget).hide();
                /**
                 * Get the child elements object
                 */

                postData.group = {
                    'object': object,
                    'object_id': object_id
                };

                $.post(window.location.protocol + '//' + window.location.hostname + '/' + 'admin/page-builder/post', {
                    'data_id': '_LOAD_WIDGETS',
                    'data': postData,
                }, function (data) {
                    $(".elements").show().html(data);
                }, 'json');

                /**
                 * Display the child elements
                 */
                $(this).closest(".modal-body").find(".elements").html($(this).attr("group")).show();
            });

            /**
             * Object select
             */
            $(document).on("click", product_details, function () {
                $(product_details).removeClass("selected");
                $(this).addClass("selected");
                $(widgetManage).attr("item", $(this).attr("object_id")).attr("disabled", false);
            });

            /**
             * Object Insert
             */
            $(document).on("click", widgetManage, function () {
                var pagebuilderSection = $(this).attr("group"),
                    widget = $(this).attr("widget"),
                    itemID = $(this).attr("item");


                var postData = {
                    'pagebuilderSection': pagebuilderSection,
                    'widget': widget,
                    'itemID': itemID
                };

                $.post(window.location.protocol + '//' + window.location.hostname + '/' + 'admin/page-builder/post', {
                    'data_id': '_LOAD_OBJECT',
                    'data': postData,
                }, function (data) {
                    /**
                     * Sortable Reload
                     */
                    $(pagebuilderSection).append(
                        data.replace("widget-content-hide", "")
                            .replace("oi-plus", "oi-minus")
                    ).sortable("refresh");

                    /**
                     * PageBuilder Refresh
                     */
                    pageBuilderElementsRefresh();
                    $($modal).modal('hide');

                }, 'json');

            });

            /**
             * Back
             */
            $(document).on("click", "#pageBuilderObject .page-builder-title", function () {
                $("#pageBuilderObject .page-builder-title").removeClass("back-active");
                $(widgetManage).attr("item", $(this).attr("object_id")).attr("disabled", true);
                $modal.find(".widget-objects").hide();
                $modal.find(".current-element").html('');
                $modal.find(".elements").html("").hide();
                $(widget).show();
            });

            /**
             * Widget Delete
             */
            $(document).on("click", ".current-fields .widget-delete", function () {
                $(this).closest(".widget-items").remove();
            });

            /**
             * Object Content Show / Hide
             */
            $(document).on("click", ".current-fields .widget-control,.current-fields .widget-name", function () {
                if ($(this).closest(".widget-items").find(".widget-items-list").hasClass("widget-content-hide")) {
                    $(this).closest(".widget-items").find(".widget-items-list").removeClass("widget-content-hide");
                    $(this).closest(".widget-items").find("span.oi").addClass("oi-minus").removeClass("oi-plus");
                } else {
                    $(this).closest(".widget-items").find(".widget-items-list").addClass("widget-content-hide");
                    $(this).closest(".widget-items").find("span.oi").addClass("oi-plus").removeClass("oi-minus");
                }
            });

            /**
             * Repeater Delete
             */
            $(document).on("click", ".wi-remove", function () {
                $(this).parents(".wi").remove();
            });
        });

        function sanitize(string) {
            return string.replace(/'/g, "").replace(/"/g, '');
        }

        /**
         * Page Builder - Create Widgets
         */
        $("." + settings.widget_field).each(function (i, object) {
            var $modal = $("#pageBuilderObject"),
                $modalUpdate = $("#pageBuilderObjectEdit"),
                widget = '#pageBuilderObject .widgets .widget';

            /**
             * Open The Page Builder Modal
             */
            $(document).on("click", ".page-builder-modal-action", function () {
                $("#pageBuilderObject").modal('show');

                $modal.find(".widget-objects").hide();
                $modal.find(".current-element").html('');
                $modal.find(".elements").html("").hide();
                $modal.find(".field-manage").attr("item", '').attr("disabled", true);
                $(widget).show();
            });

            $(".current-fields").sortable({
                beforeStop: pageBuilderElementsRefresh
            });
            pageBuilderElementsRefresh();

            /**
             * Items Preview
             */
            $(document).on("click", widget, function () {
                /**
                 * Remove the old data
                 */
                $(".elements").html();

                /**
                 * Set the modal title
                 */
                $modal.find(".current-element").html(" - " + $(this).text());

                /**
                 * Hide the rest of the elements
                 */
                $(widget).hide();

                /**
                 * Set the current id
                 */
                $modal.find(".field-manage").attr("item", $(this).attr("object")).attr("disabled", false);

                /**
                 * Get the field configuration form
                 */
                $.post(window.location.protocol + '//' + window.location.hostname + '/' + 'admin/page-builder/post', {
                    'data_id': $(this).attr("object"),
                }, function (data) {
                    $(".elements").show().html(data);

                    $(document).machineName({
                        'name': 'object_name',
                        'machine': 'machine_name'
                    });

                }, 'json');


                /**
                 * Go Back
                 */
                $(document).on("click", "#pageBuilderObject .page-builder-title", function () {
                    $("#pageBuilderObject .page-builder-title").removeClass("back-active");
                    $modal.find(".widget-objects").hide();
                    $modal.find(".current-element").html('');
                    $modal.find(".elements").html("").hide();
                    $modal.find(".field-manage").attr("item", '').attr("disabled", true);
                    $(widget).show();
                });
            });

            /**
             * Item UPDATE/INSERT
             */
            $(document).on("click", ".field-manage", function () {
                /**
                 * Field Validation
                 */
                var errors = false,
                    action = $(this).attr("action");
                $('.required').each(function (i, obj) {
                    switch ($(obj).attr("validation")) {
                        case "input":
                        case "textarea":
                            if ($(obj).val() === '') {
                                $(obj).parent(".form-group").addClass("error");
                                errors = true;
                            } else {
                                $(obj).parent(".form-group").removeClass("error");
                            }
                            break;
                        case "select":
                            if (($(obj).val() === '') || $(obj).val() === 0) {
                                $(obj).parent(".form-group").addClass("error");
                                errors = true;
                            } else {
                                $(obj).parent(".form-group").removeClass("error");
                            }
                            break;
                    }
                });

                if (!errors) {
                    var postData = {},
                        item_id = $(this).attr("item_id");
                    if (action === 'insert') {
                        postData.form_serialize = sanitize($modal.find(".field-container").serialize());
                    } else {
                        postData.form_serialize = sanitize($modalUpdate.find(".field-container").serialize()) + '&item_id=' + item_id;
                    }

                    $.post(window.location.protocol + '//' + window.location.hostname + '/' + 'admin/page-builder/post', {
                        'data_id': '_GENERATE' + $(this).attr("item"),
                        'data': postData,
                    }, function (data) {
                        if (action === 'insert') {
                            $(".current-fields").append(data).sortable("refresh");
                            pageBuilderElementsRefresh();
                            $modal.modal('hide');
                        } else {
                            /**
                             * Set the temporary space
                             */
                            $("<div id='tmp-object'></div>").insertBefore("#" + item_id);
                            /**
                             * Remove the old field
                             */
                            $("#" + item_id).remove();

                            /**
                             * Insert the updated div
                             */
                            $(data).insertBefore("#tmp-object");

                            /**
                             * Remove the temporary div
                             */
                            $("#tmp-object").remove();

                            /**
                             * Refresh the sort
                             */
                            $(".current-fields").sortable("refresh");
                            pageBuilderElementsRefresh();
                            /**
                             * Hide the modal
                             */
                            $modalUpdate.modal('hide');
                        }
                    }, 'json');
                }

            });

            /**
             * Object Destroy
             */
            $(document).on("click", ".object-destroy", function () {
                $(this).parent(".object").remove();
            });

            /**
             * Object Edit Load
             */
            $(document).on("click", ".object-edit", function () {
                var $currentModal = $("#pageBuilderObjectEdit"),
                    jsonData = $(this).parent(".object").attr("json"),
                    $temp_id = $(this).attr("temp_id"),
                    $type = $(this).attr("object");
                $currentModal.find(".field-manage").attr("item_id", $temp_id);
                $currentModal.find(".field-manage").attr("item", $(this).attr("object"));

                /**
                 * Get the field configuration form
                 */
                var postData = {};
                postData.form_serialize = $.param(JSON.parse(jsonData));

                $.post(window.location.protocol + '//' + window.location.hostname + '/' + 'admin/page-builder/post', {
                    'data_id': $type,
                    'data': postData,
                }, function (data) {
                    /**
                     * Load the object with the default data
                     */
                    $currentModal.find("#edit-element").html(data);

                    $(document).machineName({
                        'name': 'object_name',
                        'machine': 'machine_name'
                    });

                }, 'json');

                $($currentModal).modal('show');
            });
        });

    };
}(jQuery));


/**
 * PageBuilder INIT
 */
$(function () {
    $(document).pageBuilder({
        'widget': 'page-builder-widgets-add',
        'widget_field': 'page-builder-object'
    });
});