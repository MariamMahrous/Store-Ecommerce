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
                                <li class="breadcrumb-item active"> {{ __('messages.stock_management') }}
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
                                        <form class="form" action="{{ route('admin.product.stock') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf


  <input type="hidden" name="product_id" value="{{$id}}">



                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i>
                                                    {{ __('messages.stock_management') }} </h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> {{ __('messages.sku') }}
                                                            </label>
                                                            <input type="text" id="name" class="form-control"
                                                                placeholder="  " value="{{ old('sku') }}" name="sku">
                                                            @error('sku')
                                                                <span class="text-danger"> {{ $message }} </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                     <div class="col-md-6">
                                                     <div class="form-group">
                                                            <label for="projectinput2"> {{ __('messages.stock') }}
                                                            </label>
                                                            <select class="select2 form-control" name="manage_stock"  id="manage_stock">
                                                                <optgroup   label="{{ __('messages.Pselecttype') }} ">
                                                             
                                                               
                                                                        <option value="1" >   {{ __('messages.yes') }}</option>
                                                                        <option value="0" selected>   {{ __('messages.no') }}</option>
                                                             
                                                                 </optgroup>

                                                            

                                                            </select>


                                                            @error('manage_stock')
                                                                <span class="text-danger"> {{ $message }} </span>
                                                            @enderror
                                                        </div>

                                                </div>

                                       </div>
                                                <div class="row ">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput2"> {{ __('messages.product_status') }}
                                                            </label>
                                                            <select class="select2 form-control" name="in_stock" >
                                                                <optgroup >
                                                               
                                                               
                                                                        <option value="1">   {{ __('messages.available') }}</option>
                                                                        <option value="0"  >   {{ __('messages.unAvailable') }}</option>
                                                             
                                                                 </optgroup>

                                                            

                                                            </select>


                                                            @error('in_stock')
                                                                <span class="text-danger"> {{ $message }} </span>
                                                            @enderror
                                                        </div>


                                                       
                                                    </div>


  <div class="col-md-6 hidden" id='add_qty_stock' >
                                                        <div class="form-group">
                                                            <label for="projectinput1"> {{ __('messages.qty') }}
                                                            </label>
                                                            <input type="number" id="qty" class="form-control"
                                                                placeholder="  " value="{{ old('qty') }}" name="qty">
                                                            @error('qty')
                                                                <span class="text-danger"> {{ $message }} </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                 


                                               
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
        $('#manage_stock').change(function() {
             if ($(this).val() === '1') {
                $('#add_qty_stock').removeClass('hidden');
            } else {
                $('#add_qty_stock').addClass('hidden');
            }
        });
    </script>
@stop
