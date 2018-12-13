<?php
  require_once("assets/apis/common.inc.php");
?>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="assets/js/jquery-latest.min.js"></script>
  <script src="assets/js/menumaker.min.js"></script>
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/main.min.css">
  <link rel="stylesheet" href="assets/css/main_menu.css">
</head>
<style type="text/css">
  body {
    margin: 0;
    padding: 0;
    height:100%;
  }
  #ifr_result{
    border: 0;
    width: calc(100% - 1px);
    height: -moz-calc(100% - 54px);
    height: -webkit-calc(100% - 54px);
    height: calc(100% - 54px);
  }
  #menu_text {
    position: absolute;
    top: 15px;
    right: 50px;
    color: white;
    font-weight: bold;
    z-index: 1;
  }
</style>
<div id="menu_text"></div>
<div class="row">
  <div class="col-md-12">
    <div id="cssmenu">
      <ul style="display: block;">
         <li class="has-sub"><span class="submenu-button"></span><a href="#"><i class="fa fa-fw fa-user"></i> User</a>
            <ul style="display: block;">
               <li><a href="./"><i class="fa fa-fw fa-sign-out"></i> Log Out</a>
            </ul>
         </li>
         <li class="has-sub"><span class="submenu-button"></span><a href="#"><i class="fa fa-fw fa-calendar"></i> Data</a>
            <ul style="display: block;">
              <li class="last_node"><a href="NAR/pools_sum_total.php" target="ifr_result"><i class="fa fa-fw fa-bullhorn"></i> NAR Pools</a>
              <!--
               <li class="has-sub"><span class="submenu-button"></span><a href="#"><i class="fa fa-fw fa-bullhorn"></i> NAR</a>
                  <ul style="display: block;">
                     <li class="last_node"><a href="NAR/" target="ifr_result"><i class="fa fa-fw fa-youtube-play"></i> Live Pools</a></li>
                     <li class="last_node"><a href="NAR/pools_sum_total.php?kind=json" target="ifr_result"><i class="fa fa-fw fa-clock-o"></i> JSON Pools</a></li>
                     <li class="last_node"><a href="NAR/pools_sum_total.php?kind=html" target="ifr_result"><i class="fa fa-fw fa-file-code-o"></i> HTML Pools</a></li>
                     <li class="last_node"><a href="NAR/pools_sum_total.php?kind=chart" target="ifr_result"><i class="fa fa-fw fa-bar-chart-o"></i> Pools Chart</a></li>
                  </ul>
               </li>
              -->
            </ul>
         </li>
      </ul>
    </div>
  </div>
</div>
<iframe src="" id="ifr_result" name="ifr_result" frameborder="0"></iframe>
<script type="text/javascript">
  $("#cssmenu").menumaker({
    title: "Menu",
    breakpoint: 768,
    format: "multitoggle"
  });
  $(".last_node").click(function(){
    $(".menu-opened").click();
    $("#menu_text").text($(this).text());
  });
</script>
</html>