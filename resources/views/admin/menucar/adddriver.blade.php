@include('admin.layout.sidebar')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')

<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> เพิ่มพนักงานขับรถ</h3>
		<div class="row">

			<div class="col-md-12 mt">
				<div class="content-panel">
					<a data-toggle="modal" href="login.html#myModal1"><button type="button" class="btn btn-warning" style="float: right; margin-right:45px;margin-top:10px; color:black;">เพิ่มพนักงานขับรถ</button></a>
					<center>
						<table class="table1 table-hover">
							<h2><i class="fa-solid fa-building"></i> รายชื่อพนักงานขับรถ</h2>
							<hr>
							<!-- <button type="button" class="btn btn-warning" style="float: left; margin-left:45px;margin-bottom:20px; color:black;">ปกติ</button>
							<a href="/driverdontactive"><button type="button" class="btn btn-default" style="float: left; margin-left:5px;margin-bottom:5px;">ลาออก</button></a> -->
							<thead>
								@if(count($data)==0)
								<tr>
									<td style="text-align: center;"><b>ไม่มีข้อมูล</b></td>
								</tr>
								@else
								<tr>
									<th>ลำดับ</th>
									<!-- <Th>หมายเลขใบขับขี่</Th> -->
									<th>รหัสพนักงาน</th>
									<th>ชื่อ-นามสกุล</th>
									<th>เบอร์โทรศัพท์</th>
									<th>อายุ</th>
									<th>จำนวนงาน<br>ในเดือนนี้</th>
									<th>สถานะ</th>
									<th></th>
								</tr>
							</thead>
							@endif
							<tbody>
								<tr>
									@foreach ($data as $key => $value)
									<?php $count = 0;?>
									<td>&nbsp; &nbsp; {{++$i}}</td>
									<!-- <td>{{ $value->drivernumber }}</td> -->
									<td>{{$value->drivernumber_id}}</td>
									<td style="text-align:left;">{{ $value->prefix->name }}{{ $value->firstname }} {{ $value->lastname }}</td>
									<td>{{ $value->tel }}</td>
									<td>{{ \Carbon\Carbon::parse($value->birthday)->age }}</td>

									@foreach ($requestcar as $key => $valcheck)

									<?php
$time = strtotime($valcheck->startTime);
$newformat4 = date('Y-m', $time);

