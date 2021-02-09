<div class="content__inner">
<header class="content__title">
    <h1>Channel What's On</h1>
    <div class="col-md-12">
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <?php echo $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>
    </div>
</header>
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('channel_whatson/ch_wo/add') ?>"><i class="btn btn-light">Add</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Channel What's On</h4>
        </div>
    </div>
    
		    <div class="table-responsive">
            <table class="table table-striped table-bordered" id="mytable" width="100%" cellspacing="0">
				        <thead>
                    <tr>
                        <th>No.</th>
                        <th>Channel What's On Name</th>
                        <th>Channel What's On Description</th>
                        <!-- <th>Channel What's On Logo</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = 0;
                    foreach ($ch_wo as $ch_wo):
                    $no++;
                ?>
                <tr>
                    <td align="center"><?php echo $no;?></td>
                    <td align="center"><?php echo $ch_wo->channel_whatson_name ?></td>
                    <td align="center"><?php echo substr($ch_wo->channel_whatson_description, 0, 120) ?></td>
                    <!-- <td align="center"><img src="<?php echo base_url('media/img/'.$ch_wo->channel_whatson_logo) ?>" width="64" /></td> -->
                    <td align="center">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button>
                            <div class="dropdown-menu dropdown-menu--icon">
                                <a href="<?php echo site_url('channel_whatson/ch_wo/detail/'.$ch_wo->channel_whatson_id) ?>" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i> Detail</a>
                                <a href="<?php echo site_url('channel_whatson/ch_wo/edit/'.$ch_wo->channel_whatson_id) ?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i> Edit</a>
                                <a onclick="deleteConfirm('<?php echo site_url('channel_whatson/ch_wo/delete/'.$ch_wo->channel_whatson_id) ?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-delete zmdi-hc-fw"></i> Delete</a>                        
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Logout Delete Confirmation-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-body" align="center" id="exampleModalLabel">Are you sure?</h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-delete" class="btn btn-danger" href="#">Delete</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mytable').DataTable();
    });

    function deleteConfirm(url){
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>