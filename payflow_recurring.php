<?php
	try { 
		require_once dirname(__file__).'/Payflow-paypal-pro.php';
		$txn = new PayflowTransaction();
	
		//these are provided by your payflow reseller
		$txn->PARTNER 	= 'VSA';
		$txn->USER 		= 'nswbusinesschamber'; //or your merchant login name
		$txn->PWD		= 'Merchant001';
		$txn->VENDOR 	= $txn->USER; 
 		
		// transaction information
		$txn->ACCT 		= "4111111111111111"; //cc number
		$txn->AMT 		= '1.00'; //amount: 1 dollar
		$txn->EXPDATE	= '0222'; //4 digit expiration date
		$txn->CVV2		= '345'; 
		// billing information
		$txn->EMAIL		= 'buyer@test.com'; 
		$txn->FIRSTNAME = 'Karthick';
		$txn->LASTNAME 	= 'Madheswaran';
		$txn->STREET 	= '123 mystreet';
		$txn->CITY 		= 'Sydney';
		$txn->STATE 	= 'NSW';
		$txn->ZIP 		= '1201';
		$txn->COUNTRY 	= 'AU';
		$txn->CURRENCY = 'AUD';
		/**/
		//https://www.paypalobjects.com/en_US/vhelp/paypalmanager_help/transaction_type_codes.htm
		$txn->TRXTYPE 	= 'R'; //txn type: R for Recurring, S for Sale
		$txn->TENDER 	= 'C'; //sets to a cc transaction
		$txn->environment = 'test';
 		$txn->debug = true; //uncomment to see debugging information
		//$txn->avs_addr_required = 1; //set to 1 to enable AVS address checking, 2 to force "Y" response
		//$txn->avs_zip_required = 1; //set to 1 to enable AVS zip code checking, 2 to force "Y" response
		$txn->cvv2_required = 1; //set to 1 to enable cvv2 checking, 2 to force "Y" response
		//$txn->fraud_protection = true; //uncomment to enable fraud protection

		//Recurring Add Profile
		
		$txn->ACTION 			= 'A';  // Specifies Add (A), Modify, Cancel, Reactivate, Inquiry, or Payment.
		$txn->PROFILENAME 		= 'My Profile';
		$txn->START		 		= '12122019'; //starting date
		$txn->TERM	 			= '5';
		$txn->PAYPERIOD	 		= 'DAYS';  //DAYS, WEEK, BIWK, SMMO, FRWK, MONT, QTER, SMYR, YEAR
		
		/* Setup initial payment*/
		$txn->OPTIONALTRX 		= 'S';
		$txn->OPTIONALTRXAMT 	= '5.10';
		echo '<pre>';
		$result = $txn->process();
		print_r($result);
		exit;
		echo '<pre>';
		echo "success: " . $txn->txn_successful;
		echo "response was: " . print_r( $txn->response_arr->RESULT, true );	
		
		print $txn->response_arr['PROFILEID'];
		
		
		die();
		
		

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