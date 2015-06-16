<div class="col-md-12">
  Featured News
    <ul>
      @foreach($featured_news as $news)
      <li>{!! HTML::linkAction('Site\NewsController@preview',  $news->news_title , array($slug,$news->slug)) !!}</li>
      @endforeach
    </ul>
</div>