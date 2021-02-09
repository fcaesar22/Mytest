<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-3">
				<a href="<?php echo site_url('whatson/whatson/get_edit/'.$whatson_id) ?>"><i class="btn btn-light" class="card-title">Back</i></a>
			</div>
			<div class="col-md-12" align="center">
				<h4 class="card-title">Edit Description</h4>
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
				<form action="<?php echo site_url('whatson/whatson/update_description');?>" method="post">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>What's On Description</label>
								<textarea id="whatson_description" name="whatson_description" class="wysiwyg-editor textWysiwyg" required></textarea>
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
				<input type="hidden" value="1" name="incre" id="incre">
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
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
<script type="text/javascript">
function getUrlWysiwyg(){
	var info = $('#modal-wysiwyg').attr('data-trumbo');
	var image = $('#modal-wysiwyg #img_sel').val();
	var whatson_id = $('[name="whatson_id"]').val();
	var step = $('[name="incre"]').val();
	if (info == 1)
	{
		var editorVal = $('#whatson_description').val();
		var newHtml = editorVal + '<img src="' + image + '">';
		var set_data = editorVal + '{image,whatson_'+whatson_id+'_'+step+'}';
		$('#whatson_description').trumbowyg('html', set_data);
	}
	var test = parseInt(step)+1;
	$('[name="incre"]').val(test);
	$('#modal-wysiwyg').modal('hide');
	// insert_poster(image,art_id);
}

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

function getUrlEmbed(){
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
			url: '<?php echo base_url() ?>whatson/whatson/get_token',
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
			url: '<?php echo base_url() ?>whatson/whatson/compare_image/',
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
				const input = document.getElementById('whatson_description');  
				$('#whatson_description').focus();
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


$(document).ready(function() {
	get_data_edit();
	//load data for edit
	function get_data_edit(){
		var whatson_id = $('[name="whatson_id"]').val();
		$.ajax({
			url : "<?php echo site_url('whatson/whatson/get_data_edit');?>",
			method : "POST",
			data :{whatson_id :whatson_id},
			async : true,
			dataType : 'json',
			success : function(data){
				$.each(data, function(i, item){
					$('[name="whatson_description"]').trumbowyg('html', data[i].whatson_description);
				});
			}
		});
	}
});
</script>

<footer class="footer hidden-xs-down">
	<p>© Super Admin Responsive. All rights reserved.</p>
</footer>