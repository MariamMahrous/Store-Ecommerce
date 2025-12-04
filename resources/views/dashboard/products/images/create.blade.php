@extends('layouts.admin')

@section('content')


    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('messages.home') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">
                                        {{ __('messages.products') }} </a>
                                </li>
                                <li class="breadcrumb-item active"> {{ __('messages.images_management') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> {{ __('messages.productData') }} </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" action="{{ route('admin.products.images.store') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf


  <input type="hidden" name="product_id" value="{{$id}}">
<h4 class="form-section"><i class="ft-home"></i>{{__('messages.productsImages')}}</h4>


                                            <div class="form-group">

                               
  <div id="dpz-multiple-files" class="dropzone dropzone-area">
<div class="dz-message">

{{__('messages.selectImages')}}
</div>

<br><br>

  </div>


                                               
                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                    onclick="history.back();">
                                                    <i class="ft-x"></i> {{ __('messages.exit') }}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{ __('messages.save') }}
                                                </button>
                                            </div>
                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection
@section('script')
<script>
Dropzone.autoDiscover = false;

var uploadedDocumentMap = {};

var myDropzone = new Dropzone("#dpz-multiple-files", {
    paramName: "dzfile",
    maxFilesize: 5,  
    clickable: true,
    addRemoveLinks: true,
    acceptedFiles: 'image/*',
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    url: "{{ route('admin.products.images.store.folder') }}",
    params: { product_id: "{{ $id }}" },

    success: function(file, response){
        file._uploadedName = response.name;
        $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">');
        uploadedDocumentMap[file.name] = response.name;
    },

    removedfile: function(file){
        if(file.previewElement) {
            file.previewElement.parentNode.removeChild(file.previewElement);
        }

        // Use _uploadedName لتحديد input الصحيح
        var name = file._uploadedName || uploadedDocumentMap[file.name];
        $('form').find('input[name="document[]"][value="' + name + '"]').remove();
    },

    init: function(){
        @if(isset($event) && $event->document)
            var files = {!! json_encode($event->document) !!};
            for(var i in files){
                var file = files[i];

                // إنشاء mockFile للملفات القديمة
                var mockFile = {
                    name: file.file_name,
                    size: file.size || 12345,
                    _uploadedName: file.file_name
                };

                // إضافة الملف للـ Dropzone
                this.emit("addedfile", mockFile);

                // إضافة الصورة كـ thumbnail لو عندك URL
                if(file.url){
                    this.emit("thumbnail", mockFile, file.url);
                }

                mockFile.previewElement.classList.add('dz-complete');

                // ربط بالـ hidden input
                $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">');
            }
        @endif
    }
});
</script>
@stop
