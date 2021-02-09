<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<style>
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .image_picker_image {width: 200px;height: 130px;}
    #select option {color: black;}
    #con {align-content:center !important;}
</style>

<div class="content__inner">
<div class="row">
<div class="col-md-12">
<div class="card">
    <?php echo $this->session->flashdata('msg');?>
<div class="card-body">
<div class="row">
    <div class="col-md-3">
        <a href="<?php echo site_url('denslife/denslife');?>" class="card-title"><i class="btn btn-light" class="card-title">Back</i></a>
    </div>
    <div class="col-md-12" align="center">
        <h4 class="card-title">Add Poster Highlight</h4>
    </div>
</div>
<hr>
<br>

<form method="POST" action="<?php echo base_url("denslife/denslife/add_highlight"); ?>" id="form_submit">
    <div class="col-md-12" align="center">
        <h4><?php echo $poster[0]['article_title']?></h4><br>
    </div>
    <div class="col-md-12" align="center">    
        <div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center">
            <div class="contacts__item" id="con" align="center">
                <label>Poster Highlight</label>
                <a href="#" class="contacts__img">
                    <img id="img_pos" src="" alt="" width="100" height="100">
                </a>

                <div class="form-group">
                    <input type="hidden" class="form-control textImage" id='image_poster' name="image_poster" value="<?php echo $poster[0]['poster_url']?>" required>
                    <i class="form-group__bar"></i>
                </div>

                <a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="image_poster" data-target="#modal-content" id='butcontent'>Change Image</a>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="datetimepicker">Start Date Highlight</label>
                <div class='input-group date'>
                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                    <input type="text" id="datetimepicker1" name="startdate_highlight" placeholder="Pick a date & time" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label for="datetimepicker">End Date Highlight</label>
                <div class='input-group date'>
                    <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                    <input type="text" id="datetimepicker2" name="enddate_highlight" placeholder="Pick a date & time" class="form-control" required>
                </div>
            </div>
        </div>
    </div>
    <br>

    <input type="hidden" name="article_id" id="article_id" value="<?php echo $article_id?>">
    <!-- <input type="hidden" name="poster_id1" id="poster_id" value="<?php echo $poster[0]['poster_id']?>"> -->
    <input type="hidden" name="highlight_update" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('Y-m-d H:i:s')?>">
    
    <div class="col-md-12" align="center">
        <input class="btn btn-success" type="submit" name="btn" value="Save" />
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
$(document).ready(function() {
    get_data_poster();
        //load data for edit
    function get_data_poster(){
        var article_id = $('[name="article_id"]').val();
        $.ajax({
            url : "<?php echo site_url('image/imagedenslife/get_data_poster');?>",
            method : "POST",
            data :{article_id :article_id},
            async : true,
            dataType : 'json',
            success : function(data){
                    $('[name="image_poster"]').val(data.poster[0]['poster_url']).trigger('change');
                    $('#img_pos').attr('src',data.poster[0]['poster_url']);
                    $('[name="product_id"]').val(data.article_id).trigger('change');
            }
        });
    }
});

$( function() {
    $("#datetimepicker1").flatpickr({
        enableTime: true,
        time_24hr: true,
        enableSeconds: true,
        minuteIncrement: 1,
        dateFormat: "Y-m-d H:i:S",
    })
    $("#datetimepicker1").prop('readonly', false)
});

$( function() {
    $("#datetimepicker2").flatpickr({
        enableTime: true,
        time_24hr: true,
        enableSeconds: true,
        minuteIncrement: 1,
        dateFormat: "Y-m-d H:i:S",
    })
    $("#datetimepicker2").prop('readonly', false)
});

function getUrlContent(){
    var image = $('#modal-content .image_picker_selector').find('.selected').find('img').attr('src');
    $('.textImage').val(image);
    $('#img_pos').attr('src',image);
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
            url: '<?php echo base_url() ?>denslife/denslife/get_token',
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
          url: '<?php echo base_url() ?>denslife/denslife/compare_imagehighlight/',
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