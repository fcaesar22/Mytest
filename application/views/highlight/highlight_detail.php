<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('highlight/highlight') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Detail Highlight</h4><br>
        </div>
    </div>
    <div id="content-wrapper">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table mb-0" style="width:100%">
                <tr>
                    <th>Highlight Title :</th>
                    <td><?php foreach($content as $row):?><?php echo $row['title'];?><?php endforeach;?></td>
                </tr>
                <tr>
                    <th>Category :</th>
                    <td><?php echo $highlight->cat_highlight ?></td>
                </tr>
                <tr>
                    <th>Type :</th>
                    <td><?php echo $highlight->type_highlight ?></td>
                </tr>
                <tr>
                    <th>ID GOTO :</th>
                    <td><?php echo $highlight->id_goto ?></td>
                </tr>
                <tr>
                    <th>Start Date :</th>
                    <td><?php echo $highlight->start_date ?></td>
                </tr>
                <tr>
                    <th>End Date :</th>
                    <td><?php echo $highlight->end_date ?></td>
                </tr>
                <tr>
                    <th>Poster Highlight :</th>
                    <td><img width="128" height="72" src="<?php echo $highlight->poster_url ?>"></td>
                </tr>
            </table>       
        </div>
    </div>
    </div>
    </div>

    <script type="text/javascript">
        
    </script>

</div>
</div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>