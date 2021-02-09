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
<div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('highlight');?>" class="card-title"><i class="btn btn-light" class="card-title">Back</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Add Highlight</h4>
        </div>
    </div>
<hr>
<br>

    <form method="POST" action="<?php echo base_url("highlight/save_highlight"); ?>" id="form_submit">
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
                <div class="col-xl-6 col-lg-3 col-sm-6 col-6" align="center">
                    <div class="contacts__item" id="con" align="center">
                        <label>Image Poster</label>
                        <a href="#" class="contacts__img">
                            <img id="dplmv_pos" src="" alt="" width="100" height="100">
                        </a>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id='id_content' name="id_content" value="" required>
                            <input type="hidden" class="form-control" id='title_content' name="title_content" value="" required>
                            <input type="hidden" class="form-control" id='poster_content' name="poster_content" value="" required>
                        </div>

                        <a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="image_poster" data-target="#modal-content" id='butcontent'>Choose Image</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>DensPlay</label>
                    <select class="form-control" name="densplay_highlight" id="densplay_highlight" required>
                        <option value="">No Selected</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>DensLife</label>
                    <select class="form-control" name="denslife_highlight" id="denslife_highlight" required>
                        <option value="">No Selected</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6" align="center">
                <div class="col-xl-6 col-lg-3 col-sm-6 col-6" align="center">
                    <div class="contacts__item" id="con" align="center">
                        <label>Image Poster</label>
                        <a href="#" class="contacts__img">
                            <img id="dpl_pos" src="" alt="" width="100" height="100">
                        </a>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id='dpl_id' name="dpl_id" value="" required>
                            <input type="hidden" class="form-control" id='dpl_title' name="dpl_title" value="" required>
                            <input type="hidden" class="form-control" id='dpl_val_pos' name="dpl_val_pos" value="" required>
                        </div>

                        <a class="btn btn-light btn-sm callfunction2" data-toggle="modal" name="image_poster" data-target="#modal-content" id='butcontent'>Choose Image</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6" align="center">
                <div class="col-xl-6 col-lg-3 col-sm-6 col-6" align="center">
                    <div class="contacts__item" id="con" align="center">
                        <label>Image Poster</label>
                        <a href="#" class="contacts__img">
                            <img id="dlf_pos" src="" alt="" width="100" height="100">
                        </a>

                        <div class="form-group">
                            <input type="hidden" class="form-control" id='dlf_id' name="dlf_id" value="" required>
                            <input type="hidden" class="form-control" id='dlf_title' name="dlf_title" value="" required>
                            <input type="hidden" class="form-control" id='dlf_val_pos' name="dlf_val_pos" value="" required>
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
                        <input type="text" id="startdate_highlight" name="startdate_highlight" placeholder="Pick a date & time" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="datetimepicker">End Date Highlight</label>
                    <div class='input-group date'>
                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                        <input type="text" id="enddate_highlight" name="enddate_highlight" placeholder="Pick a date & time" class="form-control">
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

