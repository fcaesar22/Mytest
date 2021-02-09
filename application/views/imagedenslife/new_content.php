<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/video-js/video-js.css">
<link href="https://unpkg.com/@videojs/themes@1/dist/forest/index.css" rel="stylesheet">
<!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
<script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

<style>
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .image_picker_image {width: 200px;height: 130px;}
    #select option {color: black;}
    .col-sm-4 {max-width: fit-content !important;}
</style>

<?php echo $this->session->flashdata('msg');?>

<?php if (!is_array($gallery2)) {?>
<script> alert('data image not found');</script>
<?php } ?>

<div class="content__inner">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <a href="<?php echo site_url('imagedenslife/edit_poster/'.$article_id);?>" class="card-title"><i class="btn btn-light" class="card-title">Back</i></a>
                </div>
                <div class="col-md-12" align="center">
                    <h4 class="card-title">Add Image & Video Content</h4><hr><br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12" align="center">
                        <h4 class="card-title">Add Image Content</h4>
                    </div>
                    <hr>
                    <br>
                    <form name="form_img" id="form_img" method="POST" action="<?php echo base_url("imagedenslife/save_content"); ?>">
                        <div class="col-md-6">    
                            <table style="width: 100%" class="table">
                                <thead><tr><th>No.</th><th>Image</th></tr></thead>
                                <tbody id="table-details"><tr id="row1" class="jdr1">
                                    <td><span class="btn btn-sm btn-default">1</span><input type="hidden" value="6437" name="count[]"></td>
                                    <td class="farid">
                                        <div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center">
                                            <div class="contacts__item" id="con" align="center">
                                                <label>Image Poster</label>
                                                <a href="#" class="contacts__img">
                                                    <img id="img_pos" src="" alt="" width="85" height="85">
                                                </a>
                                                <div class="form-group">
                                                    <input id="id_001" type="hidden" required="" class="form-control input-sm textImage" placeholder="URL" name="poster_url[]" required>
                                                    <i class="form-group__bar"></i>
                                                </div>
                                                <a class="btn btn-light btn-sm" name="poster_url[]" onclick="show_modal('img', 'img_pos', 'id_001')">Choose Image</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="hidden" class="form-control input-sm" name="product_id[]" value="<?php echo $article_id?>"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12" align="center">
                        <button class="btn btn-sm btn-primary btn-add-more">Add More</button>
                        <button class="btn btn-sm btn-danger btn-remove-detail-row">Delete</button>
                    </div>
                </form>

                <div class="row">
                    <div class="alert alert-dismissable alert-success" style="display: none">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Data inserted successfully</strong>.
                    </div> 
                    <div class="alert alert-dismissable alert-danger"  style="display: none">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Sorry something went wrong</strong>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12" align="center">
                        <h4 class="card-title">Add Video Content</h4>
                    </div>
                </div>
                <hr>
                <br>

                <form name="form_vid" id="form_vid" method="POST" action="<?php echo base_url("imagedenslife/save_video"); ?>">
                    <div class="col-md-6">    
                        <table style="width: 100%" class="table">
                            <thead><tr><th>No.</th><th>Video</th></tr></thead>
                            <tbody id="table-video">
                            <tr id="bar0" class="ris1">
                                <td><span class="btn btn-sm btn-default">1</span><input type="hidden" value="6437" name="plus[]"></td>
                                <td class="video">
                                    <div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center">
                                        <div class="contacts__item" id="vid" align="center">
                                            <label>Video</label>
                                            <a href="#" class="contacts__img">
                                                <img id="vid_pos" src="" alt="" width="85" height="85">
                                            </a>
                                            <div class="form-group">
                                                <input id='vid_001' type="hidden" required="" class="form-control input-sm textVideo" placeholder="URL" name="stream_url[vid_001][]" required>
                                                <i class="form-group__bar"></i>
                                            </div>
                                            <a class="btn btn-light btn-sm" name="stream_url[]" onclick="show_modal('video', 'vid_pos', 'vid_001')">Choose Image</a>
                                        </div>
                                    </div>
                                </td>
                                <td><input type="hidden" class="form-control input-sm" name="video_id[vid_001][]" value="<?php echo $article_id?>"></td>
                                <td><input type="hidden" class="form-control input-sm" name="video_url[vid_001][]" value=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12" align="center">
                    <button class="btn btn-sm btn-primary btn-add-vid">Add More</button>
                    <button class="btn btn-sm btn-danger btn-remove-detail-vid">Delete</button>
                </div>
            </form>

            <div class="row">
                <div class="alert alert-dismissable alert-success" style="display: none">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Data inserted successfully</strong>.
                </div> 
                <div class="alert alert-dismissable alert-danger"  style="display: none">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Sorry something went wrong</strong>
                </div>
            </div>
        </div>

        <div class="col-md-12" align="center">
            <br><hr>
            <input class="btn btn-success pull-right" type="submit" value="submit" id="submitForms" name="submitForms" onclick="submitForms()" />
        </div>
    </div>
