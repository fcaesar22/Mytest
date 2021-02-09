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
            <h4 class="card-title">Edit Image & Video Content</h4><hr><br>
        </div>
    </div>
    <div class="row">
    <div class="col-md-6">
            <div class="col-md-12" align="center">
                <h4 class="card-title">Edit Image Content</h4>
            </div>
    <hr>
    <br>
    <form name="form_img" id="form_img" method="POST" action="<?php echo base_url("imagedenslife/update_content"); ?>">
        <div class="col-md-6">    
            <table style="width: 100%" class="table">
                <thead><tr><th>No.</th><th>Image</th></tr></thead>
                    <tbody id="table-details">
                    <tr id="row0" class="jdr1">
                        <td><span class="btn btn-sm btn-default">1</span><input type="hidden" value="6437" name="count[]"></td>
                        <td class="farid">
                        <div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center">
                        <div class="contacts__item" id="con" align="center">
                            <label>Image Poster</label>
                            <a href="#" class="contacts__img">
                                <img id="img_pos0" src="" alt="">
                            </a>
                            <div class="form-group">
                                <input id="id_000" type="hidden" required="" class="form-control input-sm textImage" placeholder="URL" name="poster_url[row0][]" required>
                                <i class="form-group__bar"></i>
                            </div>
                            <a class="btn btn-light btn-sm" name="poster_url[]" onclick="show_modal('img', 'img_pos0', 'id_000')">Choose Image</a>
                        </div>
                        </div>
                        </td>
                        <td><input type="hidden" class="form-control input-sm" name="product_id[row0][]" value="<?php echo $article_id?>"></td>
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
                <h4 class="card-title">Edit Video Content</h4>
            </div>
        </div>
    <hr>
    <br>

    <form name="form_vid" id="form_vid" method="POST" action="<?php echo base_url("imagedenslife/update_video"); ?>">
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
                                    <img id="vid_pos0" src="" alt="">
                                </a>
                                <div class="form-group">
                                    <input id='vid_000' type="hidden" required="" class="form-control input-sm textVideo" placeholder="URL" name="poster_url[bar0][]" required>
                                    <i class="form-group__bar"></i>
                                </div>
                                <a class="btn btn-light btn-sm" name="stream_url[]" onclick="show_modal('video', 'vid_pos0', 'bar0')">Choose Video</a>
                            </div>
                        </div>
                    </td>
                    <td><input type="hidden" class="form-control input-sm" name="video_id[bar0][]" value="<?php echo $article_id?>"></td>
                    <td><input type="hidden" class="form-control input-sm" name="video_url[bar0][]" value=""></td>
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
                <div id="changing-video">
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
            <div class="modal-footer">
                <input type="hidden" id="url_image_video" name="url_image_video">
                <input type="hidden" id="url_video_final" name="url_image_final">
                <button id="preview_vid" type="button" class="btn btn-link">Preview Video</button>
                <button type="button" class="btn btn-link" onclick="getUrlVideo()">Save</button>
                <button id="back_vid" type="button" class="btn btn-link">Videos</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="bungkus" style="margin: 0 auto;display: none;"><video id="my-video" class="video-js vjs-theme-forest" controls preload="auto" width="640" height="264" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video></div>

<script src="<?=base_url()?>assets/video-js/video.js">"></script>
<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
window.player = videojs('my-video');

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

    var info_img = $('#modal-xl').attr('data-img-name');
    var info_id = $('#modal-xl').attr('data-id-name');
    // set value into element
    $('#' + info_img).attr('src', image);
    $('#' + info_id).val(image);
    $('#' + info_id).find('[name="poster_url['+info_id+'][]"]').val(image)
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
    $('#' + info_id).find('[name="video_url['+info_id+'][]"]').val(video_sel);
    $('#' + info_id).find('[name="poster_url['+info_id+'][]"]').val(image);

    // hide modal
    $('#modal-vd').modal('hide');
}

$('#modal-vd').on('hidden.bs.modal', function (e) {
    player.pause();
})

