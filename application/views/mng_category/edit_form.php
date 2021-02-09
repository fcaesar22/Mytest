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

</style>

    <div id="content-wrapper">
        <div class="container-fluid">
            <form role="form" action="<?php echo site_url('mng_category/mng_category/update_product');?>" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="keyword_name" id="keyword_name" class="form-control" placeholder="Category Name" />
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <input type="hidden" name="keyword_id" value="<?php echo $keyword_id?>" required>
                    <div class="col-md-12" align="center">
                        <button class="btn btn-success pull-right" type="submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
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
                    });
                }
            });
        }
    });
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>