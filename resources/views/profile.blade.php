@extends('dashboard',['a' => 'Profile'])
@section('body')
    <div class="row">
        {{--<div class="col-xl-4 order-xl-2">
            <div class="card card-profile">
                <img src="../assets/img/theme/img-1-1000x600.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="../assets/img/theme/team-4.jpg" class="rounded-circle">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-sm btn-info  mr-4 ">Connect</a>
                        <a href="#" class="btn btn-sm btn-default float-right">Message</a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center">
                                <div>
                                    <span class="heading">22</span>
                                    <span class="description">Friends</span>
                                </div>
                                <div>
                                    <span class="heading">10</span>
                                    <span class="description">Photos</span>
                                </div>
                                <div>
                                    <span class="heading">89</span>
                                    <span class="description">Comments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5 class="h3">
                            Jessica Jones<span class="font-weight-light">, 27</span>
                        </h5>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>Bucharest, Romania
                        </div>
                        <div class="h5 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>University of Computer Science
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit profile </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$user->id}}">
                        {{csrf_field()}}
                        <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                @if($user->image)
                                <div class="col-lg-6">
                                    <img src="{{url('/images/user/'.$user->image)}}" alt="Image placeholder" class="card-img-top">
                                </div>
                                @endif
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Upload Photo</label>
                                        <input type="file" id="input-email" class="form-control" name="image" placeholder="jesse@example.com">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">First name</label>
                                        <input type="text" id="input-first-name" class="form-control" placeholder="First name" name="fname" value="{{$user->fname}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Last name</label>
                                        <input type="text" id="input-last-name" class="form-control" placeholder="Last name" name="lname" value="{{$user->lname}}">
                                    </div>
                                </div>
                            </div><div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-city">Gender</label>
                                        <select name="gender" class="form-control" id="">
                                            <option value="male" {{$user->gender =="male" ? 'selected' : ''}}>Male</option>
                                            <option value="female" {{$user->gender =="female" ? 'selected' : ''}}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Date of Birth</label>
                                        <input type="date" id="input-username" class="form-control" placeholder="DOB" name="dob" value="{{$user->dob}}">
                                    </div>
                                </div>
                            </div><div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-country">Password</label>
                                        <input type="password" name="password" value="%change-password-key%" id="input-postal-code" class="form-control" placeholder="">
                                    </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Contact information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Contact Number</label>
                                        <input type="text" name="number" value="{{$user->number}}" id="input-email" class="form-control" placeholder="123123">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Address</label>
                                        <input type="text" id="input-username" class="form-control" placeholder="Address" name="address" value="{{$user->address}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Street</label>
                                        <input type="text" name="street" value="{{$user->street}}" id="input-email" class="form-control" placeholder="Street">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">zipcode</label>
                                        <input type="text" id="input-username" class="form-control" placeholder="zipcode" name="zipcode" value="{{$user->zipcode}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">city</label>
                                        <input type="text" name="city" value="{{$user->city}}" id="input-email" class="form-control" placeholder="city">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">country</label>
                                        <input type="text" id="input-username" class="form-control" placeholder="country" name="country" value="{{$user->country}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email address</label>
                                        <input type="email" name="email" value="{{$user->email}}" id="input-email" class="form-control" placeholder="jesse@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Description -->
                        <h6 class="heading-small text-muted mb-4">About me</h6>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Tell is a little about your self</label>
                                <textarea name="aboutme" rows="4" class="form-control" placeholder="A few words about you ...">{{$user->aboutme}}</textarea>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="form-group">
                                <button class="btn btn-lg btn-primary" style="background-color: #5354CE !important;">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
