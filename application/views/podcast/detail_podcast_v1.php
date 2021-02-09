<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('podcast/podcast_v1') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Detail Podcast</h4><br>
        </div>
    </div>
    <div id="content-wrapper">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-bordered table-inverse mb-0" style="width:100%">
                <tr>
                    <th>Podcast Image :</th>
                    <td><img width="120" height="120" src="<?php echo $podcast->podcast_image ?>"></td>
                </tr>
                <tr>
                    <th>Podcast Name :</th>
                    <td><?php echo $podcast->podcast_name ?></td>
                </tr>
                <tr>
                    <th>Podcast Category :</th>
                    <td><?php echo $podcast->categories ?></td>
                </tr>
                <tr>
                    <th>Podcast Link RSS :</th>
                    <td><?php echo $podcast->link_rss ?></td>
                </tr>
                <tr>
                    <th>Created At :</th>
                    <td><?php echo $podcast->created_at ?></td>
                </tr>
                <tr>
                    <th>Updated At :</th>
                    <td><?php echo $podcast->updated_at ?></td>
                </tr>
                <tr>
                    <th>Created By :</th>
                    <td><?php echo $podcast->created_by ?></td>
                </tr>
                <?php if ($podcast->start_periode != null && $podcast->end_periode != null) { ?> 
                <tr>
                    <th>Podcas Recommendation :</th>
                    <td><button type='button' class='btn btn-outline-success' disabled>Ready</button></td>
                </tr>
                <tr>
                    <th>Start Recommendation :</th>
                    <td><?php echo $podcast->start_periode ?></td>
                </tr>
                <tr>
                    <th>End Recommendation :</th>
                    <td><?php echo $podcast->end_periode ?></td>
                </tr>
                <?php } else { ?>
                <tr>
                    <th>Podcas Recommendation :</th>
                    <td><button type='button' class='btn btn-outline-danger' disabled>Not Ready</button></td>
                </tr>
                <tr>
                    <th>Start Recommendation :</th>
                    <td><?php echo "" ?></td>
                </tr>
                <tr>
                    <th>End Recommendation :</th>
                    <td><?php echo "" ?></td>
                </tr>
                <?php } ?>
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