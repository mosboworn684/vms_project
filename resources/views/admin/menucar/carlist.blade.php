@include('admin.layout.sidebar')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> รายการรถยนต์ </h3>
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
		<!-- BASIC FORM ELELEMNTS -->
		<div class="row">
			<div class="col-md-12 mt">
				<div class="content-panel">
					<a data-toggle="modal" href="login.html#myModal2"><button type="button" class="btn btn-warning" style="float: right; margin-right:55px;margin-top:10px;color:black;">เพิ่มรถยนต์</button></a>
					<center>
						@if(isset($car))
						<table class="table1 table-hover">
							<h2><i class="fa-solid fa-car-side"></i> รายการรถยนต์</h2>
							<hr>
							<div class="col-md-12">
								<form action="{{ route('carlist1.search') }}" method="get">
									@csrf
									<button type="submit" class="btn btn-primary" style="float: right; margin-right:40px;margin-top:0px;">ค้นหา</button></a>
									<input type="search" name="searchname" id="search" class="form-control" style="float: right; margin-right:10px;margin-top:0px; width: 15%;">
									@if(Auth::user()->permission_id == 1)
									<select class="form-control" id="select" name="select" onchange="myFunction()" style="float: right; margin-right:10px;margin-top:0px;width:10%;">
										<option value="1">ทั้งหมด</option>
										<option value="2">เลขทะเบียนรถยนต์</option>
										<option value="3">แผนก</option>
										<option value="4">ประเภทรถยนต์</option>
									</select>
									@endif

									@if(Auth::user()->permission_id == 2)
									<select class="form-control" id="select" name="select" onchange="myFunction()" style="float: right; margin-right:10px;margin-top:0px;width:10%;">
										<option value="1">ทั้งหมด</option>
										<option value="2">เลขทะเบียนรถยนต์</option>
										<option value="3">ประเภทรถยนต์</option>
									</select>
									@endif

								</form>
							</div><br><br>
							<thead>
								@if(count($car)==0)
								<tr>
									<td><b>ไม่มีข้อมูล</b></td>
								</tr>
								@else
								<tr>
									<th>ลำดับ</th>
									<th>เลขทะเบียนรถยนต์</th>
									<th>แผนก</th>
									<th>ประเภทรถยนต์</th>
									<th>ยี่ห้อ</th>
									<th>รุ่น</th>
									<th>สี</th>
									<th>จำนวนที่นั่ง</th>
									<th>เลขไมล์</th>
									<th>สถานะ</th>
									<th></th>
								</tr>
							</thead>
							@endif
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
									<td>{{ $value->capacity }}</td>
									<td>{{ $value->mileage}}</td>
									@if( $value->status_id == 1)
									<td><span class="label label-success">{{ $value->status->name }}</span></td>
									@else
									<td><span class="label label-danger">{{ $value->status->name }}</span></td>
									@endif
									<td>
										<a data-toggle="modal" href="login.html#myModal2" data-target="#myModal2-{{$value->id}}"><button type="button" class="btn btn-primary">แก้ไข</button></a>
										<a data-toggle="modal" data-target="#myModal4-{{$value->id}}" href="login.html#myModal4"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
						<br>
					</center>

					@if (count($car) !=0 )
					<center>
						<div class="pagination-block">
							{{ $car->withQueryString()->links('admin.layout.paginationlinks') }}
						</div>
					</center>
					@endif


				</div>
				<!--/content-panel -->
			</div><!-- /col-md-12 -->
		</div><!-- /row -->
	</section>

	<!-- form add-->
	<form action="{{ route('carlist.store') }}" method="post">
		@csrf
		<div aria-hidden="true" aria-labelledby="myModal2Label" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center>
							<h4 class="modal-title">เพิ่มรถยนต์</h4>
						</center>
					</div>

					<div class="modal-body">
						<div class="form-group form-floating mb-3">
							<label for="floatingEmail">ประเภทรถยนต์</label>
							<select class="form-control" name="type_id" value="{{ old('type_id') }}" required="required" autofocus>
								<option value="">กรุณาระบุประเภทรถยนต์</option>
								@foreach ($typecar as $key => $value)
								<option value="{{ $value->id }}"> {{ $value->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="row" style="margin-top: -20px;">
							<div class="col-md-6 mt">
								<label for="floatingEmail">เลขทะเบียนรถยนต์</label>
								<input type="text" class="form-control" name="regisNumber" pattern="[0-9ก-ฮ][ก-ฮ][ก-ฮ]? [0-9]{1,4}" value="{{ old('regisNumber') }}" oninvalid="this.setCustomValidity('ใส่เลขทะเบียนรถยนต์ให้ถูกต้อง')" required="required" autofocus>
							</div>
							<div class="col-md-6 mt">
								<label for="floatingEmail">จังหวัด</label>
								<select class="form-control" name="province_id" value="{{ old('province_id') }}"  oninvalid="this.setCustomValidity('กรุณาเลือกจังหวัด')" required="required" autofocus>
								<option value="">กรุณาเลือกจังหวัด</option>
								@foreach ($province as $key => $value)
								<option value="{{ $value->id }}"> {{ $value->name }}</option>
								@endforeach
							</select>
							</div>
						</div><br>

						<div class="form-group form-floating mb-3">
							<label for="floatingName">สี</label>
							<select class="form-control" name="color_id" value="{{ old('color_id') }}" required="required" autofocus>
								<option value="">กรุณาระบุสีรถยนต์</option>
								@foreach ($color as $key => $value)
								<option value="{{ $value->id }}"> {{ $value->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">ยี่ห้อ</label>
							<select name="brand_id" class="form-control brand" value="{{ old('brand_id') }}" required="required" autofocus>
								<option value="">กรุณาระบุยี่ห้อรถยนต์</option>
								@foreach ($brand as $key => $value)
								<option value="{{ $value->id }}"> {{ $value->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">รุ่น</label>
							<select name="model_id" id="model_type" class="form-control model_type" value="{{ old('model_id') }}" required="required" autofocus>
								<option>กรุณาระบุรุ่นรถยนต์</option>
								<option value=""></option>
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">ระบุแผนก</label>
							<select class="form-control" name="department_id" value="{{ old('department_id') }}" required="required" autofocus>
								@if ( Auth::user()->permission_id == 1)
								<option disabled>กรุณาระบุแผนกรถยนต์</option>
								@foreach ($department as $key => $value)
								<option value="{{ $value->id }}"> {{ $value->name }}</option>
								@endforeach
								@else
								<option value="{{ Auth::user()->department_id}}"> {{ Auth::user()->department->name }}</option>
								@endif
							</select>
						</div>


						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">จำนวนที่นั่ง(รวมคนขับ)</label>
							<input type="text" id="numb1" name="capacity" class="form-control" maxlength="2" value="{{ old('mileage') }}" required="required" autofocus oninput="validateinputca()">
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">เลขไมล์</label>
							<input type="number" id="numb" name="mileage" class="form-control" value="{{ old('mileage') }}" required="required" autofocus oninput="validateinput()">
						</div>
					</div>
					<div class="modal-footer">
						<button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
					</div>

				</div>
			</div>
		</div>
	</form>
	<!-- close add -->

	<!-- form edit -->
	@foreach ($car as $key => $value)
	<form action="{{ route('carlist.update', $value->id) }}" method="post">
		@csrf
		@method('PUT')
		<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2-{{$value->id}}" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center>
							<h4 class="modal-title">แก้ไขข้อมูลรถยนต์</h4>
						</center>
					</div>

					<div class="modal-body">
						<div class="form-group form-floating mb-3">
							<label for="floatingEmail">ประเภทรถยนต์</label>
							<select class="form-control" name="type_id" value="{{ old('type_id') }}" required="required" autofocus readonly>
								<option value="{{ $value->type_id }}"> {{ $value->types->name }}</option>
							</select>
						</div>

						<div class="row" style="margin-top: -20px;">
							<div class="col-md-6 mt">
								<label for="floatingEmail">เลขทะเบียนรถยนต์</label>
								<input type="text" class="form-control" name="regisNumber" value="{{ $value->regisNumber }}" required="required" autofocus readonly>
							</div>
							<div class="col-md-6 mt">
								<label for="floatingEmail">จังหวัด</label>
								<select class="form-control" name="province_id" value="{{ old('province_id') }}" readonly>
								
								<option value="{{ $value->province_id }}"> {{ $value->provinces->name }}</option>
							</select>
							</div>
						</div><br>

						<div class="form-group form-floating mb-3">
							<label for="floatingName">สี</label>
							<select class="form-control" name="color_id" value="{{ old('color_id') }}" required="required" autofocus readonly>
								<option value="{{ $value->color_id }}"> {{ $value->colors->name }}</option>
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">ยี่ห้อ</label>
							<select name="brand_id" class="form-control brand" value="{{ old('brand_id') }}" required="required" autofocus readonly>
								<option value="{{ $value->brand_id }}"> {{ $value->brands->name }}</option>
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">รุ่น</label>
							<select name="model_id" id="model_type" class="form-control model_type" value="{{ old('model_id') }}" required="required" autofocus readonly>
								<option value="{{$value->model_id}}">{{$value->models->name}}</option>
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">ระบุแผนก</label>
							<select class="form-control" name="department_id" value="{{ old('department_id') }}" required="required" autofocus readonly>
								<option value="{{ $value->department_id }}"> {{ $value->departments->name }}</option>
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">ระบุสถานะ</label>
							<select class="form-control" name="status_id" value="{{ old('status_id') }}" required="required" autofocus>
								<option value="">กรุณาระบุสถานะรถยนต์</option>
								@foreach ($status as $key => $valuestatus)
								<option value="{{ $valuestatus->id }}"> {{ $valuestatus->name }}</option>
								@endforeach

							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">จำนวนที่นั่ง(รวมคนขับ)</label>
							<input type="text" name="capacity" readonly class="form-control" value="{{ $value->capacity }}" required="required" autofocus>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">เลขไมล์</label>
							<input type="text" name="mileage" id="Eca" oninput="validatemil(event,'{{$value->id}}')" data-id="{{$value->id}}" class="form-control" value="{{ $value->mileage }}" required="required" autofocus>

						</div>
					</div>
					<div class="modal-footer">
						<button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
					</div>

				</div>
			</div>
		</div>
	</form>
	@endforeach
	<!-- close form edit -->

	<!-- softdelete car -->
	@foreach ($car as $key => $value)
	<form action="{{ route('carlist.inactive', $value->id) }}" method="post">
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
								<H3>คุณต้องการที่จะยกเลิกรถยนต์หรือไม่</H3>
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

	@if ($message = Session::get('success'))
	<script>
		Swal.fire({
			icon: 'success',
			title: '{{$message}}',
		})
	</script>
	@endif

	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script type="text/javascript">
		$('.show_confirm').click(function(event) {
			var form = $(this).closest("form");
			var name = $(this).data("name");
			event.preventDefault();
			swal({
					title: `คุณต้องการที่จะลบหรือไม่`,
					text: "",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						form.submit();
					}
				});
		});
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {

			$(document).on('change', '.brand', function() {
				//console.log("test");

				var id = $(this).val();
				//console.log(id);
				var div = $(this).parent();
				var op = " ";

				$.ajax({
					type: 'get',
					// url:'{!!URL::to('findProductName')!!}',
					url: 'findModel',
					data: {
						'id': id
					},
					success: function(data) {
						console.log('ok');
						console.log(data);
						console.log(data.length);

						op += '<option value="0" selection disabled> กรุณาเลือกรุ่นรถยนต์ </option>'
						for (var i = 0; i < data.length; i++) {
							op += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
						}

						$('#model_type').html(op);
						// div.find('.model_type').append(op);
					},
					error: function() {

					}

				});
			});

		});

		function myFunction() {
			select = document.getElementById("select").value
			console.log(select)
			if (select == 1) {
				document.getElementById("search").disabled = true;
			} else {
				document.getElementById("search").disabled = false;
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

		function validateinputca() {
			$(document).ready(function() {
				$('#numb1').on('keypress', function(event) {
					if ((event.which < 48 || event.which > 57) && event.which != 45 || event.key === "-") {
						event.preventDefault();
					}
				});
			});
		}



		window.onload = function() {

			validateinput()
			validateinputca()
			myFunction()
		}

		function validatemil(e, id) {
			const vali = document.querySelector(`#Eca[data-id="${id}"]`)
			$(document).ready(function() {
				$(document.querySelector(`#Eca[data-id="${id}"]`)).on('keypress', function(vali, id) {
					if ((vali.which < 48 || vali.which > 57) && vali.which != 45 || vali.key === "-") {
						vali.preventDefault();
					}
				});
			});
		}
	</script>
	@include('admin.layout.script')
	</body>

	</html>