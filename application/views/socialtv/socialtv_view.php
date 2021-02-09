<div class="content__inner">
<header class="content__title">
    <h1>Social TV</h1>
    <div class="col-md-12">
        <?php echo $this->session->flashdata('msg');?>
    </div>
</header>
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <a href="<?php echo site_url('socialtv/add_socialtv') ?>"><i class="btn btn-light">Add Social TV</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Social TV</h4>
        </div>
    </div>
        <div class="tab-container">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#active_soctv" role="tab">Active Article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#inactive_soctv" role="tab">Inactive Article</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active fade show" id="active_soctv" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="mytable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Social TV Name</th>
                                    <th>Social TV Category</th>
                                    <th>Social TV Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 0;
                                foreach ($socialtvactive as $key=>$row):
                                $no++;
                            ?>
                            <tr>
                                <td align="center"><?php echo $no;?></td>
                                <td align="center"><?php echo $row['socialtv_name'] ?></td>
                                <td align="center"><?php echo $row['categories'] ?></td>
                                <td align="center"><img width="128" height="72" src="<?php echo $row['poster_url'] ?>"></td>
                                <td align="center">
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button>
                                        <div class="dropdown-menu dropdown-menu--icon">
                                            <a href="<?php echo site_url('socialtv/detail/'.$row['socialtv_id']);?>" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a>
                                            <a href="<?php echo site_url('socialtv/getedit_socialtv/'.$row['socialtv_id']);?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                            <?php if($row['visible'] =='N'){
                                            ?>
                                                <a onclick="activeConfirm('<?php echo site_url('socialtv/activated/'.$row['socialtv_id']);?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived Article</a>
                                            <?php
                                                }
                                            ?>
                                            <?php if($row['visible'] =='Y'){
                                            ?>
                                                <a onclick="inactiveConfirm('<?php echo site_url('socialtv/inactivated/'.$row['socialtv_id']);?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Inactived Article</a>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="inactive_soctv" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="mytable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Social TV Name</th>
                                    <th>Social TV Category</th>
                                    <th>Social TV Photo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $no = 0;
                                foreach ($socialtvinactive as $key=>$row):
                                $no++;
                            ?>
                            <tr>
                                <td align="center"><?php echo $no;?></td>
                                <td align="center"><?php echo $row['socialtv_name'] ?></td>
                                <td align="center"><?php echo $row['categories'] ?></td>
                                <td align="center"><img width="128" height="72" src="<?php echo $row['poster_url'] ?>"></td>
                                <td align="center">
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button>
                                        <div class="dropdown-menu dropdown-menu--icon">
                                            <a href="<?php echo site_url('socialtv/detail/'.$row['socialtv_id']);?>" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a>
                                            <a href="<?php echo site_url('socialtv/getedit_socialtv/'.$row['socialtv_id']);?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
                                            <?php if($row['visible'] =='N'){
                                            ?>
                                                <a onclick="activeConfirm('<?php echo site_url('socialtv/activated/'.$row['socialtv_id']);?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers zmdi-hc-fw"></i>Actived Article</a>
                                            <?php
                                                }
                                            ?>
                                            <?php if($row['visible'] =='Y'){
                                            ?>
                                                <a onclick="inactiveConfirm('<?php echo site_url('socialtv/inactivated/'.$row['socialtv_id']);?>')" href="#!" class="dropdown-item"><i class="zmdi zmdi-layers-off zmdi-hc-fw"></i>Inactived Article</a>
                                            <?php
                                                }
                                            ?>
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
    </div>
</div>
</div>

<!--Active banner Confirmation-->
<div class="modal fade" id="activeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-active" class="btn btn-danger" href="#">Active</a>
            </div>
        </div>
    </div>
</div>

<!--Inactive banner Confirmation-->
<div class="modal fade" id="inactiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-body" align="center">Are you sure?</div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a id="btn-inactive" class="btn btn-danger" href="#">Inactive</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mytable').DataTable();
    });

    function activeConfirm(url){
        $('#btn-active').attr('href', url);
        $('#activeModal').modal();
    }

    function inactiveConfirm(url){
        $('#btn-inactive').attr('href', url);
        $('#inactiveModal').modal();
    }
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>