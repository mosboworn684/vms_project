@include('admin.layout.sidebar')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <h3><i class="fa-solid fa-car"></i>เพิ่มรถยนต์</h3>

        <!-- BASIC FORM ELELEMNTS -->
        <form action="{{ route('carlist.store') }}" class="form-horizontal style-form" method="post">
            @csrf
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="form-panel">
                        <form class="form-horizontal style-form" method="get">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">ประเภทรถยนต์</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="type_id">
                                        <option>กรุณาระบุประเภทรถยนต์</option>
                                        @foreach ($type as $key => $value)
                                        <option value="{{ $value->id }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-sm-1 control-label">เลขทะเบียน</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="regisNumber">
                                    <br><br>
                                </div>
                                <!-- Close Row 1-->

                                <label class="col-sm-1 control-label">สี</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="color_id">
                                        <option>กรุณาระบุสีรถยนต์</option>
                                        @foreach ($color as $key => $value)
                                        <option value="{{ $value->id }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <br><br>
                                </div>
                                <label class="col-sm-1 control-label">ยี่ห้อ</label>
                                <div class="col-sm-2">
                                    <select name="brand_id" class="form-control brand">
                                        <option>กรุณาระบุยี่ห้อรถยนต์</option>
                                        @foreach ($brand as $key => $value)
                                        <option value="{{ $value->id }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label class="col-sm-1 control-label">รุ่น</label>
                                <div class="col-sm-5">
                                    <select name="model_id" id="model_type" class="form-control model_type">
                                        <option>กรุณาระบุรุ่นรถยนต์</option>
                                        <option value=""></option>
                                    </select><br><br>
                                </div>

                                <label class="col-sm-1 control-label">ระบุแผนก</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="department_id">
                                        @if ( Auth::user()->permission_id == 1)
                                        <option>กรุณาระบุแผนกรถยนต์</option>
                                        @endif
                                        @foreach ($department as $key => $value)
                                        <option value="{{ $value->id }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label class="col-sm-1 control-label">ระบุสถานะ</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="status_id">
                                        <option>กรุณาระบุสถานะรถยนต์</option>
                                        @foreach ($status as $key => $value)
                                        <option value="{{ $value->id }}"> {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label class="col-sm-1 control-label">เลขไมล์</label>
                                <div class="col-sm-2">
                                    <input type="text" name="mileage" class="form-control">
                                    <br><br>
                                </div>

                                <center><button type="submit" class="btn btn-warning">บันทึกข้อมูล</button></center>
                        </form>
                    </div><!-- form-group-->
        </form>
        </div><!-- form-panel -->
        </div><!-- col-lg-12-->
        </div><!-- /row -->
        @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{$message}}',
            })
        </script>
        @endif
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('change', '.brand', function() {
                //console.log("test");

                var id = $(this).val();
                //console.log(id);
                var div = $(this).parent();
                var op = " ";

                $.ajax({
                    type: 'get',
                    // url:'{!!URL::to('findProductName')!!}',
                    url: 'findModel',
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        console.log('ok');
                        console.log(data);
                        console.log(data.length);

                        op += '<option value="0" selection disabled> chose product </option>'
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }

                        $('#model_type').html(op);
                        // div.find('.model_type').append(op);
                    },
                    error: function() {

                    }

                });
            });

        });
    </script>
    @include('admin.layout.script')
    </body>

    </html>