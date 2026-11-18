<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
function out($code,$ok,$msg,$data=null){http_response_code($code);echo json_encode(['success'=>$ok,'message'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);exit;}
if($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(204);exit;}
if($_SERVER['REQUEST_METHOD']!=='GET'){header('Allow: GET, OPTIONS');out(405,false,'Method tidak diizinkan. Gunakan GET.');}
$res=$conn->query("SELECT id,name FROM categories ORDER BY name ASC");
$data=[];while($r=$res->fetch_assoc())$data[]=$r;
out(200,true,'Data kategori berhasil diambil.',$data);
