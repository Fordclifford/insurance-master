<?php 
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
 $db = getUipDbInstance();

if($_SESSION['admin_type']!='super'){
    echo $del_id;
    header('HTTP/1.1 401 Unauthorized', true, 401);
    exit("401 Unauthorized");
}


// Delete a user using user_id
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = getUipDbInstance();
	$db->where('batch_id', $del_id);
	$del = $db->delete('insurance_cert_numbers');
    
    $db->where('id', $del_id);
    $stat = $db->delete('insurance_batches');
    $db->disconnect();
    if ($stat && $del) {
        $_SESSION['info'] = "Batch deleted successfully!";
        header('location: batches.php');
        exit;
    }
}