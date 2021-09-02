<head>
    <!-- FSMS -->
    @php
        $url =  URL::current();
    @endphp
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="{{ $bundle['title'] }}">
    <meta name="description" content="{{ $bundle['detail'] }} ">
    <meta name="author" content="elsecolor">
    <meta property="og:title" content="{{ $bundle['title'] }} ">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:description" content="{{ $bundle['detail'] }}">
    <meta property="og:image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
    <meta itemprop="image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ asset('images/bundle/'.$bundle['preview_image']) }}">
    <meta property="twitter:title" content="{{ $bundle['title'] }} ">
    <meta property="twitter:description" content="{{ $bundle['detail'] }}">
<!-- FSMS -->
</head>


@extends('theme.master')
@section('title', "$bundle->title")
@section('content')

    @include('admin.message')
    <!-- course detail header start -->
    <section id="about-home" class="about-home-main-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="about-home-block text-white">
                        <h1 class="about-home-heading text-white">{{ $bundle['title'] }}</h1>
                        <ul>

                            <ul>
                                <li><a href="#" title="about">{{ __('frontstaticword.Created') }}:
                                        {{ $bundle->user['fname'] }} </a></li>
                                <li><a href="#" title="about">{{ __('frontstaticword.LastUpdated') }}:
                                        {{ date('jS F Y', strtotime($bundle['updated_at'])) }}</a></li>

                            </ul>
                    </div>
                </div>
                <!-- course preview -->
                <div class="col-lg-4">


                    <div class="about-home-product">
                        <div class="video-item hidden-xs">

                            <div class="video-device">
                                @if ($bundle['preview_image'] !== null && $bundle['preview_image'] !== '')
                                    <img src="{{ asset('images/bundle/' . $bundle['preview_image']) }}"
                                        class="bg_img img-fluid" alt="Background">
                                @else
                                    <img src="{{ Avatar::create($bundle->title)->toBase64() }}" class="bg_img img-fluid"
                                        alt="Background">
                                @endif

                            </div>
                        </div>


                        <div class="about-home-dtl-training">
                            <div class="about-home-dtl-block btm-10">
                                @if ($bundle->type == 1)
                                    @if ($bundle->is_subscription_enabled == 1)
                                        <div class="about-home-rate">
                                            <ul>
                                                @php
                                                $currency = App\Currency::first();
                                                @endphp
                                                @if ($bundle->discount_price == !null)
                                                    <li><i
                                                            class="{{ $currency['icon'] }}"></i>{{ $bundle['discount_price'] }}/{{ $bundle->billing_interval }}
                                                    </li>
                                                    <li><span><s><i
                                                                    class="{{ $currency->icon }}"></i>{{ $bundle['price'] }}/{{ $bundle->billing_interval }}</s></span>
                                                    </li>
                                                @else
                                                    <li><i
                                                            class="{{ $currency['icon'] }}"></i>{{ $bundle['price'] }}/{{ $bundle->billing_interval }}
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    @else
                                        <div class="about-home-rate">
                                            <ul>
                                                @php
                                                $currency = App\Currency::first();
                                                @endphp
                                                @if ($bundle->discount_price == !null)
                                                    <li><i
                                                            class="{{ $currency['icon'] }}"></i>{{ $bundle['discount_price'] }}
                                                    </li>
                                                    <li><span><s><i
                                                                    class="{{ $currency->icon }}"></i>{{ $bundle['price'] }}</s></span>
                                                    </li>
                                                @else
                                                    <li><i class="{{ $currency['icon'] }}"></i>{{ $bundle['price'] }}</li>
                                                @endif

                                            </ul>
                                        </div>
                                    @endif
                                    @if (Auth::check())
                                        @if (Auth::User()->role == 'admin')
                                            <div class="about-home-btn btm-20">
                                                <a href="" class="btn btn-secondary"
                                                    title="course">{{ __('frontstaticword.Purchased') }}</a>
                                            </div>
                                        @else


                                            @php
                                            $order = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                            $bundle->id)->first();
                                            @endphp



                                            @if (!empty($order) && $order->status == 1)

                                                <div class="about-home-btn btm-20">
                                                    <a href="" class="btn btn-secondary"
                                                        title="course">{{ __('frontstaticword.Purchased') }}</a>
                                                </div>

                                            @else
                                                @php
                                                $cart = App\Cart::where('user_id', Auth::User()->id)->where('bundle_id',
                                                $bundle->id)->first();
                                                @endphp
                                                @if (!empty($cart))
                                                    <div class="about-home-btn btm-20">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ route('remove.item.cart', $cart->id) }}">
                                                            {{ csrf_field() }}

                                                            <div class="box-footer">
                                                                <button type="submit" class="btn btn-primary"><i
                                                                        class="fa fa-shopping-cart"
                                                                        aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.RemoveFromCart') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="about-home-btn btm-20">
                                                        <form id="demo-form2" method="post"
                                                            action="{{ route('bundlecart', $bundle->id) }}"
                                                            data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <div class="box-footer">
                                                                @if ($bundle->is_subscription_enabled == 1)
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="fa fa-cart-plus"
                                                                            aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.SubscribeNow') }}</button>
                                                                @else
                                                                    <button type="submit" class="btn btn-primary"><i
                                                                            class="fa fa-cart-plus"
                                                                            aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.AddToCart') }}</button>
                                                                @endif
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        <div class="about-home-btn btm-20">
                                            @if ($bundle->is_subscription_enabled == 1)
                                                <a href="{{ route('login') }}" class="btn btn-primary"><i
                                                        class="fa fa-cart-plus"
                                                        aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.SubscribeNow') }}</a>
                                            @else

                                                <a href="{{ route('login') }}" class="btn btn-primary"><i
                                                        class="fa fa-cart-plus"
                                                        aria-hidden="true"></i>&nbsp;{{ __('frontstaticword.AddToCart') }}</a>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <div class="about-home-rate">
                                        <ul>
                                            <li>{{ __('frontstaticword.Free') }}</li>
                                        </ul>
                                    </div>
                                    @if (Auth::check())
                                        @if (Auth::User()->role == 'admin')
                                            <div class="about-home-btn btm-20">
                                                <a href="" class="btn btn-secondary"
                                                    title="course">{{ __('frontstaticword.Purchased') }}</a>
                                            </div>
                                        @else
                                            @php
                                            $enroll = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                            $bundle->id)->first();
                                            @endphp
                                            @if ($enroll == null)
                                                <div class="about-home-btn btm-20">
                                                    <a href="{{ url('bundle/enroll', $bundle->id) }}"
                                                        class="btn btn-primary"
                                                        title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                                </div>
                                            @else
                                                <div class="about-home-btn btm-20">
                                                    <a href="" class="btn btn-secondary"
                                                        title="Cart">{{ __('frontstaticword.Purchased') }}</a>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        <div class="about-home-btn btm-20">
                                            <a href="{{ route('login') }}" class="btn btn-primary"
                                                title="Enroll Now">{{ __('frontstaticword.EnrollNow') }}</a>
                                        </div>
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- course header end -->
    <!-- course detail start -->
    <section id="about-product" class="about-product-main-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="requirements">
                        <h3>{{ __('frontstaticword.Detail') }}</h3>
                        <ul>
                            <li class="comment more">

                                {!! $bundle->detail !!}

                            </li>

                        </ul>
                    </div>

                    <div class="course-content-block btm-30">
                        <h3>{{ __('frontstaticword.CoursesInBundle') }}</h3>
                        <!-- FSMS -->

                        <div class="row" style="padding-bottom:10px">
                            <div class="col-lg-8 col-6">
                                @php
                                // FSMS
                                function convertToHoursMins($time, $format = '%02d:%02d') {
                                    if ($time < 1) {
                                        return;
                                    }
                                    $hours =floor($time / 60);
                                    $minutes = ($time % 60);

                                    return sprintf($format, $hours, $minutes);
                                }

                                $courseCount = count( $bundle['course_id'] )

                                // FSMS
                            @endphp

                            <small> &nbsp; {{ $courseCount . " courses" }}</small>
                            </div>
                            <div class="col-lg-4 col-6">
                                <button type="button" onclick="toggleAllSections()" class="btn btn-link courseToggle"><span
                                        style="color:#0384a3"><strong>Expand all courses</strong></span></button>
                                <button type="button" onclick="toggleAllSections()" class="btn btn-link courseToggle"
                                    style="display:none"><span style="color:#0384a3"><strong>Collapse all
                                            courses</strong></span></button>
                            </div>
                        </div>


                        <!-- FSMS -->

                        <div class="faq-block">
                            <div class="faq-dtl">
                                <div id="accordion" class="second-accordion">
                                    @foreach ($bundle->course_id as $bundles)

                                        @php
                                        $course = App\Course::where('id', $bundles)->first();
                                        @endphp

                                        <div class="card">
                                            <div class="card-header" id="headingTwo{{ $course->id }}">
                                                <div class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#collapseTwo{{ $course->id }}" aria-expanded="false"
                                                        aria-controls="collapseTwo">

                                                        <div class="row">
                                                            <div class="col-lg-8 col-6">
                                                                <a
                                                                    href="{{ route('user.course.show', ['id' => $course->id, 'slug' => $course->slug]) }}">{{ $course->title }}</a>
                                                            </div>

                                                        </div>

                                                    </button>
                                                </div>

                                            </div>

                                            <div id="collapseTwo{{ $course->id }}" class="collapse"
                                                aria-labelledby="headingTwo" data-parent="#accordion">

                                                <div class="card-body">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <td class="class-icon">
                                                                    {{ $course->short_detail }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>



                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- course detail end -->
@endsection


@section('custom-script')
    <script>
        // FSMS
        function toggleAllSections() {
            $("div[id*='collapseTwo']").collapse('toggle');
            $(".courseToggle").toggle();
        }
        // FSMS

    </script>
@endsection