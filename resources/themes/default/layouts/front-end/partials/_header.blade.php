@php($announcement=getWebConfig(name: 'announcement'))

@if (isset($announcement) && $announcement['status']==1)
    <div class="text-center position-relative px-4 py-1 d--none" id="announcement"
         style="background-color: {{ $announcement['color'] }};color:{{$announcement['text_color']}}">
        <span>{{ $announcement['announcement'] }} </span>
        <span class="__close-announcement web-announcement-slideUp">X</span>
    </div>
@endif

<header class="rtl __inline-10">
    <div class="topbar">
        <div class="container">

            <!-- <div>
                <div class="topbar-text dropdown d-md-none ms-auto">
                    <a class="topbar-link direction-ltr" href="tel: {{ $web_config['phone'] }}">
                        <i class="fa fa-phone"></i> {{ $web_config['phone'] }}
                    </a>
                </div>
                <div class="d-none d-md-block mr-2 text-nowrap">
                    <a class="topbar-link d-none d-md-inline-block direction-ltr" href="tel:{{ $web_config['phone'] }}">
                        <i class="fa fa-phone"></i> {{ $web_config['phone'] }}
                    </a>
                </div>
            </div> -->

            <!-- <div>
                @php($currency_model = getWebConfig(name: 'currency_model'))
                @if($currency_model=='multi_currency')
                    <div class="topbar-text dropdown disable-autohide mr-4">
                        <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <span>{{session('currency_code')}} {{session('currency_symbol')}}</span>
                        </a>
                        <ul class="text-align-direction dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} min-width-160px">
                            @foreach (\App\Models\Currency::where('status', 1)->get() as $key => $currency)
                                <li class="dropdown-item cursor-pointer get-currency-change-function"
                                    data-code="{{$currency['code']}}">
                                    {{ $currency->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="topbar-text dropdown disable-autohide  __language-bar text-capitalize">
                    <a class="topbar-link dropdown-toggle" href="#" data-toggle="dropdown">
                        @foreach($web_config['language'] as $data)
                            @if($data['code'] == getDefaultLanguage())
                                <img class="mr-2" width="20"
                                     src="{{theme_asset(path: 'public/assets/front-end/img/flags/'.$data['code'].'.png')}}"
                                     alt="{{$data['name']}}">
                                {{$data['name']}}
                            @endif
                        @endforeach
                    </a>
                    <ul class="text-align-direction dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}}">
                        @foreach($web_config['language'] as $key =>$data)
                            @if($data['status']==1)
                                <li class="change-language" data-action="{{route('change-language')}}" data-language-code="{{$data['code']}}">
                                    <a class="dropdown-item pb-1" href="javascript:">
                                        <img class="mr-2"
                                             width="20"
                                             src="{{theme_asset(path: 'public/assets/front-end/img/flags/'.$data['code'].'.png')}}"
                                             alt="{{$data['name']}}"/>
                                        <span class="text-capitalize">{{$data['name']}}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div> -->
        </div>
    </div>


    <div class="navbar-sticky bg-light mobile-head">
        
        <div class="navbar navbar-expand-md navbar-light">
            <div class="container ">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand d-none d-sm-block mr-3 flex-shrink-0 __min-w-7rem"
                   href="{{route('home')}}">
                    <img class="__inline-11"
                         src="{{ getStorageImages(path: $web_config['web_logo'], type: 'logo') }}"
                         alt="{{$web_config['company_name']}}">
                </a>
                <a class="navbar-brand d-sm-none"
                   href="{{route('home')}}">
                    <img class="mobile-logo-img __inline-12"
                         src="{{ getStorageImages(path: $web_config['mob_logo'], type: 'logo') }}"
                         alt="{{$web_config['company_name']}}"/>
                </a>
                    <div class="input-group-overlay mx-lg-4 search-form-mobile text-align-direction">
    <form action="{{ route('products') }}" type="submit" class="search_form">
        <div class="d-flex justify-content-between align-items-center gap-4">
        <?php
                  $customer = auth('customer')->user();

                  if ($customer) {
                      $address = \App\Models\ShippingAddress::where('customer_id', $customer->id)
                                  ->where('is_primary', 1)
                                  ->first();
                     $shippingAddresses = \App\Models\ShippingAddress::where('customer_id', auth('customer')->id())->latest()->get();

                  } else {
                      $address = null;
                      $shippingAddresses = array();
                  }
              
                ?>
                
            <!-- Location and Country -->
            @if(auth('customer')->check() && $address?->address)
                

                <div class="dropdown">
                            <a class="navbar-tool ml-3" onclick="location.href='{{route('account-address')}}'" type="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                
                                <div class="navbar-tool-text">
                                    <small>
                                        {{ Str::limit($address?->address, 25) }}
                                    </small>
                                    {{$address?->address_type}}
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === "rtl" ? 'left' : 'right' }}" aria-labelledby="dropdownMenuButton">
                                @foreach($shippingAddresses as $add)
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="submitAddressForm({{ $add['id'] }});">
                                        <small>{{ Str::limit($add?->address, 40) }}</small>
                                    </a>
                                @endforeach
                            </div>

                        </div>
                
            @else
                @if(auth('customer')->check())
                    <div id="location-container" onclick="location.href='{{route('account-address')}}'"  class="d-flex align-items-center">
                        <i id="location-icon" class="czi-location text-muted"></i>
                        <span id="location-name" class="text-muted">Loading location...</span>
                    </div>
                @else
                    <div id="location-container" data-toggle="modal" data-target="#myModal" class="d-flex align-items-center">
                        <i id="location-icon" class="czi-location text-muted"></i>
                        <span id="location-name" class="text-muted">Loading location...</span>
                    </div>
                @endif
            @endif

            <!-- Search Input -->
            <input class="form-control appended-form-control search-bar-input" type="search"
                   autocomplete="off" data-given-value=""
                   placeholder="{{ translate('search_for_items') }}..."
                   name="name" value="{{ request('name') }}">

            <!-- Search Button -->
            <button class="input-group-append-overlay search_button d-none d-md-block" type="submit">
                <span class="input-group-text __text-20px">
                    <i class="czi-search text-white"></i>
                </span>
            </button>

            <!-- Close Button for Mobile -->
            <span class="close-search-form-mobile fs-14 font-semibold text-muted d-md-none" type="submit">
                {{ translate('cancel') }}
            </span>
        </div>

        <input name="data_from" value="search" hidden>
        <input name="page" value="1" hidden>

        <!-- Search Result Box -->
        <div class="card search-card mobile-search-card">
            <div class="card-body">
                <div class="search-result-box __h-400px overflow-x-hidden overflow-y-auto"></div>
            </div>
        </div>
    </form>
