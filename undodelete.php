<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: insurance.php');
        exit;

	}
    $customer_id = $del_id;
$data_to_update=Array();
    $db = getUipDbInstance();
   $data_to_update['cancelled'] = '0';
     $data_to_update['reinstated'] = '1';
     $db->where('id',$customer_id);
    $stat = $db->update('client_insurance_details', $data_to_update);
    $db->disconnect();

    if ($stat) 
    {
        $_SESSION['info'] = "Policy reinstated successfully!";
        header('location: insurance.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to delete client motorbike details";
    	header('location: customers.php');
        exit;

    }
    
}