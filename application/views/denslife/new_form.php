<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
<div class="card-body">
<div class="row">
	<div class="col-md-3">
		<a href="<?php echo site_url('denslife/denslife') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
	</div>
	<div class="col-md-12" align="center">
		<h4 class="card-title">Add Article DensLife&Style</h4>
		<?php echo $this->session->flashdata('success'); ?>
	</div>
</div>
<hr>
<br>

<style>
	body{font-size:12px;letter-spacing:1px;}
	.wizard-step p {margin-top:0px;}
	.wizard-row {display:table-row;}
	.wizard {display: table;width:100%;position: relative;margin-top:-50px;}
	.wizard-step .disabled{opacity:1;color:#ccc;background:#efefef;}
	.wizard-row:before {top:18px;bottom:0;position:absolute;content:" ";width:100%;height:1px;background-color:#ccc;z-order:0;}
	.wizard-step {display:table-cell;text-align:center;position:relative;}
	.btn-circle {width:30px;height:30px;text-align:center;font-size:16px;font-weight:lighter;line-height:10px;border-radius:50%;}
	select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .image_picker_image {width: 200px;height: 130px;}
    #select option {color: black;}

    .tested {display: none;}
</style>

	<div id="content-wrapper">
		<div class="container-fluid">
			<div class="well" style="margin-top:50px;">
			    <div class="wizard col-lg-12">
			      	<div class="wizard-row steps">
			        	<div class="wizard-step">
			          		<a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
			          		<p>Step 1</p>
			        	</div>
			        	<div class="wizard-step">
			          		<a href="#step-2" type="button" class="btn btn-default btn-circle disabled">2</a>
			          		<p>Step 2</p>
			        	</div>
			        	<div class="wizard-step">
			          		<a href="#step-3" type="button" class="btn btn-default btn-circle disabled">3</a>
			          		<p>Step 3</p>
			        	</div>
			      	</div>
			    </div>
			    <fieldset>
			      	<legend></legend>
			      	<form action="<?php echo site_url('denslife/denslife/save_product');?>" method="post">
			        	<div class="row step-content" id="step-1">
			          		<div class="col-md-12">
                                <div class="form-group">
                                    <label>Content Type</label>
                                    <select class="form-control" name="content_type" id="content_type" required="">
                                        <option value="">No Selected</option>
                                    </select>
                                </div>
                            </div>
			          		<div class="col-md-12">
								<div class="form-group">
									<label>Category</label><a class="btn btn-light btn-sm tested" data-toggle="modal" name="category" data-target="#modal-category" id="category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Category</a>
									<select class="js-example-basic-multiple" name="kategori_id[]" id="kategori_id" multiple="multiple" required="">
				                    </select>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Tags</label><a class="btn btn-light btn-sm" data-toggle="modal" name="taging" data-target="#modal-taging" id="taging"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Tag</a>
									<select class="js-example-basic-multiple" name="tags[]" id="tags" multiple="multiple" required="">
									</select>
								</div>
							</div>
			            	<div align="center" class="col-md-12">
			            		<input type="text" style="display: none;" name="testing" id="testing" placeholder="Tags" class="form-control" required="">
			            		<button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
			            	</div>
			            </div>
			        	<div class="row step-content" id="step-2">
			          		<div class="col-md-12">
								<div class="form-group">
									<label>Title</label>
									<input type="text" name="article_title" id="article_title" class="form-control" placeholder="Article Title" required="">
									<i class="form-group__bar"></i>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>By</label>
									<input type="text" name="article_by" id="article_by" class="form-control" placeholder="Name" required="">
									<i class="form-group__bar"></i>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Summary</label>
									<textarea name="article_summary" id="article_summary" class="form-control" placeholder="Insert article summary here" required=""></textarea>
									<i class="form-group__bar"></i>
								</div>
							</div>
			            	<div align="center" class="col-md-12">
			            		<button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
			            	</div>
			        	</div>
			        	<div class="row step-content" id="step-3">
							<div class="col-md-12">
								<div class="form-group">
									<label>URL Maps</label>
									<input type="text" name="url_google_maps" id="url_google_maps" class="form-control" placeholder="URL Maps" />
									<i class="form-group__bar"></i>
								</div>
							</div>
							<input type="hidden" value="<?=$this->fungsi->user_login()->username?>" name="created_by">
							<input type="hidden" value="<?=$this->fungsi->user_login()->username?>" name="updated_by">
			          		<div class="col-md-12">
			            		<button class="btn btn-success pull-right" type="submit">Submit</button>
			          		</div>
			        	</div>
			      	</form>
			    </fieldset>
			</div>
		</div>
	</div>
</div>
</div>
</div>

<div class="modal fade" id="modal-category" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title pull-left">Add Category</h5>
			</div>
			<form action="#" method="post" id="form" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="name">Name</label>
							<input class="form-control" type="text" name="keyword_name" placeholder="keyword name" required="">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input class="form-control" type="hidden" name="contype" id="contype" required="">
				<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-taging" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title pull-left">Add Category</h5>
			</div>
			<form action="" method="post" id="tag" >
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">                         
                    <!-- Text input-->
                    <table style="width: 100%" class="table">
                        <thead><tr><th>No.</th><th>Tag</th></tr></thead>
                        <tbody id="table-details">
                        	<tr id="row1" class="jdr1">
                            <td><span class="btn btn-sm btn-default">1</span><input type="hidden" value="6437" name="count[]"></td>
                            <td><input type="text" required="" class="form-control input-sm" placeholder="Tag" name="jtag[]"></td>
                            <td><input type="hidden" value="1" class="form-control input-sm" placeholder="Tag" name="jsort[]"></td>
                            <td><input type="hidden" value="SIN" class="form-control input-sm" placeholder="Tag" name="jchild[]"></td>
                            <td><input type="hidden" value="N" class="form-control input-sm" placeholder="Tag" name="jsub[]"></td>
                            <td><input type="hidden" value="TDL" class="form-control input-sm" placeholder="Tag" name="jref[]"></td>
                            <td><input type="hidden" value="Y" class="form-control input-sm" placeholder="Tag" name="jvis[]"></td>
                            <td><input type="hidden" value="NULL" class="form-control input-sm" placeholder="Tag" name="jpar[]"></td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary btn-sm btn-add-more">Add More</button>
                    <button class="btn btn-sm btn-warning btn-remove-detail-row">X<i class="glyphicon glyphicon-remove"></i></button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-success" type="submit" value="submit" name="submit">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
			</form>
		</div>
	</div>
</div>

<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
	
<script type="text/javascript">
	function clear_select(){
	    $('#kategori_id').val(null)
	    $('#tags').val(null)
	    $('#testing').val(null)
	}
	

	$('#content_type').select2({
	    ajax: { 
	        url: '<?= base_url() ?>denslife/denslife/content_type',
	        type: "post",
	        dataType: 'json',
	        delay: 250,
	        data: function (params) {
	            return {
	                searchTerm: params.term // search term
	            };
	        },
	        processResults: function (response) {
	            return {
	                results: response
	            };
	        },
	        cache: true
	    }
	})

	$('#content_type').on('select2:select', function (e) {
	    $('.tested').show();
	    
	    clear_select()
	    
	    var idcon = $('#content_type').val();
	    if (idcon != "" || idcon != null) {
	        $('#contype').val(idcon);
	    }

	    var data = e.params.data, target_type_url;
	    if (data.id == 247) // densplay
	    {
	        target_type_url = '<?= base_url() ?>denslife/denslife/category_densplay'
	    }
	    if (data.id == 246) // denslife
	    {
	        target_type_url = '<?= base_url() ?>denslife/denslife/category_denslife'
	    }
	    if (data.id == 325) // knowledge
	    {
	        target_type_url = '<?= base_url() ?>denslife/denslife/category_knowledge'
	    }
	    $.ajax({
	        url: target_type_url,
	        type: "post",
	        dataType: 'json',
	        delay: 250,
	        success:function(response){
	            if ($('#kategori_id').select2() != undefined)
	            {
	                $('#kategori_id').select2('destroy')
	            }

	            $('#kategori_id').select2({
	                data:response,
	                ajax: { 
	                    url: target_type_url,
	                    type: "post",
	                    dataType: 'json',
	                    delay: 250,
	                    data: function (params) {
	                        return {
	                            searchTerm: params.term // search term
	                        };
	                    },
	                    processResults: function (response) {
	                        return {
	                            results: response
	                        };
	                    },
	                    cache: true
	                }
	            })

	            if ($('#tags').select2() != undefined)
	            {
	                $('#tags').select2('destroy')
	            }

	            $('#tags').select2({
	                data:response,
	                ajax: { 
	                    url: '<?= base_url() ?>denslife/denslife/tag_denslife',
	                    type: "post",
	                    dataType: 'json',
	                    delay: 250,
	                    data: function (params) {
	                        return {
	                            searchTerm: params.term // search term
	                        };
	                    },
	                    processResults: function (response) {
	                        return {
	                            results: response
	                        };
	                    },
	                    cache: true
	                }
	            })
	        }
	    })
	})
	$('#tags').on('select2:select', function (e) {
		var valtag = $('#tags').val();
	    if (valtag != "" || valtag != null) {
	        $('#testing').val(valtag);
	    }
	});

	$('#kategori_id').select2();

	$('#tags').select2();

	$(document).ready(function() {
	  	var steps_link = $('div.steps div a'),
	    steps_contents = $('.step-content'),
	    nexts = $('.nextBtn');

	  	steps_contents.hide();

	  	steps_link.click(function(e) {
	    	e.preventDefault();
	    	var $target = $($(this).attr('href')),
	      	$item = $(this);

	    	if (!$item.hasClass('disabled')) {
	      		steps_link.removeClass('btn-primary').addClass('btn-default');
	      		$item.addClass('btn-primary');
	      		steps_contents.hide();
	      		$target.show();
	      		$target.find('input:eq(0)').focus();
	    	}
	  	});

	  	nexts.click(function() {
	    	var curStep = $(this).closest(".step-content"),
	      	curStepBtn = curStep.attr("id"),
	      	nextwizard = $('div.steps div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
	      	curInputs = curStep.find("input[type='text'],input[type='url']"),
	      	isValid = true;

	    	$(".form-group").removeClass("has-error");

	    	for (var i = 0; i < curInputs.length; i++) {
	      		if (!curInputs[i].validity.valid) {
	        		isValid = false;
	        		$(curInputs[i]).closest(".form-group").addClass("has-error");
	        		alert('silahkan Lengkapi '+curInputs.attr('placeholder')+'!');
	      		}
	    	}

	    	if (isValid) {
	      		nextwizard.removeClass('disabled').trigger('click');
	    	}
	  	});

	  	$('div.steps div a.btn-primary').trigger('click');
	});

	function save(){
	    $('#btnSave').text('saving...'); //change button text
	    $('#btnSave').attr('disabled',true); //set button disable 
	    // ajax adding data to database
	    $.ajax({
	        url : "<?php echo site_url('denslife/denslife/save_keyword')?>",
	        type: "POST",
	        data: $('#form').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {
	            if(data.status) //if success close modal and reload ajax table
	            {
	                $('#modal-category').modal('hide');
	                alert("Data Berhasil disimpan");
	            }else{
	                for (var i = 0; i < data.inputerror.length; i++) 
	                {
	                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
	                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
	                }
	            }
	            $('#btnSave').text('save'); //change button text
	            $('#btnSave').attr('disabled',false); //set button enable
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Data gagal disimpan, silahkan isi category!');
	            $('#btnSave').text('save'); //change button text
	            $('#btnSave').attr('disabled',false); //set button enable 
	        }
	    });
	}

	$(document).ready(function (){
        $("body").on('click', '.btn-add-more', function (e) {
            e.preventDefault();
            var $sr = ($(".jdr1").length + 1);
            var rowid = Math.random();
            var $html = '<tr class="jdr1" id="' + rowid + '">' +
                    '<td><span class="btn btn-sm btn-default">' + $sr + '</span><input type="hidden" name="count[]" value="'+Math.floor((Math.random() * 10000) + 1)+'"></td>' +
                    '<td><input type="text" required="" name="jtag[]" placeholder="tag" class="form-control input-sm"></td>' +
                    '<td><input type="hidden" value="1" class="form-control input-sm" placeholder="Tag" name="jsort[]"></td>' +
                    '<td><input type="hidden" value="SIN" class="form-control input-sm" placeholder="Tag" name="jchild[]"></td>' +
                    '<td><input type="hidden" value="N" class="form-control input-sm" placeholder="Tag" name="jsub[]"></td>' +
                    '<td><input type="hidden" value="TDL" class="form-control input-sm" placeholder="Tag" name="jref[]"></td>' +
                    '<td><input type="hidden" value="Y" class="form-control input-sm" placeholder="Tag" name="jvis[]"></td>' +
                    '<td><input type="hidden" value="NULL" class="form-control input-sm" placeholder="Tag" name="jpar[]"></td>' +
                    '</tr>';
            $("#table-details").append($html);
        });
        $("body").on('click', '.btn-remove-detail-row', function (e) {
            e.preventDefault();
            if($("#table-details tr:last-child").attr('id') != 'row1'){
                $("#table-details tr:last-child").remove();
            }
        });
        $("#tag").on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url() ?>denslife/denslife/save_tag',
                type: 'POST',
                data: $("#tag").serialize()
            }).always(function (response){
                var r = (response.trim());
                if(r == 1){
                   $('#modal-taging').modal('hide');
	                alert("Data Berhasil disimpan");
                }else{
                    $(".alert-danger").show();
                }
            });
        });
    });
</script>

<footer class="footer hidden-xs-down">
	<p>© Super Admin Responsive. All rights reserved.</p>
</footer>