</div>


    <!-- The Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header" style="background-color:#e3e3e3;border-bottom:solid 1px #bfb6b6 !important;">
            <h5 class="modal-title fs-15 font-bold" id="exampleModalLabel">Choose your location</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- Modal Body -->
          <div class="modal-body">
          <div class="col-md-12 fs-13 mb-4">Select a delivery location to see product availability and delivery options</div>
          <a href="{{route('customer.auth.login')}}" class="btn btn-warning btn-sm btn-circle" style="color:#000000 !important;background-color:#ffd814;border-color:#ffd814;width:100%;">Signin to see your addresses</a>
          </div>
          
        </div>
      </div>
    </div>
<!--                <div class="input-group-overlay mx-lg-4 search-form-mobile text-align-direction">-->
<!--    <form action="{{route('products')}}" type="submit" class="search_form">-->
<!--        <div class="d-flex align-items-center gap-2">-->
            <!-- Location and Country -->
<!--            <div id="location-container" class="d-flex align-items-center">-->
<!--                <i id="location-icon" class="czi-location text-muted"></i>-->
<!--                <span id="location-name" class="text-muted">Loading location...</span>-->
<!--            </div>-->

            <!-- Search Input -->
<!--            <input class="form-control appended-form-control search-bar-input" type="search"-->
<!--                   autocomplete="off" data-given-value=""-->
<!--                   placeholder="{{ translate("search_for_items")}}..."-->
<!--                   name="name" value="{{ request('name') }}">-->

            <!-- Search Button -->
