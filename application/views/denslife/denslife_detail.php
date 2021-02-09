<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<style type="text/css">
    img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 150px;
    }
</style>

<div class="content__inner">
<div class="card">
    <div class="card-body">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo site_url('denslife/denslife') ?>"><i class="btn btn-light" class="card-title">Back</i></a>
        </div>
        <div class="col-md-12" align="center">
            <h4 class="card-title">Detail Article</h4><br>
        </div>
    </div>
    <div id="content-wrapper">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table mb-0" style="width:100%">
                <tr>
                    <th>Article ID :</th>
                    <td><?php echo $denslife->article_id ?></td>
                </tr>
                <tr>
                    <th>Article Title :</th>
                    <td><?php echo $denslife->article_title ?></td>
                </tr>
                <tr>
                    <th>Article By :</th>
                    <td><?php echo $denslife->article_by ?></td>
                </tr>
                <tr>
                    <th>Category :</th>
                    <td><?php echo $denslife->categories ?></td>
                </tr>
                <tr>
                    <th>Summary :</th>
                    <td><?php echo $denslife->article_summary ?></td>
                </tr>
                <tr>
                    <th>Article Content 1 :</th>
                    <td><?php echo $denslife->article_content_1 ?></td>
                </tr>
                <tr>
                    <th>Article Content 2 :</th>
                    <td><?php echo $denslife->article_content_2 ?></td>
                </tr>
                <tr>
                    <th>Tags :</th>
                    <td><?php echo $denslife->tags ?>
                    </td>
                </tr>
                <tr>
                    <th>URL Google Maps :</th>
                    <td><?php echo $denslife->url_google_maps ?></td>
                </tr>
                <tr>
                    <th>PDF :</th>
                    <td><?php echo $denslife->pdf_url ?></td>
                </tr>
                <tr>
                    <th>Poster Image :</th>
                    <td><img height="72" width="120" src="<?php echo $denslife->poster_url ?>"></td>
                </tr>
                <tr>
                    <th>Content Image :</th>
                    <td><?php foreach ($poster as $key => $value) {
                        echo ($key + 1) . '. ' . '<img height="72" width="120" src="'.$value['poster_url'].'" alt="">' . '<input type="hidden" class="form-control input-sm" name="poster_id" value="'.$value['poster_id'].'">' . '<br/><br/>';
                    } ?>
                    </td>
                </tr>
                <tr>
                    <th>Content Video :</th>
                    <td><?php foreach ($video as $key => $value) {
                        echo ($key + 1) . '. ' . '<img height="72" width="120" src="'.$value['poster_url'].'" alt="">' . '<br/><br/>';
                    } ?>
                    </td>
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