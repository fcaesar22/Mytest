<link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

<div class="content__inner">
<header class="content__title">
    <h1>Edit User</h1>
</header>

      <div class="card">
          <div class="card-body">
              <h4 class="card-title">Edit User</h4>
                  <div class="pull-right">
                        <a href="<?=site_url('user')?>" class="btn btn-primary btn-flat">
                              <i class="fa fa-undo"></i> Back
                        </a>
                  </div><br>
                  <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                              <form action="" method="post">
                                    <div class="form-group <?=form_error('fullname') ? 'has-error' : null?>">
                                          <label>Name *</label>
                                          <input type="hidden" name="user_id" value="<?=$row->user_id?>">
                                          <input type="text" name="fullname" value="<?=$row->name?>" class="form-control">
                                          <?=form_error('fullname')?>
                                    </div>

                                    <div class="form-group <?=form_error('username') ? 'has-error' : null?>">
                                          <label>Username *</label>
                                          <input type="text" name="username" value="<?=$row->username?>" class="form-control">
                                          <?=form_error('username')?>
                                    </div>

                                    <div class="form-group <?=form_error('password') ? 'has-error' : null?>">
                                          <label>Password</label><small>(Biarkan kosong jika tidak diganti)</small>
                                          <input type="password" name="password" value="<?=$this->input->post('password')?>" class="form-control">
                                          <?=form_error('password')?>
                                    </div>

                                    <div class="form-group <?=form_error('passconf') ? 'has-error' : null?>">
                                          <label>Password Confirmation</label>
                                          <input type="password" name="passconf" value="<?=$this->input->post('passconf')?>" class="form-control">
                                          <?=form_error('passconf')?>
                                    </div>

                                    <div class="form-group">
                                          <label>Address *</label>
                                          <textarea name="address" class="form-control"><?=$row->address?></textarea>
                                          <?=form_error('address')?>
                                    </div>

                                    <div class="form-group <?=form_error('level') ? 'has-error' : null?>">
                                          <label>Level</label>
                                          <select name="level" class="form-control js-example-basic-single">
                                          <?php $level = $this->input->post('level') ? $this->input->post('level') : $row->level ?>
                                          <option value="1">Super Admin</option>
                                          <option value="2" <?=$level == 2 ? 'selected' : null?>>Admin</option>
                                          </select>
                                          <?=form_error('level')?>
                                    </div>

                                    <div class="form-group">
                                          <button type="submit" class="btn btn-success btn-flat">
                                          <i class="fa fa-paper-plane"></i> Save
                                          </button>
                                          <button type="reset" class="btn btn-flat">Reset</button>
                                    </div>
                              </form>
                        </div>
                  </div>
            </div>
      </div>
</div>

<script src="<?=base_url()?>assets/jquery/jquery.js"></script>
<script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
      $('.js-example-basic-single').select2();
</script>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>