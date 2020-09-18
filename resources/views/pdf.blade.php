<style type="text/css">
	@page {
		size: 8.5in 11in;
	}
	table{
		width: 100%;
		border: none;
	}
	table tbody td{
		height: 30px;
		border:1px solid grey;
	}
	table tbody tr.t_header td{
		text-align: center;
		font-weight: bold;
		border-top: 1px solid black;
		border-bottom:  1px solid black;
	}

	.gray{
		color: black !important;
	}
	.font-light{
		font-weight: normal !important;
	}
	table tbody tr.weekend_content td{
		height: 60px;
	}
	td,th{
		text-align: center;
		font-size: 12px;
	}
	table{
		border: none;
	}
</style>
<table cellpadding="0" cellspacing="10" autosize="1">
	<thead>
		<tr>
			<th style="height: 60px; width: 49% !important; font-size: 16px">AMERICAN TERRAZZO CO.</th>
			<th style="height: 60px; width: 50% !important; font-size: 16px">AMERICAN TERRAZZO CO.</th>
		</tr>
	</thead>
	<tbody>
		@for($i = 0; $i < count($data) ; $i+=2)
		<tr>
			<td class="employee-column" style="border: none; height: 100%;vertical-align: top; width: 49% !important">
				<table cellpadding="0" cellspacing="0" autosize="1">
						<thead>
							<tr>
								<th style="width: 50%;">&nbsp;</th>
								<th style="width: 50%;">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th style="text-align:left" >
									NAME: <span class="gray font-light">{{ $data[$i]['fullname'] }}</span>
								</th>
								<th colspan="3">
									WEEK ENDING: <span class="gray font-light">{{ $data[$i]['week_ending'] }}</span>
								</th>
							</tr>
						</tbody>
				</table>				
				<table cellpadding="0" cellspacing="0" autosize="1">
					<thead>
						<tr>
							<th style="width: 28%;">&nbsp;</th>
							<th style="width: 36%;">&nbsp;</th>
							<th style="width: 18%;">&nbsp;</th>
							<th style="width: 18%;">&nbsp;</th>
						</tr>
					</thead>					
					<tbody>
						<tr>
							<td colspan="1">Regular Hours</td>
							<td colspan="3">{{ $data[$i]['regulartime'] }}</td>
						</tr>
						<tr>
							<td>Overtime Hours</td>
							<td colspan="3">{{ $data[$i]['overtime'] }}</td>
						</tr>
						<tr>
							<td>Vacation</td>
							<td colspan="3"></td>
						</tr>
						<tr>
							<td rowspan="2">None-taxable<br>Deductions</td>
							<td colspan="3"></td>
						</tr>
						<tr>
							<td colspan="3"></td>
						</tr>
						@foreach($data[$i][$data[$i]['key']] as $key=>$dates)
							@php
								$work_day = new Carbon\Carbon($key);
							@endphp
							@if(count($dates) != 0)
								<tr class="t_header">
									<td>Job Number</td>
									<td>{{ $work_day->format('D') }} <span class="gray font-light">{{ $work_day->format('M d, Y') }}</span></td>
									<td>Reg</td>
									<td>OT</td>
								</tr>
								@foreach($dates as $key1 => $item)
									@if($work_day->format('N') == 6 || $work_day->format('N') == 7)
										<tr class="weekend_content">
											<td>{{ $key1+1 }}</td>
											<td>{{$item->project->name}}</td>
											<td>{{$item->regulartime}}</td>
											<td>{{$item->overtime}}</td>
										</tr>
									@else
										<tr>
											<td>{{ $key1+1 }}</td>
											<td>{{$item->project->name}}</td>
											<td>{{$item->regulartime}}</td>
											<td>{{$item->overtime}}</td>
										</tr>
									@endif
								@endforeach
							@else
									<tr class="t_header">
										<td>Job Number</td>
										<td>{{ $work_day->format('D') }} <span class="gray font-light">{{ $work_day->format('M d, Y') }}</span></td>
										<td>Reg</td>
										<td>OT</td>
									</tr>
								@if($work_day->format('N') == 6 || $work_day->format('N') == 7)
									<tr class="weekend_content">
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								@else
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								@endif

							@endif

							@if($work_day->format('N') == 6 || $work_day->format('N') == 7)
							@else
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>								
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>								
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>	
							@endif							
						@endforeach
					</tbody>
				</table>
			</td>
			<td class="employee-column" style="border: none; height: 100%;vertical-align: top; width: 50% !important">
				<table cellpadding="0" cellspacing="0" autosize="1">
						<thead>
							<tr>
								<th style="width: 50%;">&nbsp;</th>
								<th style="width: 50%;">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th style="text-align:left" >
									NAME: <span class="gray font-light">{{ $data[$i+1]['fullname'] }}</span> 
								</th>
								<th colspan="3">
									WEEK ENDING: <span class="gray font-light">{{ $data[$i+1]['week_ending'] }}</span>
								</th>
							</tr>
						</tbody>
				</table>			
				<table cellpadding="0" cellspacing="0" autosize="1">
					<thead>
						<tr>
							<th style="width: 28%;">&nbsp;</th>
							<th style="width: 36%;">&nbsp;</th>
							<th style="width: 18%;">&nbsp;</th>
							<th style="width: 18%;">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="1">Regular Hours</td>
							<td colspan="3">{{ $data[$i+1]['regulartime'] }}</td>
						</tr>
						<tr>
							<td>Overtime Hours</td>
							<td colspan="3">{{ $data[$i+1]['overtime'] }}</td>
						</tr>
						<tr>
							<td>Vacation</td>
							<td colspan="3"></td>
						</tr>
						<tr>
							<td rowspan="2">None-taxable<br>Deductions</td>
							<td colspan="3"></td>
						</tr>
						<tr>
							<td colspan="3"></td>
						</tr>
						@foreach($data[$i+1][$data[$i+1]['key']] as $key=>$dates)
							@php
								$work_day = new Carbon\Carbon($key);
							@endphp
							@if(count($dates) != 0)
								<tr class="t_header">
									<td>Job Number</td>
									<td>{{ $work_day->format('D') }} <span class="gray font-light">{{ $work_day->format('M d, Y') }}</span></td>
									<td>Reg</td>
									<td>OT</td>
								</tr>
								@foreach($dates as $key1 => $item)
									@if($work_day->format('N') == 6 || $work_day->format('N') == 7)
										<tr class="weekend_content">
											<td>{{ $key1+1 }}</td>
											<td>{{$item->project->name}}</td>
											<td>{{$item->regulartime}}</td>
											<td>{{$item->overtime}}</td>
										</tr>
									@else
										<tr>
											<td>{{ $key1+1 }}</td>
											<td>{{$item->project->name}}</td>
											<td>{{$item->regulartime}}</td>
											<td>{{$item->overtime}}</td>
										</tr>
									@endif
								@endforeach
							@else
									<tr class="t_header">
										<td>Job Number</td>
										<td>{{ $work_day->format('D') }} <span class="gray font-light">{{ $work_day->format('M d, Y') }}</span></td>
										<td>Reg</td>
										<td>OT</td>
									</tr>
								@if($work_day->format('N') == 6 || $work_day->format('N') == 7)
									<tr class="weekend_content">
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								@else
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								@endif

							@endif

							@if($work_day->format('N') == 6 || $work_day->format('N') == 7)
							@else
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>								
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>								
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>	
							@endif									
						@endforeach
					</tbody>
				</table>
			</td>
		</tr>
		@endfor
	</tbody>
</table>