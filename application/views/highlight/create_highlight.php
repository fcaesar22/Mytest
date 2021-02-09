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
                            <a href="<?php echo site_url('highlight/highlight');?>" class="card-title"><i class="btn btn-light" class="card-title">Back</i></a>
                        </div>
                        <div class="col-md-12" align="center">
                            <h4 class="card-title">Add Highlight</h4>
                        </div>
                    </div>
                    <hr>
                    <br>

                    <form method="POST" action="<?php echo base_url("highlight/highlight/save_highlight"); ?>" id="form_submit">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="cat_highlight" id="cat_highlight" required>
                                        <option value="">No Selected</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Type</label>
                                    <select class="form-control" name="type_highlight" id="type_highlight" required>
                                        <option value="">No Selected</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content Highlight</label>
                                    <select class="form-control" name="content_highlight" id="content_highlight" required>
                                        <option value="">No Selected</option>
                                    </select>
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
                                            <input type="hidden" class="form-control" id='id_content' name="id_content" value="" required>
                                            <input type="hidden" class="form-control" id='title_content' name="title_content" value="" required>
                                            <input type="hidden" class="form-control" id='poster_content1' name="poster_content1" value="" required>
                                            <input type="hidden" class="form-control" id='poster_content2' name="poster_content2" value="" required>
                                            <input type="hidden" class="form-control" id='poster_content3' name="poster_content3" value="" required>
                                            <input type="hidden" name="highlight_update" value="<?php date_default_timezone_set("Asia/Jakarta"); echo date('Y-m-d H:i:s')?>">
                                        </div>

                                        <a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="image_poster" data-target="#modal-content" id='butcontent'>Choose Image</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="datetimepicker">Start Date Highlight</label>
                                    <div class='input-group date'>
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                        <input type="text" id="startdate_highlight" name="startdate_highlight" placeholder="Pick a date & time" class="form-control" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="datetimepicker">End Date Highlight</label>
                                    <div class='input-group date'>
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                        <input type="text" id="enddate_highlight" name="enddate_highlight" placeholder="Pick a date & time" class="form-control" required="">
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
            url: '<?php echo base_url() ?>highlight/highlight/get_token',
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
          url: '<?php echo base_url() ?>highlight/highlight/compare_image/',
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

function clear_select(){
    $('#type_highlight').val(null)
    $('#content_highlight').val(null)
    $('#id_content').val(null)
    $('#title_content').val(null)
    $('#poster_content').val(null)
    $('#highlight_img').attr('src', null)
}

