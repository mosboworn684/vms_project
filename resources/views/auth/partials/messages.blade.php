<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(isset ($errors) && count($errors) > 0)
<div class="alert alert-warning" role="alert">
    <ul class="list-unstyled mb-0">
        @foreach($errors->all() as $error)
        <script>
            Swal.fire({
                icon: 'error',
                title: 'E-mail หรือ Password ผิด',
                
            })
        </script>
        @endforeach
    </ul>
</div>
@endif

@if(Session::get('success', false))

@if (is_array($data))
@foreach ($data as $msg)
<div class="alert alert-warning" role="alert">
    <i class="fa fa-check"></i>
    <script>
        Swal.fire(
            'error',
            '{{ $msg }}',
            'question'
        )
    </script>
</div>
@endforeach
@else
<div class="alert alert-warning" role="alert">
    <i class="fa fa-check"></i>
    <script>
        Swal.fire(
            'error',
            '{{$data}}',
            'question'
        )
    </script>
</div>
@endif
@endif