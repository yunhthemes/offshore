<?php
$servername = "localhost:3306";
$username = "wp_offshore_user";
$password = "vOs9j1@2";
$dbname = "wp_offshore";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO transaction_log (Merchant_User_Id, Merchant_ref_number, Lpsid, Lpspwd, Transactionid, Requestid, bill_firstname, bill_lastname, Purchase_summary, currencydesc, amount, CardBin, CardLast4, CardType, merchant_ipaddress, CVN_Result, AVS_Result, Status, CardToken) 
    VALUES (:Merchant_User_Id, :Merchant_ref_number, :Lpsid, :Lpspwd, :Transactionid, :Requestid, :bill_firstname, :bill_lastname, :Purchase_summary, :currencydesc, :amount, :CardBin, :CardLast4, :CardType, :merchant_ipaddress, :CVN_Result, :AVS_Result, :Status, :CardToken)");
    $stmt->bindParam(':Merchant_User_Id', $Merchant_User_Id);
    $stmt->bindParam(':Merchant_ref_number', $Merchant_ref_number);
    $stmt->bindParam(':Lpsid', $Lpsid);
    $stmt->bindParam(':Lpspwd', $Lpspwd);
    $stmt->bindParam(':Transactionid', $Transactionid);
    $stmt->bindParam(':Requestid', $Requestid);
    $stmt->bindParam(':bill_firstname', $bill_firstname);
    $stmt->bindParam(':bill_lastname', $bill_lastname);
    $stmt->bindParam(':Purchase_summary', $Purchase_summary);
    $stmt->bindParam(':currencydesc', $currencydesc);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':CardBin', $CardBin);
    $stmt->bindParam(':CardLast4', $CardLast4);
    $stmt->bindParam(':CardType', $CardType);
    $stmt->bindParam(':merchant_ipaddress', $merchant_ipaddress);
    $stmt->bindParam(':CVN_Result', $CVN_Result);
    $stmt->bindParam(':AVS_Result', $AVS_Result);
    $stmt->bindParam(':Status', $Status);
    $stmt->bindParam(':CardToken', $CardToken);

    $Merchant_User_Id = $_POST["Merchant_User_Id"];
	$Merchant_ref_number = $_POST["Merchant_ref_number"];
	$Lpsid = $_POST["Lpsid"];	
	$Lpspwd = $_POST["Lpspwd"];
	$Transactionid = $_POST["Transactionid"];
	$Requestid = $_POST["Requestid"];
	$bill_firstname = $_POST["bill_firstname"];
	$bill_lastname = $_POST["bill_lastname"];
	$Purchase_summary = $_POST["Purchase_summary"];
	$currencydesc = $_POST["currencydesc"];
	$amount = $_POST["amount"];
	$CardBin = $_POST["CardBin"];
	$CardLast4 = $_POST["CardLast4"];
	$CardType = $_POST["CardType"];
	$merchant_ipaddress = $_POST["merchant_ipaddress"];
	$CVN_Result = $_POST["CVN_Result"];
	$AVS_Result = $_POST["AVS_Result"];
	$Status = $_POST["Status"];
	$CardToken = $_POST["CardToken"];  
	$stmt->execute(); 
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
    exit();
}
$conn = null;

if(!empty($Status)) {
	echo "RECEIVED OK";
}
?>