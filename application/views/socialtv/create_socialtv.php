<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<style>
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .image_picker_image {width: 200px;height: 130px;}
    #select option {color: black;}
    #con {align-content:center !important;}
    .tested {
      display: none;
    }
</style>

<div class="content__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <?php echo $this->session->flashdata('msg');?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?php echo site_url('socialtv/socialtv');?>" class="card-title"><i class="btn btn-light" class="card-title">Back</i></a>
                        </div>
                        <div class="col-md-12" align="center">
                            <h4 class="card-title">Add Social TV</h4>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <form method="POST" action="<?php echo base_url("socialtv/socialtv/save_socialtv"); ?>" id="form_submit">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content Type</label>
                                    <select class="form-control" name="content_type" id="content_type" required>
                                        <option value="">No Selected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <a class="btn btn-light btn-sm tested" data-toggle="modal" name="category" data-target="#modal-category" id="category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Category</a>
                                    <select class="form-control" name="category_content[]" id="category_content" multiple="multiple" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Source</label>
                                    <select class="form-control" name="source_content" id="source_content" required>
                                        <option value="">No Selected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Social TV Name</label>
                                    <input class="form-control" type="text" name="socialtv_name" id="socialtv_name" placeholder="Social TV Name" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Social TV Description</label>
                                    <textarea class="form-control" name="socialtv_description" id="socialtv_description" placeholder="Social TV description..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Channel ID</label>
                                    <input class="form-control" type="text" name="channel_id" id="channel_id" placeholder="channel id" />
                                </div>
                            </div>
                            <div class="col-md-12" align="center">
                                <div class="col-xl-6 col-lg-3 col-sm-12 col-6" align="center">
                                    <div class="contacts__item" id="con" align="center">
                                        <label>Poster Highlight</label>
                                        <a href="#" class="contacts__img">
                                            <img id="highlight_img" src="" alt="" width="100" height="100">
                                        </a>

                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id='poster_content1' name="poster_content1" value="" required>
                                            <input type="hidden" class="form-control" id='poster_content2' name="poster_content2" value="" required>
                                            <input type="hidden" class="form-control" id='poster_content3' name="poster_content3" value="" required>
                                        </div>

                                        <a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="image_poster" data-target="#modal-content" id='butcontent'>Choose Image</a>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="col-md-12" align="center">
                                <input class="btn btn-success" type="submit" name="btn" value="Save" />
                            </div>
                        </div>
                    </form>
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
                            <input class="form-control" type="text" name="keyword_name" placeholder="Category name" required="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input class="form-control" type="hidden" name="contentid" id="contentid" required="">
                <button type="button" id="btnSave" onclick="save_keyword()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
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
                <div id="changing-content">
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

<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
function clear_select(){
    $('#category_content').val(null)
}

$('#content_type').select2({
    ajax: { 
        url: '<?= base_url() ?>socialtv/socialtv/content_type',
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
        $('#contentid').val(idcon);
    }
    var data = e.params.data, target_type_url;
    if (data.id == 247) // densplay
    {
        target_type_url = '<?= base_url() ?>socialtv/socialtv/category_densplay'
    }
    if (data.id == 246) // denslife
    {
        target_type_url = '<?= base_url() ?>socialtv/socialtv/category_denslife'
    }
    if (data.id == 325) // knowledge
    {
        target_type_url = '<?= base_url() ?>socialtv/socialtv/category_knowledge'
    }
    $.ajax({
        url: target_type_url,
        type: "post",
        dataType: 'json',
        delay: 250,
        success:function(response){
            if ($('#category_content').select2() != undefined)
            {
                $('#category_content').select2('destroy')
            }

            $('#category_content').select2({
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
        }
    })
})

$('#category_content').select2();

$('#source_content').select2({
    ajax: { 
        url: '<?= base_url() ?>socialtv/socialtv/source_content',
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
});

function save_keyword(){
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    // ajax adding data to database
    $.ajax({
        url : "<?php echo site_url('socialtv/socialtv/save_keyword')?>",
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

function getUrlContent(){
    var image = $('#modal-content .image_picker_selector').find('.selected').find('img').attr('src');
    var images = 'http://wp.dens.tv/img/highlight_v1/1280x720/thumbnail/'+image.replace(/.*\//, '');
    $('#poster_content1').val(image);
    $('#poster_content2').val(images);
    $('#poster_content3').val(images);
    $('#highlight_img').attr('src',image);
    $('#modal-content').modal('hide');
}

$(document).ready(function () {
    $('.page-loader').hide();
    var default_content = $("#changing-content").html();
    $("select").imagepicker();
    // Change div content
    $('#uploadcontent').click(function () {
      $('#changing-content')
      .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=50&CH=highlight_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
    });

    $('#uploadcontent').click(function () {
        $.ajax({
            url: '<?php echo base_url() ?>socialtv/socialtv/get_token',
            success: function(data){
            console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=highlight_v1&type=image');
            $('#changing-content')
            .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=highlight_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
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
          url: '<?php echo base_url() ?>socialtv/socialtv/compare_image/',
          success: function(data){
            var _gallery = "<select class='image-picker show-html'>";
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
</script>

<footer class="footer hidden-xs-down">
    <p>© Super Admin Responsive. All rights reserved.</p>
</footer>