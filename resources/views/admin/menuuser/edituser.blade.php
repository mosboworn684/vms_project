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
                    <li><a class="logout" href="/"><i class="fa-solid fa-backward"></i></a></li>
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

                    <p class="centered"><a href="{{ route('userlist.editprofile', Auth::user()->id )}}"><img src="{{ URL::asset('img/userdit.png') }}" class="img-circle" width="60"></a></p>
                    @auth
                    <h5 class="centered">{{ Auth::user()->email }}</h5>
                    <h5 class="centered">{{ Auth::user()->permission->name}}</h5>
                    <h5 class="centered">{{ Auth::user()->department->name}}</h5>
                    @endauth

                    <!-- หน้าแรก -->
                    @if ( Auth::user()->permission_id == 1 || Auth::user()->permission_id == 2 )
                    <li class="mt">
                        <a href="/" class="active">
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
                            <span>สรุปใช้การขอใช้รถยนต์</span>
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
                        <a href="javascript:;">
                            <i class="fa fa-cogs"></i>
                            <span>การตั้งค่ารถยนต์</span>
                        </a>
                        @if ( Auth::user()->permission_id == 1)
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="/driver">เพิ่มพนักงานขับรถ</a></li>
                            <li><a href="carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @else
                        <ul class="sub">
                            <li><a href="/addcolor">เพิ่มสี</a></li>
                            <li><a href="/typecar">เพิ่มประเภทรถยนต์</a></li>
                            <li><a href="/brand">เพิ่มยี่ห้อ</a></li>
                            <li><a href="carlist">รายชื่อรถยนต์</a></li>
                        </ul>
                        @endif
                    </li>
                    <li class="sub-menu">
                        <a href="{{ route('logout.perform') }}">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>LogOut</span>
                        </a>
                    </li>
                </ul>

                @else
                <li class="mt">
                    <a href="/" class="active">
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
                    <a href="{{ route('logout.perform') }}">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>LogOut</span>
                    </a>
                </li>
                </ul>
                @endif
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">

                <h3><i class="fa-solid fa-user-check"></i>แก้ไขข้อมูลพนักงาน</h3>

                <!-- BASIC FORM ELELEMNTS -->
                @if ($message = Session::get('success'))
						<script>
							Swal.fire({
								icon: 'success',
								title: '{{$message}}',
							})
						</script>
						@endif
                <div class="form-panel">
                    <div class="form-group"><br>
                        <form method="post" action="{{ route('userlist.updateprofile',$user[0]->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="row">
                                <label class="col-sm-1 control-label">คำนำหน้า</label>
                                <div class="col-sm-1">
                                    <select class="form-control" name="" value="{{ old('prefix_id') }}" readonly>
                                        <option value="{{$user[0]->prefix_id}}">{{$user[0]->prefix->name}}</option>
                                    </select><br><br>
                                    @if ($errors->has('role'))
                                    <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                                    @endif
                                </div>
                                <label class="col-sm-1 control-label">รหัสพนักงาน</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" name="employeenumber" value="{{$user[0]->employeenumber}}" readonly>
                                </div>
                                <label class="col-sm-1 control-label">ชื่อ</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name="firstname" value="{{$user[0]->firstname}}" required="required" autofocus>
                                    @if ($errors->has('firstname'))
                                    <span class="text-danger text-left">{{ $errors->first('firstname') }}</span>
                                    @endif
                                </div>
                                <label class="col-sm-1 control-label">นามสกุล</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" class="form-control" style="width: 97%;" name="lastname" value="{{$user[0]->lastname}}" required="required" autofocus>
                                    @if ($errors->has('lastname'))
                                    <span class="text-danger text-left">{{ $errors->first('lastname') }}</span>
                                    @endif <br><br>
                                </div>
                            </div>
                            <label class="col-sm-1 control-label">เบอร์โทรศัพท์</label>
                            <div class="col-sm-5">
                                <input type="tel" id="tel" oninput="validatetel()" class="form-control" name="tel" value="{{$user[0]->tel}}" required="required" autofocus pattern="[0]{1}[0-9]{2}[0-9]{3}[0-9]{4}" oninvalid="this.setCustomValidity('ใส่เบอร์มือถือให้ถูกต้อง')" oninput="this.setCustomValidity('')" />
                                @if ($errors->has('email'))
                                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                @endif

                            </div>

                            <label class="col-sm-1 control-label">email</label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" name="email" value="{{$user[0]->email}}" placeholder="name@example.com" required="required" autofocus readonly>
                                @if ($errors->has('email'))
                                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                                @endif
                                <br><br>
                            </div>
                            <!-- Close Row 1-->

                            <label class="col-sm-1 control-label">username</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="" value="{{$user[0]->username}}" readonly>
                                @if ($errors->has('username'))
                                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                                @endif
                            </div>

                            <!-- Close Row 2-->
                            <label class="col-sm-1 control-label">ระบุแผนก</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="" value="{{ old('department_id') }}" readonly>

                                    <option value="{{$user[0]->department_id}}">{{$user[0]->department->name}}</option>

                                </select><br><br>
                                @if ($errors->has('department_id'))
                                <span class="text-danger text-left">{{ $errors->first('department_id') }}</span>
                                @endif
                            </div>
                            <!-- Close Row 2-->
                            <label class="col-sm-1 control-label">กำหนดสิทธิ์</label>
                            <div class="col-sm-5">
                                <select class="form-control" name="" value="{{ old('permission_id') }}" readonly>

                                    <option value="{{$user[0]->permission_id}}">{{$user[0]->permission->name}}</option>

                                </select><br><br>
                                @if ($errors->has('permission_id'))
                                <span class="text-danger text-left">{{ $errors->first('permission_id') }}</span>
                                @endif
                            </div>

                            <center><button type="submit" class="btn btn-warning">บันทึกข้อมูล</button></center>
                        </form>

                    </div><!-- form-group-->
                </div><!-- form-panel -->

            </section>
            @include('admin.layout.script')
<script>
            function validatetel() {
			console.log('asdasdas')
	  		$(document).ready(function() {
		 	 $('#tel').on('keypress', function(event) {
			  if ((event.which < 48 || event.which > 57) && event.which != 45 || event.key === "-") {
				  event.preventDefault();
			  }
		  	});
	  		});
  		}

  window.onload = function(){
  validatetel()
  }

	</script>
</body>

</html>
