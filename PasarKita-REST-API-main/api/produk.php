<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
function out($code,$ok,$msg,$data=null){http_response_code($code);echo json_encode(['success'=>$ok,'message'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);exit;}
if($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(204);exit;}
if($_SERVER['REQUEST_METHOD']!=='GET'){header('Allow: GET, OPTIONS');out(405,false,'Method tidak diizinkan. Gunakan GET.');}
if(isset($_GET['id'])){
 $id=filter_var($_GET['id'],FILTER_VALIDATE_INT);
 if(!$id||$id<1)out(400,false,'Parameter id harus berupa bilangan bulat positif.');
 $st=$conn->prepare("SELECT p.id,p.name,p.description,p.price,p.stock,p.image,p.category_id,c.name category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.status='active' LIMIT 1");
 $st->bind_param('i',$id);$st->execute();$p=$st->get_result()->fetch_assoc();
 if(!$p)out(404,false,'Produk tidak ditemukan.');
 out(200,true,'Detail produk berhasil diambil.',$p);
}
$res=$conn->query("SELECT p.id,p.name,p.description,p.price,p.stock,p.image,p.category_id,c.name category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.status='active' ORDER BY p.created_at DESC");
$data=[];while($r=$res->fetch_assoc())$data[]=$r;
out(200,true,'Data produk berhasil diambil.',$data);