<!--            <button class="input-group-append-overlay search_button d-none d-md-block" type="submit">-->
<!--                <span class="input-group-text __text-20px">-->
<!--                    <i class="czi-search text-white"></i>-->
<!--                </span>-->
<!--            </button>-->

            <!-- Close Button for Mobile -->
<!--            <span class="close-search-form-mobile fs-14 font-semibold text-muted d-md-none" type="submit">-->
<!--                {{ translate('cancel') }}-->
<!--            </span>-->
<!--        </div>-->

<!--        <input name="data_from" value="search" hidden>-->
<!--        <input name="page" value="1" hidden>-->
<!--        <div class="card search-card mobile-search-card">-->
<!--            <div class="card-body">-->
<!--                <div class="search-result-box __h-400px overflow-x-hidden overflow-y-auto"></div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->
<!--</div>-->

                <!--<div class="input-group-overlay mx-lg-4 search-form-mobile text-align-direction">-->
                <!--    <form action="{{route('products')}}" type="submit" class="search_form">-->
                <!--        <div class="d-flex align-items-center gap-2">-->
                <!--            <input class="form-control appended-form-control search-bar-input" type="search"-->
                <!--                   autocomplete="off" data-given-value=""-->
                <!--                   placeholder="{{ translate("search_for_items")}}..."-->
                <!--                   name="name" value="{{ request('name') }}">-->

                <!--            <button class="input-group-append-overlay search_button d-none d-md-block" type="submit">-->
                <!--                    <span class="input-group-text __text-20px">-->
                <!--                        <i class="czi-search text-white"></i>-->
                <!--                    </span>-->
                <!--            </button>-->

                <!--            <span class="close-search-form-mobile fs-14 font-semibold text-muted d-md-none" type="submit">-->
                <!--                {{ translate('cancel') }}-->
                <!--            </span>-->
                <!--        </div>-->

                <!--        <input name="data_from" value="search" hidden>-->
                <!--        <input name="page" value="1" hidden>-->
                <!--        <diV class="card search-card mobile-search-card">-->
                <!--            <div class="card-body">-->
                <!--                <div class="search-result-box __h-400px overflow-x-hidden overflow-y-auto"></div>-->
                <!--            </div>-->
                <!--        </diV>-->
                <!--    </form>-->
                <!--</div>-->

                <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
                    <a class="navbar-tool navbar-stuck-toggler" href="#">
                        <span class="navbar-tool-tooltip">{{ translate('expand_Menu') }}</span>
                        <div class="navbar-tool-icon-box">
                            <i class="navbar-tool-icon czi-menu open-icon"></i>
                            <i class="navbar-tool-icon czi-close close-icon"></i>
                        </div>
                    </a>
                    <div class="navbar-tool open-search-form-mobile d-lg-none {{Session::get('direction') === "rtl" ? 'mr-md-3' : 'ml-md-3'}}">
                        <a class="navbar-tool-icon-box bg-secondary" href="javascript:">
                            <i class="tio-search"></i>
                        </a>
                    </div>
                    <div class="navbar-tool dropdown d-none d-md-block {{Session::get('direction') === "rtl" ? 'mr-md-3' : 'ml-md-3'}}">
                        <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="{{route('wishlists')}}">
                            <span class="navbar-tool-label">
                                <span class="countWishlist">
                                    {{session()->has('wish_list')?count(session('wish_list')):0}}
                                </span>
                           </span>
                            <i class="navbar-tool-icon czi-heart"></i>
                        </a>
                    </div>
                    @if(auth('customer')->check())
                        <div class="dropdown">
                            <a class="navbar-tool ml-3" type="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <div class="navbar-tool-icon-box bg-secondary">
                                        <img class="img-profile rounded-circle __inline-14" alt=""
                                             src="{{ getStorageImages(path: auth('customer')->user()->image_full_url, type: 'avatar') }}">
                                    </div>
                                </div>
                                <div class="navbar-tool-text">
                                    <small>
                                        {{ translate('hello')}}, {{ Str::limit(auth('customer')->user()->f_name, 10) }}
                                    </small>
                                    {{ translate('dashboard')}}
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                 aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                   href="{{route('account-oder')}}"> {{ translate('my_Order')}} </a>
                                <a class="dropdown-item"
                                   href="{{route('user-account')}}"> {{ translate('my_Profile')}}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                   href="{{route('customer.auth.logout')}}">{{ translate('logout')}}</a>
                            </div>
                        </div>
                    @else
                        <div class="dropdown">
                            <a class="navbar-tool {{Session::get('direction') === "rtl" ? 'mr-md-3' : 'ml-md-3'}}"
                               type="button" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <div class="navbar-tool-icon-box bg-secondary">
                                    <div class="navbar-tool-icon-box bg-secondary">
                                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.25 4.41675C4.25 6.48425 5.9325 8.16675 8 8.16675C10.0675 8.16675 11.75 6.48425 11.75 4.41675C11.75 2.34925 10.0675 0.666748 8 0.666748C5.9325 0.666748 4.25 2.34925 4.25 4.41675ZM14.6667 16.5001H15.5V15.6667C15.5 12.4509 12.8825 9.83341 9.66667 9.83341H6.33333C3.11667 9.83341 0.5 12.4509 0.5 15.6667V16.5001H14.6667Z"
                                                  fill="#1B7FED"/>
                                        </svg>

                                    </div>
                                </div>
                            </a>
                            <div class="text-align-direction dropdown-menu __auth-dropdown dropdown-menu-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}"
                                 aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('customer.auth.login')}}">
                                    <i class="fa fa-sign-in mr-2"></i> {{ translate('sign_in')}}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('customer.auth.sign-up')}}">
                                    <i class="fa fa-user-circle mr-2"></i>{{ translate('sign_up')}}
                                </a>
                            </div>
                        </div>
                    @endif
                    <div id="cart_items">
                        @include('layouts.front-end.partials._cart')
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-expand-md navbar-stuck-menu">
            <div class="container px-10px">
                <div class="collapse navbar-collapse text-align-direction" id="navbarCollapse">
                    <div class="w-100 d-md-none text-align-direction">
                        <button class="navbar-toggler p-0" type="button" data-toggle="collapse"
                                data-target="#navbarCollapse">
                            <i class="tio-clear __text-26px"></i>
                        </button>
                    </div>

                    <ul class="navbar-nav d-block d-md-none">
                        <li class="nav-item dropdown {{request()->is('/')?'active':''}}">
                            <a class="nav-link" href="{{route('home')}}">{{ translate('home')}}</a>
                        </li>
                    </ul>

                    @php($categories = \App\Utils\CategoryManager::getCategoriesWithCountingAndPriorityWiseSorting(dataLimit: 11))

                    <ul class="navbar-nav mega-nav pr-lg-2 pl-lg-2 mr-2 d-none d-md-block __mega-nav">
                        <li class="nav-item {{!request()->is('/')?'dropdown':''}}">

                            <a class="nav-link dropdown-toggle category-menu-toggle-btn ps-0"
                               href="javascript:">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M9.875 12.9195C9.875 12.422 9.6775 11.9452 9.32563 11.5939C8.97438 11.242 8.4975 11.0445 8 11.0445C6.75875 11.0445 4.86625 11.0445 3.625 11.0445C3.1275 11.0445 2.65062 11.242 2.29937 11.5939C1.9475 11.9452 1.75 12.422 1.75 12.9195V17.2945C1.75 17.792 1.9475 18.2689 2.29937 18.6202C2.65062 18.972 3.1275 19.1695 3.625 19.1695H8C8.4975 19.1695 8.97438 18.972 9.32563 18.6202C9.6775 18.2689 9.875 17.792 9.875 17.2945V12.9195ZM19.25 12.9195C19.25 12.422 19.0525 11.9452 18.7006 11.5939C18.3494 11.242 17.8725 11.0445 17.375 11.0445C16.1337 11.0445 14.2413 11.0445 13 11.0445C12.5025 11.0445 12.0256 11.242 11.6744 11.5939C11.3225 11.9452 11.125 12.422 11.125 12.9195V17.2945C11.125 17.792 11.3225 18.2689 11.6744 18.6202C12.0256 18.972 12.5025 19.1695 13 19.1695H17.375C17.8725 19.1695 18.3494 18.972 18.7006 18.6202C19.0525 18.2689 19.25 17.792 19.25 17.2945V12.9195ZM16.5131 9.66516L19.1206 7.05766C19.8525 6.32578 19.8525 5.13828 19.1206 4.4064L16.5131 1.79891C15.7813 1.06703 14.5937 1.06703 13.8619 1.79891L11.2544 4.4064C10.5225 5.13828 10.5225 6.32578 11.2544 7.05766L13.8619 9.66516C14.5937 10.397 15.7813 10.397 16.5131 9.66516ZM9.875 3.54453C9.875 3.04703 9.6775 2.57015 9.32563 2.2189C8.97438 1.86703 8.4975 1.66953 8 1.66953C6.75875 1.66953 4.86625 1.66953 3.625 1.66953C3.1275 1.66953 2.65062 1.86703 2.29937 2.2189C1.9475 2.57015 1.75 3.04703 1.75 3.54453V7.91953C1.75 8.41703 1.9475 8.89391 2.29937 9.24516C2.65062 9.59703 3.1275 9.79453 3.625 9.79453H8C8.4975 9.79453 8.97438 9.59703 9.32563 9.24516C9.6775 8.89391 9.875 8.41703 9.875 7.91953V3.54453Z"
                                          fill="currentColor"/>
                                </svg>
                                <span class="category-menu-toggle-btn-text">
                                    {{ translate('categories')}}
                                </span>
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav mega-nav1 pr-md-2 pl-md-2 d-block d-xl-none">
                        <li class="nav-item dropdown d-md-none">
                            <a class="nav-link dropdown-toggle ps-0"
                               href="javascript:" data-toggle="dropdown">
                                <i class="czi-menu align-middle mt-n1 me-2"></i>
                                <span class="me-4">
                                    {{ translate('categories')}}
                                </span>
                            </a>
                            <ul class="dropdown-menu __dropdown-menu-2 text-align-direction">
                                @php($categoryIndex=0)
                                @foreach($categories as $category)
                                    @php($categoryIndex++)
                                    @if($categoryIndex < 10)
                                        <li class="dropdown">

                                            <a <?php if ($category->childes->count() > 0) echo "" ?>
                                               href="{{route('products',['category_id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                                                <span>{{$category['name']}}</span>

                                            </a>
                                            @if ($category->childes->count() > 0)
                                                <a data-toggle='dropdown' class='__ml-50px'>
                                                    <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} __inline-16"></i>
                                                </a>
                                            @endif

                                            @if($category->childes->count()>0)
                                                <ul class="dropdown-menu text-align-direction">
                                                    @foreach($category['childes'] as $subCategory)
                                                        <li class="dropdown">
                                                            <a href="{{route('products',['category_id'=> $subCategory['id'],'data_from'=>'category','page'=>1])}}">
                                                                <span>{{$subCategory['name']}}</span>
                                                            </a>

                                                            @if($subCategory->childes->count()>0)
                                                                <a class="header-subcategories-links"
                                                                   data-toggle='dropdown'>
                                                                    <i class="czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}} __inline-16"></i>
                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    @foreach($subCategory['childes'] as $subSubCategory)
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                               href="{{route('products',['category_id'=> $subSubCategory['id'],'data_from'=>'category','page'=>1])}}">{{$subSubCategory['name']}}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                                <li class="__inline-17">
                                    <div>
                                        <a class="dropdown-item web-text-primary" href="{{ route('categories') }}">
                                            {{ translate('view_more') }}
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item dropdown d-none d-md-block {{request()->is('/')?'active':''}}">
                            <a class="nav-link" href="{{route('home')}}">{{ translate('home')}}</a>
                        </li>

                        @if(getWebConfig(name: 'product_brand'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#"
                                   data-toggle="dropdown">{{ translate('brand') }}</a>
                                <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} scroll-bar">
                                    @php($brandIndex=0)
                                    @foreach(\App\Utils\BrandManager::getActiveBrandWithCountingAndPriorityWiseSorting() as $brand)
                                        @php($brandIndex++)
                                        @if($brandIndex < 10)
                                            <li class="__inline-17">
                                                <div>
                                                    <a class="dropdown-item"
                                                       href="{{route('products',['brand_id'=> $brand['id'],'data_from'=>'brand','page'=>1])}}">
                                                        {{$brand['name']}}
                                                    </a>
                                                </div>
                                                <div class="align-baseline">
                                                    @if($brand['brand_products_count'] > 0 )
                                                        <span class="count-value px-2">( {{ $brand['brand_products_count'] }} )</span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                    <li class="__inline-17">
                                        <div>
                                            <a class="dropdown-item web-text-primary" href="{{route('brands')}}">
                                                {{ translate('view_more') }}
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if ($web_config['discount_product'] > 0)
                            <li class="nav-item dropdown {{request()->is('/')?'active':''}}">
                                <a class="nav-link text-capitalize"
                                   href="{{ route('products', ['data_from' => 'discounted', 'page' => 1]) }}">
                                    {{ translate('discounted_products')}}
                                </a>
                            </li>
                        @endif

                        @if ($web_config['digital_product_setting'] && count($web_config['publishing_houses']) == 1)
                            <li class="nav-item dropdown d-none d-md-block {{request()->is('/')?'active':''}}">
                                <a class="nav-link" href="{{ route('products',['publishing_house_id' => 0, 'product_type' => 'digital', 'page'=>1]) }}">
                                    {{ translate('Publication_House') }}
                                </a>
                            </li>
                        @elseif ($web_config['digital_product_setting'] && count($web_config['publishing_houses']) > 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                    {{ translate('Publication_House') }}
                                </a>
                                <ul class="text-align-direction dropdown-menu __dropdown-menu-sizing dropdown-menu-{{Session::get('direction') === "rtl" ? 'right' : 'left'}} scroll-bar">
                                    @php($publishingHousesIndex=0)
                                    @foreach($web_config['publishing_houses'] as $publishingHouseItem)
                                        @if($publishingHousesIndex < 10 && $publishingHouseItem['name'] != 'Unknown')
                                            @php($publishingHousesIndex++)
                                            <li class="__inline-17">
                                                <div>
                                                    <a class="dropdown-item"
                                                       href="{{ route('products',['publishing_house_id'=> $publishingHouseItem['id'], 'product_type' => 'digital', 'page'=>1]) }}">
                                                        {{ $publishingHouseItem['name'] }}
                                                    </a>
                                                </div>
                                                <div class="align-baseline">
                                                    @if($publishingHouseItem['publishing_house_products_count'] > 0 )
                                                        <span class="count-value px-2">( {{ $publishingHouseItem['publishing_house_products_count'] }} )</span>
                                                    @endif
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                    <li class="__inline-17">
                                        <div>
                                            <a class="dropdown-item web-text-primary"
                                               href="{{ route('products', ['product_type' => 'digital', 'page' => 1]) }}">
                                                {{ translate('view_more') }}
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @php($businessMode = getWebConfig(name: 'business_mode'))
                        @if ($businessMode == 'multi')
                            <!-- <li class="nav-item dropdown {{request()->is('/')?'active':''}}">
                                <a class="nav-link text-capitalize"
                                   href="{{route('vendors')}}">{{ translate('all_vendors')}}</a>
                            </li> -->
                        @endif

                        @if(auth('customer')->check())
                            <li class="nav-item d-md-none">
                                <a href="{{route('user-account')}}" class="nav-link text-capitalize">
                                    {{ translate('user_profile')}}
                                </a>
                            </li>
                            <li class="nav-item d-md-none">
                                <a href="{{route('wishlists')}}" class="nav-link">
                                    {{ translate('Wishlist')}}
                                </a>
                            </li>
                        @else
                            <li class="nav-item d-md-none">
                                <a class="dropdown-item pl-2" href="{{route('customer.auth.login')}}">
                                    <i class="fa fa-sign-in mr-2"></i> {{ translate('sign_in')}}
                                </a>
                                <div class="dropdown-divider"></div>
                            </li>
                            <li class="nav-item d-md-none">
                                <a class="dropdown-item pl-2" href="{{route('customer.auth.sign-up')}}">
                                    <i class="fa fa-user-circle mr-2"></i>{{ translate('sign_up')}}
                                </a>
                            </li>
                        @endif

                        @if ($businessMode == 'multi')
                            @if(getWebConfig(name: 'seller_registration'))
                                <li class="nav-item">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle text-white text-max-md-dark text-capitalize ps-2"
                                                type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ translate('vendor_zone')}}
                                        </button>
                                        <div class="dropdown-menu __dropdown-menu-3 __min-w-165px text-align-direction"
                                             aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item text-nowrap text-capitalize" href="{{route('vendor.auth.registration.index')}}">
                                                {{ translate('become_a_vendor')}}
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-nowrap" href="{{route('vendor.auth.login')}}">
                                                {{ translate('vendor_login')}}
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endif
                    </ul>
                    @if(auth('customer')->check())
                        <div class="logout-btn mt-auto d-md-none">
                            <hr>
                            <a href="{{route('customer.auth.logout')}}" class="nav-link">
                                <strong class="text-base">{{ translate('logout')}}</strong>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="megamenu-wrap">
            <div class="container">
                <div class="category-menu-wrap">
                    <ul class="category-menu">
                        @foreach ($categories as $key=>$category)
                            <li>
                                <a href="{{route('products',['category_id'=> $category['id'],'data_from'=>'category','page'=>1])}}">{{$category->name}}</a>
                                @if ($category->childes->count() > 0)
                                    <div class="mega_menu z-2">
                                        @foreach ($category->childes as $sub_category)
                                            <div class="mega_menu_inner">
                                                <h6>
                                                    <a href="{{route('products',['category_id'=> $sub_category['id'],'data_from'=>'category','page'=>1])}}">{{$sub_category->name}}</a>
                                                </h6>
                                                @if ($sub_category->childes->count() >0)
                                                    @foreach ($sub_category->childes as $sub_sub_category)
                                                        <div>
                                                            <a href="{{route('products',['category_id'=> $sub_sub_category['id'],'data_from'=>'category','page'=>1])}}">{{$sub_sub_category->name}}</a>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                        <li class="text-center">
                            <a href="{{route('categories')}}" class="text-primary font-weight-bold justify-content-center">
                                {{ translate('View_All') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<style>
    /* Styling for the search input */
.search-bar-input {
    width:550px;
    padding: 8px 12px; /* Adjusted padding for a smaller look */
    font-size: 14px; /* Slightly smaller font */
}

/* Location and country container styling */
#location-container {
    display: flex;
    align-items: center;
    gap: 8px; /* Space between the icon and text */
    font-size: 14px; /* Match the font size of the search input */
    color: #6c757d; /* Muted color */
}

/* Styling for location icon */
#location-icon {
    font-size: 16px; /* Adjust icon size */
}

