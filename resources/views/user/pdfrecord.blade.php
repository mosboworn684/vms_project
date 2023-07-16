@inject('thaiDateHelper', 'App\Services\ThaiDateHelperService')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link href="{{ public_path('css/bootstrap.css') }}" rel="stylesheet"> -->
    <style>
        @page {
            margin-top: 230px;
        }

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

        table,
        td,
        th {
            border: 1px solid;
            padding-left: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        header {
            position: fixed;
            left: 0px;
            right: 0px;

        }
    </style>
    <style>
        .pagenum:before {
            content: counter(page);
        }

        .pagenum {
            float: right;
        }
    </style>

</head>

<body>
    <header>
        <img src="{{ public_path('img/logo1.jpg') }}" align="left" style="width: 20%;height: 25%;margin-top:-170px;">
        <h2 style="text-align: center;margin-right:0px; margin-top:-170px; margin-bottom:-250px;">รายงานข้อมูลการใช้รถยนต์</h2>
        
    </header>
    <script type='text/php'>
        if (isset($pdf))
            {
                $pdf->page_text(790, $pdf->get_height() - 580, "{PAGE_NUM} / {PAGE_COUNT}", null, 12, array(0,0,0));
                @if($startTime!=null)
                $pdf->page_text(350, $pdf->get_height() - 515, "ระหว่างวันที่ : {{$thaiDateHelper->simpleDate($startTime)}} - {{$thaiDateHelper->simpleDate($endTime)}}", null, 12, array(0,0,0));
                @endif
                @if($select == 1)
                $pdf->page_text(350, $pdf->get_height() - 515, "ทั้งหมด", null, 12, array(0,0,0));
                @elseif($select == 2)
                $pdf->page_text(390, $pdf->get_height() - 490, "แผนก : {{$name}}", null, 12, array(0,0,0));
                @elseif($select == 3)
                $pdf->page_text(370, $pdf->get_height() - 490, "ชื่อ-นามสกุล ผู้ขอใช้รถ : {{$name}}", null, 12, array(0,0,0));
                @elseif($select == 4)
                $pdf->page_text(390, $pdf->get_height() - 490, "เลขทะเบียนรถ : {{$name}}", null, 12, array(0,0,0));
                @elseif($select == 5)
                $pdf->page_text(390, $pdf->get_height() - 490, "คืนรถยนต์ล่าช้า ", null, 12, array(0,0,0));
                @endif
                $pdf->page_text(660, $pdf->get_height() - 470, "ออกรายงานโดย : {{ Auth::user()->prefix->name}}{{ Auth::user()->firstname}} {{ Auth::user()->lastname}}", null, 12, array(0,0,0));
                $pdf->page_text(695, $pdf->get_height() - 450, "ออกรายงานวันที่ : {{$thaiDateHelper->simpleDate($datenow)}}", null, 12, array(0,0,0));
                
            }
        </script>
    <!-- <img src="{{ public_path('img/logo1.jpg') }}" align="left" style="width: 15%;height: 15%; "> -->
     
    <!-- @if($startTime!=null)
    <h4 style="text-align: center; margin-right:100px;">ระหว่างวันที่ : {{$thaiDateHelper->simpleDate($startTime)}} - {{$thaiDateHelper->simpleDate($endTime)}}</h4>
    @endif
    <h4 style="text-align: right; margin-bottom:-25px;">ออกรายงานโดย : {{ Auth::user()->prefix->name}}{{ Auth::user()->firstname}} {{ Auth::user()->lastname}}</h4>
    <h4 style="text-align: right; margin-bottom:0px;">ออกรายงานวันที่ : {{$thaiDateHelper->simpleDate($datenow)}}</h4> --> 
    <main>
        <table class="table1 table-hover" align="center" style="page-break-after: never;">
            <thead>
                <tr>
                    <th>ลำดับที่</th>
                    <th>วันที่ขอใช้รถ</th>
                    <th>รหัสคำขอ</th>
                    <th>ผู้ขอใช้</th>
                    <th>เบอร์ติดต่อผู้ใช้ {{$select}}</th>
                    <th>เลขทะเบียน<br>รถยนต์</th>
                    <th>สถานที่</th>
                    <th>พนักงานขับรถ</th>
                    <th>วันที่ใช้งาน</th>
                    <th>ใช้งานถึงวันที่</th>
                    <th>ระยะทางใน<br>
                        การใช้งาน (กม.)</th>
                    <th>จำนวนเงินที่<br>เติมน้ำมัน(บาท)</th>
                    <th width="2px;">หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recordrequest as $key => $value)
                <tr>
                    <th>{{++$i}}</th>
                    <td>{{$thaiDateHelper->simpleDate($value->created_at)}}</td>
                    <th>{{$value->requestNo}}</th>
                    <td>{{$value->users->firstname}} {{$value->users->lastname}} </td>
                    <td>{{$value->users->tel}}</td> 
                    <td>{{$value->cars->regisNumber}}</td>
                    <td>{{$value->location}}</td>
                    @if($value->want_driver == 0)
                    <td style="text-align: center;">-</td>
                    @else
                    <td style="text-align: left;">{{$value->drivers->prefix->name}}{{$value->drivers->firstname}} {{$value->drivers->lastname}}</td>
                    @endif
                    <td>{{$thaiDateHelper->simpleDateFormat($value->startTime)}}</td>
                    <td>{{$thaiDateHelper->simpleDateFormat($value->endTime)}}</td>
                    <td style="text-align: center;">{{$value->run_mileage}}</td>
                    <td style="width:2px; text-align: right;">{{number_format($value->price_oil)}}</td>
                    @if($value->status_return==1)
                    <td style="text-align: center;" width="60px;">คืนรถช้า</td>
                    @else
                    <td style="text-align: center;" width="60px;"> {{$value->detail}}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>