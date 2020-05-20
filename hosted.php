<?php
ini_set('max_execution_time', 300);
	$sec_totekn = uniqid();
	$SECURETOKEN = '';
	$SECURETOKENID = '';
	try { 
		require_once 'Payflow-paypal-pro.php';
		$txn = new PayflowTransaction();
	
		//these are provided by your payflow reseller
		$txn->PARTNER 	= 'VSA';
		$txn->VENDOR	= 'sankarR'; //or your merchant login name
		$txn->PWD		= 'Merchant0001';
		$txn->USER 	= $txn->VENDOR; 
 		
		// billing information
		$txn->EMAIL		= 'buyer@test.com';
		$txn->FIRSTNAME = 'Raj';
		$txn->LASTNAME 	= "Rad'hakrishnan";
		$txn->STREET 	= '75 Riordan SurryHills';
		$txn->CITY 		= 'Sydney';
		$txn->STATE 	= 'NSW';
		$txn->ZIP 		= '1201';
		$txn->COUNTRY 	= 'AU';
		//$txn->VERBOSITY='HIGH';
		$txn->TEMPLATE='MOBILE';
		
		$txn->AMT 				= '13.00';
		$txn->CURRENCY 			= 'AUD';
		$txn->CREATESECURETOKEN = 'Y';
		//$txn->SILENTTRAN		='TRUE';
		$txn->SECURETOKENID 	= $sec_totekn;
		
		//$txn->SILENTPOSTURL 	= 'http://localhost/test/payflow/test.php';
		$txn->RETURNURL = 'http://localhost/Source_codes/Payflow_transparent/success.php';
		$txn->ERRORURL 	= 'http://localhost/Source_codes/Payflow_transparent/error.php';
		
		/**/
		//https://www.paypalobjects.com/en_US/vhelp/paypalmanager_help/transaction_type_codes.htm
		$txn->TRXTYPE 	= 'S'; //txn type: R for Recurring, S for Sale
		$txn->TENDER 	= 'C'; //sets to a cc transaction
		$txn->environment = 'test';
 		$txn->debug 	= true; //uncomment to see debugging information
		//$txn->avs_addr_required = 1; //set to 1 to enable AVS address checking, 2 to force "Y" response
		//$txn->avs_zip_required = 1; //set to 1 to enable AVS zip code checking, 2 to force "Y" response
		$txn->cvv2_required = 1; //set to 1 to enable cvv2 checking, 2 to force "Y" response
		//$txn->fraud_protection = true; //uncomment to enable fraud protection
		//var_dump($txn);

		$txn->process();

		
		
	//echo "success: " . $txn->txn_successful;
		//echo "response was: " . print_r( $txn->response_arr->RESULT, true );	
		//echo '</pre>';
		//print_r($txn->response_arr);
		$SECURETOKEN = $txn->response_arr['SECURETOKEN'];
		$SECURETOKENID = $txn->response_arr['SECURETOKENID']; 
		
	}
	catch( TransactionDataException $tde ) {
		echo 'bad transaction data ' . $tde->getMessage();
	}
	catch( InvalidCredentialsException $e ) {
		echo 'Invalid credentials';
	}
	catch( InvalidResponseCodeException $irc ) {
		echo 'bad response code: ' . $irc->getMessage();
	}
	catch( AVSException $avse ) {
		echo 'AVS error: ' . $avse->getMessage();
	}
	catch( CVV2Exception $cvve ) {
		echo 'CVV2 error: ' . $cvve->getMessage();
	}
	catch( FraudProtectionException $fpe ) {
		echo 'Fraud Protection error: ' . $fpe->getMessage();
	}
	catch( Exception $e ) {
		echo $e->getMessage();
	}
	
	?>

<html>
	
	<head></head>
	
	<body>
		<!-- <form action="https://pilot-payflowlink.paypal.com" method="POST">
			<input type="hidden" name="SECURETOKEN" value="<?php echo $SECURETOKEN ?>">
			<input type="hidden" name="SECURETOKENID" value="<?php echo $SECURETOKENID ?>">
			<p> <input name="ACCT" placeholder="16 digit card number" value="4647525516582555"> </p>
			<p> <input name="EXPDATE" placeholder="Expire" value="1217"> </p>
			<p> <input name="CVV2" placeholder="CVV" value="123"> </p>
			<p> <button type="submit" >Submit</button> </p>
		</form>  -->
		<iframe src="https://pilot-payflowlink.paypal.com?MODE=TEST&SECURETOKENID=<?php echo $SECURETOKENID ?>&SECURETOKEN=<?php echo $SECURETOKEN ?>"
    name="test_iframe" scrolling="no" width="570px" height="540px"></iframe>
	</body>
</html>