/* Adjusting spacing and alignment for the country name */
#location-name {
    font-weight: 500; /* Medium weight to make it stand out */
}

/* Responsive adjustments for mobile */
@media (max-width: 768px) {
    .search-bar-input {
        width: 150px; /* Smaller width on mobile */
        font-size: 12px; /* Smaller font size */
    }

    #location-container {
        gap: 4px; /* Reduce space on smaller screens */
        font-size: 12px; /* Adjust font size */
    }
}

</style>
@push('script')

<script>
    function submitAddressForm(addressId) {
        // Create a new form element
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('account-address-make-primary') }}';
        form.style.display = 'none';

        // Add CSRF token input
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Add address_id input
        const addressInput = document.createElement('input');
        addressInput.type = 'hidden';
        addressInput.name = 'address_id';
        addressInput.value = addressId;
        form.appendChild(addressInput);

        // Add address_id input
        const addressInputTest = document.createElement('input');
        addressInputTest.type = 'hidden';
        addressInputTest.name = 'header_id';
        addressInputTest.value = addressId;
        form.appendChild(addressInputTest);

        // Append the form to the body and submit
        document.body.appendChild(form);
        form.submit();
    }
</script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyjv0M9sYSqLdyQFeOIwlSrL7F5mj9YTI&libraries=places&callback=initMap" async defer></script>-->

