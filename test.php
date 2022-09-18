<?php
$orderdate = '2022-09-15 11:15:30'; 
$currentdate = date('Y-m-d H:i:s');
$from_time = strtotime($orderdate); 
$to_time = strtotime($currentdate); 
$diff_minutes = round(abs($from_time - $to_time) / 3600);
echo $diff_minutes;
?>