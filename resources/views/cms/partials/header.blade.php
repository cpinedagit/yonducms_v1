<header class='container-fluid header header--fixed'>
   <div class="row">
    <div class="pull-left header__logo">
       <!--Change SRC to put logo-->
       <a href="{{ URL().'/cms' }}">
          {!! HTML::image(asset('public/images/'.env('APP_LOGO')), 'CMS Logo', ['class'=>'app_logo_header']); !!}
        </a>
    </div>
    <div class="pull-left header__search">
        <a href="#"><i class="fa fa-globe"></i> View Site</a>
        <div class="input-group">
              <span class="input-group-addon" id="search-icon"><i class="fa fa-search"></i></span>
              <input type="text" class="form-control" placeholder="Search..." id="search">
        </div>
    </div>
    <ul class="pull-right list-unstyled header__menu-list">
        @if(checkAccess(8)>0)
        <li>
          <a href="#" id="notif" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"><i class="fa fa-bell-o"></i></a>
          <div class="dropdown-menu dropdown-menu--notif" role="menu" aria-labelledby="notif">
             @if((bellCounter())>0)
                <h5 class='notif-summary'>You have {{ bellCounter() }} new request/s</h5>
             @endif
             @if(count(notification_lists())==0)
                 <h5 class='notif-summary'>No request found!</h5>
             @endif
             <!-- notif lists -->
             <div class="notif-list">
             <ul class="list-unstyled media-circle-list">
              @foreach (notification_lists() as $user)
                <li>
                    <div class='image-holder'>
                       <div class="circle image-holder__user-pic">
                          @if($user->profile_pic!="")
                            {!! HTML::image("public/images/profile/".$user->profile_pic, "", []) !!}
                          @else
                            {!! HTML::image("public/images/profile/default_pic.png", "", []) !!}
                          @endif
                       </div>
                    </div>
                    <div class='desc-holder'>
                        <p>{{ $user->username }}: {{ $user->first_name." ".$user->last_name }}</p>
                        <p>Change password request</p>
                    </div>
                 </li>              
               @endforeach
             <!-- notif lists -->
             </ul>
            </div>
            </div>
            @if((bellCounter())>0)
              <a href="#" id="notif" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                <span class="badge badge--left">{{ bellCounter() }}</span>
              </a>
            @endif
        </li>
        @endif  
         <li class="header__menu-list__account">
            <div class="dropdown header__menu-list__account__dropdown">
              <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                <div class="circle header__menu-list__account__dropdown__icon">
                  {!! HTML::image('public/images/profile/' . \Auth()->user()->profile_pic, \Auth()->user()->username) !!}
                </div>
               <div class="header__menu-list__account__dropdown__name">
                    <!--Current user firstname-->
                    {{ \Auth()->user()->first_name }}                    
                    <i class="fa fa-chevron-down"></i>
                </div>
              </a>
              <ul class="dropdown-menu header__menu-list__account__dropdown__options" role="menu" aria-labelledby="dLabel">
              <!--Include menu content here-->
                <li class='header__menu-list__account__dropdown__options__acct-info'>
                   <div class="circle header__menu-list__account__dropdown__options_icon">
                      <!-- PUT IMAGE IF AVAILABLE -->
                      {!! HTML::image('public/images/profile/' . \Auth()->user()->profile_pic, \Auth()->user()->username) !!}
                   </div>
                    <div class="header__menu-list__account__dropdown__options_account-name">
                         {{ \Auth()->user()->first_name }}
                    </div>
                    <div class="header__menu-list__account__dropdown__options_account-email">
                         {{ \Auth()->user()->email }}
                    </div>
                </li>
               <li> {!! HTML::link('cms/user/profile','My Profile') !!} </li>
               <li> {!! HTML::link('auth/logout','Log-out') !!} </li>
               <li><a href="#">Help</a></li>
              </ul>
            </div>
        </li>
    </ul>
   </div> 
</header>