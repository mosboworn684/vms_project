@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf')}}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
        }

        th {
            padding-left: 60px;
            text-align: left;
        }

        td {
            padding-left: 60px;
        }

        .d1 {
            background-color: #FDF5E6;
        }

        table {
            width: 100%;
        }
    </style>
</head>

<body>
    <img src="{{ public_path('img/logo1.jpg') }}" align="left" style="width: 15%;height: 10%; ">
   
    <h2 style="text-align: center; margin-right:100px;">รายละเอียดการขอใช้รถยนต์</h2>
    <h4 style="text-align: right; margin-bottom:-25px;">ออกรายงานโดย : {{ Auth::user()->prefix->name}}{{ Auth::user()->firstname}} {{ Auth::user()->lastname}}</h4>
    <h4 style="text-align: right; margin-bottom:-30px;">ออกรายงานวันที่ : {{$thaiDateHelper->simpleDate($datenow)}}</h4>
    <h3 style="text-align: left; margin-top: 0px; color: #ffa200;">ข้อมูลการขอใช้รถยนต์</h3>

    <table align="center" style="border-top: 2px solid #ffa200;border-bottom: 2px solid #ffa200;margin-top: -15px;">
        <tbody>
            <tr class="d1">
                @foreach($recordrequest as $key => $value)
                <th style="width: 250px;">หมายเลขคำขอ</th>
                <td>{{ $value->requestNo }}</td>
            </tr>
            <tr>
                <th>ประเภทรถยนต์</th>
                <td>{{$value->types->name}}</td>
            </tr>
            <tr class="d1">
                <th>ขอใช้รถ</th>
                @if($value->department_car == 1)
                <td>ใช้รถของส่วนกลาง</td>
                @else
                <td>ใช้รถของแผนก</td>
                @endif
            </tr>
            <tr>
                <th>ทะเบียนรถยนต์</th>
                <td>{{$value->cars->regisNumber}}</td>
            </tr>
            <tr class="d1">
                <th>ยี่ห้อ</th>
                <td>{{$value->cars->brands->name}}</td>
            </tr>
            <tr>
                <th>รุ่น</th>
                <td>{{$value->cars->models->name}}</td>
            </tr>
            <tr class="d1">
                <th>จำนวนผู้เดินทาง</th>
                <td>{{$value->passenger}}</td>
            </tr>
            <tr>
                <th>ต้องการคนขับรถ</th>
                @if($value->want_driver == 0)
                <td>ไม่ต้องการพนักงานขับรถ</td>
                @elseif ($value->want_driver == 1)
                <td>ยังไม่จัดพนักงานขับรถ</td>
                @else
                <td>{{$value->drivers->prefix->name}}{{$value->drivers->firstname}} {{$value->drivers->lastname}}</td>
                @endif
            </tr>
            <tr class="d1">
                <th>วันที่ขอใช้</th>
                <td>{{$thaiDateHelper->simpleDateFormat($value->created_at)}}</td>
            </tr>
            <tr>
                <th>วันที่ใช้งาน</th>
                <td>{{$thaiDateHelper->simpleDateFormat($value->startTime)}}</td>
            </tr>
            <tr class="d1">
                <th>ขอใช้ถึงวันที่</th>
                <td>{{$thaiDateHelper->simpleDateFormat($value->endTime)}}</td>
            </tr>
            <tr>
                <th>สถานที่</th>
                <td>{{$value->location}}</td>
            </tr>
            <tr class="d1">
                <th>หมายเหตุ</th>
                <td>{{$value->detail}}</td>
            </tr>
            <tr>
                <th>เลขไมล์ก่อนใช้งาน</th>
                <td>{{$value->first_mileage}}</td>
            </tr>
            <tr class="d1">
                <th>เลขไมล์หลังใช้งาน</th>
                <td>{{$value->current_mileage}}</td>
            </tr>
            <tr>
                <th>ระยะทางที่ใช้เดินทาง</th>
                <td>{{$value->run_mileage}}</td>
            </tr>
            <tr class="d1">
                <th>ราคาที่เติมน้ำมัน (บาท)</th>
                <td>{{$value->price_oil}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
    <h3 style="color: #ffa200;">ข้อมูลผู้ขอใช้</h3>
    <table align="center" style="border-top: 2px solid #ffa200;;border-bottom:2px solid #ffa200;margin-top: -15px;">
        <tbody>
            <tr class="d1">
                @foreach($recordrequest as $key => $value)
                <th style="width: 250px;">ชื่อ-นามสกุล</th>
                <td>{{$value->users->prefix->name}}{{ $value->users->firstname }} {{ $value->users->lastname }}</td>
            </tr>
            <tr>
                <th>เบอร์โทรศัพท์</th>
                <td>{{$value->users->tel}}</td>

            </tr>
            <tr class="d1">
                <th>แผนก</th>
                <td>{{$value->departments->name}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
</body>

</html>
