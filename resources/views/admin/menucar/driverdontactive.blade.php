@include('admin.layout.sidebar')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<h3><i class="fa fa-angle-right"></i> เพิ่มพนักงานขับรถ</h3>
		<div class="row">

			<div class="col-md-12 mt">
				<div class="content-panel">

					<center>
						<table class="table1 table-hover">
							<h2><i class="fa-solid fa-building"></i> รายชื่อพนักงานขับรถ</h2>
							<hr>
							<a href="/driver"><button type="button" class="btn btn-default" style="float: left; margin-left:45px;margin-bottom:20px; color:black;">ปกติ</button></a>
							<button type="button" class="btn btn-warning" style="float: left; margin-left:5px;margin-bottom:5px; color:black;">ลาออก</button>
							<thead>
								@if(count($data)==0)
								<tr>
									<td style="text-align: center;"><b>ไม่มีข้อมูล</b></td>
								</tr>
								@else
								<tr>
									<th>ลำดับ</th>
									<Th>หมายเลขใบขับขี่</Th>
									<th>ชื่อ-นามสกุล</th>
									<th>เบอร์โทรศัพท์</th>
									<th>สถานะ</th>
									<th></th>
								</tr>
							</thead>
							@endif
							<tbody>
								<tr>
									@foreach ($data as $key => $value)
									<td>&nbsp; &nbsp; {{++$i}}</td>
									<td>{{ $value->drivernumber }}</td>
									<td style="text-align:left;">{{ $value->prefix->name }}{{ $value->firstname }} {{ $value->lastname }}</td>
									<td>{{ $value->tel }}</td>
									@if( $value->status_id == 1)
									<td><span class="label label-success">{{ $value->status->name }}</span></td>
									@else
									<td><span class="label label-danger">{{ $value->status->name }}</span></td>
									@endif

									<td style="width:5px;">

									<form action="{{ route('driverdontactive.update', $value->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
										<button type="submit" class="btn btn-success">ใช้งาน</button></a>
									</form>

									</td>
									<td style="width:5px;">
										<form action="{{ route('driverdontactive.destroy', $value->id) }}" method="post">
											@csrf
											@method('DELETE')
											<input name="_method" type="hidden" value="DELETE">
											<button type="submit" class="btn btn-theme04 show_confirm" data-toggle="tooltip" title='Delete'>ลบ</button>
										</form>
									</td>
								</tr>
							</tbody>
							@endforeach
						</table>


						@if(count($data) != 0)
						<center>{!! $data->links() !!}</center>
						@endif
					</center><br>
				</div>
				<!--/content-panel -->
			</div><!-- /col-md-12 -->
		</div><!-- /row -->
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
								<option>กรุณาระบุคำนำหน้า</option>
								@foreach ($prefix as $key => $value)
								<option value="{{ $value->id }}"> {{ $value->name }}</option>
								@endforeach
							</select>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingEmail">หมายเลขใบขับขี่</label>
							<input type="text" class="form-control" name="drivernumber" maxlength="8" minlength="8" required="required" autofocus>
						</div>
						<div class="form-group form-floating mb-3">
							<label for="floatingEmail">ชื่อ</label>
							<input type="text" class="form-control" name="firstname" required="required" autofocus>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingName">นามสกุล</label>
							<input type="text" class="form-control" name="lastname" required="required" autofocus>
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">เบอร์โทรศัพท์</label>
							<input type="tel" class="form-control" name="tel" required="required" pattern="[0]{1}[0-9]{2}[0-9]{3}[0-9]{4}" oninvalid="this.setCustomValidity('ใส่เบอร์มือถือให้ถูกต้อง')" oninput="this.setCustomValidity('')" />
						</div>

						<div class="form-group form-floating mb-3">
							<label for="floatingPassword">สถานะ</label>
							<select class="form-control" name="status_id" value="{{ old('status_id') }}" required="required" autofocus>
								<option>กรุณาระบุสถานะ</option>
								@foreach ($status as $key => $value)
								<option value="{{ $value->id }}"> {{ $value->name }}</option>
								@endforeach
							</select>
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
	</body>

	</html>
