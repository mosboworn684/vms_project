@include('admin.layout.sidebarrole')
<section id="main-content">
          <section class="wrapper">

          <h3><i class="fa fa-angle-right"></i> รีเซ็ตรหัสผ่าน </h3>

		  @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                {{$message}}
                                 </div>
                              @endif
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
              <div class="col-md-12 mt">
	                  	<div class="content-panel">
                              <center>
	                          <table class="table table-hover">
	                  	  	  <h2> <i class="fa-solid fa-palette"></i> เพิ่มสี</h2>
	                  	  	  <hr>

	                                  <input type="password" style="width:600px;" class="form-control" name="name" required="required" autofocus>
                                        <br><br>
                                      <input type="password" style="width:600px;" class="form-control" name="name" required="required" autofocus>
	                                  <button type="submit" class="btn btn-warning"><i class="fa-solid fa-plus"></i></button>
                                      
	                  	</div><!--/content-panel -->
	            </div><!-- /col-md-12 -->
          	</div><!-- /row -->
  </section>
  @include('admin.layout.script')
  </body>
</html>