<script>
var tc, tf;

function save_media(media_name, csrf_hash) {
    $('.wrapper-spinner').show();
    var url = BASE_URL + 'uploader/save_cron';
    var data = {};
    data[csrf_name]  = csrf_hash;
    data['filename'] = media_name;
    $.post(url, data, function(result) {
        if (result.OK)
        {
            $('.wrapper-spinner').show();
            // var new_csrf = result.next_csrf;
            // convert_media(media_name, new_csrf);
            check_media_transcode(media_name);
        }
        else
        {
            $('.wrapper-spinner').hide();
            $('#uploader').plupload('notify', 'error', result.error.message);
            $('#uploader').plupload('clearQueue');
        }
    });
}

function convert_media(media_name, csrf_hash) {
    $('.wrapper-spinner').show();
    var url = BASE_URL + 'uploader/convert_media/' + media_name;
    var data = {};
    data[csrf_name]  = csrf_hash;
    // data['filename'] = media_name;
    $.post(url, data, function(result) {
        if (result.OK)
        {
            var obj = {
                original_name: media_name,
                new_name     : result.data.name,
                next_csrf    : result.next_csrf,
                type         : 'convert'
            };
            update_status_media(obj);
        }
        else
        {
            $('.wrapper-spinner').hide();
            $('#uploader').plupload('notify', 'error', result.error.message);
            $('#uploader').plupload('clearQueue');
        }
    });
}

function transfer_media(media_name, new_name, csrf_hash) {
    $('.wrapper-spinner').show();
    var url = BASE_URL + 'uploader/transfer_media/' + new_name;
    var data = {};
    data[csrf_name]  = csrf_hash;
    // data['filename'] = media_name;
    $.post(url, data, function(result) {
        if (result.OK)
        {
            var obj = {
                original_name: media_name,
                new_name     : new_name,
                next_csrf    : result.next_csrf,
                type         : 'transfer'
            };
            update_status_media(obj);
        }
        else
        {
            $('.wrapper-spinner').hide();
            $('#uploader').plupload('notify', 'error', result.error.message);
            $('#uploader').plupload('clearQueue');
        }
    });
}

function update_status_media(data) {
    if (typeof data == 'object')
    {
        $('.wrapper-spinner').show();
        var url = BASE_URL + 'uploader/update_status_media';
        var obj = {};
        obj[csrf_name]  = data.next_csrf;
        obj['filename'] = data.original_name;
        obj['new_name'] = data.new_name;
        obj['type']     = data.type;

        $.post(url, obj, function(result) {
            if (result.OK)
            {
                if (result.data.next_step == 'transfer')
                {
                    // var filename = result.data.filename;
                    // var new_name = result.data.filename_transcode;
                    // var new_csrf = result.next_csrf;
                    // transfer_media(filename, new_name, new_csrf);
                    var obj = {
                        original_name: result.data.filename,
                        new_name     : result.data.filename_transcode,
                        next_csrf    : result.next_csrf,
                        type         : 'transfer'
                    };
                    update_status_media(obj);
                }
                else
                {
                    $('.wrapper-spinner').hide();
                    // check_media_transcode(media_name);
                    // check_media_transfer(media_name);
                    $('#uploader').plupload('notify', 'info', 'The media file <strong>' + result.data.filename + '</strong> successfully transcoded!');
                }
            }
            else
            {
                $('.wrapper-spinner').hide();
                $('#uploader').plupload('notify', 'error', result.error.message);
                $('#uploader').plupload('clearQueue');
            }
        });
    }
    else
    {
        $('.wrapper-spinner').hide();
        $('#uploader').plupload('notify', 'error', 'Wrong object format to pass.');
    }
}

function check_media_transcode(media_name, dur = 60*1000) {
    tc = setInterval(function(){
        var url = BASE_URL + 'uploader/check_transcode';
        var data = { filename: media_name };
        $.post(url, data, function(result) {
            if (result.OK)
            {
                if (result.data[0].status_transcode == '1')
                {
                    stop_check_media('1');

                    var new_name = result.data[0].filename_transcode;
                    check_media_transfer(new_name);
                }
            }
        });
    }, dur);
}

