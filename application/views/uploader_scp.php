<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Video Uploader</title>
    <!-- jquery ui -->
    <link type="text/css" rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.min.css" media="screen">
    <!-- plupload jquery ui -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css') ?>">
</head>
<body>

    <form id="form" method="post" action="<?php echo base_url() . '/uploader_scp/do_upload'; ?>">
        <div id="uploader">
            <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
            <input type="submit" value="Submit">
        </div>
        <br>
    </form>

    <!-- jquery -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js" charset="UTF-8"></script>
    <!-- jquery ui -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js" charset="UTF-8"></script>
    <!-- plupload -->
    <script type="text/javascript" src="<?php echo base_url('assets/plupload/plupload.full.min.js'); ?>"></script>
    <!-- plupload jquery ui -->
    <script type="text/javascript" src="<?php echo base_url('assets/plupload/jquery.ui.plupload/jquery.ui.plupload.min.js'); ?>"></script>

    <!-- plupload config & init -->
    <script>
        BASE_URL = '<?php echo base_url(); ?>';
    </script>

    <script type="text/javascript">
        // Initialize the widget when the DOM is ready
        $(function() {
            $("#uploader").plupload({
                // General settings
                runtimes : 'html5,flash,silverlight,html4',
                url : BASE_URL + 'uploader_scp/do_upload',
                unique_names : true,

                chunk_size: '100mb',

                max_retries: 3,

                // Resize images on clientside if we can
                resize : {
                    width : 200,
                    height : 200,
                    quality : 90,
                    crop: true // crop to exact dimensions
                },

                // Specify what files to browse for
                filters : {
                    // Maximum file size
                    max_file_size : '5gb',
                    // Specify what files to browse for
                    mime_types: [
                        // {title : "Image files", extensions : "jpg,gif,png"},
                        // {title : "Zip files", extensions : "zip"}
                        {title : "Video files", extensions : "avi,mpeg,mpg,mp4"}
                    ]
                },

                // Rename files by clicking on their titles
                rename: true,

                // Sort files
                sortable: true,

                prevent_duplicates: true,

                // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
                dragdrop: true,

                // Views to activate
                views: {
                    list: true,
                    thumbs: true, // Show thumbs
                    active: 'thumbs'
                },

                // Flash settings
                flash_swf_url : BASE_URL + 'assets/plupload/Moxie.swf',

                // Silverlight settings
                silverlight_xap_url : BASE_URL + 'assets/plupload/Moxie.xap'
            });

            // handle on uploaded event plupload
            $('#uploader').on('uploaded', function(event, uploader) {
                var result = uploader.result;
                var resp   = !result.response ? null : JSON.parse(result.response);

                if (resp && typeof resp == 'object')
                {
                    if (resp.error)
                    {
                        $('#uploader').plupload('notify', 'Error', resp.error.message);
                        $('#uploader').plupload('removeFile', uploader.file);
                        $('#uploader').plupload('refresh');
                    }
                    else
                    {
                        // ajax call to transcode movie into hls format
                        // movie2hls(uploader.file.name);
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
            var custom = header_text + ' Rename files by clicking on their titles. Movie file only: <strong style="color: #D77E4B">avi, mpeg, mpg, mp4</strong>.'
            $('.plupload_header_text').html(custom);

            function movie2hls(data) {
                // modified ui
                // var status_wrapper = $('.plupload_started');
                // status_wrapper.toggleClass('plupload_hidden');
                // var status_text = $('.plupload_upload_status').text();
                // $('.plupload_upload_status').text(status_text + ' | Begin transcoding to HLS...')

                $.ajax({
                    'url' : BASE_URL + 'uploader_scp/movie2hls',
                    'type': 'post',
                    'data': {'files':data},
                    'success': function(result, status, xhr) {
                        console.log(xhr)
                        // $('.plupload_upload_status').text(status_text + ' | Finish transcoding to HLS...')
                        // status_wrapper.toggleClass('plupload_hidden');

                        if (result.success === true)
                        {
                            var file = result.data.filename;
                            // ajax call to transfer hls
                            // transfer(file);
                        }
                    },
                    'error': function(xhr, status, error) {
                        console.log(xhr)
                        // $('.plupload_upload_status').text(status_text + ' | Finish transcoding to HLS...')
                        // status_wrapper.toggleClass('plupload_hidden');
                    }
                })
            }
        });
    </script>
</body>
</html>