<div class="content__inner">
<header class="content__title">
    <h1>STB Dens.TV</h1>
</header>

	<div class="card">
	    <div class="card-body">
	        <h4 class="card-title">Data STB</h4>
	        <hr>

    <div class="container">
        <a href="<?php echo base_url("/index.php/person/upload"); ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i>Import CSV</a>
        <button class="btn btn-success" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add STB</button>
        <br />
        <table id="table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>Username/Email</th>
                    <th>Serial Number</th>
                    <th>Status</th>
                    <th>Model</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('person/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
});

function add_person()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add STB'); // Set Title to Bootstrap modal title
}

function edit_person(seq)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('person/ajax_edit/')?>/" + seq,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="seq"]').val(data.seq);
            $('[name="user"]').val(data.user);
            $('[name="serial_number"]').val(data.serial_number);
            $('[name="status"]').val(data.status);
            $('[name="model"]').val(data.model);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit STB'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}


function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('person/ajax_add')?>";
    } else {
        url = "<?php echo site_url('person/ajax_update')?>";
    }
    
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                alert("Data Berhasil disimpan");
                table.ajax.reload();
            }
            else
            {
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
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_person(seq)
{
    if(confirm('Apakah anda yakin?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('person/ajax_delete')?>/"+seq,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                alert("Data Berhasil dihapus");
                table.ajax.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
    }
}
</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="seq"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-6">Username/Email</label>
                            <div class="col-md-9">
                                <input name="user" placeholder="Username/Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Serial Number</label>
                            <div class="col-md-9">
                                <input name="serial_number" placeholder="Serial Number" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Status</label>
                            <div class="col-md-9">
                                <select name="status" class="form-control">
                                    <option value="">--Select Status--</option>
                                    <option value="1">1:Ready</option>
                                    <option value="2">2:Login</option>
                                    <option value="3">3:Dismantle</option>
                                    <option value="4">4:Used</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6">Model</label>
                            <div class="col-md-9">
                                <select name="model" class="form-control">
                                    <option value="">--Select Model--</option>
                                    <option value="MRVL88DE3108">MRVL88DE3108</option>
                                    <option value="CASTPAL-AW526">CASTPAL-AW526</option>
                                    <option value="DENS2X MKTECH-MMP-OTT 888">DENS2X MKTECH-MMP-OTT 888</option>
                                    <option value="XLHOME">XLHOME</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
	    </div>
	</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>
</div>