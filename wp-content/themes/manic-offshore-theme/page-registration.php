<?php 
$api_url = 'http://localhost:8888/offshore/b/api/company';
$response = wp_remote_get($api_url);
print_r($response['body']);
?>