<!--<script>-->
<!--    function getLocation() {-->
<!--        document.getElementById("location-name").innerText = "Loading location...";-->

<!--        if (navigator.geolocation) {-->
<!--            navigator.geolocation.getCurrentPosition(showPosition, handleError);-->
<!--        } else {-->
<!--            document.getElementById("location-name").innerText = "Geolocation not supported";-->
<!--        }-->
<!--    }-->

<!--    function showPosition(position) {-->
<!--        var lat = position.coords.latitude;-->
<!--        var lon = position.coords.longitude;-->

<!--        var geocoder = new google.maps.Geocoder();-->
<!--        var latlng = new google.maps.LatLng(lat, lon);-->

<!--        geocoder.geocode({ 'latLng': latlng }, function(results, status) {-->
<!--            if (status == google.maps.GeocoderStatus.OK && results[0]) {-->
<!--                var country = '';-->
                <!-- // Find the country from the address components -->
<!--                for (var i = 0; i < results[0].address_components.length; i++) {-->
<!--                    var component = results[0].address_components[i];-->
<!--                    if (component.types[0] == "country") {-->
<!--                        country = component.long_name;-->
<!--                        break;-->
<!--                    }-->
<!--                }-->
<!--                document.getElementById("location-name").innerText = country;-->
<!--            } else {-->
<!--                document.getElementById("location-name").innerText = "Unable to determine location";-->
<!--            }-->
<!--        });-->
<!--    }-->

    <!-- // Error callback for geolocation -->
