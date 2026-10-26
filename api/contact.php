<?php
require __DIR__.'/../includes/functions.php';
header('Content-Type: application/json');
$out = fn($ok,$m)=>exit(json_encode(['ok'=>$ok,'message'=>$m]));
if ($_SERVER['REQUEST_METHOD']!=='POST') $out(false,'Invalid request');
if (!hash_equals($_SESSION['t'] ?? '', $_POST['csrf'] ?? '')) $out(false,'Session expired, refresh the page.');
if (!empty($_POST['website'])) $out(true,'Thanks!');

$clean = fn($s,$n=200)=>mb_substr(trim(preg_replace('/[\r\n\t]+/',' ',(string)$s)),0,$n);
$allowed = []; foreach (cfg('service_groups') as $items) $allowed = array_merge($allowed,$items);
$services = array_values(array_intersect(array_map('trim',(array)($_POST['services']??[])), $allowed));
$budget = in_array($_POST['budget']??'', cfg('budgets'), true) ? $_POST['budget'] : '';

$d = [
 'name'=>$clean($_POST['name']??'',100), 'email'=>$clean($_POST['email']??'',120),
 'phone'=>$clean($_POST['phone']??'',30), 'country'=>$clean($_POST['country']??'',60),
 'company'=>$clean($_POST['company']??'',100), 'services'=>$services, 'budget'=>$budget,
 'message'=>mb_substr(trim((string)($_POST['message']??'')),0,1500),
];
if (!$d['name']||!filter_var($d['email'],FILTER_VALIDATE_EMAIL)||!$d['country']||!$d['phone']||!$d['services'])
  $out(false,'Please fill all required fields and pick at least one service.');
$d['time']=date('c'); $d['ip']=$_SERVER['REMOTE_ADDR']??'';
file_put_contents(__DIR__.'/../storage/leads.log', json_encode($d,JSON_UNESCAPED_UNICODE).PHP_EOL, FILE_APPEND|LOCK_EX);
$body = "Name: {$d['name']}\nEmail: {$d['email']}\nPhone: {$d['phone']}\nCountry: {$d['country']}\nCompany: {$d['company']}\n"
      . "Services: ".implode(', ',$d['services'])."\nBudget: {$d['budget']}\n\nDetails:\n{$d['message']}\n";
@mail(cfg('mail_to'),'New lead — '.cfg('name'),$body,'From: '.cfg('email')."\r\nReply-To: ".$d['email']);
$out(true,'Thanks! We will reply within 24 hours.');
