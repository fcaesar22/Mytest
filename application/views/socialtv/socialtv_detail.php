<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('socialtv/socialtv') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Detail Social TV</h4><br>
        </div>
    </div>
    <div id="content-wrapper">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table mb-0" style="width:100%">
                <tr>
                    <th>Poster Social TV :</th>
                    <td><img width="128" height="72" src="<?php echo $socialtv->poster_url ?>"></td>
                </tr>
                <tr>
                    <th>Social TV Name :</th>
                    <td><?php echo $socialtv->socialtv_name ?></td>
                </tr>
                <tr>
                    <th>Social TV Description :</th>
                    <td><?php echo $socialtv->socialtv_description ?></td>
                </tr>
                <tr>
                    <th>Category :</th>
                    <td><?php echo $socialtv->categories ?></td>
                </tr>
                <tr>
                    <th>Source :</th>
                    <td><?php echo $socialtv->source_content ?></td>
                </tr>
                <tr>
                    <th>Created At :</th>
                    <td><?php echo $socialtv->created_at ?></td>
                </tr>
                <tr>
                    <th>Updated At :</th>
                    <td><?php echo $socialtv->updated_at ?></td>
                </tr>
                <tr>
                    <th>Created By :</th>
                    <td><?php echo $socialtv->created_by ?></td>
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