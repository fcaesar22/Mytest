<div class="content__inner">
<header class="content__title">
    <h1>Dashboard</h1>
</header>
	<div class="card">
	    <div class="card-body">
	        <h4 class="card-title">Form Import</h4>
	        <form method="post" action="<?php echo base_url("/index.php/person/import"); ?>" enctype="multipart/form-data">
		<input type="file" name="file">
		<button type='submit' name='form'>Upload</button>
		<input type="button" value="Back" onclick="window.location.href='http://localhost/CRUD_STB'" />
	</form>
        </div>
    </div>

	<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>