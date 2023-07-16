@include('admin.layout.sidebarrole')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
            <div class="col-md-12 mt">
                <div class="content-panel">
                <ul class="nav nav-pills" style="margin-top: -15px;">
                        <li><a href="/carset" style="color:black;">รอจัด</a></li>
                        <li><a href="#" style="background-color:white;color:#ffa200;border-bottom: 4px solid #ffa200;">จัดแล้ว</a></li>
                    </ul>
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
                                    <th>หมายเลขอ้างอิง</th>
                                    <th>ผู้จอง</th>
                                    <th>แผนก</th>
                                    <th>วันที่ใช้งาน</th>
                                    <th>จำนวนผู้เดินทาง</th>
                                    <th>สถานที่</th>
                                    <th>ประเภทรถยนต์</th>
                                    <th>สถานะ</th>
                               
                                </tr>
                            </thead>
                            @endif
                            <tbody>
                                <tr>
                                    @foreach ($carset as $key => $value)
                                    <td>{{++$i}}</td>
                                    <td>{{ $value->requestNo }}</td>
                                    <td>{{ $value->users->firstname }}</td>
                                    <td>{{ $value->departments->name }}</td>
                                    <td>{{ $value->startTime }}</td>
                                    <td>{{ $value->passenger }}</td>
                                    <td>{{ $value->location }}</td>
                                    <td>{{ $value->types->name }}</td>
                                    
                                    @if ($value->status_set_id == 2 && $value->want_driver == 0)
                                    <td> <span class="label label-success">จัดรถยนต์แล้ว</span>
                                    
                                    </td>
                                    @elseif ($value->status_set_id == 2 && $value->want_driver == 2)
                                    <td><span class="label label-success">จัดรถยนต์แล้ว</span>
                                        <span class="label label-success">จัดคนขับแล้ว</span>
                                    </td>

                                    @endif
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
    @include('admin.layout.script')
    </body>

    </html>