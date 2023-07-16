<div class="container">
  <h3>View all image</h3>
  <hr>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Image id</th>
        <th scope="col">Image</th>
      </tr>
    </thead>
    <tbody>
      @foreach($imageData as $data)
      <tr>
        <td>{{$data->id}}</td>
        <td> @foreach (json_decode($data->slip_oil, true) as $picture) 
            <img src="{{ asset('/image/'.$picture) }}" style="height:120px; width:200px" />
         @endforeach
        </td>
        <td>

          <img src="/img/{{$data->slip_oil}}" style="height: 100px; width: 150px;">
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>