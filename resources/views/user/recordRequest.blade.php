@include('admin.layout.sidebarrole')
@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
@include('admin.layout.scriptimg')
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <li class="active" ><a href="#" style="background-color:white;color:#ffa200;border-bottom: 4px solid #ffa200;">ยังไม่คืนรถ</a></li>
                        <li><a href="/returncar" style="color:black;">คืนรถแล้ว</a></li>
                    </ul>
                   
                    <a data-toggle="modal" href="login.html#myModal1"><button type="button" class="btn btn-warning" style="float: right; margin-right:55px;margin-top:10px;color:black;">ขอใช้รถยนต์</button></a>
                    <center>
                        <table class="table1 table-hover">
                            <h2><i class="fa-solid fa-floppy-disk"></i> บันทึกการขอใช้รถยนต์</h2>
                            <hr>
                            <thead>
                                @if(count($data)==0)
                                <tr>
                                    <td><b>ไม่มีข้อมูล</b></td>
                                </tr>
                                @else
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขที่การขอใช้รถยนต์</th>
                                    <th>แผนก</th>
                                    <th>ประเภทรถยนต์</th>
                                    <th>สถานที่</th>
                                    <th>วันที่ใช้งาน</th>
                                    <th>ขอใช้ถึงวันที่</th>
                                    <th>สถานะ</th>
                                    <th>ดำเนินการ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            @endif
                            <tbody>
                                <tr>
                                    @foreach ($data as $key => $value)

                                    @if($value->endTime < $datetime) <td style="color:red; font-weight: bold;">{{++$i}}</td>
                                        <td style="color:red; font-weight: bold;">{{$value->requestNo}}</td>
                                        <td style="color:red; font-weight: bold;">{{$value->departments->name}}</td>
                                        <td style="color:red; font-weight: bold;">{{ $value->types->name }}</td>
                                        <td style="color:red; font-weight: bold;">{{ $value->location }}</td>
                                        <td style="color:red; font-weight: bold;">{{ $thaiDateHelper->simpleDateFormat($value->startTime) }}</td>
                                        <td style="color:red; font-weight: bold;">{{ $thaiDateHelper->simpleDateFormat($value->endTime) }}</td>
                                        <td style="color:red; font-weight: bold;">{{ $value->status->name }}</td>

                                        @else
                                        <td>{{++$i}}</td>
                                        <td>{{ $value->requestNo}}</td>
                                        <td>{{ $value->departments->name}}</td>
                                        <td>{{ $value->types->name }}</td>
                                        <td>{{ $value->location }}</td>
                                        <td>{{ $thaiDateHelper->simpleDateFormat($value->startTime) }}</td>
                                        <td>{{ $thaiDateHelper->simpleDateFormat($value->endTime) }}</td>
                                        <td>{{ $value->status->name }}</td>

                                        @endif

                                        @if ($value->status_id == "3" && $value->user_id == Auth::user()->id )
                                        <td style="text-align: left;">
                                            <form action="{{ route('recordRequest.destroy', $value->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a data-toggle="modal" data-target="#myModal2-{{$value->id}}" href="login.html#myModal2"><button type="button" class="btn btn-info">รายละเอียด</button></a>
                                                @if($datetime<=$value->startTime)
                                                    <a data-toggle="modal" data-target="#myModal4-{{$value->id}}" href="login.html#myModal4"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                                    @endif
                                            </form>
                                        </td>
                                        @if($datetime>=$value->startTime)
                                        <td style="text-align: left;">
                                            <a data-toggle="modal" data-target="#myModal3-{{$value->id}}" href="login.html#myModal3"><button type="submit" class="btn btn-success">คืนรถ</button>
                                        </td>
                                        @endif

                                        @elseif($value->status_id == "3" && Auth::user()->permission_id != 3 )
                                        <td style="text-align: left;">
                                            <form action="{{ route('recordRequest.destroy', $value->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a data-toggle="modal" data-target="#myModal2-{{$value->id}}" href="login.html#myModal2"><button type="button" class="btn btn-info">รายละเอียด</button></a>
                                                @if($datetime<=$value->startTime)
                                                    <a data-toggle="modal" data-target="#myModal4-{{$value->id}}" href="login.html#myModal4"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                            </form>
                                        </td>

                                        <td style="text-align: left;"><a href="{{ route('recordRequest.edit', $value->id )}}"><button type="submit" class="btn btn-success">เปลี่ยนรถ</button></a></td>
                                        @endif

                                        @else
                                        <form action="{{ route('recordRequest.destroy', $value->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <td style="text-align: left;"><a data-toggle="modal" data-target="#myModal2-{{$value->id}}" href="login.html#myModal2"><button type="button" class="btn btn-info">รายละเอียด</button></a>
                                                <a data-toggle="modal" data-target="#myModal4-{{$value->id}}" href="login.html#myModal4"><button type="button" class="btn btn-danger">ยกเลิก</button></a>
                                            </td>
                                        </form>
                                        <td></td>
                                        @endif
                                </tr>
                                @csrf
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
    @if ($message = Session::get('errorunit'))
    <script>
        //error จำนวนผู้เดินทาง
        Swal.fire({
            icon: 'error',
            title: '{{$message}}',
        })
    </script>
    @elseif ($message = Session::get('errordate'))
    <script>
        //error วันที่
        Swal.fire({
            icon: 'error',
            title: '{{$message}}',
        })
    </script>
    @elseif ($message = Session::get('errordate1'))
    <script>
        //error ขอใช้รถยนต์เวลานี้ไปแล้ว
        Swal.fire({
            icon: 'error',
            title: '{{$message}}',
        })
    </script>
    @elseif ($message = Session::get('success'))
    <script>
        // ขอใช้รถยนต์สำเร็จ
        Swal.fire({
            icon: 'success',
            title: '{{$message}}',
        })
    </script>
    @elseif ($message = Session::get('errormileage'))
    <script>
        //error ไมล์รถ
        Swal.fire({
            icon: 'error',
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
    </div>
    @endforeach
    <!--  -->

    <!-- modal คืนรถ -->
    @foreach ($data as $key => $value)
    <form action="{{ route('recordRequest.update', $value->id ,)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal3-{{$value->id}}" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center>
                            <h4 class="modal-title">การขอใช้รถยนต์</h4>
                        </center>
                    </div>
                    <div class="modal-body">
                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">เลขไมล์ก่อนใช้งาน</label>
                            @if($value->status_set_id==2)
                            <input type="text" class="form-control" name="first_mileage" value="{{$value->first_mileage}}" required="required" autofocus readonly>
                            @endif
                        </div>
                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">เลขไมล์หลังใช้งาน</label>
                            <input type="text" class="form-control" name="current_mileage" required="required" autofocus>
                        </div>

                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">จำนวนเงินที่เติมน้ำมัน(บาท)</label>
                            <input type="text" class="form-control" name="price_oil" required="required" autofocus>
                        </div>
                        <div class="form-group form-floating mb-3">
                            <!-- <div class="input-group control-group increment"> -->
                            <!-- <input type="file"  class="form-control" id="upload_file" onchange="preview_image();" multiple>
                            <div id="image_preview">
                            </div> -->
                            <label for="floatingEmail">สลิป</label>
                            <input id="fileupload" class="form-control" type="file" name="slip_oil[]" multiple>
                            <hr />
                            <div id="dvPreview">
                            </div>

                            <!-- <div class="input-group-btn">
                                    <button class="btn btn-success" type="button" id="addimg"><i class="glyphicon glyphicon-plus"></i>เพิ่ม</button>
                                </div> -->
                            <!-- </div> -->
                        </div>
                        <!-- <div class="form-group form-floating mb-3">
                            <div class="clone hide">
                                <div class="control-group input-group" style="margin-top:10px">
                                    <input type="file" name="slip_oil[]" class="form-control" onchange="onFileSelected(event)">
                                    <img id="myimage[]" height="80" width="100">
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger" type="button" id="removeimg"><i class="glyphicon glyphicon-remove"></i> ลบ</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">หมายเหตุ (ถ้าไม่มีให้ใส่ -)</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="returndetail" required="required" autofocus></textarea>
                            <span class="file-custom"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="w-100 btn btn-lg btn-danger" type="button">ยกเลิก</button>
                        <button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
    </form> @endforeach

    <!-- model ขอใช้รถ -->
    <form class="needs-validation" action="{{ route('recordRequest.store') }}" method="post">
        @csrf
        <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal1" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center>
                            <h4 class="modal-title">การขอใช้รถยนต์</h4>
                        </center>
                    </div>
                    <div class="modal-body">
                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">ประเภทรถยนต์</label>
                            <select class="form-control" name="type_id" required="required" aria-label="select example" autofocus>
                                <option value="">กรุณาระบุประเภทรถยนต์</option>
                                @foreach ($type as $key => $value)
                                <option value="{{ $value->id }}" @selected(old('type_id')==$value->id) >
                                    {{ $value->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group form-floating mb-3">
                            <input type="radio" name="department_car" id="optionsRadios1" value="{{Auth::user()->department_id}}" checked>
                            ขอใช้รถยนต์ของแผนก
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="department_car" id="optionsRadios2" value="1">
                            ขอใช้รถยนต์ของส่วนกลาง
                        </div>
                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">จำนวนผู้เดินทาง </label>
                            <input type="text" class="form-control" id="numb" name="passenger" value="{{old('passenger')}}" required="required" autofocus min="1" max="99" maxlength="2" oninput="validateinput()">

                            <p id="demo" style="color:red"></p>
                        </div>
                        <div class="form-group form-floating mb-3">
                            <input type="checkbox" id="checkdriver" value="1" name="want_driver" @checked(old('want_driver' ))>
                            ต้องการคนขับรถ
                        </div>

                        <div class="form-group form-floating mb-3">
                            <label for="floatingPassword">วันที่ใช้รถ</label>
                            <input type="datetime-local" class="form-control" name="startTime" id="start_time" value="{{ date('Y-m-d\TH:i', strtotime($datetime)) }}" min="{{ date('Y-m-d\TH:i', strtotime($datetime)) }}" oninvalid="this.setCustomValidity('กรุณาเลือกวันและเวลาปัจจุบัน')" onchange="myEndtime()">
                            <br>
                            <label for="floatingPassword">ขอใช้ถึงวันที่</label>

                            <input type="hidden" name="checktime" value="{{ date('Y-m-d\TH:i', strtotime($datetime)) }}">

                            <input type="datetime-local" class="form-control" name="endTime" id="end_time" value="{{ date('Y-m-d\TH:i', strtotime($datetime)) }}" min="{{ date('Y-m-d\TH:i', strtotime($datetime)) }}" oninvalid="this.setCustomValidity('กรุณาเลือกวันและเวลาให้มากกว่าวันที่ขอใช้')">
                            <p></p>
                        </div>

                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">สถานที่</label>
                            <input type="text" class="form-control" name="location" value="{{old('location')}}" required="required" autofocus>
                        </div>

                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">หมายเหตุ (ถ้าไม่มีให้ใส่ - )</label>
                            <input type="text" class="form-control" name="detail" placeholder="หากมีรายละเอียด" required="required" value="{{old('detail')}}">
                            <input type="hidden" class="form-control" name="user_id" value="{{Auth::user()->id}}">
                            <input type="hidden" class="form-control" name="requestNo" value="VMS{{rand(0, 9999)}}">
                            <input type="hidden" class="form-control" name="status_id" value="1">
                        </div>
                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail" style="color:red;"><b>กรุณาใส่ข้อมูลให้ครบ</b></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="w-100 btn btn-lg btn-danger" type="button">ยกเลิก</button>
                        <button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--  -->

    <!-- modal ลบคำขอ -->
    @foreach ($data as $key => $value)
    <form action="{{ route('recordRequest.destroy', $value->id ,)}}" method="post">
        @csrf
        @method('DELETE')
        <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal4-{{$value->id}}" class="modal fade">
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
                    </div>
                    <div class="modal-footer">
                        <button class="w-100 btn btn-success" type="submit">ตกลง</button>
                        <button data-dismiss="modal" class="w-100 btn btn-danger" type="button">ยกเลิก</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    @endforeach
    <!--  -->


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    @include('admin.layout.script')

    <!-- <script type="text/javascript">
        $(document).ready(function() {
            $("#addimg").click(function() {
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click", "#removeimg", function() {
                $(this).parents(".control-group").remove();
            });
        });
    </script> -->
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="jquery.form.js"></script>

    <script>
        function myFunction() {
            // Get the value of the input field with id="numb"
            const x = document.getElementById("numb");
            // If x is Not a Number or less than one or greater than 10
            let text;
            let check = x.value.includes(".")



            if (x.value >= 1 && check == false) {
                text = "";
                console.log("ok")
            } else {
                text = "กรุณาใส่ผู้เดินทางที่ถูกต้อง";
                document.getElementById("numb").focus();
            }
            document.getElementById("demo").innerHTML = text;
        }

        function myEndtime() {
            const x = document.getElementById("start_time")
            const y = document.getElementById("end_time")
            console.log('test')
            y.value = x.value
            y.min = x.value
        }

        function validateinput() {
            $(document).ready(function() {
                $('#numb').on('keypress', function(event) {
                    if ((event.which < 48 || event.which > 57) && event.which != 45 || event.key === "-") {
                        event.preventDefault();
                    }
                });
            });
        }

        function driver() {
            const wantdriver = document.getElementById("checkdriver")
            const sumdriver = document.getElementById("numb")
            console.log(wantdriver.value)
            if (wantdriver.checked == true) {
                console.log('+')
                sumdriver.value++
            } else {
                console.log('-')
                sumdriver.value--
            }
        }
        window.onload = validateinput;
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('#show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `คุณต้องการที่จะยกเลิกคำขอหรือไม่`,
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((result) => {

                    if (result) {
                        form.submit();
                    } else {
                        console.log("csdad")
                    }
                })
        });
    </script>

    </body>

</html>