<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
<div class="card-body">
<div class="row">
	<div class="col-md-3">
		<a href="<?php echo site_url('denslife/denslife/get_edit/'.$article_id);?>" class="card-title"><i class="btn btn-light" class="card-title">Back</i></a>
	</div>
	<div class="col-md-12" align="center">
		<h4 class="card-title">Add Article Content DensLife&Style</h4>
		<?php echo $this->session->flashdata('success'); ?>
	</div>
</div>
<hr>
<br>

<style>
	select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .image_picker_image {width: 200px;height: 130px;}
    #select option {color: black;}
</style>

	<div id="content-wrapper">
		<div class="container-fluid">
	      	<form action="<?php echo site_url('denslife/denslife/save_article');?>" method="post">
	          	<div class="row">
	          		<div class="col-md-6">
	            		<div class="form-group">
		            		<label>Article Content 1</label>
		            		<textarea id="article_content_1" name="article_content_1" class="wysiwyg-editor textImage" required></textarea>
	            		</div>
	            	</div>
	            	<div class="col-md-6">
	            		<div class="form-group">
		            		<label>Article Content 2</label>
		            		<textarea id="article_content_2" name="article_content_2" class="wysiwyg-editor"></textarea>
	            		</div>
	            	</div>
	            </div>

				<input type="hidden" name="article_id" value="<?php echo $article_id?>">
          		<div class="col-md-12">
            		<button class="btn btn-success pull-right" type="submit">Submit</button>
          		</div>
	      	</form>
		</div>
	</div>
</div>
</div>
</div>

<div class="page-loader">
    <div class="page-loader__spinner">
        <svg viewBox="25 25 50 50">
            <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
</div>

<div class="modal fade" id="modal-content" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Select an image</h5>
            </div>
            <div class="modal-body">
                <div id="changing-content">
                    <select class='image-picker show-html' id="img_sel" name="img_sel">
                      <?php
                        if($gallery!=null){
                            for ($i=0; $i < count($gallery) ; $i++) { 
                              $counter = $i+1;
                               echo "<option data-img-src='".$gallery[$i]."' data-img-alt='Image ".$counter."' value='".$gallery[$i]."'> Image ".$counter."</option>";
                            }
                        }
                      ?>
                     </select>
                </div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" id="art_id" name="art_id" value="<?php echo $article_id?>">
                <button id="uploadcontent" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn" onclick="getUrlContent()">Save</button>
                <button id="backcontent" type="button" class="btn btn-link callfunction2">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-embed" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <form action="" method="get" id="form_embed">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Select an image</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>URL Embed</label>
                        <input type="text" name="url" id="url">
                    </div>
                    <div class="col-md-12">
                        <label>Width</label>
                        <input type="text" name="maxwidth" id="maxwidth" value="600">
                    </div>
                    <div class="col-md-12">
                        <label>Height</label>
                        <input type="text" name="maxheight" id="maxheight" value="450">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" onclick="getUrlEmbed()">Save</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
	
