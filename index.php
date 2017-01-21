<?php
$cards_running = json_decode(file_get_contents('xxxxxxxxxxxxxxxxxxxxxxx')); //実行中のリスト
$cards_plans = json_decode(file_get_contents('xxxxxxxxxxxxxxxxxxxxxxx')); //実行予定のリスト

function convert_to_fuzzy_time($time_db)
{
  $unix   = strtotime($time_db);
  $now    = time();
  $diff_sec   = $now - $unix;
  if($diff_sec < 60){
    $time   = $diff_sec;
    $unit   = "秒前";
  }
  elseif($diff_sec < 3600){
    $time   = $diff_sec/60;
    $unit   = "分前";
  }
  elseif($diff_sec < 86400){
    $time   = $diff_sec/3600;
    $unit   = "時間前";
  }
  elseif($diff_sec < 2764800){
    $time   = $diff_sec/86400;
    $unit   = "日前";
  }
  else{
    if(date("Y") != date("Y", $unix)){
      $time   = date("Y年n月j日", $unix);
    }
    else{
      $time   = date("n月j日", $unix);
    }

    return $time;
  }
  return (int)$time .$unit;
}

function DisplayCards($cards,$state)
{
  foreach ($cards as $key => $value)
  {
    $d2 = new DateTime($value->dateLastActivity);
    if (isset($value->labels[0]->color))
    {
      if ($value->labels[0]->color == "red")
      {
        $color = '#ff3333';
      }
      if ($value->labels[0]->color == "orange")
      {
        $color = "#ffa333";
      }
      if ($value->labels[0]->color == "yellow") 
      {
        $color = '#ffff69';
      }
      if ($value->labels[0]->color == "green")
      {
        $color = '#69ff69';
      }
      if ($value->labels[0]->color == "blue") 
      {
        $color = '#9e6ff';
      }
    }else{
      $color = "white";
    }
    if ($state === "running") {
      $addstate = " brink";
    }
    echo '<div class="column'.$addstate.'" style="background-color: '.$color.'">'.$value->name.'<small>   ('.convert_to_fuzzy_time($d2->format('Y/m/d H:i:s')).')</small></div>';
    $d2 = null;
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trello TV</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script type="text/javascript" language="javascript">

    setTimeout("location.reload()",5000);

  </script>
  <style>
    body{
      background-color: #333;
    }
    body::-webkit-scrollbar {
      display: none;
    }
    .column{
      color: #000;
      font-size: 32px;
      font-weight:500;
      border-radius: 5px;
      box-shadow: 2px 2px 5px rgba(255,255,255,0.1);
      padding-right: 5px;
      padding-bottom: 8px;
      padding-top: 6px;
      padding-left: 20px;
      margin: 10px;
    }
    small{
      font-size: 18px;
    }
    .brink{
     animation: Flash1 1s infinite;
   }

   @keyframes Flash1{
     50%{
      box-shadow: 0 0px 10px 5px orange;
      background-color: white;
    }
  }

</style>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#" style="font-size: 2em;">Trello Todo Monitor</a>
        <a class="navbar-brand" href="#"><?php echo date("Y年 m月 d日 H:i 現在"); ?></a>
      </div>
    </div><!--/.container-fluid -->
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">
        <?php

        if (!empty($cards_running)) {
          DisplayCards($cards_running,"running");
        }

        DisplayCards($cards_plans);

        ?>
      </div>
    </div>

  </div>
</body>
</html>