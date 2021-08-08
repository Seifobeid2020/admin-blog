<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
 {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
 <script
 src="https://code.jquery.com/jquery-3.6.0.min.js"
 integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
 crossorigin="anonymous" ></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link ref="stylesheet" href="css/app.css">

    <link href="{{ asset('/app.css') }}" rel="stylesheet" type="text/css" >
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>


    @livewireStyles
     <!-- Bootstrap core js -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

     {{-- CDNs for image 'lightbox2' --}}
     <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css" integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title>Admin User</title>
  </head>

<body style="font-family: Open Sans, sans-serif">

    <section class="">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">





              <a class="navbar-brand" href="/"> {{__('translation.title')}}</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                @auth

                @if(Auth::user()->role=='admin')

                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/users">{{__('translation.users')}}</a>
                  </li>

                @endif


                @endauth
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/blogs">{{__('translation.blogs')}}</a>
                  </li>

                </ul>
                <div class="d-flex ms-auto  justify-content-center align-items-center">
                    <div class="navbar-nav">
                        @if(app()->getLocale() == 'en')
                        <a class="dropdown-item" href="{{route('switchLan','ar')}}"> عربي</a>
                       @else
                       <a class="dropdown-item" href="{{route('switchLan','en')}}"> English</a>
                        @endif
                        {{-- <select class="nav-item form-select form-select-lg" id="select-language" aria-label=".form-select-lg example" >
                            <option selected value="en">En</option>
                            <option value="ar">Ar</option>

                          </select> --}}
                    </div>



                      @auth

                      <div class="font-weight-light " style="margin-right: 5px">{{__('translation.welcome')}}, <b>  {{ auth()->user()->first_name }}</b>! </div>



                    <ul class="navbar-nav ms-5">
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>

                            <ul class="dropdown-menu " style="left: -120px" aria-labelledby="navbarScrollingDropdown">
                              <li><a class="dropdown-item" href="/profile">{{__('translation.profile')}}</a></li>
                              <li><a class="dropdown-item" href="/manageBlogs">{{__('translation.manage_blogs')}}</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li class="d-flex justify-content-center">
                               <form method="POST" action="/logout" class="text-xs font-semibold text-blue-500  ">
                                @csrf

                                <button  type="submit" class="btn btn-primary">{{__('translation.logout')}}</button>
                            </form></li>
                            </ul>

                          </li>
                        </ul>
                    @else
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                        <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="/register">{{__('translation.register')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/login">{{__('translation.login')}}</a>
                        </li>

                    </ul>
                        {{-- <a href="/register" class="text-xs font-bold uppercase">Register</a>
                        <a href="/login" class="ml-6 text-xs font-bold uppercase">Log In</a> --}}
                        @endauth

                    </div>





              </div>
            </div>
          </nav>




    </section>
    <div>
        @yield('content')

    </div>
    <x-flash />
    @livewireScripts


    <script>
        // var selectLanguageElement=    document.getElementById("select-language");
    //     $('#select-language').change(function($event) {
    //         console.log($event.target.value);
    //         var selectLanguageValue =$event.target.value;




    //         console.log('{{csrf_token()}}');
    //         $.ajax({
    //             type: 'POST',  // http method
    //             url:"{{ route('home') }}",
    //             data: { data: selectLanguageValue , _token: '{{csrf_token()}}' },  // data to submit
    //             dataType    : 'json',
    //             success: function (data) {
    //                 location.reload();
    //                 console.log(data);
    //             },
    //             error: function ( errorMessage) {
    //                 console.log(errorMessage);
    //             }
    //         });


    // });
    </script>


</body>
