@include('admin.layout.sidebarrole')

@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> การอนุมัติ </h3>

        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
            <div class="col-md-12 mt">
                <div class="content-panel">
                    <center>
                        <table class="table1 table-hover">
                            <h2> รายการอนุมัติ</h2>
                            <hr>
                            <thead>
                                @if(count($record)==0)
                                <b>ไม่มีรายการอนุมัติ</b>
                                @else
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขที่การขอใช้รถยนต์</th>
                                    <th>แผนก</th>
                                    <th>ประเภทรถยนต์</th>
                                    <th>สถานที่</th>
                                    <th>ขอใช้วันที่</th>
                                    <th>วันที่สร้างคำขอ</th>
                                    <th align="center" colspan="3">ดำเนินการ</th>
                                </tr>
                                @endif
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($record as $key => $value)
                                    <td>{{++$i}}</td>
                                    <td>{{$value->requestNo}}</td>
                                    <td>{{$value->departments->name}}</td>
                                    <td>{{ $value->types->name }}</td>
                                    <td>{{ $value->location }}</td>
                                    <td>{{ $thaiDateHelper->simpleDateFormat($value->startTime) }}</td>
                                    <td>{{ $thaiDateHelper->simpleDateFormat($value->endTime) }}</td>
                                    <td style="width:2%;">
                                        <a data-toggle="modal" data-target="#myModal2-{{$value->id}}" href="login.html#myModal2"><button type="button" class="btn btn-info">รายละเอียด</button></a>
                                    </td>
                                    <td style="width:1%;">
                                        <form action="{{ route('approve.update', $value->id )}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success">อนุมัติ</button>
                                        </form>
                                    </td>
                                    <td style="width:1%;"> 
                                    <a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if(count($record) != 0)
                        <center>{!! $record->links() !!}</center>
                        @endif

                        @if ($message = Session::get('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '{{$message}}',
                            })
                        </script>
                        @endif
                    </center>
                </div>
                <!-- modal รายละเอียด -->
                @foreach ($record as $key => $value)
                <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2-{{$value->id}}" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content1">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <center>
                                    <h4 class="modal-title">รายละเอียดการขอใช้รถ</h4>
                                </center>
                            </div>
                            <!--  -->
                            <div class="modal-body">
                                <table class="table2 table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">หมายเลขคำขอ</th>
                                            <th scope="col">พนักงานขับรถ</th>
                                            <th scope="col">วันที่ใช้งาน</th>
                                            <th scope="col">ขอใช้ถึงวันที่</th>
                                            <th scope="col">สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$value->requestNo}}</td>
                                            @if($value->want_driver == 0)
                                            <td>ไม่ต้องการพนักงานขับรถ</td>
                                            @elseif ($value->want_driver == 1)
                                            <td>ยังไม่จัดพนักงานขับรถ</td>
                                            @else
                                            <td>{{$value->drivers->firstname}} {{$value->drivers->lastname}}</td>
                                            @endif
                                            <td>{{$thaiDateHelper->simpleDateFormat($value->startTime)}}</td>
                                            <td>{{$thaiDateHelper->simpleDateFormat($value->endTime)}}</td>
                                            @if ($value->status_set_id == 1)
                                            <td>ยังไม่ได้รับการจัดรถ</td>
                                            @else
                                            <td>ได้รับการจัดรถแล้ว</td>
                                            @endif
                                        </tr>
                                    </tbody>

                                    <!--  -->
                                    <thead>
                                        <tr>
                                            <th scope="col">ผู้ขอใช้</th>
                                            <th scope="col">แผนก</th>
                                            <th scope="col">จำนวนผู้เดินทาง</th>
                                            <th scope="col">สถานที่</th>
                                            <th scope="col">หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$value->users->prefix->name}} {{$value->users->firstname}} {{$value->users->lastname}}</td>
                                            <td>{{$value->departments->name}}</td>
                                            <td>{{$value->passenger}}</td>
                                            <td>{{$value->location}}</td>
                                            <td>{{$value->detail}}</td>
                                        </tr>
                                    </tbody>
                                    <!--  -->
                                    <thead>
                                        <tr>
                                            <th scope="col">ขอใช้รถ</th>
                                            <th scope="col">ประเภทรถยนต์</th>
                                            <th scope="col">ทะเบียนรถยนต์</th>
                                            <th scope="col">ยี่ห้อ</th>
                                            <th scope="col">รุ่น</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @if($value->department_car == 1)
                                            <td>ใช้รถของส่วนกลาง</td>
                                            @else
                                            <td>ใช้รถของแผนก</td>
                                            @endif

                                            <td>{{$value->types->name}}</td>
                                            @if ($value->status_set_id == 1)
                                            <td>ยังไม่ได้รับการจัดรถ</td>
                                            @else
                                            <td>{{$value->cars->regisNumber}}</td>
                                            @endif

                                            @if ($value->status_set_id == 1)
                                            <td>ยังไม่ได้รับการจัดรถ</td>
                                            @else
                                            <td>{{$value->cars->brands->name}}</td>
                                            @endif

                                            @if ($value->status_set_id == 1)
                                            <td>ยังไม่ได้รับการจัดรถ</td>
                                            @else
                                            <td>{{$value->cars->models->name}}</td>
                                            @endif
                                        </tr>
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
                </div>@endforeach
                <!--  -->
                <!--/content-panel -->
            </div><!-- /col-md-12 -->
        </div><!-- /row -->

        @foreach ($record as $key => $value)
        <form action="{{ route('approve.destroy', $value->id) }}" method="post">
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
                                    <H3>คุณต้องการที่จะไม่อนุมัติคำขอหรือไม่ </H3>
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
    </section>
    @include('admin.layout.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `ต้องการไม่อนุมัติใช่หรือไม่`,
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