<!--    function handleError(error) {-->
<!--        switch(error.code) {-->
<!--            case error.PERMISSION_DENIED:-->
<!--                document.getElementById("location-name").innerText = "Location access denied. <button id='retry-location' onclick='requestLocationAgain()'>Try again</button>";-->
<!--                break;-->
<!--            case error.POSITION_UNAVAILABLE:-->
<!--                document.getElementById("location-name").innerText = "Location information unavailable";-->
<!--                break;-->
<!--            case error.TIMEOUT:-->
<!--                document.getElementById("location-name").innerText = "Location request timed out";-->
<!--                break;-->
<!--            case error.UNKNOWN_ERROR:-->
<!--                document.getElementById("location-name").innerText = "An unknown error occurred";-->
<!--                break;-->
<!--        }-->
<!--    }-->

    <!-- // Function to request location again if denied -->
<!--    function requestLocationAgain() {-->
        <!-- getLocation(); // Re-attempt fetching the location -->
<!--    }-->

    <!-- // Initialize location fetching on page load -->
<!--    window.onload = function() {-->
<!--        getLocation();-->
<!--    };-->
<!--</script>-->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyjv0M9sYSqLdyQFeOIwlSrL7F5mj9YTI&libraries=places&callback=initMap" async defer></script>

<script>

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, handleError);
        } else {
            document.getElementById("location-name").innerText = "Geolocation not supported";
        }
    }

    // Success callback for geolocation
    function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;

        // Now use Google Maps API to get the country name from latitude and longitude
        var geocoder = new google.maps.Geocoder();

        var latlng = new google.maps.LatLng(lat, lon);
        geocoder.geocode({ 'latLng': latlng }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                console.log(results);
                    var country = '';
                    // Find the country from the address components
                    for (var i = 0; i < results[0].address_components.length; i++) {
                        var component = results[0].address_components[i];
                        if (component.types[0] == "country") {
                            country = component.long_name;
                            break;
                        }
                    }
                    document.getElementById("location-name").innerText = country;
                }
            } else {
                document.getElementById("location-name").innerText = "Unable to determine location";
            }
        });
    }

    // Error callback for geolocation
    function handleError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                document.getElementById("location-name").innerText = "Location access denied";
                break;
            case error.POSITION_UNAVAILABLE:
                document.getElementById("location-name").innerText = "Location information unavailable";
                break;
            case error.TIMEOUT:
                document.getElementById("location-name").innerText = "Location request timed out";
                break;
            case error.UNKNOWN_ERROR:
                document.getElementById("location-name").innerText = "An unknown error occurred";
                break;
        }
    }

    // Initialize location fetching on page load
    window.onload = function() {
        getLocation();
    };
</script>

    <script>
        "use strict";

        $(".category-menu").find(".mega_menu").parents("li")
            .addClass("has-sub-item").find("> a")
            .append("<i class='czi-arrow-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}'></i>");
    </script>
@endpush
