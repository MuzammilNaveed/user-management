@extends('admin.layout.master')
@section('page_title','Setting')
@section('container')

<style>
    .tag {
        width: fit-content !important;
    }

    .bootstrap-tagsinput {
        display: flex !important;
        margin-top: 5px !important;
        box-shadow: none !important;
    }

    .label-info {
        background-color: #6d5eac !important;
    }
    #videoUpload-1 {
        display:none !important;
    }
</style>

<div class="row mt-3">
    <div class="col-md-4">
        <div class="card p-3">
            @if($user->profile_pic != null)
                <img src="{{asset('users')}}/{{$user->profile_pic}}" style="border-radius:100%; width:120px;height:100px" class="img-fluid d-block mx-auto" alt="">
            @else
                <h5 class="text-danger bg-light text-center shadow-sm" style="background: black;
    border-radius: 100%;
    margin: 10px 94px;
    padding: 39px 12px;
    display: flex;
    justify-content: center;
    align-items: center;">No Image </h5>
            @endif
            <span class="badge bg-primary text-white" style="position:absolute; top:20px;right:20px;">Admin</span>
            <h4 class="text-center m-0 p-0 mt-3 mb-2">{{$user->name}}</h4>

            <hr class="m-0 p-0">
            <div class="mt-2">
                <span class="small text-muted">Email Address</span> <br>
                <span class="text-center m-0 p-0"> <a href="mailto:{{$user->email}}">{{$user->email}}</a> </span>
            </div>
            <div class="mt-2">
                <span class="small text-muted">Address</span> <br>
                @if($user->address == null)
                    <span class="text-danger ">Address is missing </span> <br>
                @else
                <p><i class="fas fa-map-marker-alt"></i> {{$user->address}}</p> <br>
                @endif

                @if($user->phone == null)
                    <span class="text-danger ">Phone is missing</span> <br>
                @else
                <p><i class="fas fa-map-marker-alt"></i> {{$user->phone}}</p> <br>
                @endif
            </div>

        </div>

        <div class="card p-3">
            <div class="d-flex justify-content-around">
                <a href="{{$user->facebook}}"> <i class="fab fa-facebook" style="font-size:25px;"></i> </a>
                <a href="{{$user->instagram}}"> <i class="fab fa-instagram" style="font-size:25px;"></i> </a>
                <a href="{{$user->twitter}}"> <i class="fab fa-twitter" style="font-size:25px;"></i> </a>
                <a href="{{$user->linkedin}}"> <i class="fab fa-linkedin-in" style="font-size:25px;"></i> </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-transparent ">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-fillup d-none d-md-flex d-lg-flex d-xl-flex" data-init-reponsive-tabs="dropdownfx">
                <li class="nav-item">
                    <a href="#" class="active" data-toggle="tab" data-target="#slide1"><span>Profile</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="tab" data-target="#slide2"><span>Change Password</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="tab" data-target="#slide3"><span>System Date Format</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="tab" data-target="#slide4"><span>Website</span></a>
                </li>
            </ul>
            <div class="nav-tab-dropdown cs-wrapper full-width d-lg-none d-xl-none d-md-none">
                <div class="cs-select cs-skin-slide full-width" tabindex="0"><span class="cs-placeholder">Hello World</span>
                    <div class="cs-options">
                        <ul>
                            <li data-option="" data-value="#slide1"><span>Home</span></li>
                            <li data-option="" data-value="#slide2"><span>Profile</span></li>
                            <li data-option="" data-value="#slide3"><span>Messages</span></li>
                            <li data-option="" data-value="#slide4"><span>website</span></li>
                        </ul>
                    </div><select class="cs-select cs-skin-slide full-width" data-init-plugin="cs-select">
                        <option value="#slide1" selected="">Home</option>
                        <option value="#slide2">Profile</option>
                        <option value="#slide3">Messages</option>
                        <option value="#slide4">website</option>
                    </select>
                    <div class="cs-backdrop"></div>
                </div>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">

                <div class="tab-pane slide-left active" id="slide1">
                    <div class="col-md-12">
                        <form id="addRecord" enctype="multipart/form-data" autocomplete="off">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Name <span class="text-danger">*</span> </label>
                                        <input name="name" type="text" value="{{$user->name}}" class="form-control input-sm" placeholder="User Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default bg-light">
                                        <label class="small text-muted">Email Address <span class="text-danger">*</span></label>
                                        <input name="email" type="email" value="{{$user->email}}" class="form-control input-sm" placeholder="User Email Address" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Phone</label>
                                        <input name="phone" type="text" value="{{$user->phone}}" class="form-control input-sm" placeholder="User Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Address</label>
                                        <input name="address" type="text" value="{{$user->address}}" class="form-control input-sm" placeholder="User Full Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-8">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">FaceBook</label>
                                        <input name="facebook" type="text" value="{{$user->facebook}}" class="form-control input-sm" placeholder="User Facebook Link">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Linkedin</label>
                                        <input name="linkedin" type="text" value="{{$user->linkedin}}" class="form-control input-sm" placeholder="User Linkedin Link">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Instagram</label>
                                        <input name="instagram" type="text" value="{{$user->instagram}}" class="form-control input-sm" placeholder="User Linkedin Link">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Twitter</label>
                                        <input name="twitter" type="text" value="{{$user->twitter}}" class="form-control input-sm" placeholder="User Linkedin Link">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="file" class="form-control dropify" data-default-file="{{asset('users')}}/{{$user->profile_pic}}" name="profile_pic" data-allowed-file-extensions="png jpg jpeg">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <button id="save" type="submit" class="btn btn-primary btn-lg mr-2">Save</button>
                                <button id="process" style="display:none" type="button" class="btn btn-primary btn-lg" disabled><i class="fas fa-circle-notch fa-spin mr-1"></i> Processing</button>
                                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</button>
                            </div>


                        </form>
                    </div>
                </div>

                <div class="tab-pane slide-left" id="slide2">
                    <div class="col-md-12">
                        <form id="changePasswordForm" method="POST" action="{{url('change_password')}}" enctype="multipart/form-data" autocomplete="off">
                            <div class="row mt-2">
                                <div class="form-group form-group-default">
                                    <label class="small text-muted">Old Password <span class="text-danger">*</span> </label>
                                    <input id="old_password" name="old_password" type="text" class="form-control input-sm" placeholder="Your Old Password">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">New Password <span class="text-danger">*</span></label>
                                        <input name="password" id="password" type="text" class="form-control input-sm" placeholder="Your New Password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Confirm Password <span class="text-danger">*</span></label>
                                        <input id="confirm_password" type="text" class="form-control input-sm" placeholder="Confirm Your Password">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <button id="save" type="submit" class="btn btn-primary btn-lg mr-2">Save</button>
                                <button id="process" style="display:none" type="button" class="btn btn-primary btn-lg" disabled><i class="fas fa-circle-notch fa-spin mr-1"></i> Processing</button>
                                <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cancel</button>
                            </div>


                        </form>
                    </div>
                </div>

                <div class="tab-pane slide-left" id="slide3">
                    <div class="col-md-12">
                        <form id="saveRecord" onsubmit="return false">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="sys_dt_frmt">Date Format</label>
                                        <select name="sys_dt_frmt" id="sys_dt_frmt" class="form-control">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" id="saveBtn" onclick="saveSystemDateAndTime()" class="btn btn-success">Save</button>
                            <button style="display:none" id="processing" class="btn btn-success" type="button" disabled><i class="fas fa-circle-notch fa-spin"></i> Processing</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane slide-left" id="slide4">
                    <div class="col-md-12">
                        <form id="settingForm" method="POST" action="{{url('save_setting')}}" enctype="multipart/form-data" >
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Website Name <span class="text-danger">*</span> </label>
                                        <input name="site_name" value="{{$setting != null ? $setting->site_name : '-' }}" type="text" class="form-control input-sm" placeholder="Website Name">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image" class="small font-weight-bold text-dark">Dashboard Logo</label>
                                        <input type="file" class="form-control dropify" name="dashboard_logo" data-height="150" data-default-file="{{asset('settings')}}/{{ $setting != null ? $setting->dashboard_logo : '-'}}">
                                    </div>
                                </div>
                            </div>

                            
                            <button type="submit" id="sysBtn" class="btn btn-success btn-lg">Save</button>
                            <button style="display:none" id="sys_process" class="btn btn-success btn-lg" type="button" disabled><i class="fas fa-circle-notch fa-spin"></i> Processing</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


