<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
    	<div class="col-md-3">
    		<a href="<?php echo site_url('whatson') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
    	</div>
    	<div class="col-md-12" align="center">
    		<h4 class="card-title">Edit Channel What's On</h4>
    	</div>
    </div>
    <hr>
    <br>

    <style>
        select {
            display: block !important;
        }

        select.image-picker {
            margin-bottom: 20px;
        }

      	.image_picker_image {
          	width: 200px;
          	height: 130px;
      	}
        #select option {
            color: black;
        }
        #whatson_purpose option {
            color: black;
        }
        #whatson_type option {
            color: black;
        }
    </style>

	<div id="content-wrapper">
	<div class="container-fluid">
		<form action="<?php echo site_url('whatson/update_product');?>" method="post">
      <div class="row">
    		<div class="col-sm-6">
      		<div class="form-group">
				    <label style="margin-bottom: 22px;">What's On Title</label>
				    <input type="text" class="form-control" name="whatson_title" placeholder="What's On Title" required>
				    <i class="form-group__bar"></i>
  				</div>
          <div class="form-group">
            <label>What's On Image</label>
            <a class="btn btn-light btn-sm callfunction" data-toggle="modal" name="whatson_image" data-target="#modal-image" id='butimage'>Choose Image</a>
            <input type="text" class="form-control textImage" id= 'whimage' name="whatson_image" placeholder="what's on image" required>
            <i class="form-group__bar"></i>
          </div>
          <div class="form-group">
            <label>What's On Video</label>
            <input type="text" class="form-control" name="whatson_video" placeholder="what's on video">
            <i class="form-group__bar"></i>
          </div>
          <div class="form-group">
            <label>Category What's On</label>
            <select id="select" class="form-control js-example-basic-single" name="category" required>
              <?php foreach($category as $row):?>
              <option value="<?php echo $row->category_whatson_id;?>"><?php echo $row->category_whatson_name;?></option>
              <?php endforeach;?>
            </select>
          </div>
          <div class="form-group">
            <label>Sub Category What's On Name</label>
            <select id="select" class="form-control js-example-basic-single" name="subcategory" id="subcategory" required>
              <?php foreach($subcategory as $row):?>
              <option value="<?php echo $row->sub_category_whatson_id;?>"><?php echo $row->sub_category_whatson_name;?></option>
              <?php endforeach;?>
            </select>
          </div>
				</div>
				<div class="col-md-6">
          <div class="form-group">
            <label>What's On Description</label>
            <textarea id="whatson_description" name="whatson_description" class="wysiwyg-editor textWysiwyg" required></textarea>
          </div>
        </div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Channel What's On Name</label>
					    <select id="select" class="form-control js-example-basic-single" name="channelwo" id="channelwo" required>
					    	<?php foreach($channelwo as $row):?>
					    	<option value="<?php echo $row->channel_whatson_id;?>"><?php echo $row->channel_whatson_name;?></option>
					    	<?php endforeach;?>
					    </select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Thumbnail What's On Name</label>
					    <select id="select" class="form-control js-example-basic-single" name="thumbnailname" id="thumbnailname" required>
					    	<?php foreach($thumbnailname as $row):?>
					    	<option value="<?php echo $row->thumbnail_whatson_id;?>"><?php echo $row->thumbnail_whatson_name;?></option>
					    	<?php endforeach;?>
					    </select>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Content ID</label>
					    <input type="text" class="form-control" name="content_id" placeholder="Content ID" required>
					    <i class="form-group__bar"></i>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Content URL</label>
					    <input type="text" class="form-control" name="content_url" placeholder="Content URL" required>
					    <i class="form-group__bar"></i>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					    <label>Content URL Image</label><a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="content_url_image" data-target="#modal-content" id='butcontent'>Choose Image</a>
	                    <input type="text" class="form-control textContent" id= 'whcontent' name="content_url_image" placeholder="what's on image" required>
	                    <i class="form-group__bar"></i>
					</div>
				</div>
				<div class="col-sm-6">
          <div class="form-group">
            <label for="datetimepicker">What's On Schedule Time</label>
            <div class='input-group date'>
                  <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                  <input type="text" id="datetimepicker" name="whatson_schedule_time" placeholder="Pick a date & time" class="form-control">
                  <i class="form-group__bar"></i>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
              <label>What's On Purpose</label>
              <select class="form-control js-example-basic-single" name="whatson_purpose" id="whatson_purpose" required>
                <option value="0">What's On</option>
                <option value="1">DensPlay</option>
              </select>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
              <label>What's On Type</label>
              <select class="form-control js-example-basic-single" name="whatson_type" id="whatson_type" required>
                <option value="1">Text</option>
                <option value="2">Image</option>
                <option value="3">Video</option>
              </select>
          </div>
        </div>
				<input type="hidden" name="whatson_id" value="<?php echo $whatson_id?>" required>
				<div class="col-sm-12" align="center">
					<button class="btn btn-success" type="submit">Update</button>
				</div>
			</div>
		</form>

	</div>
	</div>
	</div>

