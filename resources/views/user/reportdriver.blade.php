@include('admin.layout.sidebarrole')

@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<section id="main-content">
    <section class="wrapper"><br>
        <div class="content-panel">
        <ul class="nav nav-pills" style="margin-top: -15px;">
                <li><a href="/report" style="color:black;">สรุปข้อมูลการใช้รถ</a></li>
                <li><a href="/reportuser" style="color:black;">สรุปข้อมูลพนักงาน</a></li>
                @if(Auth::user()->permission_id == 1)
                <li class="active"><a href="#" style="background-color:white;color:#ffa200;border-bottom: 4px solid #ffa200;">สรุปข้อมูลพนักงานขับรถยนต์</a></li>
                @endif
            </ul>
            <div class="row ">

                <div class="col-md-12">
                    <center>

                        <table class="table1 table-hover">
                            <h2> ข้อมูลพนักงานขับรถยนต์</h2>
                            <h5 style="text-align: right; margin-right:10px; margin-top:10px;"><b>เฉพาะพนักงานขับรถที่ยังทำงานอยู่</b></h5>
                            <hr  style="margin-top:5px;">
                            <div class="col-md-12">
                                <form action="{{ route('reportdriver1.search') }}" method="get">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="float: right; margin-right:40px;margin-top:0px;">ค้นหา</button></a>
                                    <input type="search" name="name" class="form-control" style="float: right; margin-right:10px;margin-top:0px; width: 15%;">
                                </form>
                            </div><br>
                            <br>
                            <thead>
                            @if(count($driver)==0)
                            <tr>
                                <td><b>ไม่มีข้อมูล</b></td>
                            </tr>
                            @else
                                <tr>
                                    <th>ลำดับที่</th>
                                    <td>รหัสพนักงาน</td>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>เบอร์โทรศัพท์</th>
                                </tr>
                            </thead>
                            @endif
                            <tbody>
                                @foreach($driver as $key => $value)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{ $value->drivernumber_id }}</td>
                                    <td style="text-align: left;">{{ $value->prefix->name }}{{ $value->firstname }} {{ $value->lastname }}</td>
                                    <td>{{ $value->tel }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <center>
                            <div class="pagination-block">
                                {{ $driver->withQueryString()->links('admin.layout.paginationlinks') }}
                            </div>
                        </center>
                </div>
            </div><br>
        </div>
    </section>
    @include('admin.layout.script')
    </body>

    </html>