@endsection

@section('scripts')
<script src="{{asset('admin/js/settings.js')}}"></script>
<script>

    $("#site_keywords").tagsinput('items')
    $('.dropify').dropify({
        messages: {
            'default': 'Upload Image',
            'replace': 'Drag and drop or click to replace',
            'remove': 'Remove',
            'error': 'Ooops, something wrong happended.'
        }
    });

    var today = new Date();
    var dt_option = ``;
    var format1 = moment(today).format('DD-MM-YYYY');
    var format2 = moment(today).format('DD/MM/YYYY');
    var format3 = moment(today).format('DD/MM/YY');
    var format4 = moment(today).format('Do MMMM YYYY');
    var format5 = moment(today).format('DD.MM.YYYY');
    var format6 = moment(today).format('MM/DD/YYYY');

    var arr = [{
            frmt: "DD/MM/YYYY",
            date: format2
        },
        {
            frmt: "DD-MM-YYYY",
            date: format1
        },
        {
            frmt: "'DD/MM/YY",
            date: format3
        },
        {
            frmt: "Do MMMM YYYY",
            date: format4
        },
        {
            frmt: "DD.MM.YYYY",
            date: format5
        },
        {
            frmt: "MM/DD/YYYY",
            date: format6
        },
    ]

    for (var i = 0; i < arr.length; i++) {
        dt_option += `<option value="` + arr[i].frmt + `" ` + (arr[i].frmt == arr[5].frmt ? "selected" : '-') + `> ` + arr[i].frmt + ` ` + " e.g. " + `    ` + arr[i].date + `</option>`;
    }

    $("#sys_dt_frmt").html(dt_option);
</script>
@show