</div>
</div>
</div>

<div class="modal fade" id="modal-xl" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Select an image</h5>
            </div>
            <div class="modal-body">
                <div id="changing-content">
                    <select class='image-picker show-html' name="img_sel">
                        <?php
                        if($gallery1!=null){
                            for ($i=0; $i < count($gallery1) ; $i++) { 
                                $counter = $i+1;
                                echo "<option data-img-src='".$gallery1[$i]."' data-img-alt='Image ".$counter."' value='".$gallery1[$i]."'> Image ".$counter."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="upload_img" type="button" class="btn btn-link">Upload Image</button>
                <button type="button" class="btn btn-link" onclick="getUrlImage()">Save</button>
                <button id="back_img" type="button" class="btn btn-link">Images</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
                            <h4 align="center">Videos</h4><br><br>
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="url_image_video" name="url_image_video">
                <input type="hidden" id="url_video_final" name="url_video_final">
                <button id="preview_vid" type="button" class="btn btn-link">Preview Video</button>
                <button type="button" class="btn btn-link" onclick="getUrlVideo()">Save</button>
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
                <div id="changing-preview">
                    <div id="bungkus" style="margin: 0 auto;display: none;"><video id="my-video" class="video-js vjs-theme-forest" controls preload="auto" width="410" height="230" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- <script src="<?=base_url()?>assets/jquery/jquery.js"></script> -->
<script src="<?=base_url()?>assets/video-js/video.js">"></script>
<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
window.player = videojs('my-video');

// function submitForms(){
//     var x = document.forms["form_img"]["poster_url[]"].value;
//     var y = document.forms["form_vid"]["stream_url[]"].value;
//     if (x == "" && y=="") {
//         alert("Data not available!");
//         window.location.reload();
//         <?php $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Harap isi content gambar/video</div>'); ?>
//         return false;
//     }
// }

// function submitForms(){
//     document.getElementById("form_img").submit();
//     document.getElementById("form_vid").submit();
// }

$(document).ready(function() {
    $("#submitForms").click(function(e) {
        e.preventDefault(); // or make the button type=button
        $.post($("#form_img").attr("action"), $("#form_img").serialize(), function() {
            $.post($("#form_vid").attr("action"), $("#form_vid").serialize(),
            function() {
                alert('Data berhasil ditambah');
                window.location.href = '<?php echo base_url() ?>denslife';
            });
        });
    });
});

function getUrlImage(){
    var image = $('#modal-xl .image_picker_selector').find('.selected').find('img').attr('src');
    // get required element from modal data attribute
    var info_img = $('#modal-xl').attr('data-img-name');
    var info_id = $('#modal-xl').attr('data-id-name');
    // set value into element
    $('#' + info_img).attr('src', image);
    $('#' + info_id).val(image);
    // hide modal
    $('#modal-xl').modal('hide');
}

function getUrlVideo(){
    var image = $('#url_image_video').val()
    var video_sel = $('#url_video_final').val()
    var info_img = $('#modal-vd').attr('data-vid-name');
    var info_id = $('#modal-vd').attr('data-vidid-name');
    // set value into element
    $('#' + info_img).attr('src', image);
    $('#' + info_id).val(image);
    $('[name="stream_url['+info_id+'][]"]').val(image);
    $('[name="video_url['+info_id+'][]"]').val(video_sel);

    // hide modal
    $('#modal-vd').modal('hide');
}

$('#modal-preview').on('hidden.bs.modal', function (e) {
    player.pause();
})

$(document).ready(function () {
    var default_content = $("#changing-content").html();
    var default_content = $("#changing-video").html();
    $("select").imagepicker();
    // Change div content
    $('#upload_img').click(function () {
        $.ajax({
            url: '<?php echo base_url() ?>image/imagedenslife/get_token',
            success: function(data){
                console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=denslife_v1&type=image');
                $('#changing-content')
                .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=denslife_v1&type=image" width="100%" height="400px" frameborder="0"></iframe>');
            }
        });
    });

    $('#back_img').click(function () {
        console.log(default_content);
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>image/imagedenslife/compare_image',
            success: function(data){
                console.log(data);
                var _gallery = "<select class='image-picker show-html'>";
                data = JSON.parse(data);
                if(data!=null){
                    for (var i = 0; i < data.length; i++) {
                        var _counter = parseInt(i+1);
                        _gallery = _gallery + "<option data-img-src='"+data[i]+"' data-img-alt='Image "+_counter+"' value='"+data[i]+"'> Image "+_counter+"</option>";
                    }                
                }
                _gallery = _gallery+"</select>";
                console.log(_gallery);
                $('#changing-content').html(_gallery);
                $("select").imagepicker();
            }
        });
    });

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
            $('#changing-preview').html($(bungkus).append(vid_preview));
        }
        else
        {
            $('#changing-preview').html($('<div id="bungkus" style="display:block; margin: 0 auto;"></div>').append(vid_preview));
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
});

