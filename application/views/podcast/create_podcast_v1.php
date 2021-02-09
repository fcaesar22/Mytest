<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?=base_url()?>assets/fa/dist/css/fontawesome-iconpicker.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<style>
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .image_picker_image {width: 200px;height: 130px;}
    #select option {color: black;}
    #con {align-content:center !important;}
    .tested {display: none;}
    /*.iconpicker-popover {
        display: block;
        top: -120px !important;
        left: 103px !important;
        max-width: 601.828px !important;
        border: 1px solid rgba(0,0,0,.2) !important;
        border-radius: 6px !important;
    }
    .iconpicker-search {
        width: 100% !important;
        height: 34px !important;
        padding: 6px 12px !important;
        font-size: 14px !important;
        line-height: 1.42857143 !important;
        color: #555 !important;
        background-color: #fff !important;
        background-image: none !important;
        border: 1px solid #ccc !important;
        border-radius: 4px !important;
    }*/
    .iconpicker-search {display: none !important;}
    .iconpicker .iconpicker-items {
        position: relative !important;
        clear: both !important;
        float: none !important;
        padding: 12px 0 0 12px !important;
        background: #fff !important;
        margin: 0 !important;
        overflow: hidden !important;
        overflow-y: auto !important;
        min-height: 49px !important;
        max-height: 246px !important;
        color: black !important;
    }
    .iconpicker-item {
        float: left !important;
        width: 18px !important;
        height: 16px !important;
        padding: 10px !important;
        margin: 0 14px 14px 0 !important;
        text-align: center !important;
        cursor: pointer !important;
        border-radius: 3px !important;
        font-size: 18px !important;
        box-shadow: 0 0 0 1px #ddd !important;
    }
    .iconpicker .iconpicker-item.iconpicker-selected {
        box-shadow: none !important;
        color: #fff !important;
        background: #000 !important;
    }
    .arrow{display: none !important;}
    #sel_icon{margin-right: 10px;}
</style>

<div class="content__inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <?php echo $this->session->flashdata('msg');?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?php echo site_url('podcast/podcast_v1');?>" class="card-title"><i class="btn btn-light" class="card-title">Back</i></a>
                        </div>
                        <div class="col-md-12" align="center">
                            <h4 class="card-title">Add Podcast</h4>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <form method="POST" action="<?php echo base_url("podcast/podcast_v1/save_podcast"); ?>" id="form_submit">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Category</label>
                                    <a class="btn btn-light btn-sm" data-toggle="modal" name="category" data-target="#modal-category" id="category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Category</a>
                                    <select class="form-control" name="category_podcast" id="category_podcast" required>
                                        <option value="">No Selected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Sub Category</label>
                                    <a class="btn btn-light btn-sm tested" data-toggle="modal" name="sub_category" data-target="#modal-subcategory" id="sub_category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Sub Category</a>
                                    <select class="form-control" name="sub_category_podcast[]" id="sub_category_podcast" multiple="multiple" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Podcast Name</label>
                                    <input class="form-control" type="text" name="podcast_name" id="podcast_name" placeholder="Podcast Name" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Podcast Link RSS</label>
                                    <input class="form-control" type="text" name="link_rss" id="link_rss" placeholder="Podcast link rss" />
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

<div class="modal fade" id="modal-category" tabindex="-1" style="display: none;" data-backdrop="false" data-keyboard="false" aria-hidden="true">
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
                            <input class="form-control" type="text" name="keyword_namecategory" placeholder="Category name" required="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="margin-right: 80px;" class="control-label" for="parameterValue">Select Icon <button id="delicon1" name="delicon1" type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o" id="delicon2" name="delicon2"></i></button></label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default"><i class="" id="val_icon" name="val_icon"></i></button>
                                <button type="button" class="icp icp-dd btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input class="form-control" name="icon_category" id="icon_category" value="" type="hidden"/>
                <button type="button" id="btnSave" onclick="save_category()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-subcategory" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Add Sub Category</h5>
            </div>
            <form action="#" method="post" id="form_sub" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="keyword_name" placeholder="Sub Category name" required="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input class="form-control" type="hidden" name="contentid" id="contentid" required="">
                <button type="button" id="btnSave" onclick="save_sub_category()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?=base_url()?>assets/fa/dist/js/fontawesome-iconpicker.js"></script>
<script type="text/javascript">
$('#delicon1').on('click', function () {
    $('[name="icon_category"]').val(null);
    $('#val_icon').get(0).className = "";
});

$(function () {
    $('.icp-dd').each(function() {
        var $this = $(this);
        $this.iconpicker({
            container: $(' ~ .dropdown-menu:first', $this)
        });
    });

    $('.icp').on('iconpickerSelected', function(e) {
        $('#val_icon').get(0).className = '' +
                e.iconpickerInstance.options.iconBaseClass + ' ' +
                e.iconpickerInstance.getValue(e.iconpickerValue);
        var t = document.getElementById('val_icon').className;
        $('#icon_category').val(t);
    });
});

function clear_select(){
    $('#sub_category_podcast').val(null)
}

$("#category_podcast").select2({
    ajax: {
        url: '<?= base_url() ?>podcast/podcast_v1/category_podcast',
        dataType: 'json',
        type: "post",
        data: function (params) {
            return {
                searchTerm: params.term // search term
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
    },
    templateResult: function (data) {
        console.log('templateResult');
        var $state = $('<span><i id="sel_icon" class="'+data.icon+'"></i>' + data.text + '</span>');
        return $state
    }
});

// $('#category_podcast').select2({
//     ajax: { 
//         url: '<?= base_url() ?>podcast/podcast_v1/category_podcast',
//         type: "post",
//         dataType: 'json',
//         delay: 250,
//         data: function (params) {
//             return {
//                 searchTerm: params.term // search term
//             };
//         },
//         processResults: function (response) {
//             return {
//                 results: response
//             };
//             console.log(response);
//         },
//         templateResult: function (response) {
//             console.log('templateResult');
//             return '<span><i class="fab fa-accusoft"></i> ' + response.text + '</span>';
//         },
//         cache: true
//     }
// })

$('#category_podcast').on('select2:select', function (e) {
    $('.tested').show();
    clear_select()
    var idcon = $('#category_podcast').val();
    if (idcon != "" || idcon != null) {
        $('#contentid').val(idcon);
    }
    var data = e.params.data, target_type_url;
    if (data.id == idcon) // podcast
    {
        target_type_url = '<?= base_url() ?>podcast/podcast_v1/sub_category_podcast'
    }
    $.ajax({
        url: target_type_url,
        type: "post",
        dataType: 'json',
        delay: 250,
        success:function(response){
            if ($('#sub_category_podcast').select2() != undefined)
            {
                $('#sub_category_podcast').select2('destroy')
            }

            $('#sub_category_podcast').select2({
                data:response,
                ajax: { 
                    url: target_type_url,
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term, id_cat: idcon
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

$('#sub_category_podcast').select2();

function save_category(){
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    // ajax adding data to database
    $.ajax({
        url : "<?php echo site_url('podcast/podcast_v1/save_category')?>",
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

function save_sub_category(){
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    // ajax adding data to database
    $.ajax({
        url : "<?php echo site_url('podcast/podcast_v1/save_sub_category')?>",
        type: "POST",
        data: $('#form_sub').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal-subcategory').modal('hide');
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
</script>

<footer class="footer hidden-xs-down">
    <p>© Super Admin Responsive. All rights reserved.</p>
</footer>