<script type="text/javascript">
	function getUrlContent(){
		var info = $('#modal-content').attr('data-trumbo');
	    var image = $('#modal-content #img_sel').val();
	    var art_id = $('#art_id').val()
	    if (info == 1)
	    {
	    	var editorVal = $('#article_content_1').val();
	    	var newHtml = editorVal + '<img src="' + image + '">';
	    	$('#article_content_1').trumbowyg('html', newHtml);
	    }
	    else
	    {
	    	var editorVal = $('#article_content_2').val();
	    	var newHtml = editorVal + '<img src="' + image + '">';
	    	$('#article_content_2').trumbowyg('html', newHtml);
	    }
	    $('#modal-content').modal('hide');
	    insert_poster(image,art_id);
	}

	function insert_poster(image,art_id){
	    $.ajax({
	        url : '<?php echo base_url() ?>denslife/denslife/insert_artposter',
	        method : "POST",
	        data :{image :image, art_id :art_id},
	        async : true,
	        dataType : 'json',
	        success : function(data){
	            
	        }
	    });
	}

	function getUrlEmbed(){
        // $('#form_embed').submit();
        $.ajax({
            url: 'https://noembed.com/embed?nowrap=on',
            type: 'GET',
            data: {
                url: $('#url').val(),
                maxwidth: $('#maxwidth').val(),
                maxheight: $('#maxheight').val()
            },
            cache: false,
            dataType: 'json',

            success: function (data) {
                console.log(data)

                if (data.html)
                {
                    var info = $('#modal-embed').attr('data-trumbo');
                    if (info == 1)
                    {
                        var editorVal = $('#article_content_1').val();
                        var newHtml = editorVal + data.html;
                        $('#article_content_1').trumbowyg('html', newHtml);
                    }
                    else
                    {
                        var editorVal = $('#article_content_2').val();
                        var newHtml = editorVal + data.html;
                        $('#article_content_2').trumbowyg('html', newHtml);
                    }
                }
                else
                {
                    alert('URL not supported for embeded');
                }
                $('#modal-embed').modal('hide');
            },
            error: function () {
                console.log('error')
                $('#modal-embed').modal('hide');
            }
        });
    }

    function logResults(json){
        console.log(json);
    }

	$(document).ready(function () {
	    $('.page-loader').hide();
	    var default_content = $("#changing-content").html();
	    $("select").imagepicker();
	    // Change div content
	    $('#uploadcontent').click(function () {
	      $('#changing-content')
	      .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=50&CH=denslife_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
	    });

	    $('#uploadcontent').click(function () {
	        $.ajax({
	            url: '<?php echo base_url() ?>denslife/denslife/get_token',
	            success: function(data){
	            console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=denslife_v1&type=image');
	            $('#changing-content')
	            .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=denslife_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
	            }
	        });
	    });

	    $('#back').click(function () {
	        $('#changing-content')
	        .html(default_content);
	    });

	    $('.callfunction2').click(function () {
	        $('.page-loader').show();
	        console.log(default_content);
	        $.ajax({
	          type: "GET",
	          url: '<?php echo base_url() ?>denslife/denslife/compare_image/',
	          success: function(data){
	            var _gallery = "<select class='image-picker show-html' id='img_sel' name='img_sel'>";
	            data = JSON.parse(data);
	            console.log(data);
	            for (var i = 0; i < data.length; i++) {
	                var _counter = parseInt(i+1);
	                _gallery = _gallery + "<option data-img-src='"+data[i]+"' data-img-alt='Image "+_counter+"' value='"+data[i]+"'> Image "+_counter+"</option>";
	            }
	            _gallery = _gallery+"</select>";
	             console.log(_gallery);
	                $('#changing-content').html(_gallery);
	                $("select").imagepicker();
	                $('.page-loader').hide();                
	          }
	          ,error: function(data){
	            $('.page-loader').hide();
	          }
	        });
	    });

	    $('[name=img_sel]').on('change', function(e){
	        var optionVideo = $("option:selected", this);
	        var optionImage = $(optionVideo).attr('data-img-src');
	        var valueSelected = this.value;
	        $('#url_image').val(optionImage)
	        $('#url_image').val(valueSelected)
	    })
	});

	$('#modal-content').on('shown.bs.modal', function (e) {
	    $('[name=img_sel]').change();
	})

	$('#article_content_1').trumbowyg({
        // imageWidthModalEdit: true,
        btnsDef: {
            uplImg: {
                fn: function() {
                    $('#modal-content').attr('data-trumbo', 1);
                    $('#modal-content').modal('show');
                },
                tag: 'imgcUpload',
                title: 'Upload Image',
                text: 'Upload Image',
                hasIcon: true,
                ico: 'insertImage'
            },
            embed: {
                fn: function() {
                    $('#modal-embed').attr('data-trumbo', 1);
                    $('#modal-embed').modal('show');
                },
                tag: 'embed',
                title: 'embed',
                text: 'embed',
                hasIcon: true,
                ico: 'insertImage'
            }
        },
        btns: [
                ["viewHTML"],
                ["undo", "redo"],
                ["formatting"],
                ["strong", "em", "del"],
                ["superscript", "subscript"],
                ["link"],
                ['uplImg'],
                ['embed'],
                ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
                ["unorderedList", "orderedList"],
                ["horizontalRule"],
                ["removeformat"],
                ["fullscreen"]
            ],
    });

    $('#article_content_2').trumbowyg({
        removeformatPasted: true,
        tagsToRemove: ['script'],
        btnsDef: {
            uplImg: {
                fn: function() {
                    $('#modal-content').attr('data-trumbo', 2);
                    $('#modal-content').modal('show');
                },
                tag: 'imgcUpload',
                title: 'Upload Image',
                text: 'Upload Image',
                hasIcon: true,
                ico: 'insertImage'
            },
            embed: {
                fn: function() {
                    $('#modal-embed').attr('data-trumbo', 2);
                    $('#modal-embed').modal('show');
                },
                tag: 'embed',
                title: 'embed',
                text: 'embed',
                hasIcon: true,
                ico: 'insertImage'
            }
        },
        btns: [
                ["viewHTML"],
                ["undo", "redo"],
                ["formatting"],
                ["strong", "em", "del"],
                ["superscript", "subscript"],
                ["link"],
                ['uplImg'],
                ['embed'],
                ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
                ["unorderedList", "orderedList"],
                ["horizontalRule"],
                ["removeformat"],
                ["fullscreen"]
            ],
    });
</script>

<footer class="footer hidden-xs-down">
	<p>© Super Admin Responsive. All rights reserved.</p>
</footer>