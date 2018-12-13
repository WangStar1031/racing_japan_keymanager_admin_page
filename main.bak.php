<?php
	
	require_once("assets/apis/common.inc.php");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Racing Japan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" href="assets/css/style.css?<?=date("YmdHis")?>" type="text/css" media="screen"/>
        <style>
            *{
                margin:0;
                padding:0;
            }
            body{
                font-family:Arial;
                background:#fff url(assets/images/bg.png) no-repeat top left;
            }
            .title{
                width:419px;
                height:411px;
                position:absolute;
                top:400px;
                left:220px;
                background:transparent url(assets/images/horse22.gif) no-repeat top left;
            }
            #content{
                margin:0 auto;
            }


        </style>
    </head>

    <body>
        <div id="content">
            
            <div class="title"></div>

            <div class="navigation" id="nav">
                <div class="item home">
                    <img src="assets/images/bg_home.png" alt="" width="199" height="199" class="circle"/>
                    <a href="#" class="icon"></a>
                    <h2>NAR</h2>
                    <ul>
                        <li><a href="NAR/" target="_blank">Live Pool</a></li>
                        <li><a href="NAR/pools_sum_total.php" target="_blank">Pool Data</a></li>
                    </ul>
                </div>
                <div class="item user">
                    <img src="assets/images/bg_user.png" alt="" width="199" height="199" class="circle"/>
                    <a href="#" class="icon"></a>
                    <h2>User</h2>
                    <ul>
                        <li><a href="/">Log Out</a></li>
                    </ul>
                </div>
                <div class="item shop">
                    <img src="assets/images/bg_shop.png" alt="" width="199" height="199" class="circle"/>
                    <a href="#" class="icon"></a>
                    <h2>Menu</h2>
                    <ul>
                    </ul>
                </div>
                <div class="item camera">
                    <img src="assets/images/bg_camera.png" alt="" width="199" height="199" class="circle"/>
                    <a href="#" class="icon"></a>
                    <h2>Menu</h2>
                    <ul>
                    </ul>
                </div>
                <div class="item fav">
                    <img src="assets/images/bg_fav.png" alt="" width="199" height="199" class="circle"/>
                    <a href="#" class="icon"></a>
                    <h2>Menu</h2>
                    <ul>
                    </ul>
                </div>
            </div>
        </div>
        <!-- The JavaScript -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.easing.1.3.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#nav > div').hover(
                function () {
                    var $this = $(this);
                    $this.find('img').stop().animate({
                        'width'     :'199px',
                        'height'    :'199px',
                        'top'       :'-25px',
                        'left'      :'-25px',
                        'opacity'   :'1.0'
                    },500,'easeOutBack',function(){
                        $(this).parent().find('ul').fadeIn(700);
                    });

                    $this.find('a:first,h2').addClass('active');
                },
                function () {
                    var $this = $(this);
                    $this.find('ul').fadeOut(500);
                    $this.find('img').stop().animate({
                        'width'     :'52px',
                        'height'    :'52px',
                        'top'       :'0px',
                        'left'      :'0px',
                        'opacity'   :'0.1'
                    },5000,'easeOutBack');

                    $this.find('a:first,h2').removeClass('active');
                }
            );
            });
        </script>
    </body>
</html>