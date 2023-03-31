<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
	<body>
		<div class="container" style= "max-width: 1024;">
        	<table border="0" cellpadding="5" cellspacing="0" style = "width:1024 display:flex !important;">
				<tr>
					<td valign="top" width="70%">
						<table>
                     		<tr>
                        		<td>
									<table width="100%" border="0" align="left" >
										<tr>
											<td>
												<p style="margin-bottom:0px;">
													<span>Date</span>
													<span> {{date('d/m/Y', time())}}</span>
												</p>  
												<p style="margin-top:0px;">
													<span>Proposal for</span>
													<span> @foreach($packages as $package) 
																@if($package->id == $work_name_id )
																	{{$package->work_name_info->work_name }} 
																@endif
															@endforeach
													</span>
												</p>
												<p style="margin:0px;">
													To
												</p>
												<p style="margin:0px;">
													<span>Dear </span>
													<span> {{$prospects->name}}</span>
												</p>
												<p style="margin:0px;">
													<span> {{$prospects->city}}, {{$prospects->state_info->state}}</span>
												</p>
												<p>
													DesignLAB International is pleased to offer you the most competitive proposal. We are
														certain you will find the information in line, apt to your needs. The proposal covers
														our various packages, offers, amount and deadlines
												</p>
											</td>
										</tr>
									</table>
										<p style="text-align: left;"><b>Packages</b></p>
									<table style="margin-top: 15px;  border-spacing: 0; width: 100%;" cellpadding="0" mc:edit="table-1">
										<thead>
											<tr>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">What you provides</th>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">What we deliver</th>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">Rates/
													@foreach($measurements as $measurement) 
														{{ $measurement->measurement_name }} 
													@endforeach
												</th>
											</tr>
										</thead>
										<tbody style="padding-top: 15px;">
											<tr style="margin-bottom: 7px;">
												<td style="padding: 10px; border: 1px solid gray;">
													@foreach($packages as $package) 
												{!! nl2br($package->we_provide) !!}
													@endforeach
												</td>
												<td style="padding: 10px; border: 1px solid gray;">
													@foreach($packages as $package) 
												{!! nl2br($package->we_deliver) !!}
													@endforeach
												</td>
												<td style="padding: 10px; border: 1px solid gray;">
													@foreach($packages as $package)
														@php  $price =  json_decode($package->rate_id); @endphp
														@foreach($rates as $rate)
															@if(in_array($rate->id, $price)  )
																{{$rate->price}} {{'/'}} {{$rate->measurement_name_info['measurement_name']}} ( {{$rate->value}} {{$rate->condition}} {{$rate->measurement_name_info['measurement_name']}} )
															>@endif
														@endforeach
													@endforeach
												</td>                                                        	 			
											</tr>
										</tbody>
									</table>
										<p style="text-align: left;"><b>Project Details</b></p>
									<table style="margin-top: 15px; border-spacing: 0; width: 100%;" cellpadding="0" mc:edit="table-1">
										<thead>
											<tr>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">Project Name</th>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">Project ID</th>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">Rates</th>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">Area 
													@foreach($measurements as $measurement) 
														{{ $measurement->measurement_name }} 
													@endforeach
												</th>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">Amount</th>
												<th style="padding: 10px; border: 1px solid gray; background-color: gray; color: white;">Deadline</th>
											</tr>
										</thead>
										<tbody style="padding-top: 15px;">
											<tr style="margin-bottom: 7px;">	
												<td style="padding: 10px; border: 1px solid gray;">	
													@php $data =  json_encode($Plannig_package_name); @endphp
													@foreach($packages as $package) 
														@if( in_array($package->id, $Plannig_package_name) )
															{!! nl2br($package->Plannig_package_name) !!} 
														@endif
													@endforeach

												</td>
												<td style="padding: 10px; border: 1px solid gray;">{{$package->id}}</td>
												<td style="padding: 10px; border: 1px solid gray;">
													@foreach($rates as $rate)
														@foreach($measurements as $measurement) 
													(INR  {{ $rate->price }}/ {{ $measurement->measurement_name }})
														@endforeach
													@endforeach
												</td>  
												<td style="padding: 10px; border: 1px solid gray;">{{$area}}</td>
												<td style="padding: 10px; border: 1px solid gray;">
													@foreach($packages as $package)
														@php $pcg_rate =  json_decode($package->rate_id); @endphp
														@foreach($rates as $key=>$rate)
															@if($area >= $rate['value']  )
																@php $amount = $area * $rate['price']; @endphp 
																INR{!! nl2br($amount) !!}
															@else
																@php $amount = $area * $rate['price']; @endphp
																INR{!! nl2br($amount) !!}
															@endif	
														@endforeach
													@endforeach 
												                                                     	 			
													
												<td style="padding: 10px; border: 1px solid gray;">
													@php	
														$deadline_day = implode(',', $deadline); 
													@endphp
													{{$deadline_day}}
														
											 </td>                                                       	 			
												                                                       	 			
											</tr>
										</tbody>
									</table>
										<p style="text-align: left;"><b>Bank Details</b> </p>
									<table style="margin-top: 15px; width: 60%; border-spacing: 0;" mc:edit="table-2">
										<tbody style="padding-top: 15px;">
											<tr style="margin-bottom: 7px;">
												<td style="width: 190px; border: 1px solid gray;">Bank</td>
												<td style="width: 190px; border: 1px solid gray;">State Bank of India</td>
											</tr>
											<tr style="margin-bottom: 7px;">
												<td style="width: 190px; border: 1px solid gray;">Branch </td>
												<td style="width: 190px; border: 1px solid gray;">Old Palasia, Indore</td>
											</tr>
											<tr style="margin-bottom: 7px;">
												<td style="width: 190px; border: 1px solid gray;">Account holder name</td>
												<td style="width: 190px; border: 1px solid gray;">DesignLAB</td>
											</tr>
											<tr style="margin-bottom: 7px;">
												<td style="width: 190px; border: 1px solid gray;">Account type</td>
												<td style="width: 190px; border: 1px solid gray;">Current</td>
											</tr>
											<tr style="margin-bottom: 7px;">
												<td style="width: 190px; border: 1px solid gray;">Account number </td>
												<td style="width: 190px; border: 1px solid gray;">316 079 321 62</td>
											</tr>
											<tr style="margin-bottom: 7px;">
												<td style="width: 190px; border: 1px solid gray;">IFS Code</td>
												<td style="width: 190px; border: 1px solid gray;">SBIN 000 3432</td>
											</tr>
										</tbody>
									</table>
									<table style="margin-top: 15px;  border-spacing: 0; width: 100%;" cellpadding="0" mc:edit="table-1">
										<tbody style="padding-top: 15px;">
											<tr>
												<td>
													<p style="margin-top:15px;">
														Deposit amount in the above mentioned bank.
													</p>  
													<p style="margin-top:0px;">
														Design LAB International is a service based company of ABS Group. We enable our
														clients to address the challenging requirements of their customers‚ and build goodwill
														by delivering creative solutions
													</p>
													<p style="margin:0px;">
														Thank you for the opportunity to serve you. We look forward for further communication with you, after you have reviewed the proposal. 
													</p>
													<p style="margin-top:15px;">
														Best Regards
													</p>
													<p style="margin:0px;">
														DesignLAB International
													</p>
													<p>
														Terms:
													</p>
													<p><small> <i>1. GST will be charge on bill.</i>   </small></p>
													<p><small> <i>2. No other hidden charges are applicable on the above mentioned services.</i>   </small></p>
													<p><small> <i>3. E & OE.</i></small></p>
												</td>
											</tr>
										</tbody>
									</table>
										<p><i>Please note that this is a system generated proposal and does not require signature.</i></p>
								</td>
                     		</tr>
                  		</table>
					</td>
					<td  valign="top" style="width:10%; padding: 0px 17px; border-left: 4px solid #b33292; background: #e6e7e9">
						<img width="170px;" src="data:image/png;base64,{{ base64_encode( file_get_contents( storage_path('/app/public/files/1/contect-img.jpg') ))}}">
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>