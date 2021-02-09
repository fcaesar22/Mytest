<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/image-picker/image-picker.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/video-js/video-js.css">
	<link href="https://unpkg.com/@videojs/themes@1/dist/forest/index.css" rel="stylesheet">
	<!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
	<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
	<script type="text/javascript" src="http://aid.digdaya.co.id/assets/jwplayer/jwplayer.js"></script>
	<script>jwplayer.key="O43oQ2NyiFFoHAYtP5twBStX9zBfUA836LoDx0p3WiM=";</script>
    <title>Trumbowyg</title>
</head>

<style>
	select {display: block !important;}
	select.image-picker {margin-bottom: 20px;}
	.image_picker_image {width: 200px;height: 130px;}
	#naming {color: rgba(0, 0, 0, 0.85);}
</style>

<body>
	<form action="<?php echo site_url('test_pdf/save_video');?>" method="post">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<textarea id="vid_url" name="vid_url" class="wysiwyg-editor textWysiwyg" required></textarea>
					<input type="hidden" id="con_vid" name="con_vid">
				</div>
			</div>
		<br>
			<div class="col-sm-12" align="center">
				<button class="btn btn-success" type="submit">Save</button>
			</div>
		</div>
	</form>

	<div class="modal fade" id="modal-vd" tabindex="-1" style="display: none;" aria-hidden="true">
	    <div class="modal-dialog modal-xl">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title pull-left">Select a video</h5>
	            </div>
	            <div class="modal-body">
	                <div class="tab-container">
	                    <ul class="nav nav-tabs nav-fill" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link active" data-toggle="tab" href="#active_art" role="tab">Videos</a>
	                        </li>
	                    </ul>
	                    <div class="tab-content">
	                        <div class="tab-pane active fade show" id="active_art" role="tabpanel">
	                            <div id="changing-video" class="tester">
	                                <select class='image-picker show-html' name="vid_sel">
	                                    <?php
	                                    if($gallery2!=null){
	                                        for ($i=0; $i < count($gallery2) ; $i++) {
	                                            $counter = $i+1;
	                                            echo "<option data-img-src='".$gallery2[$i]['url_video_poster']."' data-img-alt='Image ".$counter."' value='".$gallery2[$i]['url_video']."'> Image ".$counter."</option>";
	                                        }
	                                    }
	                                    ?>
	                                </select>
	                            </div>
	                        </div>
	                        <div class="tab-pane fade" id="inactive_art" role="tabpanel">
	                            <div class="row">
	                                <div class="col-md-12" align="center">
	                                    <div name="embed_sel" class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center">
	                                        <div class="contacts__item" id="embed" align="center">
	                                            <label>Image</label>
	                                            <a href="#" class="contacts__img">
	                                                <img id="embed_pos" src="" alt="" width="100" height="100">
	                                            </a>
	                                            <a class="btn btn-success btn-sm" name="embed_images" id="embed_images">Choose Image</a>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <input type="hidden" id="url_image_video" name="url_image_video">
	                <input type="hidden" id="url_video_final" name="url_video_final">
	                <button id="preview_vid" type="button" class="btn btn-link">Preview Video</button>
	                <button type="button" class="btn btn-link" onclick="getUrlVid()">Save</button>
	                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	    </div>
	</div>
	<div class="modal fade" id="modal-preview" tabindex="-1" style="display: none;" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title pull-left">Preview Video</h5>
	            </div>
	            <div class="modal-body">
	                <div id="changing-embed">
	                    <div id="bungkus" style="margin: 0 auto;display: none;"><video id="my-video" class="video-js vjs-theme-forest" controls preload="auto" width="410" height="230" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video></div>
	                </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	    </div>
	</div>

	<script src="<?=base_url()?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?=base_url()?>assets/video-js/video.js">"></script>
	<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>
	<script src="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
	<script src="<?=base_url()?>assets/js/app.min.js"></script>
	<script src="<?=base_url()?>assets/vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
	<script src="<?=base_url()?>assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	window.player = videojs('my-video');

	function getUrlVid(){
	    var image = $('#url_image_video').val()
	    var video_sel = $('#url_video_final').val()
	    var info_img = $('#modal-vd').attr('data-vid-name');
	    var info_id = $('#modal-vd').attr('data-vidid-name');
	    // set value into element
	    $('#' + info_img).attr('src', image);
	    $('#' + info_id).val(image);

	    var editorVal = $('#vid_url').val();
      	var newHtml = editorVal + '<div class="selm-player" id="jwplayers" ></div>';
      	$('#vid_url').trumbowyg('html', newHtml);
      	var playerInstance = jwplayer("jwplayers");
		playerInstance.setup({
		    autostart: true,
		    controls: false,
		    file: video_sel,
		    mute: true,
		    displaytitle: false,
		    displaydescription: false,
		    stretching: 'fill',
		    height: '100%',
		    width: '100%'
		});
      	$('#con_vid').val(video_sel);
	    // hide modal
	    $('#modal-vd').modal('hide');
	}

	$('#vid_url').trumbowyg({
		removeformatPasted: true,
		tagsToRemove: ['script'],
		btnsDef: {
	        insertvid: {
	            fn: function() {
	                $('#modal-vd').attr('data-trumbo', 1);
	                $('#modal-vd').modal('show');
	            },
	            tag: 'Insert Video',
	            title: 'Insert Video',
	            text: 'Insert Video',
	            hasIcon: true,
	            ico: 'noembed'
	        }
		},
		btns: [
			['insertvid']
		],
	});

	$(document).ready(function () {
	    var default_content = $("#changing-video").html();
	    $("select").imagepicker();
	    // Change div content

	    $('[name=vid_sel]').on('change', function(e){
	        var optionVideo = $("option:selected", this);
	        var optionImage = $(optionVideo).attr('data-img-src');
	        var valueSelected = this.value;
	        $('#url_image_video').val(optionImage)
	        $('#url_video_final').val(valueSelected)
	    })

	    $('#preview_vid').click(function () {
	        var image = $('#modal-vd .image_picker_selector').find('.selected').find('img').attr('src');
	        var video_sel = $('[name=vid_sel]').val();
	        var vid_preview = '<video id="my-video" style="margin: 0 auto;" class="video-js vjs-theme-forest" controls preload="auto" width="410" height="230" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video>'
	        var bungkus
	        if ($('#bungkus').html() != undefined)
	        {
	            bungkus = $('#bungkus').html('').css({
	                display:'block',
	                margin:'0 auto'
	            })
	            $('#changing-embed').html($(bungkus).append(vid_preview));
	        }
	        else
	        {
	            $('#changing-embed').html($('<div id="bungkus" style="display:block; margin: 0 auto;"></div>').append(vid_preview));
	        }

	        if (window.player.isReady_) window.player.dispose();

	        window.player = videojs('my-video');
	        window.player.src({
	            src: video_sel,
	            type: 'application/x-mpegURL',
	            // withCredentials: true
	        });
	        $('#modal-preview').modal('show');
	    });

	    $('#modal-preview').on('hidden.bs.modal', function (e) {
	        player.pause();
	    });
	});
	</script>
</body>

</html>