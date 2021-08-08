
<div>
    {{-- Because she competes with no one, no one can compete with her. --}}


    <div class="container">
        <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="account-settings">
                    <div class="user-profile">
                        <div class="user-avatar">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
                        </div>
                        <h5 class="user-name">
                            {{ ($userDetails['first_name'] && $userDetails['last_name']) ? ($userDetails['first_name']  .' '. $userDetails['last_name']) : '---' }}

                        </h5>
                        <h6 class="user-email">  {{ $userDetails['email'] }} </h6>
                    </div>
                    <div class="about">
                        <h5>About</h5>
                        <p>I'm Yuki. Full Stack Designer I enjoy creating user-centric, delightful and human experiences.</p>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
        <div class="card h-100">
            <div class="card-body">
                <form wire:submit.prevent="update(Object.fromEntries(new FormData($event.target)))">
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h6 class="mb-2 text-primary">{{__("translation.personal_details")}}</h6>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">

                                <label for="first_name">{{__('translation.first_name')}}</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"  wire:model.defer="userDetails.first_name">
                                @error('userDetails.first_name')
                                <p class="help is-danger">{{$message}}</p>

                                @enderror

                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="last_name">{{__("translation.last_name")}}</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"  wire:model.defer="userDetails.last_name" placeholder="Enter last name">
                                @error('userDetails.last_name')
                                <p class="help is-danger">{{$message}}</p>

                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="eMail">{{__("translation.email")}}</label>
                                <input type="email" class="form-control" id="eMail" name="email" wire:model.defer="userDetails.email"  placeholder="Enter email ID">
                                @error('userDetails.email')
                                <p class="help is-danger">{{$message}}</p>

                                @enderror
                            </div>
                        </div>
                        {{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone"   placeholder="Enter phone number">
                            </div>
                        </div> --}}

                    </div>

                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="text-right d-flex justify-content-end">
                                {{-- <button type="button"  class="btn btn-secondary">{{__("translation.cancel")}}</button> --}}
                                <button type="submit" class="btn btn-primary">{{__("translation.update")}}</button>
                            </div>
                        </div>
                    </div>

                </form>
                <hr>
                <div  class="change_password">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <h6 class="mb-2 text-primary">{{__("translation.change_password")}}</h6>
                    </div>
                    <form wire:submit.prevent="updatePassword(Object.fromEntries(new FormData($event.target)))">
                        <div class="row gutters justify-content-md-center">

                            <div class="col-12">

                                <div class="form-group ">

                                    <label for="old_password">{{__('translation.old_password')}}</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password"  wire:model.defer="oldPassword">
                                    @error('oldPassword')
                                    <p class="help is-danger">{{$message}}</p>

                                    @enderror

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="new_password">{{__("translation.new_password")}}</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password"  wire:model.defer="newPassword" placeholder="Enter new password">
                                    @error('newPassword')
                                    <p class="help is-danger">{{$message}}</p>

                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="confirm_password">{{__("translation.confirm_password")}}</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" wire:model.defer="confirmPassword"  placeholder="confirm password">
                                    @error('confirmPassword')
                                    <p class="help is-danger">{{$message}}</p>

                                    @enderror
                                    <p class="help is-danger"></p>
                                </div>
                            </div>
                            @error('error')
                            <p class="help is-danger">{{$message}}</p>
                            @enderror
                            @error('success')
                            <p style="color: green">{{$message}}</p>
                            @enderror


                        </div>

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right d-flex justify-content-end">
                                    {{-- <button type="button"  class="btn btn-secondary">{{__("translation.cancel")}}</button> --}}
                                    <button type="submit" class="btn btn-primary">{{__("translation.update")}}</button>
                                </div>
                            </div>
                        </div>

                    </form>


                </div>

            </div>
        </div>
        </div>
        </div>
        </div>



</div>


