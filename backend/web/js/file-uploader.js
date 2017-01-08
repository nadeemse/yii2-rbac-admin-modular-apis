
function getURLVar(key) {

    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}

$(document).ready(function() {
    //Form Submit for IE Browser
    $('button[type=\'submit\']').on('click', function() {
        $("form[id*='form-']").submit();
    });

    // Highlight any found errors
    $('.text-danger').each(function() {
        var element = $(this).parent().parent();

        if (element.hasClass('form-group')) {
            element.addClass('has-error');
        }
    });

    // Tooltip remove fixed
    $(document).delegate('[data-toggle=\'tooltip\']', 'click', function(e) {
        $('body > .tooltip').remove();
    });

    // Override summernotes image manager
    $('.summernote').each(function() {
        var element = this;

        $(element).summernote({
            disableDragAndDrop: true,
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'image', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            buttons: {
                image: function() {
                    var ui = $.summernote.ui;

                    // create button
                    var button = ui.button({
                        contents: '<i class="fa fa-image" />',
                        tooltip: $.summernote.lang[$.summernote.options.lang].image.image,
                        click: function () {
                            $('#modal-image').remove();

                            $.ajax({
                                url: 'index.php?route=common/filemanager&token=' + getURLVar('token'),
                                dataType: 'html',
                                beforeSend: function() {
                                    $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                                    $('#button-image').prop('disabled', true);
                                },
                                complete: function() {
                                    $('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
                                    $('#button-image').prop('disabled', false);
                                },
                                success: function(html) {
                                    $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                                    $('#modal-image').modal('show');

                                    $('#modal-image a.thumbnail').on('click', function(e) {

                                        e.preventDefault();

                                        $(element).summernote('insertImage', $(this).attr('href'));

                                        $('#modal-image').modal('hide');
                                    });
                                }
                            });
                        }
                    });

                    return button.render();
                }
            }
        });
    });

    // Image Manager
    $(document).delegate('a[data-toggle=\'image\']', 'click', function(e) {
        e.preventDefault();

        $('.popover').popover('hide', function() {
            $('.popover').remove();
        });

        var element = this;

        $(element).popover({
            html: true,
            placement: 'right',
            trigger: 'manual',
            content: function() {
                return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
            }
        });

        $(element).popover('show');

        $('#button-image').on('click', function() {
            $('#modal-image').remove();

            $.ajax({
                url: '/file-manager?target=' + $(element).parent().find('input').attr('id') + '&thumb=' + $(element).attr('id'),
                dataType: 'html',
                beforeSend: function() {
                    $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                    $('#button-image').prop('disabled', true);
                },
                complete: function() {
                    $('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
                    $('#button-image').prop('disabled', false);
                },
                success: function(html) {
                    $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });

            $(element).popover('hide', function() {
                $('.popover').remove();
            });
        });

        $('#button-clear').on('click', function() {
            $(element).find('img').attr('src', $(element).find('img').attr('data-placeholder'));

            $(element).parent().find('input').attr('value', '');

            $(element).popover('hide', function() {
                $('.popover').remove();
            });
        });
    });

    // tooltips on hover
    $('[data-toggle=\'tooltip\']').tooltip({container: 'body', html: true});

    // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function() {
        $('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
    });

    // https://github.com/opencart/opencart/issues/2595
    $.event.special.remove = {
        remove: function(o) {
            if (o.handler) {
                o.handler.apply(this, arguments);
            }
        }
    }

    $('[data-toggle=\'tooltip\']').on('remove', function() {
        $(this).tooltip('destroy');
    });
});