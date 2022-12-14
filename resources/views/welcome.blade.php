<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Management</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  

</head>
<body>

<div class="container">
  <h2 class="text-center">Email Inserting: </h2>
  <br>
  <form action="/insert" method="post" class="form-group" style="width:70%; margin-left:15%;">

    <input type="hidden" name="_token" value = "<?php echo csrf_token(); ?>"><input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">

    <label class="form-group">Name:</label>
    <input type="text" class="form-control" placeholder="Name" name="name">

    <!-- <input type="number" class="form-control" placeholder="Last Name" name="isp_id"> -->


      <div class="form-group">
        <label class="form-label">ISP:</label>
        <select class="form-control select2" style="width: 100%;" name="isp_id">
          @foreach($isps as $isp)
            <option value="{{$isp->id}}">{{$isp->isp_name}}</option>
          
          @endforeach
        </select>
      </div>

    <!-- <input type="number" class="form-control" placeholder="Last Name" name="geo_id"> -->
    
    <div class="form-group">
        <label class="form-label">GEO:</label>
        <select class="form-control select2" style="width: 100%;" name="geo_id">
          @foreach($geos as $geo)
            <option value="{{$geo->id}}">{{$geo->geo_name}}</option>
          
          @endforeach
        </select>
      </div>

    <label>MX:</label>
        <input type="text" class="form-control" placeholder="Enter Email" name="mx"><br>
        <button type="submit"  value = "Add student" class="btn btn-primary">Submit</button>
  </form>
</div>

</body>
</html>