function check_media_transfer(media_name, dur = 60*1000) {
    tf = setInterval(function(){
        var url = BASE_URL + 'uploader/check_transfer';
        var data = { filename: media_name };
        $.post(url, data, function(result) {
            if (result.OK)
            {
                if (result.data[0].status_transcode == '1')
                {
                    $('.wrapper-spinner').hide();
                    stop_check_media('2');
                    $('#uploader').plupload('notify', 'info', 'The media file(s) successfully transcoded!');
                }
            }
        });
    }, dur);
}

function stop_check_media(type = '1') {
    if (type == '1')
    {
        clearInterval(tc);
    }
    else
    {
        clearInterval(tf);
    }
}

// initialize the widget when the DOM is ready
$(function() {

    $('.wrapper-spinner').hide();

    $('#uploader').plupload({
        runtimes        : 'html5,flash,silverlight,html4',
        url             : BASE_URL + 'uploader/upload',
        multipart_params: OBJ_CSRF,
        unique_names    : true,
        chunk_size      : '100mb',
        max_retries     : 3,
        // resize images on clientside if we can
        resize: {
            width  : 200,
            height : 200,
            quality: 90,
            crop   : true
        },
        // specify what files to browse for
        filters: {
            max_file_size: '5gb',
            mime_types   : [
                {
                    title     : 'Video Files',
                    extensions: 'avi,mpeg,mpg,mp4'
                }
            ]
        },
        rename            : true,
        sortable          : true,
        prevent_duplicates: true,
        dragdrop          : true,
        // views to activate
        views: {
            list  : true,
            thumbs: true,
            active: 'thumbs'
        },
        flash_swf_url      : BASE_URL + 'assets/plupload/Moxie.swf',
        silverlight_xap_url: BASE_URL + 'assets/plupload/Moxie.xap',
        // Post init events, bound after the internal events
        init: {
            BeforeUpload: function(up, file) {
                // Called right before the upload for a given file starts, can be used to cancel it if required
                console.log('[BeforeUpload]', 'File: ', file);
            },

            FileUploaded: function(up, file, info) {
                // Called when file has finished uploading
                // console.log('[FileUploaded] File:', file, "Info:", info);
                $('.wrapper-spinner').show();
                var resp = JSON.parse(info.response);

                if (resp.OK)
                {
                    var new_csrf = resp.next_csrf;
                    save_media(resp.info.name, new_csrf);
                }
                else
                {
                    $('#uploader').plupload('notify', 'error', resp.error.message);
                }
            },

            ChunkUploaded: function(up, file, info) {
                // Called when file chunk has finished uploading
                // console.log('[ChunkUploaded] File:', file, "Info:", info);
                $('.wrapper-spinner').show();
                var resp = JSON.parse(info.response);

                if (resp.OK)
                {
                    var new_csrf = resp.next_csrf;
                    // up.settings.multipart_params[csrf_name] = new_csrf;
                    up.setOption('multipart_params', {
                            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                        }
                    );
                }
                else
                {
                    $('#uploader').plupload('notify', 'error', resp.error.message);
                }
            },

            UploadComplete: function(up, files) {
                // Called when all files are either uploaded or failed
                // console.log('[UploadComplete]');
                // $('#uploader').plupload('notify', 'info', 'The media file(s) successfully uploaded. Please wait a moment, begin transcoding process!');
                $('.wrapper-spinner').hide();
            },

            Error: function(up, args) {
                // Called when error occurs
                // log('[Error] ', args);
                $('.wrapper-spinner').hide();
            }
        }
    });

    // Handle the case when form was submitted before uploading has finished
    $('#form').submit(function(e) {
        // Files in queue upload them first
        if ($('#uploader').plupload('getFiles').length > 0)
        {
            // When all files are uploaded submit form
            $('#uploader').on('complete', function() {
                $('#form')[0].submit();
            });

            $('#uploader').plupload('start');
        }
        else
        {
            alert("You must have at least one file in the queue.");
        }
        return false; // Keep the form from submitting
    });

    // modified header text from widget
    var header_text = $('.plupload_header_text').text();
    var custom      = header_text + ' Rename files by clicking on their titles. ' +
        'Movie file only: <strong style="color: #D77E4B">avi, mpeg, mpg, mp4</strong>.';
    $('.plupload_header_text').html(custom);

});
</script>
