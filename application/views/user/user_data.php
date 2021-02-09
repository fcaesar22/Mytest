<div class="content__inner">
<header class="content__title">
    <h1>Data Users</h1>
</header>

  <div class="card">
      <div class="card-body">
          <h4 class="card-title">Data Users</h4>

          <div class="pull-right">
            <a href="<?=site_url('user/add')?>" class="btn btn-primary btn-flat">
              <i class="fa fa-user-plus"></i> Create
            </a>
          </div><br>
          <div class="box-body table-responsive">
              <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th class="text-center">NO</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Username</th>
                      <th class="text-center">Address</th>
                      <th class="text-center">Level</th>
                      <th class="text-center">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $no = 1;
                  foreach($row->result() as $key => $data) { ?>
                  <tr>
                      <td class="text-center"><?=$no++?></td>
                      <td class="text-center"><?=$data->name?></td>
                      <td class="text-center"><?=$data->username?></td>
                      <td class="text-center"><?=$data->address?></td>
                      <td class="text-center"><?=$data->level == 1 ? "SuperAdmin" : "Admin"?></td>
                      <td class="text-center" width="160px">
                      <form action="<?=site_url('user/del')?>" method="post">
                          <div class="dropdown">
                              <button class="btn btn-light dropdown-toggle" data-toggle="dropdown">ACTION</button>
                              <div class="dropdown-menu dropdown-menu--icon"> 
                                  <a href="<?=site_url('user/edit/'.$data->user_id)?>" class="dropdown-item">
                                  <i class="fa fa-pencil"></i> Update
                                  </a>
                                  <input type="hidden" name="user_id" value="<?=$data->user_id?>">
                                  <button onclick="return confirm('Apakah anda yakin?')" class="dropdown-item">
                                      <i class="fa fa-trash"></i> Delete
                                  </button>
                              </div>
                          </div>
                      </form>
                      </td>
                  </tr>
                  <?php
                  } ?>
              </tbody>
              </table>
          </div>
      </div>
  </div>

<footer class="footer hidden-xs-down">
<p>© Super Admin Responsive. All rights reserved.</p>
</footer>