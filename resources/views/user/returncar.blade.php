@include('admin.layout.sidebarrole')
@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12 mt">
                <div class="content-panel">
                    <ul class="nav nav-pills" style="margin-top: -15px;">
                        <li><a href="/recordRequest" style="color:black;">ยังไม่คืนรถ</a></li>
                        <li><a href="#" style="background-color:white;color:#ffa200;border-bottom: 4px solid #ffa200;">คืนรถแล้ว</a></li>
                    </ul>
                    <center>
                        <table class="table1 table-hover">
                            <h2> <i class="fa-solid fa-floppy-disk"></i>คืนรถแล้ว</h2>
                            <hr>
                            <thead>
                                @if(count($data)==0)
                                <tr>
                                    <td><b>ไม่มีข้อมูล</b></td>
                                </tr>
                                @else
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>หมายเลขคำขอ</th>
                                    <th>เลขไมล์ก่อนใช้งาน</th>
                                    <th>เลขไมล์หลังใช้งาน</th>
                                    <th>ระยะทางที่ใช้เดินทาง</th>
                                    <th>ราคาน้ำมันที่เติม (บาท)</th>
                                    <th>ดูสลิป</th>
                                    <th>หมายเหตุ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @endif
                            <tbody>
                                <tr>
                                    @foreach ($data as $key => $value)
                                    <td>{{++$i}}</td>
                                    <th>{{$value->requestNo}}</th>
                                    <td>{{$value->first_mileage}}</td>
                                    <td>{{$value->current_mileage}}</td>
                                    <td>{{$value->run_mileage}}</td>
                                    <td style="text-align: right;">{{number_format($value->price_oil)}}</td>
                                    <td><a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3">คลิก</a></td>
                                    <td>{{$value->returndetail}}</td>
                                    <td><a data-toggle="modal" data-target="#myModal2-{{$value->id}}" href="login.html#myModal2"><button type="button" class="btn btn-info">รายละเอียด</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </center>
                    @if(count($data) != 0)
                    <center>{!! $data->links() !!}</center>

                    @endif
                </div>
                <!--/content-panel -->
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>
    @if ($message = Session::get('successreturn'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{$message}}',
        })
    </script>
    @endif

    <!-- modal รายละเอียด -->
    @foreach ($data as $key => $value)
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
                                <th scope="col">วันที่ขอใช้</th>
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

    <!-- modal โชว์รูป -->
    @foreach ($data as $key => $value)
    <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal3-{{$value->id}}" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content1">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center>
                        <h4 class="modal-title">สลิป</h4>
                    </center>
                </div>

                <!--  -->
                <div class="modal-body">
                    <?php $img = explode(',', $value->slip_oil); ?>
                    @foreach ($img as $key => $value1)
                    <center><img src="{{ asset('/storage/images/'.$value1) }}" style="height:25%; width:25%" /></center>
                    <br>

                    @endforeach
                </div>
                <!--  -->

                <div class="modal-footer">
                    <button data-dismiss="modal" class="w-100 btn btn-lg btn btn-default" type="button">ปิด</button>
                </div>

            </div>
        </div>
    </div>@endforeach
    <!--  -->


    <!--  -->
    @include('admin.layout.script')
    </body>

    </html>