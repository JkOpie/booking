@extends('layouts')

@push('header')
<header class="page-header page-header-dark bg-gradient-primary-to-secondary mb-4" style="margin-top: 90px">

</header>

@endpush

@push('content')
<style>
    .img-account-profile {
        height: 4rem;
    }
</style>
<div class="container px-4">
    <div class="row">
        <div class="col-xl-4">
            <!-- Profile picture card-->
            <div class="card mb-3">
                <div class="card-header">Profile Picture</div>
                <div class="card-body text-center">
                    <form  action="{{route('users.update-image', Auth::user()->id)}}" method="post" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <!-- Profile picture image-->
                        @if (Auth::user()->image)
                            <img class="img-account-profile rounded-circle mb-2 upload-image" src="/profiles/{{Auth::user()->image}}" alt="">
                        @else
                            <img class="img-account-profile rounded-circle mb-2 upload-image" src="/template/assets/img/illustrations/profiles/profile-1.png" alt="">
                        @endif

                        <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <!-- Profile picture upload button-->
                        <div class="mb-2">
                            <input class="form-control upload" type="file" name="image" required>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">Upload new image</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">
                    <form  action="{{route('users.update', Auth::user()->id)}}" method="post">
                        @method('put')
                        @csrf
                        <!-- Form Group (username)-->
                        <div class="mb-3">
                            <label class="small mb-1" >Username (how your name will appear to other users on the site)</label>
                            <input class="form-control" type="text" placeholder="Enter your username" name="name" value="{{Auth::user()->name}}" required>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" >Email address</label>
                            <input class="form-control" type="email" placeholder="Enter your email address" name="email" value="{{Auth::user()->email}}" required>
                        </div>


                        <div class="mb-3">
                            <label class="small mb-1" >Phone Number</label>
                            <input class="form-control" type="text" placeholder="Enter your phone number Ex:01084144385" name="phone" value="{{Auth::user()->phone}}" required>
                        </div>


                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div>
            {{-- <div class="card mb-4">
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <form action="{{route('profiles.update-password', Auth::user()->id)}}" method="post">
                        @method('put')
                        @csrf
                        <!-- Form Group (username)-->
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label class="small mb-1">Previous Password</label>
                                <input class="form-control" type="password" placeholder="Enter your previous password" name="previous_password" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="small mb-1">Password</label>
                                <input class="form-control" type="password" placeholder="Enter your password" name="password" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="small mb-1">Confirm Password</label>
                                <input class="form-control" type="password" placeholder="Enter your confirm password" name="confirm_password" required>
                            </div>

                        </div>

                        <!-- Save changes button-->
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endpush
