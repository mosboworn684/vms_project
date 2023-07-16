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
<script type='text/php'>
        if (isset($pdf)) 
            {         
                $pdf->page_text(540, $pdf->get_height() - 830, "{PAGE_NUM} / {PAGE_COUNT}", null, 12, array(0,0,0));
            }
        </script>
    <img src="{{ public_path('img/logo1.jpg') }}" align="left" style="width: 15%;height: 10%; ">
    
    <h2 style="text-align: center; margin-right:100px;">รายงานพนักงานขับรถยนต์</h2>
    <h4 style="text-align: right; margin-bottom:-20;">ออกรายงานโดย : {{ Auth::user()->prefix->name}}{{ Auth::user()->firstname}} {{ Auth::user()->lastname}}</h4>
    <h4 style="text-align: right; margin-bottom:0;">ออกรายงานวันที่ : {{$thaiDateHelper->simpleDate($datenow)}}</h4>

    <table class="table1 table-hover" align="center">
        <thead>
            <tr>
                <th>ลำดับที่</th>
                <th>รหัสพนักงาน</th>
                <th>ชื่อ-นามสกุล</th>
                <th>เบอร์โทรศัพท์</th>
            </tr>
        </thead>
        <tbody>
            @foreach($driver as $key => $value)
            <tr>
                <td align="center">{{++$i}}</td>
                <td align="center">{{ $value->drivernumber_id }}</td>
                <td>{{ $value->prefix->name }}{{ $value->firstname }} {{ $value->lastname }}</td>
                <td align="center">{{ $value->tel }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4 style="text-align: right; margin-top:0px;">เฉพาะพนักงานที่ยังทำงานอยู่</h4>
</body>

</html>
