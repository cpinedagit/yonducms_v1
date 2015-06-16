<div class="masthead masthead--custom home-container">
    <div class="inner">
        {!! HTML::image('public/site/images/sample-main-logo.png','',array('class' => 'img-responsive logo-mini')) !!}

        <nav class="main-nav nav-top-fixed">
            <div class="container">
                <div class="home-container__navigation pull-right tcon tcon-menu--xcross" id="togglenav">
                    <span class="tcon-menu__lines" aria-hidden="true"></span>
                    <span class="tcon-visuallyhidden">toggle menu</span>
                    <!-- <i class="fa fa-bars" id="togglenav"></i>-->
                </div>
                <ul id="menu" class="nav masthead-nav">
                    @if(isset($objMenu))
                    @foreach($objMenu as $siteMenu)

                    <li>
                        <a href="{!! $siteMenu->slug ? $siteMenu->slug : 'http://'.$siteMenu->external_link !!}"> 
                            <span class="link-title">{!! $siteMenu->label !!}</span> 
                            {!! parentCssElement($siteMenu->menu_id, 'caret') !!}
                        </a> 
                        {!! getSubMenuSite($siteMenu->menu_id) !!}
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </nav>
    </div>
</div>