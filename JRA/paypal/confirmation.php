<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Pay Throught Paypal</title>
</head>
<body>
<div align="center">
<table border="0" width="900" cellspacing="0" cellpadding="0">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><form name="form1" method="POST" action="paypal_entry.php">
		<input type="hidden" name="paymentType" value="Sale" />
				<table width="880" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top" class="content4">
                    <table border="0" width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td width="50%" valign="top">
							<div align="left">
								<table border="0" width="98%" cellspacing="0" cellpadding="4" class="content4" style="border:1px solid #333333; font-family:Verdana; font-size:8pt; color:#000000">
									<tr>
										<td width="100%" colspan="2" background="images/collectionbg1_see.png">
										<b><font size="2">Personal Information</font></b></td>
									</tr>
									<tr>
										<td width="35%" background="images/collectionbg1_see.png" align="right">
										<b>First Name:</b></td>
										<td width="50%" background="images/collectionbg1_see.png"><input type="text" name="fname" value="" /></td>
									</tr>
									<tr>
										<td width="35%" background="images/collectionbg1_see.png" align="right">
										<b>Last Name:</b></td>
										<td width="50%" background="images/collectionbg1_see.png"><input type="text" name="lname" value="" /></td>
									</tr>
									<tr>
										<td width="35%" background="images/collectionbg1_see.png" align="right">
										<b>Amount: </b> </td>
										<td width="50%" background="images/collectionbg1_see.png"><input type="text" name="ftotal" value=""></td>
									</tr>
									<tr>
										<td width="100%" colspan="2" background="images/collectionbg1_see.png"><b>
										<font size="2">Credit Card Information</font></b></td>
									</tr>
									<tr>
										<td width="35%" align="right"><b>Card Type :</b></td>
										<td width="65%" align="left">
										<select name="creditCardType" style="width:150px;">
					                    <option value="Visa" selected="selected">Visa</option>
					                    <option value="MasterCard">MasterCard</option>
					                    <option value="Discover">Discover</option>
					                    <option value="Amex">American Express</option>
					                    </select></td>
									</tr>
									<tr>
										<td width="35%" align="right"><b>Card Number :</b></td>
										<td width="65%" align="left">
										<input type="text" size="19" maxlength="19" name="creditCardNumber" style="width:150px;" /></td>
									</tr>
									<tr>
										<td width="35%" align="right"><b>Expiration Date :</b></td>
										<td width="65%" align="left">
                                      <select name="expDateMonth">
					                    <option value="1">01</option>
					                    <option value="2">02</option>
					                    <option value="3">03</option>
					                    <option value="4">04</option>
					                    <option value="5">05</option>
					                    <option value="6">06</option>
					                    <option value="7">07</option>
					                    <option value="8">08</option>
					                    <option value="9">09</option>
					                    <option value="10">10</option>
					                    <option value="11">11</option>
					                    <option value="12">12</option>
					                    </select> <select name="expDateYear" size="1">
						                    <option value="2013" selected>2013</option>
						                    <option value="2014">2014</option>
						                    <option value="2015">2015</option>
						                    <option value="2016">2016</option>
						                    <option value="2017">2017</option>
						                    <option value="2019">2019</option>
						                    <option value="2020">2020</option>
						                    <option value="2021">2021</option>
						                    <option value="2022">2022</option>
						                    <option value="2023">2023</option>
						                    <option value="2024">2024</option>
						                    <option value="2025">2025</option>
						                    <option value="2026">2026</option>
						                    <option value="2027">2027</option>
						                    <option value="2028">2028</option>
						                    <option value="2029">2029</option>
						                    <option value="2030">2030</option>
					                    </select></td>
									</tr>
									<tr>
										<td width="35%" align="right"><b>CVV Number :</b></td>
										<td width="65%" align="left">
										<input type="text" size="3" maxlength="4" name="cvv2Number" /><input type="hidden" name="paymentType" value="Sale" /></td>
									</tr>
									</table>
							</div>
							</td>
							<td width="50%" valign="top">
							<?php if($_GET['flag']==2){ ?>
							<div align="right">
								<table border="0" width="98%" cellspacing="0" cellpadding="4" class="content4" style="border:1px solid #333333;">
									<tr>
										<td width="100%" background="images/collectionbg1_see.png" align="center">
										<b><font size="2" color="#FF0000">Transaction Declined</font></b></td>
									</tr>
									<tr>
										<td width="100%" align="left" height="10"></td>
									</tr>
									<tr>
										<td width="100%" align="left">
										<?php 
											$err=$_SESSION['reshash'];
						                	if($err[L_LONGMESSAGE0] != ""){
						                		print  $err[L_LONGMESSAGE0]."<br><br>";
						                	}
						                	if($err[L_LONGMESSAGE1] != ""){
						                		print  $err[L_LONGMESSAGE1]."<br><br>";
						                	}
						                	if($err[L_LONGMESSAGE2] != ""){
						                		print  $err[L_LONGMESSAGE2]."<br><br>";
						                	}
                						?></td>
									</tr>
									</table>
							</div>
							<?php } ?></td>
						</tr>
						<tr>
							<td width="50%" valign="top" align="right" style="padding-right: 10px">
					<input type="submit" value="Submit" name="B1"></td>
							<td width="50%" valign="top">
							&nbsp;</td>
						</tr>
					</table>
					</td>
                  </tr>      

                  </table>
				</form></td>
	</tr>
</table>
</div>
</body>	
</html>