$(document).ready(function (){
    $("body").on('click', '.btn-add-more', function (e) {
        e.preventDefault();
        var $sr = ($(".jdr1").length + 1);
        var uniq = 'id_' + (new Date()).getTime();
        var i = 1;
        var $html = '<tr  class="jdr1" >' +
        '<td><span class="btn btn-sm btn-default">' + $sr + '</span><input type="hidden" name="count[]" value="'+Math.floor((Math.random() * 10000) + 1)+'"></td>' +
        '<td class="farid"><div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center"><div class="contacts__item" id="con" align="center"><label>Image Poster</label><a href="#" class="contacts__img"><img id="img_pos'+$sr+'"" src="" alt="" width="85" height="85"></a><div class="form-group"><input id="id_00'+$sr+'" type="hidden" required="" class="form-control input-sm textImage" placeholder="URL" name="poster_url[]" required><i class="form-group__bar"></i></div><a class="btn btn-light btn-sm" name="poster_url[]" onclick="show_modal(\'img\', \'img_pos'+$sr+'\', \'id_00'+$sr+'\')">Choose Image</a></div></div></td>' +
        '<td><input type="hidden" readonly="" class="form-control input-sm" name="product_id[]" value="<?php echo $article_id?>"></td>' +
        '</tr>';

        $("#table-details").append($html);

        if($('.farid input').val.length ==0){
            $('.btn-add-more').attr('disabled', true);
        }else{
            $('.btn-add-more').attr('disabled', false);
        }
    });

    $("body").on('click', '.btn-remove-detail-row', function (e) {
        e.preventDefault();
        if($("#table-details tr:last-child").attr('id') != 'row1'){
            $("#table-details tr:last-child").remove();
        }    
    });

    $("body").on('focus', ' .datetimepicker', function () {
        $(this).flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
        });
    });
});

$(document).ready(function (){
    $("body").on('click', '.btn-add-vid', function (e) {
        e.preventDefault();
        var $sr = ($(".ris1").length);
        var $no = ($(".ris1").length + 1);
        var uniq = 'vid_' + (new Date()).getTime();
        var $html = '<tr id="bar'+ $sr +'" class="ris1" >' +
        '<td><span class="btn btn-sm btn-default">' + $no + '</span><input type="hidden" name="plus[]" value="'+Math.floor((Math.random() * 10000) + 1)+'"></td>' +
        '<td class="video"><div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center"><div class="contacts__item" id="vid" align="center"><label>Video</label><a href="#" class="contacts__img"><img id="vid_pos'+$no+'" src="" alt="" width="85" height="85"></a><div class="form-group"><input id="vid_00'+$no+'" type="hidden" required="" class="form-control input-sm textVideo" placeholder="URL" name="stream_url[vid_00'+ $no +'][]" required><i class="form-group__bar"></i></div><a class="btn btn-light btn-sm" name="stream_url[]" onclick="show_modal(\'vid\', \'vid_pos'+$no+'\', \'vid_00'+$no+'\')">Choose Image</a></div></div></td>' +
        '<td><input type="hidden" class="form-control input-sm" name="video_id[vid_00'+ $no +'][]" value="<?php echo $article_id?>"></td>' +
        '<td><input type="hidden" class="form-control input-sm" name="video_url[vid_00'+ $no +'][]" value=""></td>' +
        '</tr>';

        $("#table-video").append($html);

        if($('.video input').val.length ==0){
            $('.btn-add-vid').attr('disabled', true);
        }else{
            $('.btn-add-vid').attr('disabled', false);
        }
    });

    $("body").on('click', '.btn-remove-detail-vid', function (e) {
        e.preventDefault();
        if($("#table-video tr:last-child").attr('id') != 'bar0'){
            $("#table-video tr:last-child").remove();
        }    
    });

    $("body").on('focus', ' .datetimepicker', function () {
        $(this).flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
        });
    });
});


function show_modal(type, img, id) {
    if (type == 'img')
    {
        // add data attribute into modal
        $('#modal-xl').attr('data-img-name', img);
        $('#modal-xl').attr('data-id-name', id);
        // show modal
        $('#modal-xl').modal('show');
    }
    else
    {
        // add data attribute into modal
        $('#modal-vd').attr('data-vid-name', img);
        $('#modal-vd').attr('data-vidid-name', id);
        // show modal
        $('#modal-vd').modal('show');
    }
}

$('#modal-vd').on('shown.bs.modal', function (e) {
    $('[name=vid_sel]').change();
})

$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

$(document).on('hidden.bs.modal', '.modal', function () {
    $('.modal:visible').length && $(document.body).addClass('modal-open');
});
</script>

<footer class="footer hidden-xs-down">
    <p>© Super Admin Responsive. All rights reserved.</p>
</footer>