@extends("components.layout")


@section('content')
<style>
            #signup .container #signup-row #signup-column #signup-box {
            margin-top: 120px;
            max-width: 600px;
            height: auto;
            border: 1px solid #9C9C9C;
            border-radius:10px;
            background-color: #EAEAEA;
            }

            #signup .container #signup-row #signup-column #signup-box #signup-form {
            padding: 20px;
            }

            #signup .container #signup-row #signup-column #signup-box #signup-form #register-link {
            margin-top: -85px;
            }
</style>

   <div style="  margin: 0;
   padding: 0;
   height: 100vh;">


 <div id="signup">
    <div class="container">
        <div id="signup-row" class="row justify-content-center align-items-center">
            <div id="signup-column" class="col-md-6">
                <div id="signup-box" class="col-md-12">
                    <form id="signup-form" class="form" method="POST" action="/register">
                        @csrf

                        <h3 class="text-center text-info">{{__('translation.register')}}</h3>
                        <div class="form-group">
                            <label for="first_name" class="text-info">{{__('translation.first_name')}}:</label><br>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}"  >
                            @error('first_name')
                            <p class="text-red-500 text-xs mt-2" style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="text-info">{{__('translation.last_name')}}:</label><br>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}"  >
                            @error('last_name')
                            <p class="text-red-500 text-xs mt-2" style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-info">{{__('translation.email')}}:</label><br>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"  >
                            @error('email')
                            <p class="text-red-500 text-xs mt-2" style="color: red">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="password" class="text-info">{{__('translation.password')}}:</label><br>
                            <input type="password" name="password" id="password" class="form-control"  >
                            @error('password')
                            <p class="text-red-500 text-xs mt-2" style="color: red">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-group mt-3">
                            <div class=" d-flex justify-content-between ">

                                <label for="remember-me" class="text-info"><span>{{__('translation.remember_me')}}</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <a href="/login" class="text-info">{{__('translation.login')}}</a>
                            </div>
                            <div class="mt-3">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   </div>

    @endsection
