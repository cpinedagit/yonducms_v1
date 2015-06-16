      <div class="loader-container">
       <div class="loader">
          <div class="dot dot1"></div>
          <div class="dot dot2"></div>
          <div class="dot dot3"></div>
          <div class="dot dot4"></div>
        </div>
      </div>

<div class="main-container">
  <section class="main-container__navigation-container">
     <div class="main-container__navigation-container__toggle">
           <i class="fa fa-bars" id="nav-toggle"></i>
       </div>
       <div class="main-container__navigation-container__welcome">
           <div class="circle main-container__navigation-container__welcome__icon">
              <!--  Put image here -->
              {!! HTML::image('public/images/profile/' . \Auth()->user()->profile_pic, \Auth()->user()->username) !!}
           </div>
           <div class='main-container__navigation-container__welcome__name'>
               <h4>Welcome</h4>
               <span>{{ \Auth()->user()->username }}!</span>
               <div class="main-container__navigation-container__welcome__name__status">
                   <small>Status</small>
                   <i class="fa fa-circle-o"></i>
                   <span class='status'>Online</span>
               </div>
           </div>
       </div>

        @include('cms.partials.menu');

  </section>
  <main class="container-fluid main-container__content">
    <div class='main-container__content__title'>
      @yield('title')
    </div>
    <div class="main-container__content__breadcrumbs">
      {!! Breadcrumbs::renderIfExists() !!}
    </div>

      @yield('content')
      
  </main>
</div> 