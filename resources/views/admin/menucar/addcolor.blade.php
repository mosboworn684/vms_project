@include('admin.layout.sidebar')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->

<section id="main-content">
	<section class="wrapper">

		<h3><i class="fa fa-angle-right"></i> เพิ่มสี </h3>
		<!-- BASIC FORM ELELEMNTS -->
		<div class="row mt">
			<div class="col-md-12 mt">
				<div class="content-panel">
					<center>
						<table class="table table-hover">
							<h2> <i class="fa-solid fa-palette"></i> เพิ่มสี</h2>
							<hr>
							<thead>
							@if(count($data)==0)
                            <td colspan="4" style="text-align: center;"><b>ไม่มีข้อมูล</b></td>
                            @else
								<tr>
									<th></th>
									<th>ลำดับ</th>
									<th>สี</th>
									<th></th>
								</tr>
							</thead>
							@endif
							<tbody>
								<tr>
									@foreach ($data as $key => $value)
									<td></td>
									<td>&nbsp; &nbsp; {{++$i}}</td>
									<td>{{ $value->name }}</td>
									<td>
										<form action="{{ route('addcolor.destroy', $value->id) }}" method="post">
											@csrf
											@method('DELETE')
											<a data-toggle="modal" href="login.html#myModal2" data-target="#myModal2-{{$value->id}}"><button type="button" class="btn btn-primary">แก้ไข</button></a>
											<input name="_method" type="hidden" value="DELETE">
											<button type="submit" class="btn btn-theme04 show_confirm" data-toggle="tooltip" title='Delete'>ลบ</button>
									</td>
								</tr>
								</form>
								@endforeach
								<tr>
									<td></td>
									<td>เพิ่มสี</td>
									<form action="{{ route('addcolor.store') }}" class="form-horizontal style-form" method="post">
										@csrf
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
						<form action="{{ route('addcolor.update', $value->id) }}" method="post">
							@csrf
							@method('PUT')
							<div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2-{{$value->id}}" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<center>
												<h4 class="modal-title">แก้ไขสีรถยนต์</h4>
											</center>
										</div>

										<div class="modal-body">
											<div class="form-group form-floating mb-3">
												<label for="floatingEmail">สีรถยนต์</label>
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