$time2 = strtotime($valcheck->startTime);
$newformat5 = date('Y-m', $time2);
?>
									@if(($valcheck->driver_id == $value->id ) && ($newformat4 == $newformat5))
									<?php $count++;?>
									@endif
									@endforeach

									<td>{{$count}} </td>

									<?php $count = 0;?>

									@if( $value->status_id == 1)
									<td><span class="label label-success">{{ $value->status->name }}</span></td>
									@else
									<td><span class="label label-danger">{{ $value->status->name }} </span></td>
									@endif

									<td>
										<a data-toggle="modal" href="login.html#myModal2" data-target="#myModal3-{{$value->id}}"><button type="button" class="btn btn-info">ตารางงาน</button></a>
										<a data-toggle="modal" href="login.html#myModal2" data-target="#myModal2-{{$value->id}}"><button type="button" class="btn btn-primary">แก้ไข</button></a>
										<a data-toggle="modal" data-target="#myModal4-{{$value->id}}" href="login.html#myModal4"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
									</td>
								</tr>
								@endforeach
						</table>

						<!-- form edit -->
						@foreach ($data as $key => $value)
						<form action="{{ route('driver.update', $value->id) }}" method="post">
							@csrf
							@method('PUT')
							<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2-{{$value->id}}" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<center>
												<h4 class="modal-title">แก้ไขข้อมูลพนักงานขับรถ</h4>
											</center>
										</div>

										<div class="modal-body">
											<div class="form-group form-floating mb-3">
												<label for="floatingEmail">คำนำหน้า</label>
												<select class="form-control" name="prefix_id" value="{{ old('prefix_id') }}" readonly>
													<option value="{{ $value->prefix_id }}"> {{ $value->prefix->name }}</option>
												</select>
											</div>
											<div class="form-group form-floating mb-3">
												<label for="floatingEmail">หมายเลขใบขับขี่</label>
												<input type="text" class="form-control" name="drivernumber" value="{{ $value->drivernumber }}" readonly>
											</div>

											<div class="form-group form-floating mb-3">
												<label for="floatingEmail">ชื่อ</label>
												<input type="text" class="form-control" name="firstname" value="{{ $value->firstname }}" required="required" autofocus>
											</div>

											<div class="form-group form-floating mb-3">
												<label for="floatingName">นามสกุล</label>
												<input type="text" class="form-control" name="lastname" value="{{ $value->lastname }}" required="required" autofocus>
											</div>

											<div class="form-group form-floating mb-3">
												<label for="floatingPassword">เบอร์โทรศัพท์</label>
												<input type="tel" class="form-control" data-id="{{$value->id}}" id="Etel" name="tel" oninput="validateedittel(event,'{{$value->id}}')" required="required" value="{{ $value->tel }}" pattern="[0]{1}[0-9]{2}[0-9]{3}[0-9]{4}" maxlength="10"   oninvalid="this.setCustomValidity('ใส่เบอร์มือถือให้ถูกต้อง')" oninput="this.setCustomValidity('')" />
											</div>

											<div class="form-group form-floating mb-3">
												<label for="floatingPassword">สถานะ</label>
												<select class="form-control" id="showdate" name="status_id" required="required" autofocus onchange="sSelect(event, '{{$value->id}}')">
													@foreach ($status as $key => $value3)
													<option value="{{ $value3->id }}"> {{ $value3->name }}</option>
													@endforeach
												</select>
											</div>

											<div class="form-group form-floating mb-3">
												<label for="floatingPassword" style="display:none" id="dsd" data-id="{{$value->id}}">ตั้งแต่วันที่</label>

												<input type="date" class="form-control" id="starttime" placeholder="วัน/เดือน/ปี" name="starttime" style="display:none" min="{{ date('Y-m-d'); }}" data-id="{{$value->id}}" onchange="myEndtime(event,'{{$value->id}}')">

												<label for="floatingPassword" style="display:none" id="dsd1" data-id="{{$value->id}}">จนถึงวันที่</label>

												<input type="date" class="form-control" id="endtime" placeholder="วัน/เดือน/ปี" name="endtime" style="display:none" data-id="{{$value->id}}">
											</div>
											<div class="modal-footer">
												<button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
											</div>

										</div>
									</div>
								</div>
							</div>
						</form>
						<!-- close form edit -->
						@endforeach
						</tbody>
						@if(count($data) != 0)
						<center>{!! $data->links() !!}</center>
						@endif
					</center><br>
				</div>
				<!--/content-panel -->
			</div><!-- /col-md-12 -->
		</div><!-- /row -->

		<!-- form softdelete -->
		@foreach ($data as $key => $value)
		<form action="{{ route('driver.inactive', $value->id) }}" method="post">
			@csrf
			@method('PUT')
			<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal4-{{$value->id}}" class="modal fade">
				<div class="modal-dialog" style="margin-top: 250px; width: 450px;">
					<div class="modal-content">


						<div class="modal-body">
							<div class="form-group form-floating mb-3">
								<center><img src="{{ URL::asset('img/icon-warning.png') }}" width="20%" alt=""></center>
							</div>
							<div class="form-group form-floating mb-3">
								<center>
									<H3>คุณต้องการที่จะยกเลิกพนักงานหรือไม่</H3>
								</center>
							</div>
						</div>
						<div class="modal-footer">
							<button class="w-100 btn btn-success" type="submit">ตกลง</button>
							<button data-dismiss="modal" class="w-100 btn btn-danger" type="button">ยกเลิก</button>
						</div>

					</div>
				</div>
			</div>
		</form>
		@endforeach
		<!--  -->

		<!-- รายละเอียด -->
		@foreach ($data as $key => $value)
		<?php $k = 1;?>
		<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal3-{{$value->id}}" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content1">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center>
							<h4 class="modal-title">รายละเอียดพนักงานขับรถ </h4>
						</center>
					</div>
					<!--  -->

					<div class="modal-body">
						<table class="table2 table-striped table-hover">
							<thead>
								<tr>
									<th scope="col">ลำดับ</th>
									<th scope="col">หมายเลขคำขอ</th>
									<th scope="col">ตั้งแต่วันที่</th>
									<th scope="col">ถึงวันที่</th>
									<!-- <th scope="col">สถานะ</th> -->
								</tr>
							</thead>
							<tbody>
								@foreach ($requestcar as $key => $val)
								<?php
