<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Login Form | CodingLab</title> -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body>
    <div class="container">
        <div class="wrapper">
            <div class="title"><span>ลืมรหัสผ่าน </span></div>
            <form action="{{ route('login.resetpassword') }}" method="post">
                @csrf
                @method('PUT')
                @include('auth.partials.messages')
                <div class="row">
                    <h5>E-mail</h5>
                    <i class="fas fa-lock"></i>
                    <input type="email" name="email" placeholder="name@example.com" required="required" class="form-control placeholder-no-fix" autofocus>
                </div><br>

                <div class="row">
                    <h5>เบอร์โทรศัพท์</h5>
                    <i class="fas fa-lock"></i>
                    <input type="text" name="tel" placeholder="Tel" id="tel" oninput="validatetel()" class="form-control placeholder-no-fix" required="required" autofocus maxlength="10">
                </div><br>

                <div class="row">
                    <h5>รหัสผ่านใหม่</h5>
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="password" class="form-control placeholder-no-fix" required="required" autofocus><br>
                    <span style="color:red">@error('password'){{$message}}@enderror</span>
                </div><br>

                <div class="row">
                    <h5>ยืนยันรหัสผ่าน</h5>
                    <i class="fas fa-lock"></i>
                    <input type="password" name="confirmpassword" placeholder="confirm-password" class="form-control placeholder-no-fix" required="required" autofocus><br>
                </div><br>
                <div class="pass">
                    <a data-toggle="modal" href="/login">Already have a password</a>
                </div>
                <div class="row button">
                    <input type="submit" value="Reset Password">
                </div>
                @if ($message = Session::get('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: '{{$message}}',
                    })
                </script>
                @endif
            </form>
            
        </div>
    </div>
    <!-- Modal -->
    @include('admin.layout.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
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

        window.onload = validatetel;
    </script>
</body>

</html>