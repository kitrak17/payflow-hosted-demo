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

		
		$txn->AMT 				= '17.01';
		$txn->CURRENCY 			= 'AUD';
		$txn->TRXTYPE 	= 'S'; //txn type: R for Recurring, S for Sale
		$txn->TENDER 	= 'C'; //sets to a cc transaction
		$txn->environment = 'test';
 		$txn->ORIGID 	= 'B70PAD882D44'; 

		$txn->process();	
		echo '</pre>';
		print_r($txn->response_arr);
		
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