<div class="modal fade" id="modal-image" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left">Select an image</h5>
      </div>
      <div class="modal-body">
        <div id="changing-contentimage">
          <select class='image-picker show-html'>
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
        <button id="uploadimage" type="button" class="btn btn-link">Upload Image</button>
        <button type="button" class="btn btn-link" onclick="getUrlImage()">Save</button>
        <button id="backimage" type="button" class="btn btn-link callfunction">Images</button>
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-content" tabindex="-1" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left">Select an image</h5>
      </div>
      <div class="modal-body">
        <div id="changing-content2">
          <select class='image-picker show-html'>
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
        <button id="uploadcontent" type="button" class="btn btn-link">Upload Image</button>
        <button type="button" class="btn" onclick="getUrlContent()">Save</button>
        <button id="backcontent" type="button" class="btn btn-link callfunction2">Images</button>
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-wysiwyg" tabindex="-1" style="display: none;" aria-hidden="true">
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
                <button id="uploadwysiwyg" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn" onclick="getUrlWysiwyg()">Save</button>
                <button id="backwysiwyg" type="button" class="btn btn-link callfunction3">Images</button>
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
                <h5 class="modal-title pull-left">Embed Video</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>URL Embed</label>
                        <input type="text" name="url_embed" id="url_embed">
                    </div>
                    <div class="col-md-12">
                        <label>Width</label>
                        <input type="text" name="maxwidth_embed" id="maxwidth_embed" value="600">
                    </div>
                    <div class="col-md-12">
                        <label>Height</label>
                        <input type="text" name="maxheight_embed" id="maxheight_embed" value="450">
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
	<script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
	<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
  <script src="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
	<script type="text/javascript">
  function getUrlWysiwyg(){
      var info = $('#modal-wysiwyg').attr('data-trumbo');
      var image = $('#modal-wysiwyg #img_sel').val();
      if (info == 1)
      {
        var editorVal = $('#whatson_description').val();
        var newHtml = editorVal + '<img src="' + image + '">';
        $('#whatson_description').trumbowyg('html', newHtml);
      }
      $('#modal-wysiwyg').modal('hide');
      // insert_poster(image,art_id);
  }

  function getUrlEmbed(){
      // $('#form_embed').submit();
      $.ajax({
          url: 'https://noembed.com/embed?nowrap=on',
          type: 'GET',
          data: {
              url: $('#url_embed').val(),
              maxwidth: $('#maxwidth_embed').val(),
              maxheight: $('#maxheight_embed').val()
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
                      var editorVal = $('#whatson_description').val();
                      var newHtml = editorVal + data.html;
                      $('#whatson_description').trumbowyg('html', newHtml);
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
        $('#uploadwysiwyg').click(function () {
          $('#changing-content')
          .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
        });

        $('#uploadwysiwyg').click(function () {
            $.ajax({
                url: '<?php echo base_url() ?>whatson/get_token',
                success: function(data){
                console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image');
                $('#changing-content')
                .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
                }
            });
        });

        $('#backwysiwyg').click(function () {
            $('#changing-content')
            .html(default_content);
        });

        $('.callfunction3').click(function () {
            $('.page-loader').show();
            console.log(default_content);
            $.ajax({
              type: "GET",
              url: '<?php echo base_url() ?>whatson/compare_image/',
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
    });

    $('#whatson_description').trumbowyg({
          removeformatPasted: true,
          tagsToRemove: ['script'],
          btnsDef: {
              uplImg: {
                  fn: function() {
                      $('#modal-wysiwyg').attr('data-trumbo', 1);
                      $('#modal-wysiwyg').modal('show');
                  },
                  tag: 'imgcUpload',
                  title: 'Upload Image',
                  text: 'Upload Image',
                  hasIcon: true,
                  ico: 'insertImage'
              },
              embedvideo: {
                  fn: function() {
                      $('#modal-embed').attr('data-trumbo', 1);
                      $('#modal-embed').modal('show');
                  },
                  tag: 'Embed Video',
                  title: 'Embed Video',
                  text: 'Embed Video',
                  hasIcon: true,
                  ico: 'noembed'
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
                  ['embedvideo'],
                  ["justifyLeft", "justifyCenter", "justifyRight", "justifyFull"],
                  ["unorderedList", "orderedList"],
                  ["horizontalRule"],
                  ["removeformat"]
              ],
      });

  // function insert_poster(image,art_id){
  //     $.ajax({
  //         url : '<?php echo base_url() ?>denslife/insert_artposter',
  //         method : "POST",
  //         data :{image :image, art_id :art_id},
  //         async : true,
  //         dataType : 'json',
  //         success : function(data){
              
  //         }
  //     });
  // }

  $('.js-example-basic-single').select2();
	function getUrlImage(){
      var image = $('#modal-image .image_picker_selector').find('.selected').find('img').attr('src');
      //$('image-picker').hide();

      $('.textImage').val(image);
      $('#modal-image').modal('hide');
  }

	function getUrlContent(){
	      var image = $('#modal-content .image_picker_selector').find('.selected').find('img').attr('src');
	      //$('image-picker').hide();

	      $('.textContent').val(image);
	      $('#modal-content').modal('hide');

	    }

	$(document).ready(function() {
        get_data_edit();

    	$( function() {
	    $("#datetimepicker").flatpickr({
	    	enableTime: true,
			time_24hr: true,
			enableSeconds: true,
			minuteIncrement: 1,
			dateFormat: "Y-m-d H:i:S",
	    	});
	  	});

		//load data for edit
        function get_data_edit(){
        	var whatson_id = $('[name="whatson_id"]').val();
        	$.ajax({
        		url : "<?php echo site_url('whatson/get_data_edit');?>",
                method : "POST",
                data :{whatson_id :whatson_id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $.each(data, function(i, item){
                        $('[name="whatson_title"]').val(data[i].whatson_title);
                        $('[name="whatson_description"]').trumbowyg('html', data[i].whatson_description);
                        $('[name="whatson_image"]').val(data[i].whatson_image);
                        $('[name="whatson_video"]').val(data[i].whatson_video);
                        $('[name="category"]').val(data[i].category_whatson_id).trigger('change');
                        $('[name="subcategory"]').val(data[i].sub_category_whatson_id).trigger('change');
                        $('[name="channelwo"]').val(data[i].channel_whatson_id).trigger('change');
                        $('[name="thumbnailname"]').val(data[i].thumbnail_whatson_id).trigger('change');
                        $('[name="content_id"]').val(data[i].content_id).trigger('change');
                        $('[name="content_url"]').val(data[i].content_url).trigger('change');
                        $('[name="content_url_image"]').val(data[i].content_url_image).trigger('change');
                        $('[name="whatson_schedule_time"]').val(data[i].whatson_schedule_time).trigger('change');
                        $('[name="whatson_purpose"]').val(data[i].whatson_purpose).trigger('change');
                        $('[name="whatson_type"]').val(data[i].whatson_type).trigger('change');
                    });
                }
        	});
        }
    });

    $(document).ready(function () {
    var default_content = $("#changing-contentimage").html();
    console.log(default_content);
    $("select").imagepicker();
    // Change div content
    $('#uploadimage').click(function () {
      $('#changing-contentimage')
      .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
    });


        $('#uploadimage').click(function () {
        $.ajax({
            url: '<?php echo base_url() ?>whatson/get_token',
            success: function(data){
            console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image');
            $('#changing-contentimage')
            .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
            }
        });
      });

        //#backimage
    $('.callfunction').click(function () {
        console.log(default_content);
        $.ajax({
          type: "GET",
          url: '<?php echo base_url() ?>whatson/compare_image',
          success: function(data){
            var _gallery = "<select class='image-picker show-html'>";
            data = JSON.parse(data);
            console.log(data);
            if(data!=null){
                for (var i = 0; i < data.length; i++) {
                    var _counter = parseInt(i+1);
                    _gallery = _gallery + "<option data-img-src='"+data[i]+"' data-img-alt='Image "+_counter+"' value='"+data[i]+"'> Image "+_counter+"</option>";
                }
            }
            _gallery = _gallery+"</select>";
             console.log(_gallery);
                $('#changing-contentimage').html(_gallery);
                $("select").imagepicker();
          }
        });
        // $('#changing-content').html(default_content);
        // $("select").imagepicker();
    });

  });

  $(document).ready(function () {
    var default_content = $("#changing-content2").html();
    $("select").imagepicker();
    // Change div content
    $('#uploadcontent').click(function () {
      $('#changing-content2')
      .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
    });


        $('#uploadcontent').click(function () {
        $.ajax({
            url: '<?php echo base_url() ?>whatson/get_token',
            success: function(data){
            console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image');
            $('#changing-content2')
            .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=30&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
            }
        });
      });

        //#backcontent
    $('.callfunction2').click(function () {
        console.log(default_content);
        $.ajax({
          type: "GET",
          url: '<?php echo base_url() ?>whatson/compare_image',
          success: function(data){
            var _gallery = "<select class='image-picker show-html'>";
            data = JSON.parse(data);
            console.log(data);
            if(data!=null){
                for (var i = 0; i < data.length; i++) {
                    var _counter = parseInt(i+1);
                    _gallery = _gallery + "<option data-img-src='"+data[i]+"' data-img-alt='Image "+_counter+"' value='"+data[i]+"'> Image "+_counter+"</option>";
                }
            }
            
            _gallery = _gallery+"</select>";
             console.log(_gallery);
                $('#changing-content2').html(_gallery);
                $("select").imagepicker();
          }
        });
        // $('#changing-content').html(default_content);
        // $("select").imagepicker();
    });
    // $('.js-example-basic-single').select2();

  });
  

	</script>

</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>