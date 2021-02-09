<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AID</title>
        <link rel="shortcut icon" href="<?=base_url()?>assets/img/dens_tv.png">
        <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/animate.css/animate.min.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/image-picker/image-picker.css"> 
        <meta name="description" content="Content Management System">
        <meta name="keywords" content="HTML,CSS,PHP,XML,JavaScript">
        <meta name="author" content="AID">
        <meta property="og:url"           content="http://aid.digdaya.co.id" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="AID" />
        <meta property="og:description"   content="Content Management System" />
        <meta property="og:image"         content="<?=base_url()?>assets/img/dens_tv.png" />
        <script src="<?=base_url()?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js"></script>
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
    </head>
    <style type="text/css">
        span.icon-podcast {
            background-image: url("<?=base_url()?>assets/img/iconlifestyle.png");
        }
        span.icon-podcast {
            float: left;
            width: 24px;
            height: 24px;
            margin-right: 10px;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 100%;
        }
    </style>
    <body data-sa-theme="9">
        <main class="main">
            <div class="page-loader">
                <div class="page-loader__spinner">
                    <svg viewBox="25 25 50 50">
                        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
            </div>

            <header class="header">
                <div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">
                    <i class="zmdi zmdi-menu"></i>
                </div>

                <div class="logo hidden-sm-down">
                    <a href="<?=base_url('dashboard')?>">
                    	<img src="<?=base_url()?>assets/img/logo.png" alt="">
                    </a>
                </div>
                
                <ul class="top-nav">                    
                <div id="MyClockDisplay" class="clock hidden-md-down" onload="showTime()"></div>
                </ul>
            </header>

            <aside class="sidebar">
                <div class="scrollbar-inner">

                    <div class="user">
                        <div class="user__info" data-toggle="dropdown">
                            <img class="user__img" src="<?=base_url()?>assets/demo/img/profile-pics/8.jpg" alt="">
                            <div>
                                <div class="user__name"><?=$this->fungsi->user_login()->username?></div>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <!-- <a class="dropdown-item" href="">View Profile</a> -->
                            <a class="dropdown-item" href="<?php echo base_url('Auth/logout'); ?>">Logout</a>
                        </div>
                    </div>

                    <ul class="navigation">
                        <li><a href="<?=base_url('dashboard')?>"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <?php if($this->fungsi->user_login()->level == 1) { ?>
                        <li><a href="<?=base_url('person')?>"><i class="zmdi zmdi-tv-play zmdi-hc-fw"></i> STB</a></li>
                        <?php } ?>
                        <?php if($this->fungsi->user_login()->level == 2) { ?>
                        <li class="navigation__sub">
                            <a href=""><i class="zmdi zmdi-collection-text"></i> What's On</a>
                            <ul>
                                <li><a href="<?=base_url('category_whatson/cat_wo')?>">Category What's On</a></li>
                                <li><a href="<?=base_url('subcategory_whatson/sub_wo')?>">Sub Category What's On</a></li>
                                <li><a href="<?=base_url('channel_whatson/ch_wo')?>">Channel What's On</a></li>
                                <li><a href="<?=base_url('whatson/whatson')?>">What's On</a></li>
                                <li><a href="<?=base_url('whatson/wo_content')?>">What's On Content</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <!-- <li><a href="<?=base_url('test')?>"><i class="zmdi zmdi-tv-play zmdi-hc-fw"></i> Test</a></li> -->
                        <?php if($this->fungsi->user_login()->level == 1) { ?>
                        <li class="navigation__sub">
                            <a href=""><i class="zmdi zmdi-collection-text"></i> DensLife&Style</a>
                            <ul>
                                <li><a href="<?=base_url('denslife/denslife')?>">Article DensLife&Style</a></li>
                                <li><a href="<?=base_url('mng_category/mng_category')?>">Category</a></li>
                                <!-- <li><a href="<?=base_url('imagedenslife')?>">Image DensLife&Style</a></li> -->
                            </ul>
                        </li>
                        <li><a href="<?=base_url('highlight/highlight')?>"><i class="zmdi zmdi-view-carousel zmdi-hc-fw"></i><span>Highlight</span></a></li>
                        <li><a href="<?=base_url('socialtv/socialtv')?>"><i class="zmdi zmdi-tv-list zmdi-hc-fw"></i><span>Social TV</span></a></li>
                        <li><a href="<?=base_url('podcast/podcast_v1')?>"><span class="icon icon-podcast"></span>Podcast</a></li>
                        <li><a href="<?=base_url('user')?>"><i class="zmdi zmdi-accounts zmdi-hc-fw"></i><span>Users</span></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </aside>

            <section class="content">
                <?php echo $contents ?>
            </section>
        </main>

        <!-- Javascript -->
        <!-- Vendors -->
        <!-- <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
         -->
        
        <script type="text/javascript">
            function showTime(){
                var date = new Date();
                var h = date.getHours(); // 0 - 23
                var m = date.getMinutes(); // 0 - 59
                var s = date.getSeconds(); // 0 - 59
                var session = "AM";
                
                if(h == 0){
                    h = 12;
                }
                
                if(h > 12){
                    h = h - 12;
                    session = "PM";
                }
                
                h = (h < 10) ? "0" + h : h;
                m = (m < 10) ? "0" + m : m;
                s = (s < 10) ? "0" + s : s;
                
                var time = h + ":" + m + ":" + s + " " + session;
                document.getElementById("MyClockDisplay").innerText = time;
                document.getElementById("MyClockDisplay").textContent = time;
                
                setTimeout(showTime, 1000);
    
            }

            showTime();
        </script>
    </body>
</html>