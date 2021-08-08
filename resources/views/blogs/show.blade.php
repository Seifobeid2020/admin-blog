@extends('components.layout')
@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap');

        .header {
            padding: 30px;
            font-size: 40px;
            text-align: center;
            background: rgb(236, 236, 236);
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 250px;
            position: relative;
            margin: auto;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .activeSlider,
        .dot:hover {
            background-color: #717171;
        }

        .user-avatar img {
            width: 90px;
            height: 90px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
        }

        .rating-user-name {
            font-weight: bold;
            font-size: 20px
        }

        .rating-publish-date {
            font-size: 14px;
            color: rgb(119, 119, 119)
        }

        .rating-content {
            font-size: 16px;
        }

        .checked {
            color: orange;
        }


        .rating-container {
            width: 400px;
            margin: 0 auto;
            background-color: #e0dfdf;
            padding: 4px;
            border-radius: 10px;

        }

        .inner {
            padding: 1em;
            background-color: rgb(255, 217, 160);
            overflow: hidden;
            position: relative;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            border-radius: 10px;
        }

        .rating {
            float: left;
            width: 45%;
            margin-right: 5%;
            text-align: center;
        }

        .rating-num {
            color: #333333;
            font-size: 72px;
            font-weight: 100;
            line-height: 1em;
        }

        .rating-stars {
            font-size: 20px;
            color: #E3E3E3;
            margin-bottom: .5em;
        }

        .rating-stars .active {
            color: #737373;
        }

        .rating-users {
            font-size: 14px;
        }

        .histo {
            float: left;
            width: 50%;
            font-size: 13px;
        }

        .histo-star {
            float: left;
            padding: 3px;

        }

        .histo-rate {
            width: 100%;
            display: block;
            clear: both;
        }

        .bar-block {
            margin-left: 5px;
            color: black;
            display: block;
            float: left;
            width: 75%;
            position: relative;
        }

        .bar {
            padding: 4px;
            display: block;
        }

        #bar-five {
            width: 0;
            background-color: #9FC05A;
        }

        #bar-four {
            width: 0;
            background-color: #ADD633;
        }

        #bar-three {
            width: 0;
            background-color: #FFD834;
        }

        #bar-two {
            width: 0;
            background-color: #FFB234;
        }

        #bar-one {
            width: 0;
            background-color: #FF8B5A;
        }

        .button-rating-see-more {
            border-radius: 50px;
            border: 2px solid #157380;
            background-color: #919191;
            color: #ffffff;
            cursor: pointer;
            font-size: 17px;
            padding: 15px 30px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 600;
            outline: none;
            margin-bottom: 10px;
        }

        .total-rating {
            border-left: 3px solid #8b8b8b;
            border-radius: 2px;

        }

    </style>

    <div class="container">
        @if (Session::get('locale') == 'en')
            <div class="header">
                <h1>{{ $blog->title }}</h1>
            </div>
            <div class="mt-3">
                <div>
                    <h2>{{ $blog->topic }}</h2>
                    <small>{{ $blog->writer_name }}, <span> {{ $blog->date }}</span></small>
                </div>

                <div class="slideshow-container">

                    @foreach ($blog->images_array as $image)
                        <div class="mySlides ">
                            <div class="numbertext">{{ $loop->index + 1 }} / {{ count($blog->images_array) }}</div>
                            <img src="{{ asset($image) }}" style="width:250px;hight:200px">
                            <div class="text"></div>
                        </div>

                    @endforeach


                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>

                </div>
                <br>

                <div style="text-align:center">
                    @foreach ($blog->images_array as $image)
                        <span class="dot" onclick="currentSlide({{ $loop->index + 1 }})"></span>

                    @endforeach

                </div>

            </div>
            <div class="content">
                {{ $blog->content }}
            </div>
            <div class="row">
                <div class="col-8 file">

                    <embed src="{{ asset($blog->fileURL) }}" width="800px" height="800px" />

                </div>
                <div class="col-4 video">


                    <x-embed url="{{ $blog->videoURL }}" aspect-ratio="16:9" />

                </div>

            </div>
            <div class="mt-5">
                <h1>Rating</h1>
                <hr>
                <div class="row">
                    <div class="col-8">
                        <h5 class="ps-2">Leave a Comment</h5>
                        <hr>
                        <div class="container">
                            @auth
                                @if ($hasThisBlog)
                                    it is your blog
                                @elseif ($commented)
                                    you already commented
                                @else
                                    <form method="post" id="rate">
                                        @csrf
                                        <div class="row">


                                            <div class="col-8">
                                                <textarea name="comment" id="comment" cols="60" rows="7"></textarea>
                                            </div>
                                            <div class="col-4 ">
                                                <div class="container">
                                                    <div class="d-flex flex-column">
                                                        <div class="p-2 stars">
                                                            <span class="fa fa-star checked" id="star-1"></span>
                                                            <span class="fa fa-star " id="star-2"></span>
                                                            <span class="fa fa-star " id="star-3"></span>
                                                            <span class="fa fa-star " id="star-4"></span>
                                                            <span class="fa fa-star " id="star-5"></span>
                                                        </div>
                                                        <input name="star-value" id="starValue" style="display: none" value="1">
                                                        <div class="p-2 ">
                                                            <button class="btn btn-success"> Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </form>
                                @endif

                            @else
                                you need to login

                                <div class="d-flex justify-content-center">
                                    <a href="/login">
                                    <button type="button" href="/login" class="btn btn-primary">
                                       login
                                        </button>
                                    </a>

                                </div>
                            @endauth

                        </div>
                    </div>
                    <div class="col-4 total-rating">
                        <h5 class="ps-2">Total Rating</h5>
                        <hr>
                        <div class="rating-container">
                            <div class="inner">
                                <div class="rating">
                                    <span class="rating-num">{{ $arrayOfRatingTable['averageTotalStars'] }}</span>
                                    <div class="rating-stars">
                                        <span><i class="active icon-star"></i></span>
                                        <span><i class="active icon-star"></i></span>
                                        <span><i class="active icon-star"></i></span>
                                        <span><i class="active icon-star"></i></span>
                                        <span><i class="icon-star"></i></span>
                                    </div>
                                    <div class="rating-users">
                                        <i class="icon-user"></i> {{ $arrayOfRatingTable['totalRatingBlog'] }} total
                                    </div>
                                </div>

                                <div class="histo">
                                    <div class="five histo-rate">
                                        <span class="histo-star">
                                            <i class="active icon-star"></i> 5 </span>
                                        <span class="bar-block">
                                            <span id="bar-five" class="bar">
                                                <span>{{ $arrayOfRatingTable['fiveStar']['totalNumber'] }}</span>&nbsp;
                                            </span>
                                        </span>
                                    </div>

                                    <div class="four histo-rate">
                                        <span class="histo-star">
                                            <i class="active icon-star"></i> 4 </span>
                                        <span class="bar-block">
                                            <span id="bar-four" class="bar">
                                                <span>{{ $arrayOfRatingTable['fourStar']['totalNumber'] }}</span>&nbsp;
                                            </span>
                                        </span>
                                    </div>

                                    <div class="three histo-rate">
                                        <span class="histo-star">
                                            <i class="active icon-star"></i> 3 </span>
                                        <span class="bar-block">
                                            <span id="bar-three" class="bar">
                                                <span>{{ $arrayOfRatingTable['threeStar']['totalNumber'] }}</span>&nbsp;
                                            </span>
                                        </span>
                                    </div>

                                    <div class="two histo-rate">
                                        <span class="histo-star">
                                            <i class="active icon-star"></i> 2 </span>
                                        <span class="bar-block">
                                            <span id="bar-two" class="bar">
                                                <span>{{ $arrayOfRatingTable['twoStar']['totalNumber'] }}</span>&nbsp;
                                            </span>
                                        </span>
                                    </div>

                                    <div class="one histo-rate">
                                        <span class="histo-star">
                                            <i class="active icon-star"></i> 1 </span>
                                        <span class="bar-block">
                                            <span id="bar-one" class="bar">
                                                <span>{{ $arrayOfRatingTable['oneStar']['totalNumber'] }}</span>&nbsp;
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Comments</h5>
                <hr>
                <div class="container">

                    {{-- new code of comments --}}
                    @foreach ($comments as $comment)
                        <div class="row ms-3 mb-5">
                            <div class="col-1">
                                <div class="user-avatar">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                                </div>

                            </div>
                            <div class="col-11">
                                <span class="rating-user-name">{{ $comment->first_name }}&nbsp; {{ $comment->last_name }}
                                </span>
                                <div class="d-flex align-items-center mb-1 ">

                                    @for ($k = 1, $j = $comment->stars; $k <= 5; $k++, $j--)
                                        @if ($j > 0) <span class="fa fa-star
                                        checked"></span>
                                    @else
                                        <span class="fa fa-star "></span> @endif
                                    @endfor
                                    <span class="rating-publish-date"> &nbsp; {{ $comment->created_at }}</span>
                                </div>
                                <div class="rating-content">

                                    {{ $comment->comment }}
                                </div>
                            </div>

                        </div>

                    @endforeach

                    <div class="rating-see-more d-flex align-items-center justify-content-center">

                        <button class="button-rating-see-more">See More</button>
                    </div>
                </div>
            </div>
        @else

        <div class="header">
            <h1>{{ $blog->title_ar }}</h1>
        </div>
        <div class="mt-3">
            <div>
                <h2>{{ $blog->topic_ar }}</h2>
                <small>{{ $blog->writer_ar }}, <span> {{ $blog->date }}</span></small>
            </div>

            <div class="slideshow-container">

                @foreach ($blog->images_array as $image)
                    <div class="mySlides ">
                        <div class="numbertext">{{ $loop->index + 1 }} / {{ count($blog->images_array) }}</div>
                        <img src="{{ asset($image) }}" style="width:250px;hight:200px">
                        <div class="text"></div>
                    </div>

                @endforeach


                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>

            </div>
            <br>

            <div style="text-align:center">
                @foreach ($blog->images_array as $image)
                    <span class="dot" onclick="currentSlide({{ $loop->index + 1 }})"></span>

                @endforeach

            </div>

        </div>
        <div class="content">
            {{ $blog->content_ar }}
        </div>
        <div class="row">
            <div class="col-8 file">

                <embed src="{{ asset($blog->fileURL) }}" width="800px" height="800px" />

            </div>
            <div class="col-4 video">


                <x-embed url="{{ $blog->videoURL }}" aspect-ratio="16:9" />

            </div>

        </div>
        <div class="mt-5">
            <h1>التقيمات</h1>
            <hr>
            <div class="row">
                <div class="col-8">
                    <h5 class="ps-2">اترك تعليق</h5>
                    <hr>
                    <div class="container">
                        @auth
                            @if ($hasThisBlog)
                                انها مدونتك
                            @elseif ($commented)
                               لقد علقت سابقا
                            @else
                                <form method="post" id="rate">
                                    @csrf
                                    <div class="row">


                                        <div class="col-8">
                                            <textarea name="comment" id="comment" cols="60" rows="7"></textarea>
                                        </div>
                                        <div class="col-4 ">
                                            <div class="container">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2 stars">
                                                        <span class="fa fa-star checked" id="star-1"></span>
                                                        <span class="fa fa-star " id="star-2"></span>
                                                        <span class="fa fa-star " id="star-3"></span>
                                                        <span class="fa fa-star " id="star-4"></span>
                                                        <span class="fa fa-star " id="star-5"></span>
                                                    </div>
                                                    <input name="star-value" id="starValue" style="display: none" value="1">
                                                    <div class="p-2 ">
                                                        <button class="btn btn-success"> تسليم</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </form>
                            @endif

                        @else
                            عليك بتسجيل الدخول اولا
                            <div class="d-flex justify-content-center">
                                <a href="/login">
                                    <button type="button" href="/login" class="btn btn-primary">
                                        تسجيل الدخول
                                        </button>
                                    </a>

                            </div>



                        @endauth

                    </div>
                </div>
                <div class="col-4 total-rating">
                    <h5 class="ps-2">مجموع التقيمات</h5>
                    <hr>
                    <div class="rating-container">
                        <div class="inner">
                            <div class="rating">
                                <span class="rating-num">{{ $arrayOfRatingTable['averageTotalStars'] }}</span>
                                <div class="rating-stars">
                                    <span><i class="active icon-star"></i></span>
                                    <span><i class="active icon-star"></i></span>
                                    <span><i class="active icon-star"></i></span>
                                    <span><i class="active icon-star"></i></span>
                                    <span><i class="icon-star"></i></span>
                                </div>
                                <div class="rating-users">
                                    <i class="icon-user"></i> {{ $arrayOfRatingTable['totalRatingBlog'] }} total
                                </div>
                            </div>

                            <div class="histo">
                                <div class="five histo-rate">
                                    <span class="histo-star">
                                        <i class="active icon-star"></i> 5 </span>
                                    <span class="bar-block">
                                        <span id="bar-five" class="bar">
                                            <span>{{ $arrayOfRatingTable['fiveStar']['totalNumber'] }}</span>&nbsp;
                                        </span>
                                    </span>
                                </div>

                                <div class="four histo-rate">
                                    <span class="histo-star">
                                        <i class="active icon-star"></i> 4 </span>
                                    <span class="bar-block">
                                        <span id="bar-four" class="bar">
                                            <span>{{ $arrayOfRatingTable['fourStar']['totalNumber'] }}</span>&nbsp;
                                        </span>
                                    </span>
                                </div>

                                <div class="three histo-rate">
                                    <span class="histo-star">
                                        <i class="active icon-star"></i> 3 </span>
                                    <span class="bar-block">
                                        <span id="bar-three" class="bar">
                                            <span>{{ $arrayOfRatingTable['threeStar']['totalNumber'] }}</span>&nbsp;
                                        </span>
                                    </span>
                                </div>

                                <div class="two histo-rate">
                                    <span class="histo-star">
                                        <i class="active icon-star"></i> 2 </span>
                                    <span class="bar-block">
                                        <span id="bar-two" class="bar">
                                            <span>{{ $arrayOfRatingTable['twoStar']['totalNumber'] }}</span>&nbsp;
                                        </span>
                                    </span>
                                </div>

                                <div class="one histo-rate">
                                    <span class="histo-star">
                                        <i class="active icon-star"></i> 1 </span>
                                    <span class="bar-block">
                                        <span id="bar-one" class="bar">
                                            <span>{{ $arrayOfRatingTable['oneStar']['totalNumber'] }}</span>&nbsp;
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h5>التعليقات</h5>
            <hr>
            <div class="container">

                {{-- new code of comments --}}
                @foreach ($comments as $comment)
                    <div class="row ms-3 mb-5">
                        <div class="col-1">
                            <div class="user-avatar">
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                            </div>

                        </div>
                        <div class="col-11">
                            <span class="rating-user-name">{{ $comment->first_name }}&nbsp; {{ $comment->last_name }}
                            </span>
                            <div class="d-flex align-items-center mb-1 ">

                                @for ($k = 1, $j = $comment->stars; $k <= 5; $k++, $j--)
                                    @if ($j > 0) <span class="fa fa-star
                                    checked"></span>
                                @else
                                    <span class="fa fa-star "></span> @endif
                                @endfor
                                <span class="rating-publish-date"> &nbsp; {{ $comment->created_at }}</span>
                            </div>
                            <div class="rating-content">

                                {{ $comment->comment }}
                            </div>
                        </div>

                    </div>

                @endforeach

                <div class="rating-see-more d-flex align-items-center justify-content-center">

                    <button class="button-rating-see-more">See More</button>
                </div>
            </div>
        </div>




        @endif


    </div>











    <script>
        var slideIndex = 1;

        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");

            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            //   slideIndex++;
            //   if (slideIndex > slides.length) {slideIndex = 1}
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" activeSlider", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " activeSlider";
            //   setTimeout(showSlides, 2000); // Change image every 2 seconds

        }



        $(document).ready(function() {

            //    {{-- $('#rate').submit(function( event ) {
            //         console.log($('#rate').serialize());
            //         event.preventDefault();
            //         });
            // --}}


            function starsPicker(starNumber) {
                for (let i = 0, j = starNumber - 1; i < stars.length; i++, j--) {
                    if (j >= 0) {
                        stars[i].className = 'fa fa-star checked';
                        lastStar = i + 1;
                    } else {
                        stars[i].className = 'fa fa-star';
                    }

                }
                document.getElementById("starValue").value = lastStar;

            }

            var stars = [];
            var lastStar = 1;

            for (let i = 1; i <= 5; i++) {
                stars.push(document.getElementById('star-' + i));

            }
            console.log(stars);
            $('.stars').click(function($event) {
                if ($event.target == stars[0]) {
                    starsPicker(1);
                } else if ($event.target == stars[1]) {
                    starsPicker(2);
                } else if ($event.target == stars[2]) {
                    starsPicker(3);
                } else if ($event.target == stars[3]) {
                    starsPicker(4);
                } else if ($event.target == stars[4]) {
                    starsPicker(5);
                }


            });




            $('.bar span').hide();
            $('#bar-five').animate({
                width: "{{ $arrayOfRatingTable['fiveStar']['starRatio'] }}%"
            }, 1000);
            $('#bar-four').animate({
                width: "{{ $arrayOfRatingTable['fourStar']['starRatio'] }}%"
            }, 1000);
            $('#bar-three').animate({
                width: "{{ $arrayOfRatingTable['threeStar']['starRatio'] }}%"
            }, 1000);
            $('#bar-two').animate({
                width: "{{ $arrayOfRatingTable['twoStar']['starRatio'] }}%"
            }, 1000);
            $('#bar-one').animate({
                width: "{{ $arrayOfRatingTable['oneStar']['starRatio'] }}%"
            }, 1000);

            setTimeout(function() {
                $('.bar span').fadeIn('slow');
            }, 1000);

        });
    </script>


@endsection
