<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <link rel="stylesheet" href="lib/genericons/genericons.css">
    <link rel="stylesheet" href="css/refresh.css">

    <title>Headline Feed</title>
    <?php include 'assets/core.php'; ?>
</head>

<body>
  <?php include_once("assets/analyticstracking.php") ?>



  <script src="lib/hammer.2.0.4.js"></script>
  <script src="lib/wptr.1.1.js"></script>
	
  <!--
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-md-offset-1">
          <ul style="list-style: none;">

                  <li class="panel panel-default">
                    <div class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#section1">
                        <div class="source"><meta itemprop="url" content="#"><span>CNN</span>&nbsp;&nbsp;&nbsp;&nbsp;<span>1h</span></div>
                        <div class="headline" itemprop="headline">Belgium's Christian Benteke sets World Cup goal record in 7 seconds</div>
                      </a>
                    </div>
                    <div id="section1" class="panel-collapse collapse">
                      <img class="img-responsive" src="http://i.imgur.com/4BWqmN8.jpg?fb" alt="Store charging 7 percent tax to men." />
                      <div class="panel-body">
                        <p class="source">
                          <span>CNN</span>&nbsp;&nbsp;&nbsp;&nbsp;
                          <span>1h</span>
                        </p>
                        <p>
                          General info about story.
                        </p>
                      </div>
                    </div>
                  </li>

          <ul>
        </div>
      </div>
    </div>
  -->

  <div class="container" id="content">
    <div class="row">
      <div class="col-md-9 col-md-offset-1">
        <h1>Headline Feed</h1>
        <h3>The quickest world news catch up in one place.</h3>
        <p><a href="about.php" class="source">More Info</a></p>
        <ul style="list-style: none;" id="wrap">
        <!-- GET DATA FROM scroll.php -->
        <ul>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  <script src="js/bootstrap.min.js"></script>
</body>
<script type="text/javascript" src="js/infinite_scroll.js"></script>

</html>
