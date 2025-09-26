@csrf
<div class="row mb-4">
    <div class="col">
        <div  class="form-group">
            <label class="form-label fw-bold " for="title">Title</label>
            <input type="text" id="title" class="form-control"  value="{{old('title')}}"  name="title" placeholder="Enter your title"/>
            <span style="color: darkred">@error('title') {{$message}} @enderror</span>
        </div>
    </div>
</div>

<div  class="form-group mb-4">
    <label class="form-label fw-bold" for="email">Description</label>
    <textarea id="description" name="description" class="form-control">{{old('description')}}</textarea>
    <span style="color: darkred">@error('description') {{$message}} @enderror</span>
</div>

<div class="form-group mb-4">
    <label class="form-label fw-bold" for="custom-file">Status</label>
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" style="width: 50px; height: 28px;">
    </div>
</div>


<div class="form-group mb-4">
    <label class="form-label fw-bold" for="custom-file">Image</label>
    <input type="file" class="form-control" id="custom-file" name="image[]" multiple/>
    <div id="image-preview"></div>
</div>



