$(function () {
    "use strict";
    $.fn.galleryManager = function (options) {
        /**
         * This is the easiest way to have default options.
         * @type {jQuery|void}
         */
        var settings = $.extend({}, options);

        /**
         * @type {jQuery.fn.init|jQuery|HTMLElement}
         */

        var $fileLoad = $(".file-load"),
            $fileChange = ".file-load .file-select",
            $fileClear = ".file-load .clear",
            $galleryClear = ".file-load .clearGallery",
            $fileManagerModal = $(".gallery-modal"),
            $loadFiles = window.location.protocol + '//' + window.location.hostname + '/' + 'filesmanagement/load',
            $uploadLocation = window.location.protocol + '//' + window.location.hostname + '/' + 'filesmanagement/upload',
            $fileObject = '.gallery-modal .modal-body #files-list .files-container .item',
            $fileSelect = '.gallery-modal .modal-footer #objectInsert',
            $filePreview = '.picture-preview .image-container',
            $fileUpload = $('.filemanager-upload'),
            $target, $current, $currentObject;


        $(document).on("click", $fileChange, function () {
            /**
             * If this variable was already registered
             */
            if ($current) {
                /**
                 * If we're using a different file group
                 */
                if ($current.attr("group") !== $(this).attr("group")) {
                    /**
                     * Container Reset
                     */
                    $fileManagerModal.find("#files-list .files-container").html('<div class="col">Loading...</div>');
                }
            }

            /**
             * Insert Reset
             */
            $fileManagerModal.find('#objectInsert').attr({
                'object': '',
                'save_to': '',
                'group': '',
                'display_to': '',
                'location': ''
            });

            $current = $(this);
            $target = $current.closest(".file-load");

            var $object = $current.attr("object"),
                $saveTo = $current.attr("save_to"),
                $group = $current.attr("group"),
                $display_to = $current.attr("display_to"),
                $gallery = $current.attr("gallery");

            // Set the new attributes
            $fileManagerModal.find('#objectInsert').attr({
                'object': $object,
                'save_to': $saveTo,
                'group': $group,
                'display_to': $display_to,
                'gallery': $gallery
            });

            // Open the modal
            $fileManagerModal.modal('show');
        });

        // Picture Clear
        $(document).on("click", $fileClear, function () {
            // Image Clear
            $("#" + $(this).closest(".file-load").find(".select-image").attr("save_to")).val("");

            // File Clear
            $(this).closest(".file-load").find("input").val("");

            // Text Clear
            $(this).closest(".file-load").find(".file-current").text("");
            $($filePreview).html("");
        });

        // Gallery Clear
        $(document).on("click", $galleryClear, function () {
            $(this).closest(".picture-select").remove();
        });

        /**
         * On Modal Open
         */
        $fileManagerModal.on('shown.bs.modal', function () {
            // Upload Init

            $fileUpload.fileupload({
                url: $uploadLocation + '/' + $current.attr("group") + '?location=' + ($($fileSelect).attr("object")),
                dataType: 'json',
                done: function (e, data) {

                    var parent = $(this).attr("id");
                    if ($current.attr("group") === 'images') {
                        $fileManagerModal.find("#files-list .files-container").prepend('<div class="col-auto">' +
                            '<div class="item" object_name="' + data.result.title + '" location="' + data.result.src_location + '">' +
                            '<div class="image">' +
                            '<img src="' + data.result.location + '"/>' +
                            '</div>' +
                            '<div class="title">' + data.result.title + '</div>' +
                            '</div>' +
                            '</div>');
                    } else {
                        $fileManagerModal.find("#files-list .files-container").prepend('<div class="col-auto">' +
                            '<div class="item" object_name="' + data.result.title + '" location="' + data.result.src_location + '">' +
                            '<div class="file">' +
                            '<div><img src="' + data.result.extension_image + '"/><div class="title">' + data.result.title + '</div></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                    }

                    $('#' + parent + '-progress .progress-bar').css(
                        'width',
                        0 + '%'
                    );

                },
                progressall: function (e, data) {
                    var parent = $(this).attr("id");
                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    $('#' + parent + '-progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

            // Files Load
            $.get($loadFiles + '?group=' + $current.attr("group"), function (data) {
                var files = '';
                $.each(data, function (index, image) {
                    if ($current.attr("group") === 'images') {
                        files = files + imageLoadTemplate(image);
                    } else {
                        files = files + fileLoadTemplate(image);
                    }
                });
                $fileManagerModal.find("#files-list .files-container").html(files);
            }).done(function () {
            }).fail(function () {
            });
        });

        /**
         * File Select
         */
        $(document).on("click", $fileObject, function () {
            $currentObject = $(this);
            $($fileObject).removeClass("selected");
            $currentObject.addClass("selected");
            $($fileSelect).attr({
                "location": $(this).attr("location"),
                "object_name": $(this).attr("object_name"),
                "location_src": $(this).find("img").attr("src")
            });
        });

        /**
         * On Image Save
         */
        $(document).on("click", $fileSelect, function () {
            var $this = $(this);
            var
                object = $this.attr("object"),
                save_to = $this.attr("save_to"),
                group = $this.attr("group"),
                location = $this.attr("location"),
                display_to = $this.attr("display_to"),
                src = $this.attr("location_src"),
                object_name = $this.attr("object_name"),
                imageName;

            if (object_name) {
                imageName = object_name;
            }

            if ($current.attr("gallery")) {
                if (display_to) {
                    var multipleGroup = $target.attr("group") ? $target.attr("group") : '';

                    $target.find(display_to).append('' +
                        '<div class="picture-select picture-preview-simple d-inline-block picture-object">' +
                        '   <input type="hidden" class="form-control multiple gallery_picture_multiple" group="' + multipleGroup + '" unique_id="' + $(".gallery_picture_multiple").length + '" id="gallery_picture[]" name="gallery_picture[]" value="' + $currentObject.attr("location") + '">' +
                        '   <div class="clearGallery">x</div>' +
                        '   <div class="image-container">' +
                        '       <img src="' + $currentObject.find("img").attr("src") + '">' +
                        '   </div>' +
                        '</div>');
                }
            } else {
                if (display_to) {
                    $target.find(display_to).html(imageName + ' (x)');
                }
            }

            if (location) {
                $target.find("#" + save_to).val(location);
                $target.find($filePreview).html("<img src='" + src + "'/>");
            }

            $fileManagerModal.modal('hide');
        });

        /**
         * @param file
         * @returns {string}
         */
        function imageLoadTemplate(file) {
            return '<div class="col-auto">' +
                '<div location="' + file.location + '" class="item" object_name="' + file.title + '">' +
                '<div class="image">' +
                '<img src="' + file.value + '"/>' +
                '</div>' +
                '<div class="title">' + file.title + '</div>' +
                '</div>' +
                '</div>';
        }

        /**
         *
         * @param file
         * @returns {string}
         */
        function fileLoadTemplate(file) {
            return '<div class="col-auto">' +
                '<div location="' + file.location + '" class="item" object_name="' + file.title + '">' +
                '<div class="file">' +
                '<div>' +
                '<img src="' + file.extension_image + '"/>' +
                '<div class="title">' + file.title + '</div></div>' +
                '</div>' +
                '</div>' +
                '</div>';
        }
    };
}(jQuery));

$(function () {
    /**
     * Gallery Init
     */
    $(document).galleryManager({});
});