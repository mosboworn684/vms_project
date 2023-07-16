@include('admin.layout.sidebar1')
<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <h3><i class="fa fa-angle-right"></i> รายชื่อพนักงาน </h3>
        <!-- BASIC FORM ELELEMNTS -->
        <div class="row mt">
            <div class="col-md-12 mt">
                <div class="content-panel">
                <a href="/userlist"><button type="button" class="btn btn-default" style="float: left; margin-left:45px;margin-bottom:20px; color:black;">ปกติ</button></a>
                            <button type="button" class="btn btn-warning" style="float: left; margin-left:5px;margin-bottom:5px; color:black;">ลาออก</button>
                    <center>
                        @if ($message = Session::get('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '{{$message}}',
                            })
                        </script>
                        @endif
                        <table class="table1 table-hover">
                            <h2 style="margin-right:200px;"><i class="fa-solid fa-users"></i> รายชื่อพนักงาน</h2>
                            <hr>
                           
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>รหัสพนักงาน</th>
                                    <th>ชื่อ - นามสกุล</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>email</th>
                                    <th>username</th>
                                    <th>สิทธิ์</th>
                                    <th>แผนก</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($user as $key => $value)

                                    @if($value->id != Auth::user()->id)

                                    <td> {{++$i}}</td>
                                    <td>{{$value->employeenumber}}</td>
                                    <td style="text-align: left; width:200px;">{{ $value->prefix->name }}&nbsp; {{ $value->firstname }} &nbsp; {{ $value->lastname }}</td>
                                    <td>{{ $value->tel }}</td>
                                    <td style="text-align: left; width:200px;">{{ $value->email }}</td>
                                    <td style="text-align: left;">{{ $value->username }}</td>
                                    <td style="text-align: left;">{{ $value->permission->name }}</td>
                                    <td style="text-align: left; width:100px; " >{{ $value->department->name }}</td>

                                    <td style="width:10px;" >
                                    <form action="{{ route('userDontactive.update', $value->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success">ใช้งาน</button></a>
                                    </form>
                                    </td>

                                    <td style="width:10px;" >
                                        <form action="{{ route('userDontactive.destroy', $value->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-theme04 show_confirm" data-toggle="tooltip" title='Delete'>ลบ</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </center>
                    <!-- <center><a href="/register" button type="submit" class="btn btn-warning">เพิ่มพนักงาน</button></a></center><br> -->
                    @if(count($user) != 0)
                    <center>{!! $user->links() !!}</center>
                    @endif
                </div>
                <!--/content-panel -->
            </div><!-- /col-md-12 -->
        </div><!-- /row -->
    </section>

    @include('admin.layout.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `คุณต้องการที่จะลบหรือไม่`,
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
