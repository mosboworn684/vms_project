@include('admin.layout.sidebarrole')
@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> จัดพนักงานขับรถ </h3>
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
                        <table class="table table-hover">
                            <h2><i class="fa-solid fa-id-card"></i> จัดพนักงานขับรถ</h2>
                            <h5>วันที่เริ่มงาน {{$thaiDateHelper->simpleDate($carset->startTime)}}- {{$thaiDateHelper->simpleDate($carset->endTime)}}</h5>
                            @if(count($driver) == 0)
                            <tr>
                                <td colspan="6">ไม่มีพนักงานขับรถให้จัด</td>
                            </tr>
                            <tr>
                                <td colspan="6"><a href="/carset"><button type="button" class="btn  btn-warning">ย้อนกลับ</button></a></td>
                            </tr>
                            @endif
                            <h5 style="text-align: right; margin-right: 10px;"><b>เฉพาะพนักงานที่พร้อมทำงาน</b></h5>
                            <hr>
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>คำนำหน้า</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>อายุ</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>จำนวนงาน<br>ในเดือนนี้</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($driver as $key => $value)
                                    <?php $count = 0; ?>
                                    <td style="text-align:center;">{{++$i}}</td>
                                    <td>{{ $value->prefix->name }}</td>
                                    <td>{{ $value->firstname }} {{ $value->lastname }}</td>
                                    <td style="text-align:center;">{{ \Carbon\Carbon::parse($value->birthday)->age }}</td>
                                    <td>{{ $value->tel }}</td>

                                    @foreach ($requestcar as $key => $valcheck)
                                    <?php
                                    $time = strtotime($valcheck->startTime);
                                    $newformat4 = date('Y-m', $time);

                                    $time2 = strtotime($valcheck->startTime);
                                    $newformat5 = date('Y-m', $time2);
                                    ?>
                                    @if(($valcheck->driver_id == $value->id ) && ($newformat4 == $newformat5))

                                    <?php $count++; ?>
                                    @endif
                                    @endforeach
                                    <td style="text-align:center;">{{$count}} </td>
                                    <?php $count = 0; ?>

                                    @if( $value->status_id == 2)
                                    <td><a data-toggle="modal" href="login.html#myModal4" data-target="#myModal4-{{$value->id}}"><button type="button" class="btn btn-danger">วันลา</button></a></td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td>

                                        <form action="{{ route('managedriver.updatedriver', ['driverid'=>$value->id, 'requestid'=>$carset->id] )}}" method="post">

                                            <a data-toggle="modal" href="login.html#myModal2" data-target="#myModal2-{{$value->id}}"><button type="button" class="btn btn-info">ตารางงาน</button></a>
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success">จัดคนขับ</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </center><br>
                    <!-- รายละเอียด -->
                    @foreach ($driver as $key => $value)
                    <?php $k = 1; ?>
                    <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2-{{$value->id}}" class="modal fade">
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

                                            $time2 = strtotime($begin);
                                            $newformat2 = date('Y-m', $time2);
                                            ?>
                                            @if(($val->driver_id == $value->id ) && ($newformat == $newformat2))

                                            <tr>
                                                <td>{{$k++}}</td>
                                                <td>{{$val->requestNo}}</td>
                                                <td>{{$thaiDateHelper->simpleDateFormat($val->startTime)}}</td>
                                                <td>{{$thaiDateHelper->simpleDateFormat($val->endTime)}}</td>
                                                <!-- <td>
                                                    {{$newformat}}---{{$newformat2}}
                                                </td> -->
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

                    @foreach ($driver as $key => $value)
                    <!-- วันลา -->
                    <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal4-{{$value->id}}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content1">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <center>
                                        <h4 class="modal-title">รายละเอียดวันลา </h4>
                                    </center>
                                </div>

                                <div class="modal-body">
                                    <table class="table2 table-striped table-hover">
                                        <thead>
                                            <tr>

                                                <th scope="col">ตั้งแต่วันที่</th>
                                                <th scope="col">ถึงวันที่</th>
                                                <!-- <th scope="col">สถานะ</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <td>{{$thaiDateHelper->simpleDate($value->starttime)}}</td>
                                            <td>{{$thaiDateHelper->simpleDate($value->endtime)}}</td>
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
                </div>
                <!--/content-panel -->
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>

    <!-- form edit -->
    @include('admin.layout.script')
    </body>

    </html>