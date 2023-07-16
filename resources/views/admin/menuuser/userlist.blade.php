@include('admin.layout.sidebar1')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">

		<h3><i class="fa fa-angle-right"></i> รายชื่อพนักงาน </h3>
		<!-- BASIC FORM ELELEMNTS -->
		<div class="row mt">
			<div class="col-md-12 mt">
				<div class="content-panel">
					<!-- <button type="button" class="btn btn-warning" style="float: left; margin-left:45px;margin-bottom:20px; color:black;">ปกติ</button>
					<a href="/userDontactive"><button type="button" class="btn btn-default" style="float: left; margin-left:5px;margin-bottom:10px;">ลาออก</button></a> -->
					<a data-toggle="modal" href="login.html#myModal2"><button type="button" class="btn btn-warning" style="float: right; margin-right:55px;margin-top:10px; color:black;	">เพิ่มพนักงาน</button></a>
					<center>
						@if ($message = Session::get('success'))
						<script>
							Swal.fire({
								icon: 'success',
								title: '{{$message}}',
							})
						</script>
						@endif

						@if ($message = Session::get('error'))
						<script>
							Swal.fire({
								icon: 'error',
								title: '{{$message}}',
							})
						</script>
						@endif

						<table class="table1 table-hover">
							<h2><i class="fa-solid fa-users"></i> รายชื่อพนักงาน</h2>
							<hr>
							<div class="col-md-12">
								<form action="{{ route('userlist1.search') }}" method="get">
									@csrf
									<button type="submit" class="btn btn-primary" style="float: right; margin-right:40px;margin-top:0px;">ค้นหา</button></a>
									<input type="search" name="searchname" id="search" class="form-control" style="float: right; margin-right:10px;margin-top:0px; width: 15%;">
									@if(Auth::user()->permission_id == 1)
									<select class="form-control" id="select" name="select" onchange="myFunction()" style="float: right; margin-right:10px;margin-top:0px;width:10%;">
										<option value="1">ทั้งหมด</option>
										<option value="2">รหัสพนักงาน</option>
										<option value="3">ชื่อ-นามสกุล</option>
										<option value="4">เบอร์โทรศัพท์</option>
										<option value="5">แผนก</option>
									</select>
									@endif

									@if(Auth::user()->permission_id == 2)
									<select class="form-control" id="select" name="select" onchange="myFunction()" style="float: right; margin-right:10px;margin-top:0px;width:10%;">
										<option value="1">ทั้งหมด</option>
										<option value="2">รหัสพนักงาน</option>
										<option value="3">ชื่อ-นามสกุล</option>
										<option value="4">เบอร์โทรศัพท์</option>
									</select>
									@endif
								</form>
							</div>
							<thead>
								@if(count($user)==0)
								<b>ไม่มีข้อมูล</b>
								@else
								<tr>
									<th>ลำดับ</th>
									<th>รหัสพนักงาน</th>
									<th>ชื่อ - นามสกุล</th>
									<th>เบอร์โทรศัพท์</th>
									<th>email</th>
									<th>username</th>
									<th>สิทธิ์</th>
									<th>แผนก</th>
								</tr>
								@endif
							</thead>
							<tbody>
								<tr>
									@foreach ($user as $key => $value)

									@if($value->id != Auth::user()->id)
									<td> {{++$i}}</td>
									<td>{{$value->employeenumber}}</td>
									<td style="text-align: left;">{{ $value->prefix->name }}&nbsp; {{ $value->firstname }} &nbsp; {{ $value->lastname }}</td>
									<td>{{ $value->tel }}</td>
									<td style="text-align: left;">{{ $value->email }}</td>
									<td style="text-align: left;">{{ $value->username }}</td>
									<td style="text-align: left;">{{ $value->permission->name }}</td>
									<td style="text-align: left;">{{ $value->department->name }}</td>
									<td>
										@csrf
										@method('DELETE')
										<a href="{{ route('userlist.edit', $value->id )}}"><button type="button" class="btn btn-info">แก้ไขข้อมูล</button></a>
										<a data-toggle="modal" href="login.html#myModal1" data-target="#myModal1-{{$value->id}}"><button type="button" class="btn btn-primary">เปลี่ยนรหัสผ่าน</button></a>
										<a data-toggle="modal" data-target="#myModal4-{{$value->id}}" href="login.html#myModal4"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
										@endif
									</td>
								</tr>
								<form action="{{ route('home.updatepassword', $value->id) }}" method="post">
									@csrf
									@method('PUT')
									<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal1-{{$value->id}}" class="modal fade">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<center>
														<h4 class="modal-title">รีเซ็ตรหัสผ่าน</h4>

													</center>
												</div>
												<div class="modal-body">
													<div class="form-group form-floating mb-3">
														<label for="floatingEmail">รหัสผ่านใหม่</label>
														<input type="password" class="form-control" name="password" required="required" autofocus>
													</div>

													<div class="form-group form-floating mb-3">
														<label for="floatingEmail">ยืนยันรหัสผ่านใหม่</label>
														<input type="password" class="form-control" name="confirm" required="required" autofocus>
													</div>
												</div>
												<div class="modal-footer">
													<button data-dismiss="modal" class="w-100 btn btn-lg btn-danger" type="submit">ยกเลิก</button>
													<button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
												</div>
											</div>
										</div>
									</div>
								</form>
								@endforeach
							</tbody>
						</table>
					</center>
					<!-- <center><a href="/register" button type="submit" class="btn btn-warning">เพิ่มพนักงาน</button></a></center><br> -->
					@if(count($user) != 0)
					<center>
						<div class="pagination-block">
							{{ $user->withQueryString()->links('admin.layout.paginationlinks') }}
						</div>
					</center>
					@endif
				</div>

				<!--/content-panel -->
			</div><!-- /col-md-12 -->
		</div><!-- /row -->

		<!-- form add-->
		<form method="post" action="{{ route('register.perform') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			@csrf
			<div aria-hidden="true" aria-labelledby="myModal2Label" role="dialog" tabindex="-1" id="myModal2" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<center>
								<h4 class="modal-title">เพิ่มพนักงาน</h4>
							</center>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6 ">
									<label for="floatingEmail">คำนำหน้า</label>
									<select class="form-control" name="prefix_id" value="{{ old('prefix_id') }}" required="required" autofocus>
										<option value="">กรุณาระบุคำนำหน้า</option>
										@foreach ($prefix as $key => $value)
										<option value="{{ $value->id }}"> {{ $value->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-6 ">@if ( Auth::user()->permission_id == 2)
									<label for="floatingEmail">รหัสพนักงาน</label>
									<input type="text" class="form-control" name="employeenumber" value="{{$requestNo}}" required="required" autofocus readonly>
									@endif
								</div>
							</div><br>

							<div class="row">
								<div class="col-md-6 ">
									<label for="floatingEmail">ชื่อ</label>
									<input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required="required" autofocus>
								</div>
								<div class="col-md-6 ">
									<label for="floatingEmail">นามสกุล</label>
									<input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required="required" autofocus>
									@if ($errors->has('firstname'))
									<span class="text-danger text-left">{{ $errors->first('firstname') }}</span>
									@endif
								</div>
							</div><br>

							<div class="form-group form-floating mb-3">
								<label for="floatingPassword">เบอร์โทรศัพท์</label>
								<input type="tel" class="form-control" name="tel" id="tel" required="required" pattern="[0]{1}[0-9]{2}[0-9]{3}[0-9]{4}" oninput="validatetel()" maxlength="10" oninvalid="this.setCustomValidity('ใส่เบอร์มือถือให้ถูกต้อง')" oninput="this.setCustomValidity('')" />
								@if ($errors->has('tel'))
								<span class="text-danger text-left">{{ $errors->first('tel') }}</span>
								@endif
							</div>

							<div class="form-group form-floating mb-3">
								<label for="floatingPassword">E-mail</label>
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus>
								@if ($errors->has('email'))
								<span class="text-danger text-left">{{ $errors->first('email') }}</span>
								@endif
							</div>
							<div class="form-group form-floating mb-3">
								@if ( Auth::user()->permission_id == 2)
								<label for="floatingPassword">Username</label>
								<input type="text" class="form-control" name="username" value="{{ $requestNo }}" required="required" autofocus readonly>
								@endif

								@if ($errors->has('username'))
								<span class="text-danger text-left">{{ $errors->first('username') }}</span>
								@endif
							</div>
							<div class="form-group form-floating mb-3">
								<label for="floatingPassword">Password</label>
								<input type="password" class="form-control" name="password" value="{{ old('password') }}" required="required" autofocus>
								@if ($errors->has('password'))
								<span class="text-danger text-left">{{ $errors->first('password') }}</span>
								@endif
							</div>
							<div class="form-group form-floating mb-3">
								<label for="floatingPassword">กำหนดสิทธิ์</label>
								<select class="form-control" name="permission_id" value="{{ old('permission_id') }}" required="required" autofocus>
									@if ( Auth::user()->permission_id == 1)
									<option value="">กรุณาระบุสิทธิ์การใช้งาน</option>
									@endif
									@foreach ($permission as $key => $value)

									<option value="{{ $value->id }}"> {{ $value->name }}</option>
									@endforeach
								</select>
								@if ($errors->has('permission_id'))
								<span class="text-danger text-left">{{ $errors->first('permission_id') }}</span>
								@endif
							</div>
							<div class="form-group form-floating mb-3">
								<label for="floatingPassword">แผนก</label>
								<select class="form-control" name="department_id" value="{{ old('department_id') }}" required="required" autofocus>
									@if ( Auth::user()->permission_id == 1)
									<option value="">กรุณาระบุแผนก</option>
									@endif
									@foreach ($department as $key => $value)
									<option value="{{ $value->id }}"> {{ $value->name }} </option>
									@endforeach
								</select>
								@if ($errors->has('department_id'))
								<span class="text-danger text-left">{{ $errors->first('department_id') }}</span>
								@endif
							</div>
							<div class="form-group form-floating mb-3">
								<h5 style="color:red;">**กรุณากรอกข้อมูลให้ครบถ้วน</h5>
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

		<!-- modal ลบคำขอ -->
		@foreach ($user as $key => $value)
		<form action="{{ route('userlist.inactive', $value->id) }}" method="post">
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
	</section>


	@include('admin.layout.script')
	<script>
		function myFunction() {
			select = document.getElementById("select").value
			console.log(select)
			if (select == 1) {
				document.getElementById("search").disabled = true;
			} else {
				document.getElementById("search").disabled = false;
			}
		}

		function validatetel() {
			console.log('asdasdas')
			$(document).ready(function() {
				$('#tel').on('keypress', function(event) {
					if ((event.which < 48 || event.which > 57) && event.which != 45 || event.key === "-") {
						event.preventDefault();
					}
				});
			});
		}

		window.onload = function() {
			myFunction()
			validatetel()
		}
	</script>
	</body>

	</html>
