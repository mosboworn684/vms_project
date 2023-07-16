<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Vehicle Management System</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--external css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <link href="{{ asset('css/zabuto_calendar.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" /> -->
    <link href="{{ asset('js/gritter/css/jquery.gritter.css') }}" rel="stylesheet">
    <link href="{{ asset('lineicons/style.css') }}" rel="stylesheet">
    <!-- <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script> -->

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ URL::asset('js/chart-master/Chart.js') }}"></script>
</head>

<body>

    <section id="container">
        <!-- *************************************************Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for *********************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
        <!--header start-->
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>Vehicle Management System</b></a>
            <!--logo end-->
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="/brand"><i class="fa-solid fa-backward"></i></a></li>
                </ul>
            </div>
        </header>
        <!--header end-->

        <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">

                    <p class="centered"><a href="{{ route('userlist.edit', Auth::user()->id )}}"><img src="{{ URL::asset('img/userdit.png') }}" class="img-circle" width="60"></a></p>
                    @auth
                    <h5 class="centered">{{ Auth::user()->email }}</h5>
                    <h5 class="centered">{{ Auth::user()->permission->name}}</h5>
                    <h5 class="centered">{{ Auth::user()->department->name}}</h5>
                    @endauth

                    <li class="mt">
                        <a href="/">
                            <i class="fa-solid fa-list-check"></i>
                            <span>หน้าหลัก</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="/recordRequest">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>การขอใช้รถยนต์</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="/approve">
                            <i class="fa-solid fa-square-check"></i>
                            <span>อนุมัติ</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="/carset">
                            <i class="fa-solid fa-car"></i>
                            <span>จัดรถยนต์</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="/report">
                            <i class="fa-solid fa-house-chimney"></i>
                            <span>สรุปใช้การขอใช้รถยนต์</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>การตั้งค่าผู้ใช้</span>
                        </a>
                        <ul class="sub">
                            <li><a href="/register">เพิ่มผู้ใช้</a></li>
                            <li><a href="/department">เพิ่มแผนก</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="active">
                            <i class="fa fa-cogs"></i>
                            <span>การตั้งค่ารถยนต์</span>
                        </a>
                        @if ( Auth::user()->permission_id == 1)
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li class="active"><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/driver">เพิ่มพนักงานขับรถ</a></li>
                            <li><a href="/carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @else
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li class="active"><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @endif
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>LogOut</span>
                        </a>
                    </li>
                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <section id="main-content">
            <section class="wrapper">
                <h3><i class="fa fa-angle-right"></i> เพิ่มรุ่น </h3>
                <div class="row mt">
                    <div class="col-md-12 mt">
                        <div class="content-panel">
                            <center>
                                <table class="table table-hover">
                                    <h2><i class="fa-solid fa-car-side"></i>{{$brand[0]->name}}</h2>
                                    <hr>
                                    <thead>
                                        @if(count($model)==0)
                                        <tr>
                                            <td style="text-align: center;" colspan="4"><b>ไม่มีข้อมูล</b></td>
                                        </tr>
                                        @else
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รุ่น</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    @endif
                                    <tbody>
                                        <tr>
                                            @foreach ($model as $object)
                                            <td>&nbsp; &nbsp; {{++$i}}</td>
                                            <td>{{ $object->name }}</td>
                                            <td></td>
                                            <td>
                                                <form action="{{ route('model.destroy', $object->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a data-toggle="modal" href="login.html#myModal2" data-target="#myModal2-{{$object->id}}"><button type="button" class="btn btn-primary">แก้ไข</button></a>
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-theme04 show_confirm" data-toggle="tooltip" title='Delete'>ลบ</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach

                                        <tr>
                                            <td></td>
                                            <td>เพิ่มรุ่น</td>
                                            <form action="{{ route('model.store') }}" class="form-horizontal style-form" method="post">
                                                @csrf
                                                <td><input type="text" class="form-control" name="name"  required="required"></td>
                                                <td><input type="hidden" name="brand_id" value="{{$brand[0]->id}}">
                                                    <button type="submit" class="btn btn-warning">เพิ่ม</button>
                                                </td>
                                            </form>
                                        </tr>
                                    </tbody>
                                </table>
                                <!-- form edit -->
                                @foreach ($model as $key => $value)
                                <form action="{{ route('model.update', $value->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div aria-hidden="true" aria-labelledby="myModal1Label" role="dialog" tabindex="-1" id="myModal2-{{$value->id}}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <center>
                                                        <h4 class="modal-title">แก้ไขรุ่นรถยนต์</h4>
                                                    </center>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="form-group form-floating mb-3">
                                                        <label for="floatingEmail">รุ่นรถยนต์</label>
                                                        <input type="text" class="form-control" name="name" value="{{ $value->name }}" required="required" autofocus>
                                                        <input type="hidden" name="brand_id" value="{{$brand[0]->id}}">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button class="w-100 btn btn-lg btn-success" type="submit">บันทึกข้อมูล</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endforeach
                                <!-- close form edit -->
                                @if ($message = Session::get('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: '{{$message}}',
                                    })
                                </script>
                                @elseif ($message = Session::get('error'))
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{$message}}',
                                    })
                                </script>
                                @endif
                            </center>
                            @if(count($model) != 0)
                            <center>{!! $model->links() !!}</center>
                            @endif
                        </div>
                        <!--/content-panel -->
                    </div><!-- /col-md-12 -->
                </div><!-- /row -->
            </section>
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
