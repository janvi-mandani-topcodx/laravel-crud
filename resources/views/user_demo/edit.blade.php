@extends('layout')
@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Edit User</h3>
                            <form method="POST" enctype="multipart/form-data" id="edit-user-form" action="{{ route('user-demo.update', $userData->id) }}">
                                @csrf
                                @method('PUT')
                                @include('user_demo.edit-fields')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.submit-btn', function (e) {
            e.preventDefault();
            let form = $(this).closest('form')[0];
            let formData = new FormData(form);
            $.ajax({
                url: "{{route('user-demo.update', $userData->id)}}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    window.location.href = "{{route('user-demo.index')}}";
                },
                error:function (response){
                    console.log(response.responseJSON);
                    let errors = response.responseJSON.errors;
                    if (errors.firstName) {
                        $('#first-name').siblings('span').text(errors.firstName[0]);
                    }
                    if (errors.lastName) {
                        $('#last-name').siblings('span').text(errors.lastName[0]);
                    }
                    if (errors.email) {
                        $('#email').siblings('span').text(errors.email[0]);
                    }
                    if (errors.password) {
                        $('#password').siblings('span').text(errors.password[0]);
                    }
                    if (errors.confirmPassword) {
                        $('#confirm-password').siblings('span').text(errors.confirmPassword[0]);
                    }
                    if (errors.hobbie) {
                        $('.hobbies-error').text(errors.hobbie[0]);
                    }
                    if (errors.gender) {
                        $('.gender-error').text(errors.gender[0]);
                    }
                    if (errors.image) {
                        $('#custom-file').siblings('span').text(errors.image[0]);
                    }
                }
            });
        });
            $('#custom-file').on('change', function(e) {
                const files = e.target.files;
                const preview = $('#image-preview');
                preview.empty();
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.startsWith('image')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '150px';
                            img.style.margin = '5px';
                            preview.append(img);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
    </script>
@endsection
