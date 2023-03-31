@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'generateQuotation'
])
@section('content') 
<div class="content">
    <div class="container-fluid"> 
        <div class="row">
            <div class="offset-md-1 col-md-10"> 
                <form  method="post" action="{{route('genquotationCalculation-email')}}"> 
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary bg-primary">
                            <h4 class="card-title text-white text-center" >{{ __('Generate Quotation Calculation FORM') }}</h4>
                        </div>
                        <div class="card-body ml-3 mr-3">
                            <div class="row" >
                                <div class="form-group col-md-6">
                                    <label for="prospect_id">Proprietor Name</label>
                                    <div class="input-container">
                                        <i class="fa fa-user icon"></i>
                                       <select name="prospect_id" class="form-control" id="prospect_id" style="height: 39px;">
                                            <option style="height: 39px;" disabled selected>--Select Proprietor Name--</option>
                                            @if($prospects)
                                            @foreach($prospects as $prospects)
                                                <option value="{{$prospects->id}}" {{old('prospect_id') == $prospects->name ? 'selected': ''}}>{{$prospects->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                        @error('prospect_id')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="work_name_id">Work Name</label>
                                    <div class="input-container">
                                        <i class="fa fa-sitemap icon" ></i>
                                        <select class="form-control" id="work_name_id" name="work_name_id" style="height: 39px;" onclick="displayDivDemo()">
                                            <option style="height:39px;" disabled selected>--Select Work Name--</option>
                                            @if($work_names)
                                            @foreach($work_names as $work_name)
                                                <option value="{{$work_name->id}}" {{old('work_name_id') == $work_name->work_name ? 'selected': ''}}>{{$work_name->work_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                        @error('work_name_id')
                                             <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="area">Area</label>
                                    <div class="input-container">
                                        <i class="fa fa-address-card icon" aria-hidden="true"></i>
                                        <input type="text" class="form-control"  name="area" value="{{old('area')}}"  placeholder="area"> 
                                    </div>
                                        @error('area')
                                             <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="measurement_id">Measurement Name</label>
                                    <div class="input-container">
                                        <i class="fa fa-sitemap icon" ></i>
                                        <select class="form-control" style="height:39px;" name="measurement_id" id="measurement_id">
                                            <option style="height:39px;" disabled selected>--Select Measurement--</option>
                                            @if($measurements)
                                            @foreach($measurements as $measurement)
                                                <option value="{{$measurement->id}}" {{old('measurement_id') == $measurement->measurement_name ? 'selected': ''}}>{{$measurement->measurement_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                        @error('measurement_id')
                                             <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                               
                            </div>
                            <div class="col-md-12"  id="hideValuesOnSelect"  > 
                              <label for="Plannig_package_name">packages Name</label>
                                <div class="row" >
                                 @foreach($packages as $package)
                                       <div class="col-sm-6" style="display:none">
                                        <input type="checkbox" name="Plannig_package_name[]" value="{{$package->id}}" id="{{$package->Plannig_package_name}}"> <label for="{{$package->Plannig_package_name }}">
                                            {{$package->Plannig_package_name}} 
                                            </label>
                                        </div>
                                    @endforeach 
                                    </div>
                                @error('Plannig_package_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12" class="checkbox" >
                            <label><input type="checkbox" class="form-group" value="1" name="email"/> Send Email to Client</label>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <label><input type="checkbox" class="form-group" value="1" name="download_pdf" checked/> Download PDF</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Generate Quotation</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
   function displayDivDemo(id, elementValue) {
      document.getElementById(id).style.display = elementValue.value == 1 ? 'block' : 'none';
   }
</script>
<script>
jQuery(document).on('change','#work_name_id', function () {
    id = jQuery(this).val();
    $.ajax({
        url: "{{route('getpackage')}}", 
        data : {'_token' : "{{ csrf_token() }}",id: id},
        type : 'POST',
        success: function(result){
            console.log(result)
            var Plannig_package_name = $.parseJSON(result);
            var html = '';
            $.each(Plannig_package_name, function( index, value ) {
                html += '<div class="col-sm-6">'+
                                '<input type="checkbox" name="Plannig_package_name[]" value="'+value.id+'"> <label for="'+value.Plannig_package_name+'">'+
                             value.Plannig_package_name+
                                '</label>'+
                               ' <input type="text" name="deadline[]" value="{{old('deadline')}}"  placeholder="Deadline"> '+
                            '</div>';
            });
            $('#hideValuesOnSelect .row').html(html);
        }
    });
});
</script>
@endpush