<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
$('#cat_highlight').select2({
    ajax: { 
        url: '<?= base_url() ?>highlight/getcategory',
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
// $('#cat_highlight').on('select2:select', function (e) {
//     var data = e.params.data;
//     if (data.id==40){
//         target_url = '<?= base_url() ?>highlight/gettypedensplay'

//         $.ajax({
//             url: target_url,
//             type: "post",
//             dataType: 'json',
//             delay: 250,
//             success:function(response){
//                 $('#type_highlight').select2('destroy').select2({
//                     data:response
//                 })
//             }
//         })
//         $('#type_highlight').on('select2:select', function (e) {
//             var data = e.params.data;
//             if (data.id==36){
//                 target_url = '<?= base_url() ?>highlight/getdensplaychannel'
//             }
//             if (data.id==37){
//                 target_url = '<?= base_url() ?>highlight/getdensplaymovies'
//             }
//             if (data.id==38){
//                 target_url = '<?= base_url() ?>highlight/getdensplay'
//             }

//             $.ajax({
//                 url: target_url,
//                 type: "post",
//                 dataType: 'json',
//                 delay: 250,
//                 success:function(response){
//                     $('#content_highlight').select2('destroy').select2({
//                         data:response
//                     })
//                 }
//             })
//         })
//     }else{
//         target_url = '<?= base_url() ?>highlight/gettypedenslife'
//         $.ajax({
//             url: target_url,
//             type: "post",
//             dataType: 'json',
//             delay: 250,
//             success:function(response){
//                 $('#type_highlight').select2({
//                     data:response
//                 })
//             }
//         })
//         $('#type_highlight').on('select2:select', function (e) {
//             var data = e.params.data;
//             if (data.id==36){
//                 target_url = '<?= base_url() ?>highlight/getdenslifechannel'
//             }
//             if (data.id==38){
//                 target_url = '<?= base_url() ?>highlight/getdenslife'
//             }

//             $.ajax({
//                 url: target_url,
//                 type: "post",
//                 dataType: 'json',
//                 delay: 250,
//                 success:function(response){
//                     $('#content_highlight').select2('destroy').select2({
//                         data:response
//                     })
//                 }
//             })
//         })
//     }    
// });

$('#cat_highlight').on('select2:select', function (e) {
    var data = e.params.data, target_type_url;
    if (data.id == 40) // densplay
    {
        target_type_url = '<?= base_url() ?>highlight/gettypedensplay'
    }
    else
    {
        target_type_url = '<?= base_url() ?>highlight/gettypedenslife'
    }

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
        }

        var data = e.params.data;
        if (data.id==36){
            target_url = '<?= base_url() ?>highlight/get' + type_name + 'channel'
        }
        if (data.id==37){
            target_url = '<?= base_url() ?>highlight/get' + type_name + 'movies'
        }
        if (data.id==38){
            target_url = '<?= base_url() ?>highlight/get' + type_name
        }

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
                get_content_highlights(data.id);
            }
        })
    })
}
//type_id = 40 type_name = densplay data = id yang dipilih
function get_content_highlights(type_id){ 
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
                poster = data[0].file1;
                break;
            case '37': //movies
                id = data[0].movie_id;
                code = data[0].movie_code;
                poster = data[0].poster_url;
                type_name = 'movies'
                break;
            case '38': //article
                id = data[0].whatson_id;
                id = data[0].whatson_title;
                id = data[0].content_url_image;
                type_name = 'article'
                break;
        }
    })
}

$('#densplay_highlight').select2({
    ajax: { 
        url: '<?= base_url() ?>highlight/getdensplay',
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

$('#denslife_highlight').select2({
    ajax: { 
        url: '<?= base_url() ?>highlight/getdenslife',
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


$(document).ready(function(){
    $('#densplay_highlight').change(function(){
        var whatson = $(this).val();
        $.ajax({
            url:'<?= base_url() ?>highlight/getlistdensplay',
            method: 'post',
            data: {whatson: whatson},
            dataType: 'json',
            success: function(response){
                var len = response.length;

                if(len > 0){
                    // Read values
                    var id = response[0].whatson_id;
                    var title = response[0].whatson_title;
                    var image = response[0].content_url_image;
                    
                    $('#dpl_id').val(id);
                    $('#dpl_title').val(title);
                    $('#dpl_pos').attr('src', image);
                    $('#dpl_val_pos').val(image);
                   
                }else{
                    $('#dpl_id').val();
                    $('#dpl_title').val();
                    $('#dpl_pos').attr('src', );
                    $('#dpl_val_pos').val();
                }
            }
        });
    });
});

$(document).ready(function(){
    $('#denslife_highlight').change(function(){
        var denslife = $(this).val();
        $.ajax({
            url:'<?= base_url() ?>highlight/getlistdenslife',
            method: 'post',
            data: {denslife: denslife},
            dataType: 'json',
            success: function(response){
                var len = response.length;

                if(len > 0){
                    // Read values
                    var id = response[0].article_id;
                    var title = response[0].article_title;
                    var image = response[0].poster_url;
                    
                    $('#dlf_id').val(id);
                    $('#dlf_title').val(title);
                    $('#dlf_pos').attr('src', image);
                    $('#dlf_val_pos').val(image);
                   
                }else{
                    $('#dlf_id').val('');
                    $('#dlf_title').val('');
                    $('#dlf_pos').attr('src', '');
                    $('#dlf_val_pos').val('');
                }
            }
        });
    });
});

$( function() {
    $("#startdate_highlight").flatpickr({
        enableTime: true,
        time_24hr: true,
        enableSeconds: true,
        minuteIncrement: 1,
        dateFormat: "Y-m-d H:i:S",
    });
});

$( function() {
    $("#enddate_highlight").flatpickr({
        enableTime: true,
        time_24hr: true,
        enableSeconds: true,
        minuteIncrement: 1,
        dateFormat: "Y-m-d H:i:S",
    });
});
</script>

<footer class="footer hidden-xs-down">
    <p>© Super Admin Responsive. All rights reserved.</p>
</footer>