$(document).ready(function () {
    var default_content = $("#changing-content").html();
    var default_content = $("#changing-video").html();
    $("select").imagepicker();
    // Change div content
    $('#upload_img').click(function () {
        $.ajax({
            url: '<?php echo base_url() ?>imagedenslife/get_token',
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
            url: '<?php echo base_url() ?>imagedenslife/compare_image',
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
        var vid_preview = '<video id="my-video" style="margin: 0 auto;" class="video-js vjs-theme-forest" controls preload="auto" width="640" height="264" data-setup="{}"><p class="vjs-no-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="https://videojs.com/html5-video-support/" target="_blank"> supports HTML5 video</a></p></video>'
        var bungkus
        if ($('#bungkus').html() != undefined)
        {
            bungkus = $('#bungkus').html('').css({
                display:'block',
                margin:'0 auto'
            })
            $('#changing-video').html($(bungkus).append(vid_preview));
        }
        else
        {
            $('#changing-video').html($('<div id="bungkus" style="display:block; margin: 0 auto;"></div>').append(vid_preview));
        }

        if (window.player.isReady_) window.player.dispose();

        window.player = videojs('my-video');
        window.player.src({
            src: video_sel,
            type: 'application/x-mpegURL',
            // withCredentials: true
        });
    });

    $('#back_vid').click(function () {
        console.log(default_content);
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>imagedenslife/compare_video',
            success: function(data){
                console.log(data);
                var _gallery = "<select class='image-picker show-html' name='vid_sel'>";
                data = JSON.parse(data);
                if(data!=null){
                    for (var i = 0; i < data.length; i++) {
                        var _counter = parseInt(i+1);
                            _gallery = _gallery + "<option data-img-src='"+data[i]['url_video_poster']+"' data-img-alt='Image "+_counter+"' value='"+data[i]['url_video']+"'> Image "+_counter+"</option>";
                    }
                }
                _gallery = _gallery+"</select>";
                console.log(_gallery);
                $('#changing-video').html(_gallery);
                $("select").imagepicker();
                if (window.player.isReady_) window.player.pause();
            }
        });
    });
});

