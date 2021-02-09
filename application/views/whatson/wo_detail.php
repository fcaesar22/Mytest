<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('whatson/whatson') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Detail Channel What's On</h4><br>
        </div>
    </div>
    <div id="content-wrapper">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table mb-0" style="width:100%">
                <tr>
                    <th>What's On ID :</th>
                    <td><?php echo $whatson->whatson_id ?></td>
                </tr>
                <tr>
                    <th>What's On Title :</th>
                    <td><?php echo $whatson->whatson_title ?></td>
                </tr>
                <tr>
                    <th>What's On Description :</th>
                    <td><?php echo $whatson->whatson_description ?></td>
                </tr>
                <tr>
                    <th>What's On Image :</th>
                    <td><img src="<?php echo ('http://whatson.dens.tv/media/img/'.$whatson->whatson_image) ?>" width="64" /></td>
                </tr>
                <tr>
                    <th>What's On Video :</th>
                    <td><?php echo $whatson->whatson_video ?></td>
                </tr>
                <tr>
                    <th>Category What's On :</th>
                    <td><?php echo $whatson->category_whatson_name ?></td>
                </tr>
                <tr>
                    <th>Sub Category What's On :</th>
                    <td><?php echo $whatson->sub_category_whatson_name ?></td>
                </tr>
                <tr>
                    <th>Channel What's On :</th>
                    <td><?php echo $whatson->channel_whatson_name ?></td>
                </tr>
                <tr>
                    <th>Thumbnail What's On :</th>
                    <td><?php echo $whatson->thumbnail_whatson_name ?></td>
                </tr>
                <tr>
                    <th>Content ID :</th>
                    <td><?php echo $whatson->content_id ?></td>
                </tr>
                <tr>
                    <th>Content URL :</th>
                    <td><?php echo $whatson->content_url ?></td>
                </tr>
                <tr>
                    <th>Content URL Image :</th>
                    <td><img src="<?php echo (''.$whatson->content_url_image) ?>" width="64" /></td>
                </tr>
                <tr>
                    <th>What's On Schedule Time :</th>
                    <td><?php echo $whatson->whatson_schedule_time ?></td>
                </tr>
                <tr>
                    <th>What's On Purpose :</th>
                    <td><?php echo $whatson->whatson_purpose == 0 ? "Whatson" : "DensPlay" ?></td>
                </tr>
                <tr>
                    <th>What's On Type :</th>
                    <td><?php echo $whatson->whatson_type == 1 ? "Text" : "Image" ?></td>
                </tr>
                
            </table>       
        </div>
        <!-- <div class="table-responsive">
            <table class="table table-inverse table-bordered mb-0" style="width:100%">
                
                <tr>
                    <th>What's On Title :</th>
                    <td><input class="form-control" name="whatson_title" readonly=""></td>
                </tr>
                <tr>
                    <th>What's On Description :</th>
                    <td><textarea class="form-control" name="whatson_description" disabled="" =""></textarea></td>
                </tr>
                <tr>
                    <th>What's On Image :</th>
                    <td><input class="form-control" name="whatson_image" readonly=""></td>
                </tr>
                <tr>
                    <th>What's On Video :</th>
                    <td><input class="form-control" name="whatson_video" readonly=""></td>
                </tr>
                <tr>
                    <th>Category What's On :</th>
                    <td><select class="form-control" name="category" id="category" disabled>
                            <?php foreach($category as $row):?>
                            <option value="<?php echo $row->category_whatson_id;?>"><?php echo $row->category_whatson_name;?></option>
                            <?php endforeach;?>
                        </select></td>
                </tr>
                <tr>
                    <th>Sub Category What's On :</th>
                    <td><select class="form-control" name="subcategory" id="subcategory" disabled>
                            <?php foreach($subcategory as $row):?>
                            <option value="<?php echo $row->sub_category_whatson_id;?>"><?php echo $row->sub_category_whatson_name;?></option>
                            <?php endforeach;?>
                        </select></td>
                </tr>
                <tr>
                    <th>Channel What's On Name :</th>
                    <td><select class="form-control" name="channelwo" id="channelwo" disabled>
                            <?php foreach($channelwo as $row):?>
                            <option value="<?php echo $row->channel_whatson_id;?>"><?php echo $row->channel_whatson_name;?></option>
                            <?php endforeach;?>
                        </select></td>
                </tr>
                <tr>
                    <th>Thumbnail What's On Name :</th>
                    <td><select class="form-control" name="thumbnailname" id="thumbnailname" disabled>
                            <?php foreach($thumbnailname as $row):?>
                            <option value="<?php echo $row->thumbnail_whatson_id;?>"><?php echo $row->thumbnail_whatson_name;?></option>
                            <?php endforeach;?>
                        </select></td>
                </tr>
                <tr>
                    <th>Content ID :</th>
                    <td><input class="form-control" name="content_id" readonly=""></td>
                </tr>
                <tr>
                    <th>Content URL :</th>
                    <td><input class="form-control" name="content_url" readonly=""></td>
                </tr>
                <tr>
                    <th>Content URL Image :</th>
                    <td><input class="form-control" name="content_url_image" readonly=""></td>
                </tr>
                <tr>
                    <th>What's On Schedule Time :</th>
                    <td><input class="form-control" name="whatson_schedule_time" readonly=""></td>
                </tr>
                <tr>
                    <th>What's Purpose :</th>
                    <td><input class="form-control" name="whatson_purpose" readonly=""></td>
                </tr>
            </table>       
        </div> -->
            
                <!-- <input type="hidden" name="whatson_id" value="<?php echo $whatson_id?>" required> -->
            </div>
        </form>

    </div>
    </div>
    </div>

    <!-- <script src="<?=base_url()?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script> -->
    <script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        // get_data_edit();

        $( function() {
        $("#datetimepicker").flatpickr({
            enableTime: true,
            time_24hr: true,
            enableSeconds: true,
            minuteIncrement: 1,
            dateFormat: "Y-m-d H:i:S",
            });
        });

        // //load data for edit
        // function get_data_edit(){
        //     var whatson_id = $('[name="whatson_id"]').val();
        //     $.ajax({
        //         url : "<?php echo site_url('whatson/whatson/get_data_edit');?>",
        //         method : "POST",
        //         data :{whatson_id :whatson_id},
        //         async : true,
        //         dataType : 'json',
        //         success : function(data){
        //             $.each(data, function(i, item){
        //                 $('[name="whatson_title"]').val(data[i].whatson_title);
        //                 $('[name="whatson_description"]').val(data[i].whatson_description);
        //                 $('[name="whatson_image"]').val(data[i].whatson_image);
        //                 $('[name="whatson_video"]').val(data[i].whatson_video);
        //                 $('[name="category"]').val(data[i].category_whatson_id).trigger('change');
        //                 $('[name="subcategory"]').val(data[i].sub_category_whatson_id).trigger('change');
        //                 $('[name="channelwo"]').val(data[i].channel_whatson_id).trigger('change');
        //                 $('[name="thumbnailname"]').val(data[i].thumbnail_whatson_id).trigger('change');
        //                 $('[name="content_id"]').val(data[i].content_id).trigger('change');
        //                 $('[name="content_url"]').val(data[i].content_url).trigger('change');
        //                 $('[name="content_url_image"]').val(data[i].content_url_image).trigger('change');
        //                 $('[name="whatson_schedule_time"]').val(data[i].whatson_schedule_time).trigger('change');
        //                 $('[name="whatson_purpose"]').val(data[i].whatson_purpose).trigger('change');
        //             });
        //         }
        //     });
        // }
    });
    $('.js-example-basic-single').select2();
    </script>

</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>