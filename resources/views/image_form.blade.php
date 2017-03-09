<!DOCTYPE html>
<html>
<head>
  <title>Demo</title>
</head>
<body>
<form action="/image" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="file" name="file"> 
  <input type="submit" name="submit" value="Save">
</form>
</body>
</html>