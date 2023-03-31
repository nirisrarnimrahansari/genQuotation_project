@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'package'
])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-md-1 col-md-10"> 
            <form method="post" action="{{route('package.update', [$packages->id])}}"> 
                    @csrf
                    @method('PATCH')
                    <div class="card">
                        <div class="card-header card-header-primary bg-primary">
                            <h4 class="card-title text-white" >{{ __('PACKAGE UPDATE FORM') }}</h4>
                        </div>
                        <div class="card-body ml-3 mr-3">
                            <div class="row" >
                                <div class="form-group col-md-6 ">
                                    <label for="work_name_id">Work Name</label>
                                    <div class="input-container">
                                        <i class="fa fa-building-o icon" aria-hidden="true"></i>
                                        <select class="form-control" id="work_name_id" name="work_name_id" style="height: 39px;" >
                                                <option disabled selected>--Select Work Name--</option>
                                                @if($work_names)
                                                    @foreach ($work_names as $work_name)
                                                        <option value="{{$work_name->id}}" {{ $work_name->id == $packages->work_name_id ? "selected" : ""  }}>{{$work_name->work_name}}</option>
                                                    @endforeach
                                                @endif    
                                        </select>
                                    </div> 
                                    @error('work_name_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror 
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="Plannig_package_name">Package Name</label>
                                    <div class="input-container">
                                        <i class="fa fa-building-o icon" aria-hidden="true"></i>
                                        <input type="text" class="form-control" name="Plannig_package_name" value="{{$packages->Plannig_package_name}}" value="{{old('Plannig_package_name')}}">
                                    </div> 
                                    @error('Plannig_package_name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror 
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="we_provide">What you provide</label>
                                    <div class="input-container">
                                        <i class="fa fa-building-o icon" aria-hidden="true"></i>
                                        <textarea type="text" class="form-control" name="we_provide">{{$packages->we_provide}}</textarea>
                                    </div> 
                                    @error('we_provide')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror 
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="we_deliver">What we deliver</label>
                                    <div class="input-container">
                                        <i class="fa fa-building-o icon" aria-hidden="true"></i>
                                        <textarea type="text" class="form-control" name="we_deliver" >{{$packages->we_deliver}}</textarea>
                                    </div>  
                                    @error('we_deliver')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror 
                                </div> 
                            </div>
                            <div class="row" >
                                <div class="col-md-12"> 
                                    <div class="row" >
                                            @if($packages->rate_id == NULL)
                                                Rate not found
                                            @else
                                                <div class="col-md-12" id="hideValuesOnSelect" > 
                                                    <label for="rate_id">Rate in Units</label> 
                                                    <div class="row" >
                                                    @foreach($rates as $rate)
                                                        @php 
                                                            $rates = DB::table('rates')->select('*')->whereIn('id',json_decode($packages->rate_id))->where('deleted_date', NULL)->get()->toArray();
                                                        if($rates){
                                                            $work_names = DB::table('work_names')->select('work_name')->where('id',$rate->name_id)->where('deleted_date', NULL)->first();
                                                            $measurements = DB::table('measurements')->select('measurement_name')->where('id',$rate->measurement_id)->where('deleted_date', NULL)->first();
                                                             $price = json_decode($packages->rate_id);
                                                             $checked = "";
                                                            if( in_array($rate->id, $price) ){
                                                                $checked = "checked";
                                                          @endphp
                                                        <div class="col-sm-6">
                                                            <input  {{$checked}} type="checkbox" name="rate_id[]"  id="{{$rate->price}}"  
                                                   value="{{$rate->id}}"   @php echo  $rate->id == $packages->rate_id ? 'checked' : '';  @endphp>
                                                            {{$rate->price}} {{'/'}} {{$rate->measurement_name_info['measurement_name']}} {{'('}} {{$rate->value}} {{$rate->condition}} {{$rate->measurement_name_info['measurement_name']}} {{')'}}
                                                        </div>
                                                        @php 
                                                             }   
                                                        }
                                                        @endphp   
                                                         @endforeach  
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    
                                                        </div>
                                                        @error('rate_id')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror 
                                                    </div>
                                            @endif
                                    </div>
                                    @error('rate_id')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror 
                                </div>
                            </div>
                                
                        <div class="form-group col-md-12 ml-2">
                            <button class="btn btn-primary ">Update</button>
                            <a class="btn btn-md fs-1 btn-light" href="/package" >Cancel</a>
                        </div>
                    </div>
                </form>    
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
jQuery(document).on('change','#work_name_id', function () {
    id = jQuery(this).val();
    $.ajax({
        url: "{{route('getrate')}}", 
        data : {'_token' : "{{ csrf_token() }}",id: id},
        type : 'POST',
        success: function(result){
            console.log(result)
            var price_ids = $.parseJSON(result);
            var html = '';
            $.each(price_ids, function( index, value ) {
                html += '<div class="col-sm-6">'+
                                '<input type="checkbox" name="rate_id[]" value="'+value.id+'"> <label>'+
                                   '<i class="fa fa-inr" aria-hidden="true"></i>'+ value.price+' / ' + value.measurement_name_info.measurement_name +' ( ' + value.value +' '+ value.condition +' ' + value.measurement_name_info.measurement_name +')'+
                                '</label>'+
                            '</div>';
            });
            $('#hideValuesOnSelect .row').html(html);
        }
    });
});
</script>
@endpush