<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('whatson/wo_content') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Add What's On Content</h4>
        </div>
    </div>
    <hr>
    <br>

<style>
    select {display: block !important;}
    select.image-picker {margin-bottom: 20px;}
    .image_picker_image {width: 200px;height: 130px;}
    #select option {color: black;}
</style>

    <form method="POST" action="" id="frm_submit">
    <div class="col-md-12">    
        <!-- Text input-->
        <table style="width: 100%" class="table">
            <thead><tr><th>No.</th><th>What's On ID</th><th>Type</th><th style="width:40%">URL</th><th style="width:20%">Created At</th><th>Created By</th></tr></thead>
            <tbody id="table-details"><tr id="row1" class="jdr1">
                <td><span class="btn btn-sm btn-default">1</span><input type="hidden" value="6437" name="count[]"></td>
                <td><input type="text" readonly="" class="form-control input-sm" placeholder="Whatson ID" name="whatson_id[]"
                   value="<?php echo $whatson_id?>"></td>
                <td>

                <select required="" id="select" class="form-control" name="type[]"><option value="">--Please Select Type--</option><option value="image">Image</option><option value="video">Video</option></select>

                </td>
                <td class="farid"><input id='id_001' type="text" required="" class="form-control input-sm textImage" placeholder="URL" name="url[]"><a class="btn btn-light btn-sm" data-toggle="modal" name="url[]" data-target="#modal-xl" >Choose Image</a></td>
                <td><input type="text" required="" class="form-control input-sm datetimepicker" placeholder="Date" name="created_at[]"></td>
                <td><input type="text" required="" class="form-control input-sm" placeholder="Created By" name="created_by[]"></td>
                </tr>
            </tbody>
        </table>
        <button class="btn btn-sm btn-primary btn-add-more">Add More</button>
        <button class="btn btn-sm btn-danger btn-remove-detail-row">Delete</button>
    </div>
    <div class="col-md-12" align="center">
        <hr>
        <input class="btn btn-success pull-right" type="submit" value="submit" name="submit">
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
        <button id="upload" type="button" class="btn btn-link">Upload Image</button>
        <button type="button" class="btn btn-link" onclick="getUrlImage()">Save</button>
        <button id="back" type="button" class="btn btn-link">Images</button>
        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/image-picker/image-picker.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
function getUrlImage(){
    var image = $('.image_picker_selector').find('.selected').find('img').attr('src');
    var images = 'http://pic.dens.tv/wp/img/whatson_v2/1280x720/'+image.replace(/.*\//, '');
    //$('image-picker').hide();
    var _getid = $('.jdr1').find(".farid").find('input').last().attr('id');
    document.getElementById(_getid).value = images;
    $('#modal-xl').modal('hide');
}


$(document).ready(function () {
    var default_content = $("#changing-content").html();
    $("select").imagepicker();
    // Change div content
    $('#upload').click(function () {
        $.ajax({
            url: '<?php echo base_url() ?>whatson/wo_content/get_token',
            success: function(data){
            console.log('http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=whatson_v2&type=image');
            $('#changing-content')
            .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token='+data+'&thumb=50&CH=whatson_v2&type=image" width="100%" height="400px" frameborder="0"></iframe>');
            }
        });
      // $('#changing-content')
      // .html('<iframe src="http://wp.dens.tv/uploaders?w=1280&h=720&pw=448&ph=252&token=<?php print_r($token);?>&thumb=50&CH=11_indomie&type=image" width="100%" height="400px" frameborder="0"></iframe>');
    });

    $('#back').click(function () {
        console.log(default_content);
        $.ajax({
          type: "GET",
          url: '<?php echo base_url() ?>whatson/wo_content/compare_image',
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
        // $('#changing-content').html(default_content);
        // $("select").imagepicker();
    });

});

$(document).ready(function (){

    $("body").on('click', '.btn-add-more', function (e) {

        e.preventDefault();

        var $sr = ($(".jdr1").length + 1);
        // var rowid = Math.random();
        var uniq = 'id_' + (new Date()).getTime();
        var $html = '<tr class="jdr1" >' +
        '<td><span class="btn btn-sm btn-default">' + $sr + '</span><input type="hidden" name="count[]" value="'+Math.floor((Math.random() * 10000) + 1)+'"></td>' +
        '<td><input type="text" readonly="" class="form-control input-sm" placeholder="Whatson ID" name="whatson_id[]" value="<?php echo $whatson_id; ?>"></td>' +
        '<td><select required="" id="select" class="form-control" name="type[]"><option value="">--Please Select Type--</option><option value="image">Image</option><option value="video">Video</option></select></td>' +
        '<td class="farid"><input id="'+uniq+'" type="text" required="" class="form-control input-sm textImage" placeholder="URL" name="url[]"><a class="btn btn-light btn-sm" data-toggle="modal" name="url[]" data-target="#modal-xl">Choose Image</a></td>' +
        '<td><input type="text" required="" class="form-control input-sm datetimepicker" placeholder="Date" name="created_at[]"></td>' +
        '<td><input type="text" required="" class="form-control input-sm" placeholder="Created By" name="created_by[]"></td>' +
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
        
    $("#frm_submit").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url() ?>whatson/wo_content/batchInsert',
            type: 'POST',
            data: $("#frm_submit").serialize()
        }).always(function (response){
            var r = (response.trim());
            if(r == 1){
                window.location.href = "<?php echo base_url() ?>whatson/wo_content";
            }
            else{
                $(".alert-danger").show();
            }
        });
    });
});
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>
</div>