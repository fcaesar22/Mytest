<div class="content__inner">
<header class="content__title">
    <h1>Highlight</h1>
    <div class="col-md-12">
        <?php echo $this->session->flashdata('msg');?>
    </div>
</header>
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <a href="<?php echo site_url('highlight/highlight/add_highlight') ?>"><i class="btn btn-light">Add Highlight</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Highlight</h4>
        </div>
    </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="mytable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Highlight Title</th>
                        <th>Highlight Image</th>
                        <th>Highlight Category</th>
                        <th>Highlight Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $no = 0;
                    foreach ($highlight as $key=>$row)://print_r($denslife);die;
                    $no++;
                ?>
                <tr>
                    <td align="center"><?php echo $no;?></td>
                    <td align="center"><?php echo $row['title_goto'] ?></td>
                    <td align="center"><img width="128" height="72" src="<?php echo $row['poster_url'] ?>"></td>
                    <td align="center"><?php echo $row['category_covers'] ?></td>
                    <td align="center"><?php echo $row['type_highlight']?></td>
                    <td align="center"><?php echo $row['start_date'] ?></td>
                    <td align="center"><?php echo $row['end_date']?></td>
                    <td align="center">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button>
                            <div class="dropdown-menu dropdown-menu--icon">
                                <a href="<?php echo site_url('highlight/highlight/detail/'.$row['covers_id']);?>" class="dropdown-item"><i class="zmdi zmdi-search-in-page zmdi-hc-fw"></i>Detail</a>
                                <a href="<?php echo site_url('highlight/highlight/getedit_highlight/'.$row['covers_id']);?>" class="dropdown-item"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>Edit</a>
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

<script type="text/javascript" src="<?php echo base_url().'assets/js/datatables.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#mytable').DataTable();
    });
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>