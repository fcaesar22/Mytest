<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
<div class="card-body">
<div class="row">
    <div class="col-md-3">
            <a href="<?php echo site_url('denslife') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
    </div>
    <div class="col-md-12" align="center">
            <h4 class="card-title">Edit Article DensLife&Style</h4>
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
                    <form role="form" action="<?php echo site_url('denslife/update_product');?>" method="post">
                        <div class="row step-content" id="step-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="article_title" id="article_title" class="form-control" placeholder="Article Title" />
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>By</label>
                                    <input type="text" name="article_by" id="article_by" class="form-control" placeholder="Name" />
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Summary</label>
                                    <textarea name="article_summary" id="article_summary" class="form-control" placeholder="Insert article summary here"></textarea>
                                    <i class="form-group__bar"></i>
                                </div>
                            </div>
                            <div align="center" class="col-md-12">
                                <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                            </div>
                        </div>
                        <div class="row step-content" id="step-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Category</label><a class="btn btn-light btn-sm" data-toggle="modal" name="category" data-target="#modal-category" id="category"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Category</a>
                                    <select class="form-control js-example-basic-single strings" name="kategori_id[]" id="kategori_id" multiple="multiple" required>
                                    <?php foreach($keyword as $row):?>
                                        <option value="<?php echo $row->keyword_id;?>"><?php echo $row->keyword_name;?></option>
                                    <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tags</label><a class="btn btn-light btn-sm" data-toggle="modal" name="taging" data-target="#modal-taging" id="taging"><i class="zmdi zmdi-plus zmdi-hc-fw"></i>Add Tag</a>
                                    <select class="js-example-basic-multiple" name="tags[]" id="tags" multiple="multiple">
                                    <?php foreach ($tags->result() as $row) :?>
                                        <option value="<?php echo $row->keyword_id;?>"><?php echo $row->keyword_name;?></option>
                                    <?php endforeach;?>
                                    </select>
                                </div>
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
                            <input type="hidden" name="article_id" value="<?php echo $article_id?>" required>
                            <input type="hidden" value="<?=$this->fungsi->user_login()->username?>" name="created_by">
                            <input type="hidden" value="<?=$this->fungsi->user_login()->username?>" name="updated_by">
                            <div class="col-md-12">
                              <button class="btn btn-success pull-right" type="submit">Update</button>
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
                            <input class="form-control" type="text" name="keyword_name" placeholder="keyword name" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
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
    $('#kategori_id').select2({
        ajax: { 
            url: '<?= base_url() ?>denslife/getkeywords',
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

    $('#tags').select2({
        dropdownAutoWidth: !0,
        width: '100%',
        ajax: { 
            url: '<?= base_url() ?>denslife/gettags',
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
                }
            }
            if (isValid) {
                nextwizard.removeClass('disabled').trigger('click');
            }
        });

        $('div.steps div a.btn-primary').trigger('click');
    });

    $(document).ready(function() {
        get_data_edit();
            //load data for edit
        function get_data_edit(){
            var article_id = $('[name="article_id"]').val();
            $.ajax({
                url : "<?php echo site_url('denslife/get_data_edit');?>",
                method : "POST",
                data :{article_id :article_id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $.each(data, function(i, item){
                        $('[name="article_title"]').val(data[i].article_title).trigger('change');
                        $('[name="article_by"]').val(data[i].article_by).trigger('change');
                        var str = data[i].kategori_id.split(",");
                        $('#kategori_id').val(str).trigger('change');
                        $('#kategori_id').trigger({
                            type: 'select2:select',
                            params: {
                                data: str
                            }
                        });
                        var tgs = data[i].tags.split(",");
                        $('#tags').val(tgs).trigger('change');
                        $('#tags').trigger({
                            type: 'select2:select',
                            params: {
                                data: tgs
                            }
                        });
                        $('[name="article_summary"]').val(data[i].article_summary).trigger('change');
                        $('[name="url_google_maps"]').val(data[i].url_google_maps).trigger('change');
                    });
                }
            });
        }
    });

    function save(){
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        // ajax adding data to database
        $.ajax({
            url : "<?php echo site_url('denslife/save_keyword')?>",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.status){
                    $('#modal-category').modal('hide');
                    alert("Data Berhasil disimpan");
                }else{
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown){
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
                url: '<?php echo base_url() ?>denslife/save_tag',
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