@include('admin.layout.sidebar1')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">

		<h3><i class="fa fa-angle-right"></i> เพิ่มแผนก </h3>

		<!-- BASIC FORM ELELEMNTS -->
		<div class="row mt">
			<div class="col-md-12 mt">
				<div class="content-panel">
					<center>
						<table class="table table-hover">
							<h2><i class="fa-solid fa-building"></i> เพิ่มแผนก</h2>
							<hr>
							<thead>
							@if(count($data)==0)
                            <b>ไม่มีข้อมูล</b>
                            @else
								<tr>
									<th>ลำดับ</th>
									<th style="width: 20%;">รหัสแผนก</th>
									<th colspan="2">แผนก</th>
									<th></th>
								</tr>
							</thead>
							@endif
							<tbody>
								<tr>
									@foreach ($data as $key => $value)
									<td align="center">&nbsp;&nbsp;{{++$i}}</td>
									<td>{{$value->code}}</td>
									<td colspan="2">{{ $value->name}}</td>
									<td>
										<form action="{{ route('department.destroy', $value->id) }}" method="post">
											@csrf
											@method('DELETE')
											<a data-toggle="modal" href="login.html#myModal2" data-target="#myModal2-{{$value->id}}"><button type="button" class="btn btn-primary">แก้ไข</button></a>
											<input name="_method" type="hidden" value="DELETE">
											<button type="submit" class="btn btn-theme04 show_confirm" data-toggle="tooltip" title='Delete'>ลบ</button>
										</form>
									</td>
								</tr>
								@endforeach
								<tr>
									<td>รหัสแผนก</td>
									<form action="{{ route('department.store') }}" class="form-horizontal style-form" method="post">
										@csrf
										<td><input type="text" class="form-control" maxlength="2" minlength="2"name="code" required="required" autofocus></td>
										<td>ชื่อแผนก</td>
										<td><input type="text" class="form-control" name="name" required="required" autofocus></td>
										<td>
											<button type="submit" class="btn btn-warning" style="color:black;">เพิ่ม</button>
										</td>
									</form>
								</tr>
							</tbody>
						</table>
						<!-- form edit -->
						@foreach ($data as $key => $value)
						<form action="{{ route('department.update', $value->id) }}" method="post">
							@csrf
							@method('PUT')
							<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2-{{$value->id}}" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<center>
												<h4 class="modal-title">แก้ไขแผนก</h4>
											</center>
										</div>

										<div class="modal-body">
											<div class="form-group form-floating mb-3">
												<h4>รหัสแผนก</h4>
												<input type="text" class="form-control" name="code" value="{{ $value->code }}" readonly>
											</div>
											<div class="form-group form-floating mb-3">
												<h4>แผนก</h4>
												<input type="text" class="form-control" name="name" value="{{ $value->name }}" required="required" autofocus>
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
					</center>
					@if(count($data) != 0)
					<center>{!! $data->links() !!}</center>
					@endif
				</div>
				<!--/content-panel -->
			</div><!-- /col-md-12 -->
		</div><!-- /row -->
	</section>
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