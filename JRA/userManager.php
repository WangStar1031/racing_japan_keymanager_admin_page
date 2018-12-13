<?php

	require_once __DIR__ . "/makeKey.php";
	function removeToken( $_email, $_preToken){
		$fName = __DIR__ . "/logs/users/" . $_email;
		if( file_exists($fName)){
			$userInfo = json_decode(file_get_contents($fName));
			$productDetails = $userInfo->productDetails;
			$arrNewDetails = [];
			foreach ($productDetails as $key => $value) {
			// for( $i = 0; $i < count($productDetails); $i++){
				if( strcasecmp($_preToken, $value->token) == 0){
				}
				else{
					$arrNewDetails[] = $value;
				}
			}
			$userInfo->productDetails = $arrNewDetails;
			file_put_contents($fName, json_encode($userInfo));
		}
	}
	function updateUserProductInfo($_email, $_token, $_isSubmitCat, $_limit, $_limitation){
		$fName = __DIR__ . "/logs/users/" . $_email;
		if( file_exists($fName)){
			$userInfo = json_decode(file_get_contents($fName));
			$productDetails = $userInfo->productDetails;
			foreach ($productDetails as $value) {
				if( strcasecmp($_token, $value->token) == 0){
					$value->limit = $_limit;
					if( $_isSubmitCat == "false"){
						$value->unlimited = $_limitation == "true" ? true : false;
					}
					unlink($fName);
					file_put_contents($fName, json_encode($userInfo));
					return true;
				}
			}
		}
		return false;
	}
	function reNewToken($_email, $_preToken){
		$_token = makeEncryptKey($_email);
		$fName = __DIR__ . "/logs/users/" . $_email;
		if( file_exists($fName)){
			$userInfo = json_decode(file_get_contents($fName));
			$productDetails = $userInfo->productDetails;
			foreach ($productDetails as $value) {
				if( strcasecmp( $_preToken, $value->token) == 0){
					$value->token = $_token;
					unlink($fName);
					file_put_contents($fName, json_encode($userInfo));
					return;
				}
			}
		}
		return false;
	}
	function changeLimit_count($_email, $_limit_count, $_isChecked){
		$dir = __DIR__ . "/logs/users/";
		$fName = $dir . $_email;
		if( file_exists($fName)){
			$userInfo = json_decode(file_get_contents($fName));
			$userInfo->limit_count = $_limit_count;
			$userInfo->unlimited = ($_isChecked == "true" ? true:false);
			unlink($fName);
			file_put_contents($fName, json_encode($userInfo));
			return true;
		}
		return false;
	}
	function adminVerify($_userName, $_userPass){
		$fName = __DIR__ . "/logs/users/admin";
		if( !file_exists($fName)){
			$data = new \stdClass;
			$data->userName = "admin";
			$data->userPass = "admin";
			unlink($fName);
			file_put_contents($fName, json_encode($data));
		}
		$contents = file_get_contents($fName);
		$userInfo = json_decode($contents);
		if( strcasecmp($_userName, $userInfo->userName) == 0){
			if( strcasecmp($_userPass, $userInfo->userPass) == 0){
				return true;
			}
		}
		return false;
	}
	function changeAdminPassword($_curPass, $_newPass){
		$fName = __DIR__ . "/logs/users/admin";
		if( !file_exists($fName)){
			$data = new \stdClass;
			$data->userName = "admin";
			$data->userPass = "admin";
			unlink($fName);
			file_put_contents($fName, json_encode($data));
		}
		$contents = file_get_contents($fName);
		$userInfo = json_decode($contents);
		if( strcasecmp($_curPass, $userInfo->userPass) == 0){
			$userInfo->userPass = $_newPass;
			unlink($fName);
			file_put_contents($fName, json_encode($userInfo));
			return true;
		}
		return false;

	}
	function userVerify($_userName, $_userPass){
		$lstUsers = getAllUsers();
		foreach ($lstUsers as $user) {
			if( strcasecmp($_userName, $user->eMail) == 0 && strcasecmp($_userPass, $user->userPass) == 0){
				return true;
			}
		}
		return false;
	}

	function registerUser($_firstName, $_lastName, $_eMail, $_password){
		$fName = __DIR__ . "/logs/users/" . $_eMail;
		if( file_exists($fName)){
			return "Already exist.";
		}
		$user = new \stdClass;
		$user->firstName = $_firstName;
		$user->lastName = $_lastName;
		$user->eMail = $_eMail;
		$user->userPass = $_password;
		$user->token = makeEncryptKey($_eMail);
		$user->startedDate = date("Y-m-d");
		$user->expDate = date("Y-m-d");
		$user->refreshedDate = date("Y-m-d");
		$user->billingHistory = [];
		$user->limit_count = 0;
		$user->unlimited = false;
		file_put_contents(__DIR__ . "/logs/users/" . $_eMail, json_encode($user));
		return true;
	}
	function getAllUsers(){
		$retVal = [];
		$dir = __DIR__ . "/logs/users/";
		$files = scandir($dir);
		foreach ($files as $value) {
			if( is_dir($value) || $value == "admin")
				continue;
			$fContents = file_get_contents($dir . $value);
			$data = json_decode($fContents);
			$retVal[] = $data;
		}
		return $retVal;
	}
	function getStripeKey(){
		$fName = __DIR__ . "/logs/users/admin";
		$contents = file_get_contents($fName);
		$userInfo = json_decode($contents);
		if( isset($userInfo->stripeKey))return $userInfo->stripeKey;
		return false;
	}
	function getStripeSecret(){
		$fName = __DIR__ . "/logs/users/admin";
		$contents = file_get_contents($fName);
		$userInfo = json_decode($contents);
		if( isset($userInfo->stripeSecret))return $userInfo->stripeSecret;
		return false;
	}
	function getUserInfoFromEmail($_email){
		$dir = __DIR__ . "/logs/users/";
		$fName = $dir . $_email;
		// echo($fName);
		if( file_exists($fName)){
			return json_decode(file_get_contents($fName));
		}
		return false;
	}
	function setUserInfo($_userInfo){
		$dir = __DIR__ . "/logs/users/";
		$fName = $dir . $_userInfo->eMail;
		file_put_contents($fName, json_encode($_userInfo));
	}
	function discountUserCount($_eMail, $_limit_count){
		$fName = __DIR__ . "/logs/users/" . $_eMail;
		if( file_exists($fName)){
			$user = json_decode( file_get_contents($fName));
			$user->limit_count = $_limit_count;
			file_put_contents($fName, json_encode( $user));
		}
	}
	function getResponseContents($_productName, $_date){
		switch ($_productName) {
			case 'Stewards reports api key':
					$fName = __DIR__ . "/logs/stewards/" . $_date . ".json";
					if( file_exists($fName)){
						return file_get_contents($fName);
					} else{
						return "Invalid Date";
					}
				break;
			
			default:
				# code...
				break;
		}
	}
	function getApiRespond($_token, $_date){
		$dir = __DIR__ . "/logs/users/";
		$files = scandir($dir);
		foreach ($files as $value) {
			if( is_dir($value) || $value == "admin")
				continue;
			$fContents = file_get_contents($dir . $value);
			$data = json_decode($fContents);
			$product_Details = $data->productDetails;
			$email = $data->eMail;
			foreach ($product_Details as $product) {
				$token = $product->token;
				if( strcasecmp($_token, $token) == 0){
					if( strcasecmp( $product->product_cat, "Subscription") == 0){
						$today = strtotime(date("Y-m-d"));
						$expDate = strtotime( $product->limit);
						if( $today < $expDate){
							echo getResponseContents($product->productName, $_date);
						} else{
							echo "Expirated Key.";
							return;
						}
					} else{
						if( $product->unlimited == true){
							echo getResponseContents($product->productName, $_date);
							return;
						} else{
							if( $product->limit > 0){
								$product->limit --;
								unlink($dir . $value);
								file_put_contents($dir . $value, json_encode($data));
								echo getResponseContents($product->productName, $_date);
								return;
							}
						}
					}
				}
			}
		}
		echo "Invalid token";
	}
	function getUserInfoFromCode($_token){
		$dir = __DIR__ . "/logs/users/";
		$files = scandir($dir);
		foreach ($files as $value) {
			if( is_dir($value) || $value == "admin")
				continue;
			$fContents = file_get_contents($dir . $value);
			$data = json_decode($fContents);
			$product_Details = $data->productDetails;
			foreach ($product_Details as $value) {
				$token = $value->token;
				if( strcasecmp($_token, $token) == 0){
					return $data;
				}
			}
			// if( strcasecmp( $data->token, $_token) === 0)
			// 	return $data;
		}
		return false;
	}
	function verifyAdminPassword($_curPass){
		$fName = __DIR__ . "/logs/users/admin";
		if( !file_exists($fName)){
			$data = new \stdClass;
			$data->userName = "admin";
			$data->userPass = "admin";
			file_put_contents($fName, json_encode($data));
		}
		$contents = file_get_contents($fName);
		$userInfo = json_decode($contents);
		if( strcasecmp($_curPass, $userInfo->userPass) == 0){
			return true;
		}
		return false;
	}
	function changeStripeSettings($_stripeKey, $_stripeSecret){
		$fName = __DIR__ . "/logs/users/admin";
		if( !file_exists($fName)){
			$data = new \stdClass;
			$data->userName = "admin";
			$data->userPass = "admin";
			file_put_contents($fName, json_encode($data));
		}
		$contents = file_get_contents($fName);
		$userInfo = json_decode($contents);
		$userInfo->stripeKey = $_stripeKey;
		$userInfo->stripeSecret = $_stripeSecret;
		file_put_contents($fName, json_encode($userInfo));
		return true;
	}
	function stripeBilling($_key_user, $_stripeToken){
	// \Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");
		$_stripeSecret = getStripeSecret();
		\Stripe\Stripe::setApiKey($_stripeSecret);
		$charge = \Stripe\Charge::create([
			'card' => $_stripeToken,
			'amount' => 2000,
			'currency' => 'USD',
			// "source" => "tok_visa", // obtained with Stripe.js
			'description' => 'Add in wallet'
		]);
		if($charge['status'] == 'succeeded'){
			$userInfo = getUserInfoFromEmail($_key_user);
			$expDate = $userInfo->expDate;
			$date = date('Y-m-d', strtotime(date("Y-m-d", strtotime($expDate)) . " + 1 year"));
			$userInfo->expDate = $date;
			$billingHistory = $userInfo->billingHistory;
			$bill = new \stdClass;
			$bill->payDate = date("Y-m-d");
			$bill->payMethod = "Stripe";
			$bill->amount = 20.00;
			$bill->expDate = $date;
			$userInfo->billingHistory[] = $bill;
			// Write Here your Database insert logic.
			setUserInfo($userInfo);
		} else{
			// \Session::put('error', 'Money not add in wallet!!');
			// return view('subscription', ['email'=>$email, 'isActive'=>$billingData->isActive, 'errMsg'=>'* Money not add in wallet. *', 'expDate'=>$billingData->ExpirationDate]);
		}
		// print_r($_charge);
	}
?>