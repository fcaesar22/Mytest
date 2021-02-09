<link rel="stylesheet" href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?=base_url()?>assets/fa/dist/css/fontawesome-iconpicker.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
<div class="card-body">
<div class="row">
    <div class="col-md-3">
            <a href="<?php echo site_url('mng_category/mng_category') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
    </div>
    <div class="col-md-12" align="center">
            <h4 class="card-title">Edit Category</h4>
    </div>
</div>
<hr>
<br>

<style>
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
</style>

    <div id="content-wrapper">
        <div class="container-fluid">
            <form role="form" action="<?php echo site_url('mng_category/mng_category/update_product_pod');?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="keyword_name" id="keyword_name" class="form-control" placeholder="Category Name" />
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="margin-right: 320px;" class="control-label" for="parameterValue">Select Icon <button id="delicon1" name="delicon1" type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o" id="delicon2" name="delicon2"></i></button></label>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default"><i class="" id="val_icon" name="val_icon"></i></button>
                                <button type="button" class="icp icp-dd btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu"></div>
                            </div>
                        </div>
                    </div>
                </div><br>
                <input name="icon_category" id="icon_category" value="" type="hidden">
                <input type="hidden" name="keyword_id" value="<?php echo $keyword_id?>" required>
                <div class="col-md-12" align="center">
                    <button class="btn btn-success pull-right" style="margin-right: 430px" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

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

    $(document).ready(function() {
        get_data_edit();
            //load data for edit
        function get_data_edit(){
            var keyword_id = $('[name="keyword_id"]').val();
            $.ajax({
                url : "<?php echo site_url('mng_category/mng_category/get_data_edit');?>",
                method : "POST",
                data :{keyword_id :keyword_id},
                async : true,
                dataType : 'json',
                success : function(data){
                    $.each(data, function(i, item){
                        $('[name="keyword_name"]').val(data[i].keyword_name).trigger('change');
                        $('[name="icon_category"]').val(data[i].icon).trigger('change');
                        $('#val_icon').get(0).className = data[i].icon;
                    });
                }
            });
        }
    });
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>