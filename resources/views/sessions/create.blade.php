
   @extends('components.layout')

   @section('content')
<style>
            #login .container #login-row #login-column #login-box {
            margin-top: 120px;
            max-width: 600px;
            height: auto;
            border: 1px solid #9C9C9C;
            border-radius:10px;
            background-color: #EAEAEA;
            }

            #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
            }

            #login .container #login-row #login-column #login-box #login-form #register-link {
            margin-top: -85px;
            }
</style>

   <div style="  margin: 0;
   padding: 0;
   height: 100vh;">


 <div id="login">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" method="POST" action="/login">
                        @csrf

                        <h3 class="text-center text-info">{{__('translation.login')}}</h3>
                        <div class="form-group">
                            <label for="email" class="text-info">{{__('translation.email')}}:</label><br>
                            <input type="text" name="email" id="email" class="form-control"  value="{{ old('email') }}">
                            @error('email')
                            <p class="text-red-500 text-xs mt-2" style="color: red">{{ $message }}</p>
                        @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="text-info">{{__('translation.password')}}:</label><br>
                            <input type="password" name="password" id="password" class="form-control"  >

                        </div>


                        <div class="form-group mt-3">
                            <div class=" d-flex justify-content-between ">

                                <label for="remember-me" class="text-info"><span>{{__('translation.remember_me')}}</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                <a href="/register" class="text-info">{{__('translation.register')}}</a>
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