$time = strtotime($val->startTime);
$newformat = date('Y-m', $time);

$time2 = strtotime($val->startTime);
$newformat2 = date('Y-m', $time2);
?>
								@if(($val->driver_id == $value->id ) && ($newformat == $newformat2))
								<?php $count = $k++;
?>
								<tr>
									<td>{{$count}} </td>
									<td>{{$val->requestNo}} </td>
									<td>{{$thaiDateHelper->simpleDateFormat($val->startTime)}}</td>
									<td>{{$thaiDateHelper->simpleDateFormat($val->endTime)}}</td>

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
		<!--  -->

		@if ($message = Session::get('success'))
		<script>
			Swal.fire({
				icon: 'success',
				title: '{{$message}}',
			})
		</script>
		@elseif ($message = Session::get('error'))
		<script>
			Swal.fire({
				icon: 'error',
				title: '{{$message}}',
			})
		</script>
		@endif
	</section>

	<!-- form add-->
	<form action="{{ route('driver.store') }}" method="post">
		@csrf
		<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal1" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center>
							<h4 class="modal-title">เพิ่มพนักงานขับรถ</h4>
						</center>
					</div>

					<div class="modal-body">
						<div class="form-group form-floating mb-3">
							<label for="floatingEmail">คำนำหน้า</label>
							<select class="form-control" name="prefix_id" value="{{ old('prefix_id') }}" required="required" autofocus>
								<option value="">กรุณาระบุคำนำหน้า</option>
								@foreach ($prefix as $key => $value)
								<option value="{{ $value->id }}"> {{ $value->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingEmail">หมายเลขใบขับขี่</label>
							<input type="text" class="form-control" id="numb" name="drivernumber" maxlength="8" minlength="8" required="required" autofocus oninput="validateinput()">
						</div>
						<!-- <div class="form-group form-floating mb-3">
							<label for="floatingEmail">รหัสพนักงาน</label>
							<input type="text" class="form-control"  name="drivernumber_id" value="{{$drivernumberId}}"  required="required" autofocus >
						</div> -->
						<div class="form-group form-floating mb-3">
							<label for="floatingEmail">ชื่อ</label>
							<input type="text" class="form-control" name="firstname" required="required" autofocus>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingName">นามสกุล</label>
							<input type="text" class="form-control" name="lastname" required="required" autofocus>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingName">วัน/เดือน/ปีเกิด(ค.ศ.)</label>
							<input type="date" class="form-control" name="birthday" placeholder="วัน/เดือน/ปี" id="DOB" required="required" minlength="8" autofocus onchange="myFunction()">
							<p id="outputerror" style="color:red;"></p>
							<p id="outputsuccess" style="color:green;"></p>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">เบอร์โทรศัพท์</label>
							<input type="text" class="form-control" id="tel" name="tel" required="required" pattern="[0]{1}[0-9]{2}[0-9]{3}[0-9]{4}" maxlength="10" oninvalid="this.setCustomValidity('ใส่เบอร์มือถือให้ถูกต้อง')" oninput="this.setCustomValidity('')" oninput="validatetel()" />
						</div>
					</div>
					<div class="modal-footer">
						<button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
					</div>

				</div>
			</div>
		</div>
		@if ($message = Session::get('success'))
		<script>
			Swal.fire({
				icon: 'success',
				title: '{{$message}}',
			})
		</script>
		@endif
		<!--  -->
	</form>
	<!-- close add -->

	@include('admin.layout.script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

	<script>
		function myFunction() {
			var DOB = document.getElementById("DOB")
			var DOB1 = document.getElementById("DOB").value
			var outputerror = document.getElementById("outputerror")
			var outputsuccess = document.getElementById("outputsuccess")

			const getAge = birthDate => Math.floor((new Date() - new Date(birthDate).getTime()) / 3.15576e+10)

			var fifteenYearsAgo = new Date();
			fifteenYearsAgo.setFullYear(fifteenYearsAgo.getFullYear() - 25);
			var eightyOneYearsAgo = new Date();
			eightyOneYearsAgo.setFullYear(eightyOneYearsAgo.getFullYear() - 50);

			function check() {
				var birthDate = new Date(DOB.value.replace(/(..)\/(..)\/(....)/, "$3-$2-$1"));
				return birthDate <= fifteenYearsAgo && birthDate > eightyOneYearsAgo;
				console.log(birthDate);
			}

			if (check()) {
				console.log(DOB1)
				outputsuccess.textContent = "อายุ " + getAge(DOB1)
				outputerror.textContent = ""
			} else {
				outputerror.textContent = "อายุต้องอยู่ระหว่าง 25-50 ปี"
				outputsuccess.textContent = ""
			}
		}

		function validateinput() {
			$(document).ready(function() {
				$('#numb').on('keypress', function(event) {
					if ((event.which < 48 || event.which > 57) && event.which != 45 || event.key === "-") {
						event.preventDefault();
					}
				});
			});
		}

		function validatetel() {
			$(document).ready(function() {
				$('#tel').on('keypress', function(event) {
					if ((event.which < 48 || event.which > 57) && event.which != 45 || event.key === "-") {
						event.preventDefault();
					}
				});
			});
		}
		window.onload = validateinput;
		window.onload = validatetel;
	</script>



	<script type="text/javascript">
		function sSelect(e, id) {
			index = e.target.value
			if (index == '2') {
				document.querySelector(`#dsd[data-id="${id}"]`).style.display = ''
				document.querySelector(`#dsd1[data-id="${id}"]`).style.display = ''
				document.querySelector(`#starttime[data-id="${id}"]`).style.display = ''
				document.querySelector(`#endtime[data-id="${id}"]`).style.display = ''
			} else {
				document.querySelector(`#dsd[data-id="${id}"]`).style.display = 'none'
				document.querySelector(`#dsd1[data-id="${id}"]`).style.display = 'none'
				document.querySelector(`#starttime[data-id="${id}"]`).style.display = 'none'
				document.querySelector(`#endtime[data-id="${id}"]`).style.display = 'none'
			}
		}

		function myEndtime(e, id) {
			const start = document.querySelector(`#starttime[data-id="${id}"]`)
			const end = document.querySelector(`#endtime[data-id="${id}"]`)
			console.log('test')
			end.value = start.value
			end.min = start.value
		}

		function validateedittel(e,id) {
			const vali = document.querySelector(`#Etel[data-id="${id}"]`)
			$(document).ready(function() {
				$(document.querySelector(`#Etel[data-id="${id}"]`)).on('keypress', function(vali,id) {
					if ((vali.which < 48 || vali.which > 57) && vali.which != 45 || vali.key === "-") {
						vali.preventDefault();
					}
				});
			});
		}

	</script>

	</body>

	</html>