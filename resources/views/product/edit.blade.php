@extends('layout')
@section('content')


    <form method="POST" enctype="multipart/form-data" id="editUserForm" action="{{ route('product.update', $product->id) }}">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col-12 col-lg-9 col-xl-7">
                        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Edit User</h3>
                                @csrf
                                @method('PUT')
                                @include('product.edit-fields')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="gradient-custom">
            <div class="container py-5 h-100">
                <div class="row justify-content-center align-items-center h-100">
                    <div class="col-12 col-lg-9 col-xl-7">
                        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 p-md-5">
                                <div class="d-flex justify-content-between">
                                    <h4>Product Variants</h4>
                                    <span class="btn btn-info" id="add-variant">Add Product Variant</span>
                                </div>
                                <div class="variant my-2">
                                    @foreach($product->productVarients as $variants)
                                        <div class="row pt-4 one-variant" data-id="{{$variants['id']}}">
                                            <input type="hidden" id="variantEditId" name="variantEditId[]" value="{{$variants['id']}}">
                                            <div class="col">
                                                <label class="text-muted fw-bold">Title</label>
                                                <input type="text" id="variantTitle" class="form-control variant-title"  value="{{$variants['title']}}"  name="variantTitle[]" placeholder="Enter your title"/>
                                                <span style="color: darkred"></span>
                                            </div>
                                            <div class="col">
                                                <label class="text-muted fw-bold">Price</label>
                                                <input type="text" id="price" class="form-control price"  value="{{$variants['price']}}"  name="price[]" placeholder="Enter your price"/>
                                                <span style="color: darkred"></span>
                                            </div>
                                            <div class="col">
                                                <label class="text-muted fw-bold">Sku</label>
                                                <input type="text" id="sku" class="form-control sku"  value="{{$variants['sku']}}"  name="sku[]" placeholder="Enter your sku"/>
                                                <span style="color: darkred"></span>
                                            </div>
                                            <div class="col d-flex align-items-center">
                                                <div class="btn btn-danger delete-variant" data-id="{{$variants['id']}}">Delete</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="d-flex justify-content-center mt-3">
            <button type="button" class="btn btn-primary mb-4 submit-btn " style="width : 50% ;">Update</button>
        </div>
    </form>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.submit-btn', function (e) {
                e.preventDefault();

                let form = $(this).closest('#editUserForm')[0];
                let formData = new FormData(form);
                $('.one-variant').each(function() {
                    let editId = $(this).find('#variantEditId').val();
                    formData.append('editId[]', editId);
                });

                $.ajax({
                    url: "{{route('product.update', $product->id)}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response.error)
                        window.location.href = "{{route('product.index')}}";
                    },
                    error: function (response) {
                        if(response.responseJSON.error){
                            $('.description-error').text(response.responseJSON.error);
                        }

                        let errors = response.responseJSON.errors;

                        if (errors.description) {
                            $('#description').siblings('span').text(errors.description[0]);
                        }

                        if (errors.title) {
                            $('#title').siblings('span').text(errors.title[0]);
                        }

                        for(i=0; i< $('.variant-title').length; i++){
                            if (errors['variantTitle.'+ i]) {
                                console.log("aaa")
                                console.log($($('.variant-title')[i]).siblings('span'))
                                $($('.variant-title')[i]).siblings('span').text(errors['variantTitle.' + i][0]);
                            }
                        }

                        for(i=0; i< $('.price').length; i++){
                            if (errors['price.'+ i]) {
                                $($('.price')[i]).siblings('span').text(errors['price.' + i][0]);
                            }
                        }

                        for(i=0; i< $('.sku').length; i++){
                            if (errors['sku.'+ i]) {
                                $($('.sku')[i]).siblings('span').text(errors['sku.' + i][0]);
                            }
                        }
                    }
                });
            });
            $('#custom-file').on('change', function (e) {
                const files = e.target.files;
                const preview = $('#image-preview');
                preview.empty();
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    if (file.type.startsWith('image')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
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
            $('#description').summernote({
                placeholder: 'Enter Description',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                ]
            })

            $(document).on('click', '#add-variant', function () {
                if ($('.one-variant').length > 3) {
                    $('.variant').addClass('overflow-auto');
                }
                const newVariant = `
                    <div class="row pt-4 one-variant">
                        <div class="col">
                            <label class="text-muted fw-bold">Title</label>
                            <input type="text" id="variantTitle" class="form-control"  value="{{old('variant-title')}}"  name="variantTitle[]" placeholder="Enter your title"/>
                        </div>
                        <div class="col">
                             <label class="text-muted fw-bold">Price</label>
                             <input type="text" id="price" class="form-control"  value="{{old('price')}}"  name="price[]" placeholder="Enter your price"/>
                        </div>
                        <div class="col">
                            <label class="text-muted fw-bold">Sku</label>
                            <input type="text" id="sku" class="form-control"  value="{{old('sku')}}"  name="sku[]" placeholder="Enter your sku"/>
                        </div>
                        <div class="col d-flex align-items-center">
                            <div class="btn btn-danger delete-variant">Delete</div>
                        </div>
                    </div>`;
                $('.variant').append(newVariant)
            });

            $(document).on('click', '.delete-variant', function () {
                    let deleteButton = $(this);
                    let deleteId = $(this).data('id');
                    $.ajax({
                        url: "{{route('variants.delete')}}",
                        method: "GET",
                        data: { id: deleteId },
                        success: function (response) {
                            deleteButton.closest('.one-variant').remove();
                        },
                    })
            })
        });
    </script>
@endsection