$('#cat_highlight').select2({
    ajax: { 
        url: '<?= base_url() ?>highlight/highlight/getcategory',
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

$('#cat_highlight').on('select2:select', function (e) {
    var data = e.params.data, target_type_url;
    if (data.id == 40) // densplay
    {
        target_type_url = '<?= base_url() ?>highlight/highlight/gettypedensplay'
    }
    if (data.id == 39) // densplay
    {
        target_type_url = '<?= base_url() ?>highlight/highlight/gettypedenslife'
    }

    //baru
    if (data.id == 108) // webinar
    {
        target_type_url = '<?= base_url() ?>highlight/highlight/gettypewebinar'
    }
    //baru

    // else
    // {
    //     target_type_url = '<?= base_url() ?>highlight/highlight/gettypedenslife'
    // }
    clear_select()

    $.ajax({
        url: target_type_url,
        type: "post",
        dataType: 'json',
        delay: 250,
        success:function(response){
            if ($('#type_highlight').select2() != undefined)
            {
                $('#type_highlight').select2('destroy')
            }

            $('#type_highlight').select2({
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

            get_typehighlight(data.id);
        }
    })
})

function get_typehighlight(category_id) {
    $('#type_highlight').on('select2:select', function(e){
        var type_name = ''

        switch (category_id)
        {
            case '40': //densplay
                type_name = 'densplay'
                break;
            case '39': //denslife
                type_name = 'denslife'
                break;
            case '41': //densplay
                type_name = 'homepage'
                break;
            //baru
            case '108': //webinar
                type_name = 'webinar'
                break;
            //baru
        }

        var data = e.params.data;
        if (data.id==36){
            target_url = '<?= base_url() ?>highlight/highlight/get' + type_name + 'channel'
        }
        if (data.id==37){
            target_url = '<?= base_url() ?>highlight/highlight/get' + type_name + 'movies'
        }
        if (data.id==38){
            target_url = '<?= base_url() ?>highlight/highlight/get' + type_name
        }

        //baru
        if (data.id==109){
            target_url = '<?= base_url() ?>highlight/highlight/get' + type_name
        }
        //baru

        $('#content_highlight').val(null)

        $.ajax({
            url: target_url,
            type: "post",
            dataType: 'json',
            delay: 250,
            success:function(response){
                if ($('#content_highlight').select2() != undefined)
                {
                    $('#content_highlight').select2('destroy')
                }
                $('#content_highlight').select2({
                    data:response,
                    ajax: { 
                        url: target_url,
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
                get_content_highlights(category_id,data.id);
            }
        })
    })
}
$('#type_highlight').on('change.select2', function(e){
    clear_select()
})
//type_id = 40 type_name = densplay data = id yang dipilih
function get_content_highlights(category_id,type_id){ 
    $('#content_highlight').on('select2:select', function(e){

        var type_name = ''
        var data = e.params.data;
        var title = data[0].movie_id;
        var id = data[0].movie_title;

        switch (type_id)
        {
            case '36': //channel
                type_name = 'tv_channel'
                id = data[0].seq;
                title = data[0].title;
                poster1 = 'http://www.dens.tv/images/channel-logo/'+data[0].seq+'.jpg';
                poster2 = 'http://www.dens.tv/images/channel-logo/'+data[0].seq+'.jpg';
                poster3 = 'http://www.dens.tv/images/channel-logo/'+data[0].seq+'.jpg';
                break;
            case '37': //movies
                id = data[0].movie_id;
                title = data[0].movie_title;
                poster1 = data[0].poster_url;
                poster2 = data[0].poster_url;
                poster3 = data[0].poster_url;
                type_name = 'movies'
                break;
            case '38': //article
                //densplay
                if(category_id==40){
                    id = data[0].whatson_id;
                    title = data[0].whatson_title;
                    poster = data[0].content_url_image;
                    type_name = 'article'
                }else{
                    id = data[0].article_id;
                    title = data[0].article_title;
                    poster1 = data[0].poster_url;
                    poster2 = 'http://wp.dens.tv/img/denslife_v1/1280x720/thumbnail/'+poster1.replace(/.*\//, '');
                    poster3 = 'http://wp.dens.tv/img/denslife_v1/1280x720/thumbnail/'+poster1.replace(/.*\//, '');
                    type_name = 'article'
                }
                break;

            //baru
            case '109': //webinar
                id = data[0].webinar_id;
                title = data[0].topic;
                poster1 = data[0].poster_url;
                poster2 = 'http://wp.dens.tv/img/highlight_v1/1280x720/thumbnail/'+poster1.replace(/.*\//, '');
                poster3 = 'http://wp.dens.tv/img/highlight_v1/1280x720/thumbnail/'+poster1.replace(/.*\//, '');
                type_name = 'webinar'
                break;
            //baru

        }
        $('#id_content').val(id);
        $('#title_content').val(title);
        $('#poster_content1').val(poster1);
        $('#poster_content2').val(poster2);
        $('#poster_content3').val(poster3);
        $('#highlight_img').attr('src', poster1);
    })
}


$( function() {
    $("#startdate_highlight").flatpickr({
        enableTime: true,
        time_24hr: true,
        enableSeconds: true,
        minuteIncrement: 1,
        dateFormat: "Y-m-d H:i:S",
    })
    $("#startdate_highlight").prop('readonly', false)
});

$( function() {
    $("#enddate_highlight").flatpickr({
        enableTime: true,
        time_24hr: true,
        enableSeconds: true,
        minuteIncrement: 1,
        dateFormat: "Y-m-d H:i:S",
    })
    $("#enddate_highlight").prop('readonly', false)
});
</script>

<footer class="footer hidden-xs-down">
    <p>© Super Admin Responsive. All rights reserved.</p>
</footer>