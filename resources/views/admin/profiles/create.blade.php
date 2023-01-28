@extends('template_layouts.master')

@push('headers')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="user"></i></div>
                        User Profiles
                    </h1>
                </div>
            </div>
        </div>
    </div>
</header>
@endpush

@push('content')
<style>
    .img-account-profile {
        height: 6rem;
    }
</style>
<div class="container-fluid px-4">
    <form  action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                            <!-- Profile picture image-->
                            <img class="img-account-profile rounded-circle mb-2 upload-image" src="/template/assets/img/illustrations/profiles/profile-1.png" alt="">
                            <!-- Profile picture help block-->
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <!-- Profile picture upload button-->
                            <div class="mb-2">
                                <input class="form-control upload" type="file" name="image" required>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" >Username (how your name will appear to other users on the site)</label>
                                <input class="form-control" type="text" placeholder="Enter your username" name="name" value="" required>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" >Email address</label>
                                <input class="form-control" type="email" placeholder="Enter your email address" name="email" value="" required>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" >Phone Number</label>
                                <input class="form-control" type="text" placeholder="Enter your phone number Ex:01084144385" name="phone" required>
                            </div>

                            <div class="row">
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
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>

$('.upload').change(function() {
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();

    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.upload-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        $('.upload-image').attr('src', '/fyp/assets/img/illustrations/profiles/profile-1.png');
    }
});
</script>

@endpush
