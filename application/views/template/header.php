<?php $assets_path = base_url() . '/assets/'; ?>
<?php $js = $assets_path . 'js/'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?=$assets_path;?>img/icon.png">

    <title>AdaDokter.Com - Doctor's Ultimate Partner</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=$assets_path;?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
	<?php if($this->session->userdata('current_page') == 'calendar') { ?>
		<link rel='stylesheet' href='<?=$js;?>fullcalendar/lib/cupertino/jquery-ui.min.css' />
		<link href='<?=$js;?>fullcalendar/fullcalendar.css' rel='stylesheet' />
		<link href='<?=$js;?>fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
	<?php } ?>
    <link rel="stylesheet" href="<?=$assets_path;?>css/style_riandy_adadokter.css">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?=$assets_path;?>js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>