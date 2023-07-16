@include('admin.layout.sidebarrole')
<!--main content start-->
<style>
    h2 {
        color: #ffa200;
    }
</style>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <center>
                @if ($message = Session::get('cannot'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '{{$message}}',
                    })
                </script>
                @endif
                <div class="col-md-12"><br><br>
                    <p class="centered"><img src="img/user.png" class="img-circle" width="80"></p>
                    <H2>{{ Auth::user()->permission->name}}</H2><br>
                    <p>{{ Auth::user()->firstname}} {{ Auth::user()->lastname}}</p>
                    <p>{{ Auth::user()->department->name}}</p>
                    <p>{{ Auth::user()->email }}</p>
                    <a data-toggle="modal" href="login.html#myModal1"> <span class="badge bg-warning"><i class="fa-solid fa-key"></i> &nbsp;&nbsp;รีเซ็ตรหัสผ่าน</span></a>
                    <!-- BASIC FORM ELELEMNTS -->
                </div>


            </center>
        </div>
        @if ( Auth::user()->permission_id == 1 || Auth::user()->permission_id == 2)
        <div class="row mtbox">
            <div class="col-md-2 col-sm-2 col-md-offset-1 box0">
            </div>
            <div class="col-md-2 col-sm-2 box0">
                <a href="/approve">
                    <div class="box1">
                        <h3>รอการอนุมัติ</h3>
                        <h3>{{$count_approve}}</h3>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-2 box0">
                <a href="/carset">
                    <div class="box1">
                        <h3>รอการจัดรถ</h3>
                        <h3>{{$count_manage}}</h3>
                    </div>
                </a>
            </div>
            <div class="col-md-2 col-sm-2 box0">
                <a href="/recordRequest">
                    <div class="box1">
                        <h3>รอการส่งคืนรถ</h3>
                        <h3>{{$count_returncar}}</h3>
                    </div>
                </a>
            </div>

        </div><!-- /row mt -->
        @endif
    </section>
    <form action="{{ route('home.updatepassword', Auth::user()->id) }}" method="post">
        @csrf
        @method('PUT')
        <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal1" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center>
                            <h4 class="modal-title">รีเซ็ตรหัสผ่าน</h4>
                        </center>
                    </div>
                    <div class="modal-body">
                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">รหัสผ่านใหม่</label>
                            <input type="password" class="form-control" name="password" required="required" autofocus>
                        </div>

                        <div class="form-group form-floating mb-3">
                            <label for="floatingEmail">ยืนยันรหัสผ่านใหม่</label>
                            <input type="password" class="form-control" name="confirm" required="required" autofocus>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="w-100 btn btn-lg btn-danger" type="submit">ยกเลิก</button>
                        <button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @include('admin.layout.script')
    </body>

    </html>