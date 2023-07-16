@include('admin.layout.sidebarrole')
@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">


		@if ($message = Session::get('success'))
		<div class="alert alert-success">
			{{$message}}
		</div>
		@endif
		<!-- BASIC FORM ELELEMNTS -->
		<div class="row mt">
			<div class="col-md-12 mt">
				<div class="content-panel">
					<center>
						<table class="table1 table-hover">
							<h2> <i class="fa-solid fa-car"></i> ข้อมูลรถยนต์
								@if(count($car) == 0)
								<tr>
									<td colspan="10">ไม่มีรถให้จัด</td>
								</tr>
								<tr>
									<td colspan="10"><a href="/carset"><button type="button" class="btn  btn-warning">ย้อนกลับ</button></a></td>
								</tr>
								@endif
								<h5 style="text-align: right; margin-right: 10px;"><b>เฉพาะรถยนต์ที่พร้อมใช้งาน</b></h5>
							</h2>
							<hr>
							<thead>
								<tr>
									<th>ลำดับที่</th>
									<th>เลขทะเบียนรถยนต์</th>
									<th>แผนก</th>
									<th>ประเภทรถยนต์</th>
									<th>ยี่ห้อ</th>
									<th>รุ่น</th>
									<th>สี</th>
									<th>จำนวนที่นั่ง</th>
									<th>เลขไมล์</th>

									<!-- <th>สถานะ</th> -->
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>

									@foreach ($car as $key => $value)
									<td>{{++$i}}</td>
									<td>{{ $value->regisNumber }}</td>
									<td>{{ $value->departments->name }}</td>
									<td>{{ $value->types->name }}</td>
									<td>{{ $value->brands->name }}</td>
									<td>{{ $value->models->name }}</td>
									<td>{{ $value->colors->name }}</td>
									<td>{{$value->capacity}}</td>
									<td>{{ $value->mileage}}</td>
									<!-- <td><span class="badge bg-success">ว่าง</span></td> -->
									<td>
										<form action="{{ route('managecar.updatetest', ['carid'=>$value->id,'requestid'=>$carset->id] )}}" method="post">
											<a data-toggle="modal" href="login.html#myModal2" data-target="#myModal2-{{$value->id}}"><button type="button" class="btn btn-info">ตารางงาน</button></a>
											@csrf
											@method('PUT')
											<button type="submit" class="btn btn-success">จัดรถยนต์</button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<br>
					</center>
				</div>
				<!--/content-panel -->
			</div><!-- /col-md-12 -->
		</div><!-- /row -->

		@foreach ($car as $key => $value)
		<?php $k = 1;?>
		<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2-{{$value->id}}" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content1">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center>
							<h4 class="modal-title">รายละเอียดการขอใช้รถ </h4>
						</center>
					</div>
					<!--  -->

					<div class="modal-body">
						<table class="table2 table-striped table-hover">
							<thead>
								<tr>
									<th scope="col">ลำดับ</th>
									<th scope="col">หมายเลขคำขอ</th>
									<th scope="col">วันที่ใช้งาน</th>
									<th scope="col">ขอใช้ถึงวันที่</th>
									<!-- <th scope="col">สถานะ</th> -->
								</tr>
							</thead>
							<tbody>
								@foreach ($requestcar as $key => $val)
								<?php
$time = strtotime($val->startTime);
$newformat = date('Y-m', $time);
$time2 = strtotime($begin);
$newformat2 = date('Y-m', $time2);
?>
								@if(($val->car_id == $value->id ) && ($newformat == $newformat2))

								<tr>
									<td>{{$k++}}</td>
									<td>{{$val->requestNo}}</td>
									<td>{{$thaiDateHelper->simpleDateFormat($val->startTime)}}</td>
									<td>{{$thaiDateHelper->simpleDateFormat($val->endTime)}}</td>
									<!-- <td>
										{{$newformat}}---{{$newformat2}}
									</td> -->
								</tr>

								@endif
								@endforeach
							</tbody>
							<!--  -->
						</table>
					</div>

					<!--  -->
					<div class="modal-footer">
						<button data-dismiss="modal" class="w-100 btn btn-lg btn btn-default" type="button">ปิด</button>
					</div>

				</div>
			</div>
		</div>
		@endforeach
	</section>
	@include('admin.layout.script')
	</body>

	</html>