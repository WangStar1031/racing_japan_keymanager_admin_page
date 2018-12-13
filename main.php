<?php
  require_once("assets/apis/common.inc.php");
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
        <meta name="theme-color" content="#000000">
        <link rel="icon" type="image/png" href="assets/logo.png" />
        <link rel="shortcut icon" href="assets/logo.png">
        <link rel="apple-touch-icon" sizes="76x76" href="assets/apple-icon.png">
        <link rel="stylesheet" href="assets/main.css?<?=time()?>" media="screen">
        <script type="text/javascript" src="assets/js/jquery-latest.min.js"></script>
    </head>
    <body>
        <div id="menu_bar">
            <div class="side_menu_bar jss84 jss86 jss559 jss9 jss10 jss560 jss564">
                <div class="jss15 ">
                    <a href="./main.php" class="jss16 ">
                        <img src="assets/horse-logo.svg" alt="logo" class="jss22" style="fill: white;">
                    </a>
                    <a href="./main.php" class="jss18 ">Racing Japan</a>
                </div>
                <div class="jss56 jss57 ps">
                    <ul class="jss246 jss247 jss24">
                        <li class="jss252 jss255 jss259 jss25">
                            <a class="jss27 jss37 main_menu">
                                <svg class="jss240 jss579 jss28 " focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                                    <g>
                                        <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"></path>
                                    </g>
                                </svg>
                                <div class="jss569 jss30 ">
                                	Data
                                	<b class="jss45"></b>
                                </div>
                            </a>
                            <div class="jss549 jss550" style="min-height: 0px; height: auto; transition-duration: 300ms; display: none;">
                                <div class="jss551">
                                    <div class="jss552">
                                        <ul class="jss246 jss247 jss24 jss35">
                                            <li class="jss252 jss255 jss259 jss36">
                                                <a class="jss38 jss50" aria-current="false" href="NAR/pools_sum_total.php" target="ifr_result">
                                                    <span class="jss39 ">NP</span>
                                                    <div class="jss543 jss41 ">NAR Pools</div>
                                                </a>
                                            </li>
                                            <li class="jss252 jss255 jss259 jss36" style="display: none;">
                                                <a class="jss38" aria-current="false" href="#/timeline-page">
                                                    <span class="jss39 ">JP</span>
                                                    <div class="jss543 jss41 ">JRA Pools</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="jss252 jss255 jss259 jss25">
                            <a class="jss27 " aria-current="false" href="./">
                                <svg class="jss240 jss579 jss28 " version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 575.279 575.279" style="enable-background:new 0 0 575.279 575.279;" xml:space="preserve" fill="white">
                                    <g>
	<g>
		<path d="M287.64,575.279c158.86,0,287.639-128.779,287.639-287.639C575.279,128.78,446.5,0,287.64,0S0,128.78,0,287.641
			C0,446.5,128.78,575.279,287.64,575.279z M324.557,78.856v83.917v106.169c0,20.389-16.527,36.916-36.917,36.916
			c-20.389,0-36.916-16.527-36.916-36.916V162.771V78.856c0-3.592,0.539-7.053,1.497-10.337
			c4.474-15.352,18.623-26.579,35.422-26.579c16.8,0,30.949,11.227,35.423,26.579C324.018,71.8,324.557,75.264,324.557,78.856z
			 M226.48,74.211c-0.116,1.539-0.236,3.075-0.236,4.645v93.755c-42.415,22.206-71.438,66.631-71.438,117.736
			c0,73.244,59.59,132.836,132.834,132.836c73.245,0,132.834-59.592,132.834-132.836c0-51.102-29.023-95.53-71.439-117.736V78.856
			c0-1.567-0.119-3.106-0.234-4.645c94.324,26.643,163.475,113.284,163.475,216.136c0,124.062-100.574,224.635-224.635,224.635
			c-124.062,0-224.635-100.572-224.635-224.635C63.005,187.496,132.155,100.852,226.48,74.211z"/>
	</g>
</g>
                                </svg>
                                <div class="jss569 jss30 ">Log out</div>
                            </a>
                        </li>
                    </ul>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                    </div>
                </div>
                <div class="jss23" style="background-image: url(assets/bg.jpg);"></div>
            </div>
            <div class="jss2 jss7 ps ps--active-y" style="height: 100%; ">
                <iframe src="" id="ifr_result" name="ifr_result" frameborder="0" style="border: 0; width: 100%; height: 100%;"></iframe>
            </div>
            <div class="jss524" aria-hidden="true" style="opacity: 0.1; height: 100%; background: black;"></div>
            <button tabindex="0" class="tip_menu jss164 jss142 jss146 jss113 jss134 jss141" type="button" aria-label="open drawer">
                <span class="jss143">
                    <svg class="jss240" focusable="false" viewBox="0 0 24 24" aria-hidden="true">
                        <g>
                            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
                        </g>
                    </svg>
                </span>
                <span class="jss167"></span>
            </button>
        </div>
    </body>
    <script type="text/javascript">
		function toggle_menu_on() {
			if(jQuery(window).width() >= 960) return false;
            jQuery(".jss524").show();
    		jQuery(".side_menu_bar").css("transform", "none");
    	}

    	function toggle_menu_off() {
    		if(jQuery(window).width() >= 960) return false;
            jQuery(".jss524").hide();
    		jQuery(".side_menu_bar").css("transform", "translate3d(260px, 0, 0)");
    	}

    	jQuery(function(){
    		jQuery(".main_menu").click(function(){
    			jQuery(".jss549").hide();
    			if(!jQuery(this).find(".jss45").hasClass("jss48")) {    				
    				jQuery(".jss45").removeClass("jss48");
    				jQuery(this).find(".jss45").addClass("jss48");
    				jQuery(this).parent().find(".jss549").show();
    			} else {
    				jQuery(".jss45").removeClass("jss48");
    				jQuery(this).parent().find(".jss549").hide();
    			}    			
    		});
    		jQuery(".jss38").click(function(){
    			jQuery(".jss50").removeClass("jss50");
    			jQuery(this).addClass("jss50");
                jQuery("#ifr_result").attr("src", jQuery(this).attr("href"));
    			toggle_menu_off();
    		});
            jQuery(".main_menu:first").click();
            jQuery(".jss38:first").click();
    	});

    	jQuery(".tip_menu").click(function(){
    		toggle_menu_on();
    	});

    	jQuery(window).resize(function(){
    		if(jQuery(window).width() >= 960) {
    			jQuery(".side_menu_bar").css("transform", "none");
                jQuery(".jss524").hide();
            }
    		else
    			jQuery(".side_menu_bar").css("transform", "translate3d(260px, 0, 0)");
    	});

        jQuery(".jss524").click(function(){
            toggle_menu_off();
        });
    </script>
</html>
