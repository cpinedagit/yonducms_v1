<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>YONDU Web Services</title>
        <meta name="description" content="">
        <!--
        This has been remove because the page is not responsive
        <meta name="viewport" content="width=device-width, initial-scale=1">-->

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/jquery.dataTables.css">
        <link rel="stylesheet" href="css/jquery-ui.css">
        <link rel="stylesheet" href="css/bootstrap-switch.css">
        
        <link rel="stylesheet" href="css/style.css">
        
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Add your site or application content here -->
        <header class='container-fluid header header--fixed'>
           <div class="row">
            <div class="pull-left header__logo">
               <!--Change SRC to put logo-->
                <img src="images/sample-logo.png" alt="CMS Logo">
            </div>
            <div class="pull-left header__search">
                <a href="#"><i class="fa fa-globe"></i> View Site</a>
                <div class="input-group">
                      <span class="input-group-addon" id="search-icon"><i class="fa fa-search"></i></span>
                      <input type="text" class="form-control" placeholder="Search..." id="search">
                </div>
            </div>
            <ul class="pull-right list-unstyled header__menu-list">
                <li>
                    <a href="#"><i class="fa fa-bell-o"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-envelope-o"></i></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-calendar"></i></a>
                </li>
                <li class="header__menu-list__account">
                    <div class="dropdown header__menu-list__account__dropdown">
                      <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                        <div class="circle header__menu-list__account__dropdown__icon"></div>
                       <div class="header__menu-list__account__dropdown__name">
                            <!--Current user firstname-->
                            John
                            <i class="fa fa-chevron-down"></i>
                        </div>
                      </a>
                      <ul class="dropdown-menu header__menu-list__account__dropdown__options" role="menu" aria-labelledby="dLabel">
                      <!--Include menu content here-->
                        <li class='header__menu-list__account__dropdown__options__acct-info'>
                           <div class="circle header__menu-list__account__dropdown__options_icon">
                              <!-- PUT IMAGE IF AVAILABLE -->
                              <!-- <img src="images/sample.jpeg" alt="">-->
                           </div>
                            <div class="header__menu-list__account__dropdown__options_account-name">
                                John Smith
                            </div>
                            <div class="header__menu-list__account__dropdown__options_account-email">
                                john_smith@email.com
                            </div>
                        </li>
                       <li><a href="#">Account Settings</a></li>
                       <li><a href="#">Logout</a></li>
                       <li><a href="#">Help</a></li>
                      </ul>
                    </div>
                </li>
            </ul>
           </div> 
        </header>
        
        <div class="main-container">
            <section class="main-container__navigation-container">
               <div class="main-container__navigation-container__toggle">
                   <i class="fa fa-bars" id="nav-toggle"></i>
               </div>
               <div class="main-container__navigation-container__welcome">
                   <div class="circle main-container__navigation-container__welcome__icon">
                      <!-- Put image here
                      <img src="img/sample.jpeg" alt="">-->
                   </div>
                   <div class='main-container__navigation-container__welcome__name'>
                       <h4>Welcome</h4>
                       <span>John Smith</span>
                       <div class="main-container__navigation-container__welcome__name__status">
                           <small>Status</small>
                           <i class="fa fa-circle-o"></i>
                           <span class='status'>Online</span>
                       </div>
                   </div>
               </div>
               <nav class='main-container__navigation-container__navigation'>
                   <ul class="list-unstyled main-container__navigation-container__navigation__nav-list">
                       <li >
                           <a href="#1"><i class="fa fa-tachometer"></i>
                               <span>Dashboard</span>
                           </a>
                       </li>
                       <!-- use "open" class to expand
                            use "active" class to highlight the active main menu-->
                       <li>
                           <a href="#2"><i class="fa fa-files-o"></i>
                               <span>Pages</span>
                           </a>
                           <ul class="list-unstyled">
                              <!-- use "active" to highlight the active submenu-->
                               <li>
                                   <a href="#viewlist">View List</a>
                               </li>
                               <li>
                                   <a href="#">Add New</a>
                                </li>
                                <li>
                                   <a href="#">Manage Pages</a>
                                </li>
                                
                           </ul>
                       </li>
                       <li>
                           <a href="#3"><i class="fa fa-flag-o"></i>
                               <span>Banner</span>
                           </a>
                           <ul class="list-unstyled">
                               <li class='open active'>
                                   <a href="#">View List</a>
                               </li>
                               <li>
                                   <a href="#">Add New</a>
                                </li>
                           </ul>
                       </li>
                       <li>
                           <a href="#4"><i class="fa fa-newspaper-o"></i>
                               <span>News</span>
                           </a>
                           <ul class="list-unstyled">
                               <li>
                                   <a href="#">View List</a>
                               </li>
                               <li>
                                   <a href="#">Add New</a>
                                </li>
                           </ul>
                       </li>
                       <li>
                           <a href="#5"><i class="fa fa-picture-o"></i>
                               <span>Media</span>
                           </a>
                       </li>
                       <li class="open active">
                           <a href="#6"><i class="fa fa-list-alt"></i>
                               <span>Modules</span>
                           </a>
                       </li>
                       <li>
                           <a href="#"><i class="fa fa-sliders"></i>
                               <span>Editor</span>
                           </a>
                           <ul class="list-unstyled">
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                           </ul>
                       </li>
                       <li>
                           <a href="#5"><i class="fa fa-users"></i>
                               <span>Users</span>
                           </a>
                           <ul class="list-unstyled">
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                           </ul>
                       </li>
                       <li>    
                           <a href="#"><i class="fa fa-cogs"></i>
                               <span>Settings</span>
                           </a>
                           <ul class="list-unstyled">
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                               <li>
                                   <a href="#">Settings</a>
                               </li>
                           </ul>
                       </li>       
                   </ul>
               </nav>
            </section>
            <main class="container-fluid main-container__content">

            @yield('top')
            
            <!-- Breadcrumbs -->
            <div class="main-container__content__breadcrumbs">
              <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Modules</li>
              </ol>
            </div>

            @yield('body')

            <!--
               <form action="">
                   <div class='main-container__content__title'>
                        <h2>Module Management</h2>
                        <input type="submit" value="Add New Module" class='btn btn-add'>
                    </div>
                    <div class="main-container__content__breadcrumbs">
                        <ol class="breadcrumb">
                          <li><a href="#">Home</a></li>
                          <li class="active">Modules</li>
                        </ol>
                    </div>
                    <div class='main-container__content__info'>
                        <h5>Modules Installed: 8</h5>
                        <div class="table-responsive">
                            <table class="table table--module">
                                <thead>
                                    <tr>
                                        <th>Modules</th>
                                        <th>Status</th>
                                        <th>Toggle Switch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dashboard</td>
                                        <td>Enabled</td>
                                        <td><input type="checkbox" name="my-checkbox" checked></td>
                                    </tr>
                                    <tr>
                                        <td>Pages</td>
                                        <td>Enabled</td>
                                        <td><input type="checkbox" name="my-checkbox" checked></td>
                                    </tr>
                                    <tr>
                                        <td>Banner</td>
                                        <td class='module--disabled'>Disabled</td>
                                        <td><input type="checkbox" name="my-checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>News</td>
                                        <td class='module--disabled'>Disabled</td>
                                        <td><input type="checkbox" name="my-checkbox"></td>
                                    </tr>
                                    <tr>
                                        <td>Media</td>
                                        <td>Enabled</td>
                                        <td><input type="checkbox" name="my-checkbox" checked></td>
                                    </tr>
                                    <tr>
                                        <td>Editor</td>
                                        <td>Enabled</td>
                                        <td><input type="checkbox" name="my-checkbox" checked></td>
                                    </tr>
                                    <tr>
                                        <td>Users</td>
                                        <td>Enabled</td>
                                        <td><input type="checkbox" name="my-checkbox" checked></td>
                                    </tr>
                                    <tr>
                                        <td>Settings</td>
                                        <td>Enabled</td>
                                        <td><input type="checkbox" name="my-checkbox" checked></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="main-container__content__info__options__action-holder">
                            <input type="submit" class="btn btn-add" value="Save Changes">
                        </div>
                    </div>
                   
               </form> -->
            </main>
            
        </div>
        <footer class='footer footer--fixed'>
            <small class='copyright'>&copy; 2015 Yondu Website Service</small>
        </footer>
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/bootstrap-switch.min.js"></script>
        <script src="js/main.js"></script>

        @yield('scripts')
    </body>
</html>
