@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('status'))

    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div id="error-messages"></div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create the Sub user') }}</div>

                <div class="card-body">
                    <form id="sub_user_create" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Plesae enter the name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Plesae enter the Email">

                        </div>

                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" id="contact_number" placeholder="Plesae enter the Contact Number">

                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" name="gender" type="radio" id="exampleRadios1" value="1">
                                <label class="form-check-label" for="exampleRadios1">
                                    Male
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="gender" type="radio" id="exampleRadios1" value="0">
                                <label class="form-check-label" for="exampleRadios1">
                                    FeMale
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="profile_photo">Profile Photo</label>
                            <input type="file" name="profile_photo" class="form-control" id="profile_photo">

                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Hobbies</label>
                            <br>
                            @foreach($hobbie as $hobbies)
                            <input type="checkbox" name="hobbie[]" class="form-check-input" id="" value="{{$hobbies->id}}">
                            <label class="form-check-label" for="exampleCheck1">{{$hobbies->name}}</label>

                            @endforeach

                        </div>
                        <div class="form-group">
                            <label for="country-dd">Country</label>
                            <select class="form-control" name="country" id="country-dd">
                                <option value="">Select Country</option>
                                @foreach($contry as $contrys)
                                <option value="{{$contrys->country_id}}">{{$contrys->country_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="state-dd">State</label>
                            <select class="form-control" name="state" id="state-dd">
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city-dd">City</label>
                            <select class="form-control" name="city" id="city-dd">
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#country-dd').on('change', function() {
            var idCountry = this.value;
            $("#state-dd").html('');
            $.ajax({
                url: "{{url('/fetch-states')}}",
                type: "POST",
                data: {
                    country_id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#state-dd').html('<option value="">Select State</option>');
                    $.each(result.states, function(key, value) {
                        $("#state-dd").append('<option value="' + value
                            .id_state + '">' + value.state + '</option>');
                    });
                    $('#city-dd').html('<option value="">Select City</option>');
                }
            });
        });
        $('#state-dd').on('change', function() {
            var idState = this.value;
            $("#city-dd").html('');
            $.ajax({
                url: "{{url('/fetch-cities')}}",
                type: "POST",
                data: {
                    state_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(res) {
                    $('#city-dd').html('<option value="">Select City</option>');
                    $.each(res.cities, function(key, value) {
                        $("#city-dd").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });

        $.validator.addMethod('image', function(value, element) {
            // Allow empty value (no file selected) to pass validation
            if (value === '') {
                return true;
            }

            // Check if the file is an image by checking the file extension
            var extension = value.split('.').pop().toLowerCase();
            return extension === 'jpg' || extension === 'jpeg' || extension === 'png';
        }, 'Please select a valid image file (jpg, jpeg, png)');

        $("#sub_user_create").validate({

            rules: {
                name: {
                    required: true,
                    maxlength: 30
                },
                email: {
                    required: true,
                    email: true
                },
                contact_number: {
                    required: true,
                    maxlength: 10,
                    digits: true
                },
                gender: {
                    required: true,
                },
                profile_photo: {
                    required: true,
                    image: true
                },
                country: {
                    required: true,
                },
                state: {
                    required: true,
                },
                city: {
                    required: true,
                },
                'hobbie[]': {
                    required: true,
                    minlength: 2
                }

            },
            messages: {

                name: {
                    required: "Please enter name",
                },
                email: {
                    required: "Please enter valid email",
                },
                contact_number: {
                    required: "Please enter Contact Number",
                },
                gender: {
                    required: "Please select gender",
                },
                profile_photo: {
                    required: "Please select images",
                },
                country: {
                    required: "Please select  country",
                },
                state: {
                    required: "Please select  state",
                },
                city: {
                    required: "Please select  city",
                },
                'hobbie[]': {
                    required: "Please select the hobbie",
                    minlength: "Value must be at least 2"
                }
            },
            submitHandler: function(form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "/create-sub-user",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response.messsage);
                        window.location.href = response.url;
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        console.log(errors);
                        return false;
                        var errorHtml = '<ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul>';
                        $('#error-messages').html(errorHtml);
                    }
                });

            }
        })
    });
</script>
@endsection