$(document).ready(function (){
    $("body").on('click', '.btn-add-more', function (e) {
        e.preventDefault();
        var $sr = ($(".jdr1").length);
        var $no = ($(".jdr1").length+1);
        var uniq = 'id_' + (new Date()).getTime();
        var i = 1;
        var $html = '<tr id="row'+ $sr +'" class="jdr1" >' +
        '<td><span class="btn btn-sm btn-default">' + $no + '</span><input type="hidden" name="count[]" value="'+Math.floor((Math.random() * 10000) + 1)+'"></td>' +
        '<td class="farid"><div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center"><div class="contacts__item" id="con" align="center"><label>Image Poster</label><a href="#" class="contacts__img"><img id="img_pos'+$sr+'"" src="" alt=""></a><div class="form-group"><input id="id_00'+$sr+'" type="hidden" required="" class="form-control input-sm textImage" placeholder="URL" name="poster_url[row' + $sr +'][]" required><i class="form-group__bar"></i></div><a class="btn btn-light btn-sm" name="poster_url[]" onclick="show_modal(\'img\', \'img_pos'+$sr+'\', \'id_00'+$sr+'\')">Choose Image</a></div></div></td>' +
        '<td><input type="hidden" readonly="" class="form-control input-sm" name="product_id[row' + $sr +'][]" value="<?php echo $article_id?>"></td>' +
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
        var $no = ($(".ris1").length+1);
        var uniq = 'vid_' + (new Date()).getTime();
        var $html = '<tr id="bar'+ $sr +'" class="ris1" >' +
        '<td><span class="btn btn-sm btn-default">' + $no + '</span><input type="hidden" name="plus[]" value="'+Math.floor((Math.random() * 10000) + 1)+'"></td>' +
        '<td class="video"><div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center"><div class="contacts__item" id="vid" align="center"><label>Video</label><a href="#" class="contacts__img"><img id="vid_pos'+$sr+'" src="" alt=""></a><div class="form-group"><input id="vid_00'+$sr+'" type="hidden" required="" class="form-control input-sm textVideo" placeholder="URL" name="poster_url[bar'+ $sr +'][]" required><i class="form-group__bar"></i></div><a class="btn btn-light btn-sm" name="stream_url[]" onclick="show_modal(\'vid\', \'vid_pos'+$sr+'\', \'bar'+$sr+'\')">Choose Video</a></div></div></td>' +
        '<td><input type="hidden" class="form-control input-sm" name="video_id[bar'+ $sr +'][]" value="<?php echo $article_id?>"></td>' +
        '<td><input type="hidden" class="form-control input-sm" name="video_url[bar'+ $sr +'][]" value=""></td>' +
        '</tr>';
        $sr++;
        
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

$(document).ready(function() {
    get_data_image();
        //load data for edit
    function get_data_image(){
        var article_id = $('[name="product_id[row0][]"]').val();
        $.ajax({
            url : "<?php echo site_url('imagedenslife/get_data_image');?>",
            method : "POST",
            data :{article_id :article_id},
            async : true,
            dataType : 'json',
            success : function(data){
                console.log(data)
                if(data!=null){
                    var poster = data.poster
                    var poster_length = data.poster.length
                    var elem = ''
                    var i = 0
                    $.each(poster, function(idx, val) {
                        console.log(val)
                    var hidden_fields=''
                        for (var j = 0; j < val.length; j++) {
                            hidden_fields += '<input type="hidden" required="" class="form-control input-sm textImage" placeholder="URL" name="poster_url[row' + i +'][]" required value="'+val[j].poster_url+'">'+
                            '<input type="hidden" class="form-control input-sm" name="product_id[row' + i +'][]" value="'+val[j].article_id+'">'+
                            '<input type="hidden" class="form-control input-sm" name="poster_id[row' + i +'][]" value="'+val[j].poster_id+'">'+
                            '<input type="hidden" class="form-control input-sm" name="poster_type[row' + i +'][]" value="'+val[j].product_id+'">'
                        }

                        elem += '<tr id="row' + i +'" class="jdr1">' +
                        '<td><span class="btn btn-sm btn-default">' + (i+1) +'</span><input type="hidden" value="6437" name="count[]"></td>' +
                        '<td class="farid">' +
                        '<div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center">' +
                        '<div class="contacts__item" id="con" align="center">' +
                            '<label>Image Poster</label>' +
                            '<a href="#" class="contacts__img"><img id="img_pos'+ i +'" src="'+val[0].poster_url+'" alt=""></a>' +
                            '<div class="form-group">' +
                                
                                '<i class="form-group__bar"></i>' +
                            '</div>' +
                            '<a class="btn btn-light btn-sm" name="poster_url[]" onclick="show_modal(\'img\', \'img_pos' + i +'\', \'row'+i+'\')">Choose Image</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '<td>'+hidden_fields+'</tr>'
                        i++;
                    })

                    console.log(elem)

                    $('#table-details').html(elem);
                        
                }
            }
        });
    }
});

$(document).ready(function() {
    get_data_video();
        //load data for edit
    function get_data_video(){
        var article_id = $('[name="video_id[bar0][]"]').val();
        $.ajax({
            url : "<?php echo site_url('imagedenslife/get_data_video');?>",
            method : "POST",
            data :{article_id :article_id},
            async : true,
            dataType : 'json',
            success : function(data){
                console.log(data)
                if(data!=null){
                    var poster = data.poster
                    var poster_length = data.poster.length
                    var elem = ''
                    var i = 0
                    $.each(poster, function(idx, val) {
                        console.log(val)
                    var hidden_fields=''
                        for (var j = 0; j < val.length; j++) {
                            // stream_url=val[j].stream_url
                            // stream_id=val[j].stream_id
                            hidden_fields += '<input type="hidden" class="form-control input-sm" name="poster_url[bar' + i +'][]" required value="'+val[j].poster_url+'">'+
                            '<input type="hidden" class="form-control input-sm" name="poster_id[bar' + i +'][]" value="'+val[j].poster_id+'">'+
                            '<input type="hidden" class="form-control input-sm" name="video_id[bar' + i +'][]" required value="'+val[j].article_id+'">'+
                            '<input type="hidden" class="form-control input-sm" name="product_id[bar' + i +'][]" required value="'+val[j].product_id+'">'+
                            '<input type="hidden" class="form-control input-sm" name="productid_poster[bar' + i +'][]" required value="'+val[j].productid_poster+'">'
                        }

                        elem += '<tr id="bar' + i +'" class="ris1">' +
                        '<td><span class="btn btn-sm btn-default">' + (i+1) +'</span><input type="hidden" value="6437" name="plus[]"></td>' +
                        '<td class="video">' +
                        '<div class="col-xl-2 col-lg-3 col-sm-4 col-6" align="center">' +
                        '<div class="contacts__item" id="vid" align="center">' +
                        '<label>Video</label>' +
                        '<a href="#" class="contacts__img">' +
                        '<img id="vid_pos'+ i +'" src="'+val[0].poster_url+'" alt="">' +
                        '</a>' +
                        '<div class="form-group">' +
                        
                        '<i class="form-group__bar"></i>' +
                        '</div>' +
                        '<a class="btn btn-light btn-sm" name="stream_url[]" onclick="show_modal(\'video\', \'vid_pos' + i +'\', \'bar'+i+'\')">Choose Video</a>' +
                        '</div>' +
                        '</div>' +
                        '</td>'+
                        '<input type="hidden" class="form-control input-sm" name="video_url[bar' + i +'][]" required value="'+val[i].stream_url+'">'+
                        '<input type="hidden" class="form-control input-sm" name="stream_id[bar' + i +'][]" value="'+val[i].stream_id+'">'+
                        hidden_fields+'</tr>'
                        i++;
                    })

                    console.log(elem)

                    $('#table-video').html(elem);
                        
                }
            }
        });
    }
});
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>