@include('admin.layout.sidebarrole')

@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<section id="main-content">
    <section class="wrapper"><br>
        <div class="content-panel">
            <ul class="nav nav-pills" style="margin-top: -15px;">
                <li><a href="/report" style="color:black;">สรุปข้อมูลการใช้รถ</a></li>
                <li class="active"><a href="#" style="background-color:white;color:#ffa200;border-bottom: 4px solid #ffa200;">สรุปข้อมูลพนักงาน</a></li>
                @if(Auth::user()->permission_id == 1)
                <li><a href="/reportdriver" style="color:black;">สรุปข้อมูลพนักงานขับรถยนต์</a></li>
                @endif
            </ul>
            <div class="row ">
                <a href="/reportpdfuser"><button type="submit" class="btn btn-success" style="float: right; margin-right:55px;margin-top:10px;">ออกรายงาน</button></a>
                <div class="col-md-12">
                    <center>
                        @if(isset($user))
                        <table class="table1 table-hover">
                            <h2> ข้อมูลพนักงาน </h2>
                            <h5 style="text-align: right; margin-right:10px; margin-top:10px;"><b>เฉพาะพนักงานที่ยังทำงานอยู่</b></h5>
                            <hr style="margin-top:5px;">
                            <div class="col-md-12">
                                <form action="{{ route('reportuser1.search') }}" method="get">
                                    @csrf

                                    <button type="submit" class="btn btn-primary" style="float: right; margin-right:40px;margin-top:0px;">ค้นหา</button></a>
                                    <input type="search" id="search" name="name" class="form-control" style="float: right; margin-right:10px;margin-top:0px; width: 15%;">
                                    <select class="form-control" name="select" id="select" style="float: right; margin-right:10px;margin-top:0px;width:10%;" onchange="myFunction()">
                                        <option value="1">ทั้งหมด</option>
                                        <option value="2">รหัสพนักงาน</option>
                                        <option value="3">ชื่อ-นามสกุล</option>
                                        <option value="4">เบอร์โทรศัพท์</option>
                                        <option value="5">แผนก</option>
                                    </select>
                                </form>
                            </div><br>

                            <br>
                            <thead>
                                @if(count($user)==0)
                                <tr>
                                    <td><b>ไม่มีข้อมูล</b></td>
                                </tr>
                                @else
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>รหัสพนักงาน</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>สิทธิ์</th>
                                    <th>แผนก</th>
                                </tr>
                            </thead>
                            @endif
                            <tbody>
                                @foreach($user as $key => $value)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{ $value->employeenumber }}</td>
                                    <td style="text-align: left;">{{ $value->prefix->name }}{{ $value->firstname }} {{ $value->lastname }}</td>
                                    <td>{{ $value->tel }}</td>
                                    <td>{{ $value->permission->name }}</td>
                                    <td>{{ $value->department->name }}</td>
                                </tr>
                                @endforeach
                                @else
                                @endif
                            </tbody>
                        </table>
                        <center>
                            <div class="pagination-block">
                                {{ $user->withQueryString()->links('admin.layout.paginationlinks') }}
                            </div>
                        </center>
                </div>
            </div><br>
        </div>
    </section>
    @include('admin.layout.script')

    <script>
        function myFunction() {
            select = document.getElementById("select").value
            console.log(select)
            if (select == 1) {
                document.getElementById("search").disabled = true;
            } else {
                document.getElementById("search").disabled = false;
            }
        }
        window.onload = myFunction;
    </script>

    </body>

    </html>