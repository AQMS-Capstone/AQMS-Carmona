<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src = "jquery-1.12.0.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(function()
      {
        GetData();
      });

    function GetData()
    {
      $('div#MapPanel').load('loadTest.php');
      myGetData = setTimeout('GetData()',1000);
    }
    </script>
    <title></title>
  </head>
  <body>
    <div class="" id = "MapPanel">
      
    </div>
  </body>
</html>
