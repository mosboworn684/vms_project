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


    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ URL::asset('js/chart-master/Chart.js') }}"></script>
</head>

<body>

    <section id="container">

        <!--header start-->
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="#" class="logo"><b>Vehicle Management System</b></a>
            <!--logo end-->
            <div class="top-menu">

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
                            <span>บันทึกการขอใช้รถยนต์</span>
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
                            <span>สรุปการขอใช้รถยนต์</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa-solid fa-user-gear"></i>
                            <span>การตั้งค่าผู้ใช้</span>
                        </a>
                        <ul class="sub">
                            <li><a href="/userlist">รายชื่อพนักงาน</a></li>
                            <li><a href="/department">เพิ่มแผนก</a></li>

                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" class="active">
                            <i class="fa fa-cogs"></i>
                            <span>การตั้งค่ารถยนต์</span>
                        </a>
                        <!--หน้าเพิ่่มสี-->
                        @if($a == 1)
                        @if ( Auth::user()->permission_id == 1)
                        <ul class="sub">
                            <li class="active"><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/driver">เพิ่มพนักงานขับรถ</a></li>
                            <li><a href="/carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @else
                        <ul class="sub">
                            <li class="active"><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @endif
                        <!-- -->

                        <!-- หน้าเพิ่มยี่ห้อ -->
                        @elseif($a == 2)
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
                        <!-- -->

                        <!-- หน้ารายการรถ -->
                        @elseif($a == 4)
                        @if ( Auth::user()->permission_id == 1)
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/driver">เพิ่มพนักงานขับรถ</a></li>
                            <li class="active"><a href="carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @else
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li class="active"><a href="carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @endif
                        <!-- -->

                        <!-- หน้าเพิ่มประเภทรถยนต์ -->
                        @elseif($a == 5)
                        @if ( Auth::user()->permission_id == 1)
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li class="active"><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/driver">เพิ่มพนักงานขับรถ</a></li>
                            <li><a href="/carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @else
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li class="active"><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @endif
                        <!--  -->

                        <!-- หน้าเพิ่มพนักงานคนขับ -->
                        @elseif($a == 6)
                        @if ( Auth::user()->permission_id == 1)
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li class="active"><a href="/driver">เพิ่มพนักงานขับรถ</a></li>
                            <li><a href="/carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @else
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @endif
                        <!--  -->
                        @endif
                    </li>
                    <li class="sub-menu">
                        <a href="{{ route('logout.perform') }}">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>LogOut</span>
                        </a>
                    </li>
                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
</body>

</html>
