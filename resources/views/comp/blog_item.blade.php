<div class="col-xl-4 col-md-6 mb-30">
    <div class="ca-team-box ca-blg-box-3 cream-bg-3 br-7 fix p-relative z-index-1">
       <div class="ca-team-img">
          <img class="w-100" src="{{ asset('uploads/' . $item->image) }}" alt="">
       </div>
       <div class="ca-blog-date-3 ca-blg-date-3">
          <a href="#" class="blg-date-3">{{ $item->created_at->translatedFormat('M d, Y') }}</a>
       </div>
       <div class="ca-blog-box-content ca-blog-box-content-3">
          <div class="ca-b-meta">
             <!-- blog meta box -->
             <a href="@localizedRoute('blogShow', ['category' => Str::lower($item->category->title), 'slug' => $item->slug])" class="ca-blog-meta ca-blog-meta-3">
                <div class="ca-meta-icon">
                   <span><img src="{{ asset('assets/img/icon/tag-1.1.svg') }}" alt="arc asl lojistik"></span>
                </div>
                <div class="ca-meta-title">
                   <span>{{ $item->category->title }}</span>
                </div>
             </a>
          </div>
          <h4 class="ca-blog-title ca-blog-title-3 fnw-600"><a href="@localizedRoute('blogShow', ['category' => Str::lower($item->category->title), 'slug' => $item->slug])">{{ $item->title }}</a></h4>
          <p class="pt-16 pb-18">{{ Str::of(strip_tags($item->description))->limit(90) }}</p>
          <div class="blog-3-rearmore">
             <a href="@localizedRoute('blogShow', ['category' => Str::lower($item->category->title), 'slug' => $item->slug])" class="read-more3">{{ Helper::translate('read_more') }} <span><i class="fa-solid fa-angle-right"></i></span></a>
          </div>
       </div>
    </div>
 </div>