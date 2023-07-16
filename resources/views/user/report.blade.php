@include('admin.layout.sidebarrole')
@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<section id="main-content">
    <section class="wrapper"><br>
        <div class="content-panel">
        <ul class="nav nav-pills" style="margin-top: -15px;">
                        <li class="active" ><a href="#" style="background-color:white;color:#ffa200;border-bottom: 4px solid #ffa200;">สรุปข้อมูลการใช้รถ</a></li>
                        <li><a href="/reportuser" style="color:black;">สรุปข้อมูลพนักงาน</a></li>
                        @if(Auth::user()->permission_id == 1)
                        <li><a href="/reportdriver" style="color:black;">สรุปข้อมูลพนักงานขับรถยนต์</a></li>
                        @endif
                    </ul>
                <a href="/reportpdf"><button type="button" class="btn btn-success" style="float: right;margin-right:45px;">ออกรายงาน</button></a>
            <div class="row">
                <div class="col-md-12 mt">
                    <center>
                        @if(isset($recordrequest))
                        <table class="table1 table-hover">
                            <h2> รายงานการใช้รถยนต์</h2>
                            <hr>
                            <div class="col-md-12">
                                <form action="{{ route('report1.search') }}" method="get">
                                    @csrf
                                    <br>
                                    <div class="form-group">
                                        <!--จนถึง--><input type="date" id="end_time" name="dateend" class="form-control" style="float: right;margin-right:10px; width: 8%;">
                                        <label for="" style="float: right;margin-top:0px; margin-right:10px;">จนถึง</label>
                                        <!--ตั้งแต่--> <input type="date" id="start_time" name="datestart" class="form-control" style="float: right;margin-right:10px; width: 8%;" onchange=" myEndtime()">
                                        <label for="" style="float: right;margin-top:0px; margin-right:10px;">ตั้งแต่</label>

                                        <input type="search" name="name" id="search" class="form-control" style="float: right; margin-right:10px;width: 10%;" placeholder="กรุณาใส่คำค้น">
                                        <select class="form-control" name="select" id="select" style="float: right; margin-right:10px;margin-top:0px;width:10%;" onchange="myFunction()">
                                            <option value="1">ทั้งหมด</option>
                                            <option value="2">แผนก</option>
                                            <option value="3">ชื่อ-นามสกุล</option>
                                            <option value="4">เลขทะเบียนรถ</option>
                                            <option value="5">คืนรถยนต์ล่าช้า</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="float: right;margin-right:45px; margin-top:10px;">ค้นหา</button></a>
                                </form>
                            </div>
                            <hr>
                            <thead>
                                @if(count($recordrequest)==0)
                                <tr>
                                    <td><b>ไม่มีข้อมูล</b></td>
                                </tr>
                                @else
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>วันที่ขอใช้รถ</th>
                                    <th>รหัสคำขอ</th>
                                    <th>เลขทะเบียน</th>
                                    <th style="width: 250px;">ผู้ขอใช้</th>
                                    <th>เบอร์ติดต่อผู้ใช้</th>
                                    <th>วันที่ใช้งาน</th>
                                    <th>ระยะทางใน<br>
                                       การใช้งาน (กม.)</th>
                                    <th>จำนวนเงินที่<br>เติมน้ำมัน(บาท)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @endif
                            <tbody>
                                @foreach($recordrequest as $key => $value)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$thaiDateHelper->simpleDate($value->created_at)}}</td>
                                    <td>{{$value->requestNo}}</td>
                                    <td>{{$value->cars->regisNumber}}</td>
                                    <td style="padding-left: 40px; text-align: left;">{{$value->users->prefix->name}} {{$value->users->firstname}} {{$value->users->lastname}}</td>
                                    <td>{{$value->users->tel}}</td>
                                    <td>{{$thaiDateHelper->simpleDateFormat($value->startTime)}}</td>
                                    <td>{{$value->run_mileage}}</td>
                                    <td style="text-align: right; padding-right:60px;">{{number_format($value->price_oil)}}</td>
                                    <th><a href="{{ route('reportdetails.exportpdfdetails', $value->id )}}">รายละเอียด</a></th>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </center>
                    <center>
                        <div class="pagination-block">
                            {{ $recordrequest->withQueryString()->links('admin.layout.paginationlinks') }}
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </section>
    <script>
        function myEndtime() {
            const x = document.getElementById("start_time")
            const y = document.getElementById("end_time")
            console.log('test')
            y.value = x.value
            y.min = x.value
        }

        function myFunction() {
            select = document.getElementById("select").value
            console.log(select)
            if (select == 1||select == 5) {
                document.getElementById("search").disabled = true;
            } else {
                document.getElementById("search").disabled = false;
            }
        }
        window.onload = myFunction;

    </script>

    @if ($message = Session::get('errordate'))
    <script>
        //error วันที่
        Swal.fire({
            icon: 'error',
            title: '{{$message}}',
        })
    </script>
    @endif
    @include('admin.layout.script')
    </body>

    </html>
