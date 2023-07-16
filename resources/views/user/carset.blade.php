@include('admin.layout.sidebarrole')
@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
            @if ($message = Session::get('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '{{$message}}',
                })
            </script>
            @endif
            <div class="col-md-12 mt">
                <div class="content-panel">
                <ul class="nav nav-pills" style="margin-top: -15px;">
                        <li class="active" ><a href="#" style="background-color:white;color:#ffa200;border-bottom: 4px solid #ffa200;">รอจัด</a></li>
                        <li><a href="/carset1" style="color:black;">จัดแล้ว</a></li>
                    </ul>

                    <!-- <button type="button" class="btn btn-warning" style="color:black;">รอจัด</button>
                    <a href="/carset1"><button type="button" class="btn btn-default">จัดแล้ว</button></a> -->

                    <center>
                        <table class="table1 table-hover">
                            <h2> <i class="fa-solid fa-car"></i> จัดรถยนต์</h2>
                            <hr>
                            <thead>
                                @if(count($carset)==0)
                                <tr>
                                    <td><b>ไม่มีข้อมูล</b></td>
                                </tr>
                                @else
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขที่การขอใช้รถยนต์</th>
                                    <th>ผู้จอง</th>
                                    <th>แผนก</th>
                                    <th>วันที่ใช้งาน เวลา</th>
                                    <th>ถึงวันที่ &nbsp;&nbsp;&nbsp;เวลา</th>
                                    <th>จำนวนผู้เดินทาง</th>
                                    <th>สถานที่</th>
                                    <th>ประเภทรถยนต์</th>
                                    <th>สถานะ</th>
                                    <th>ดำเนินการ</th>
                                </tr>
                            </thead>
                            @endif
                            <tbody>
                                <tr>
                                    @foreach ($carset as $key => $value)
                                    <!-- ยังไม่ได้จัดคนรถยนต์ และ ยังไม่ได้จัดคนขับ -->
                                    @if ($value->status_set_id == 1 && $value->want_driver == 1)
                                    <td>{{++$i}}</td>
                                    <td>{{ $value->requestNo }}</td>
                                    <td>{{ $value->users->firstname }}</td>
                                    <td>{{ $value->departments->name }}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->startTime)}}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->endTime)}}</td>
                                    <td>{{ $value->passenger }}</td>
                                    <td>{{ $value->location }}</td>
                                    <td>{{ $value->types->name }}</td>
                                    <td> <span class="label label-danger">ยังไม่ได้จัดรถยนต์</span>
                                        <span class="label label-danger">ยังไม่ได้จัดคนขับ</span>
                                    </td>
                                    @if ( Auth::user()->permission_id == 1)
                                    <td>

                                        <a href="{{ route('carset.edit', $value->id )}}"><button type="submit" class="btn btn-success">จัดรถยนต์</button></a>
                                        <a href="{{ route('carset.editdriver', $value->id )}}"><button type="submit" class="btn btn-success">จัดคนขับ</button></a>
                                        <a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                    </td>
                                    @else
                                    <td>
                                        <a href="{{ route('carset.edit', $value->id )}}"><button type="submit" class="btn btn-success">จัดรถยนต์</button></a>
                                        <a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                    </td>
                                    @endif
                                    <!--  -->

                                    <!-- จัดรถยนต์แล้ว และ ยังไม่ได้จัดคนขับ -->
                                    @elseif($value->status_set_id == 2 && $value->want_driver == 1)
                                    <td>{{++$i}}</td>
                                    <td>{{ $value->requestNo }}</td>
                                    <td>{{ $value->users->firstname }}</td>
                                    <td>{{ $value->departments->name }}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->startTime)}}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->endTime)}}</td>
                                    <td>{{ $value->passenger }}</td>
                                    <td>{{ $value->location }}</td>
                                    <td>{{ $value->types->name }}</td>
                                    <td> <span class="label label-success">จัดรถยนต์แล้ว</span>
                                        <span class="label label-danger">ยังไม่ได้จัดคนขับ</span>
                                    </td>
                                    @if ( Auth::user()->permission_id == 1)
                                    <td><button type="button" class="btn btn-success" disabled>จัดรถยนต์</button>
                                        <a href="{{ route('carset.editdriver', $value->id )}}"><button type="submit" class="btn btn-success">จัดคนขับ</button></a>
                                        <a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                    </td>
                                    @else
                                    <td>
                                        <button type="button" class="btn btn-success" disabled>จัดรถยนต์</button></a>

                                    </td>
                                    @endif
                                    <!--  -->

                                    <!-- ยังไม่จัดรถยนต์ และ จัดคนขับแล้ว -->
                                    @elseif($value->status_set_id == 1 && $value->want_driver == 2)
                                    <td>{{++$i}}</td>
                                    <td>{{ $value->requestNo }}</td>
                                    <td>{{ $value->users->firstname }}</td>
                                    <td>{{ $value->departments->name }}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->startTime)}}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->endTime)}}</td>
                                    <td>{{ $value->passenger }}</td>
                                    <td>{{ $value->location }}</td>
                                    <td>{{ $value->types->name }}</td>
                                    <td> <span class="label label-danger">ยังไม่จัดรถยนต์</span>
                                        <span class="label label-success">จัดคนขับแล้ว</span>
                                    </td>
                                    @if ( Auth::user()->permission_id == 1)
                                    <td>
                                        <a href="{{ route('carset.edit', $value->id )}}"><button type="submit" class="btn btn-success">จัดรถยนต์</button></a>
                                        <button type="submit" class="btn btn-success" disabled>จัดคนขับ</button>
                                        <a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                    </td>
                                    @else
                                    <td><a href="{{ route('carset.edit', $value->id )}}"><button type="button" class="btn btn-success">จัดรถยนต์</button></a>
                                        <a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                    </td>
                                    @endif
                                    <!--  -->

                                    <!-- ยังไม่ได้จัดรถ และ ไม่ต้องการคนขับ -->
                                    @elseif($value->status_set_id == 1 && $value->want_driver == 0)
                                    <td>{{++$i}}</td>
                                    <td>{{ $value->requestNo }}</td>
                                    <td>{{ $value->users->firstname }}</td>
                                    <td>{{ $value->departments->name }}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->startTime)}}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->endTime)}}</td>
                                    <td>{{ $value->passenger }}</td>
                                    <td>{{ $value->location }}</td>
                                    <td>{{ $value->types->name }}</td>
                                    <td>
                                        <span class="label label-danger">ยังไม่จัดรถยนต์</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('carset.edit', $value->id )}}"><button type="submit" class="btn btn-success">จัดรถยนต์</button></a>
                                        <a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                    </td>
                                    @endif
                                    <!--  -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </center><br>
                    @if(count($carset) != 0)
                    <center>{!! $carset->links() !!}</center>

                    @endif
                </div>
                <!--/content-panel -->
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>

    <!-- form delete-->
    @foreach ($carset as $key => $value)
    <form action="{{ route('carset.destroy', $value->id ,)}}" method="post">
        @csrf
        @method('DELETE')
        <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal3-{{$value->id}}" class="modal fade">
            <div class="modal-dialog" style="margin-top: 250px; width: 450px;">
                <div class="modal-content">


                    <div class="modal-body">
                        <div class="form-group form-floating mb-3">
                            <center><img src="{{ URL::asset('img/icon-warning.png') }}" width="20%" alt=""></center>
                        </div>
                        <div class="form-group form-floating mb-3">
                            <center>
                                <H3>คุณต้องการที่จะยกเลิกคำขอหรือไม่</H3>
                            </center>
                        </div>
                        <div class="form-group form-floating mb-3">
                            <center><input type="text" name="detail" class="form-control" style="width: 85%;" placeholder="เหตุผล"></center>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="w-100 btn btn-success" type="submit">บันทึกข้อมูล</button>
                        <button data-dismiss="modal" class="w-100 btn btn-danger" type="button">ยกเลิก</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    @endforeach
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
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger',
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                    title: `คุณต้องการที่จะยกเลิกคำขอหรือไม่`,
                    input: 'text',
                    inputAttributes: {
                        name: 'detail',
                        autocapitalize: 'off'
                    },
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',

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