@include('admin.layout.sidebarrole')
@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> เปลี่ยนรถยนต์ </h3>

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
                            <h2> <i class="fa-solid fa-car"></i> เปลี่ยนรถยนต์
                                @if(count($car) == 0)
                                <tr>
                                    <td colspan="10">ไม่มีรถให้เปลี่ยน</td>
                                </tr>
                                <tr>
                                    <td colspan="10"><a href="/recordRequest"><button type="button" class="btn  btn-warning">ย้อนกลับ</button></a></td>
                                </tr>
                                @endif
                                <h5 style="text-align: right; margin-right: 80px;"><b>เฉพาะรถยนต์ที่พร้อมใช้งาน</b></h5>
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
                                    <td>{{ $value->capacity }}</td>
                                    <td>{{ $value->mileage}}</td>

                                    <td>

                                        <a data-toggle="modal" href="login.html#myModal2" data-target="#myModal2-{{$value->id}}"><button type="button" class="btn btn-info">ตารางงาน</button></a>

                                        <a data-toggle="modal" href="login.html#myModal2" data-target="#myModal3-{{$value->id}}"><button type="submit" class="btn btn-success">เปลี่ยนรถ</button></a>
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
        <?php $k = 1;?>
        @foreach ($car as $key => $value)
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
                            @if(count($requestcar)==0)
                            <tr>
                                <td><b>ไม่มีข้อมูล</b></td>
                            </tr>
                            @else
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">หมายเลขคำขอ</th>
                                    <th scope="col">วันที่ใช้งาน</th>
                                    <th scope="col">ขอใช้ถึงวันที่</th>
                                    <th scope="col">สถานะ</th>
                                </tr>
                            </thead>
                            @endif
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
                                    <td>
                                        {{$newformat}}---{{$newformat2}}
                                    </td>
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

        <!-- form change-->
        @foreach ($car as $key => $value)
        <form action="{{ route('changecar.changecar', ['carid'=>$value->id,'requestid'=>$carset->id] )}}" method="post">
            @csrf
            @method('PUT')
            <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal3-{{$value->id}}" class="modal fade">
                <div class="modal-dialog" style="margin-top: 100px; width: 600px;">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-group form-floating mb-3">
                                <table class="table2 table-striped table-hover">
                                    <thead>
                                        <h3 style="text-align: center;">รถที่ใช้อยู่ขณะนี้</h3>
                                        <tr>
                                            <th>ประเภทรถยนต์</th>
                                            <th>สี</th>
                                            <th>หมายเลขทะเบียน</th>
                                            <th>ยี่ห้อ</th>
                                            <th>รุ่น</th>

                                        </tr>
                                        <tr>
                                            <td>{{ $carset->types->name }}</td>
                                            <td>{{$carset->cars->colors->name}}</td>
                                            <td>{{$carset->cars->regisNumber}}</td>
                                            <td>{{$carset->cars->brands->name}}</td>
                                            <td>{{$carset->cars->models->name}}</td>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="form-group form-floating mb-3">
                                <center>
                                    <h2> <i class="fa-solid fa-arrow-down-long"></i></h2>
                                </center>

                            </div>
                            <div class="form-group form-floating mb-3">
                                <table class="table2 table-striped table-hover">
                                    <thead>
                                        <h3 style="text-align: center;">รถที่ต้องการเปลี่ยน</h3>
                                        <tr>
                                            <th>ประเภทรถยนต์</th>
                                            <th>สี</th>
                                            <th>หมายเลขทะเบียน</th>
                                            <th>ยี่ห้อ</th>
                                            <th>รุ่น</th>

                                        </tr>
                                        <tr>
                                            <td>{{$value->types->name}}</td>
                                            <td>{{$value->colors->name}}</td>
                                            <td>{{$value->regisNumber}}</td>
                                            <td>{{$value->brands->name}}</td>
                                            <td>{{$value->models->name}}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="form-group form-floating mb-3">
                                <center>
                                    <H4>กรุณาใส่เหตุที่เปลี่ยนรถ</H4>
                                </center>
                            </div>
                            <div class="form-group form-floating mb-3">
                                <center><input type="text" name="detail" class="form-control" style="width: 85%;" placeholder="เหตุผลที่เปลี่ยนรถยนต์" required></center>
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
    </body>

    </html>