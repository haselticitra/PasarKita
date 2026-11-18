<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
function out($code,$ok,$msg,$data=null){http_response_code($code);echo json_encode(['success'=>$ok,'message'=>$msg,'data'=>$data],JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);exit;}
if($_SERVER['REQUEST_METHOD']==='OPTIONS'){http_response_code(204);exit;}
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Allow: POST, OPTIONS');out(405,false,'Method tidak diizinkan. Gunakan POST.');}
$input=json_decode(file_get_contents('php://input'),true);
if(!is_array($input)||json_last_error()!==JSON_ERROR_NONE)out(400,false,'Body request harus berupa JSON yang valid.');
$uid=filter_var($input['user_id']??null,FILTER_VALIDATE_INT);
$address=trim((string)($input['address']??''));$phone=trim((string)($input['phone']??''));$notes=trim((string)($input['notes']??''));$items=$input['items']??null;
if(!$uid||$uid<1||$address===''||$phone===''||!is_array($items)||!count($items))out(422,false,'user_id, address, phone, dan items wajib diisi dengan benar.');
$normalized=[];
foreach($items as $it){if(!is_array($it))out(422,false,'Format item tidak valid.');$pid=filter_var($it['product_id']??null,FILTER_VALIDATE_INT);$qty=filter_var($it['quantity']??null,FILTER_VALIDATE_INT);if(!$pid||$pid<1||!$qty||$qty<1)out(422,false,'product_id dan quantity harus bilangan positif.');$normalized[$pid]=($normalized[$pid]??0)+$qty;}
$u=$conn->prepare("SELECT id FROM users WHERE id=? AND status='active' LIMIT 1");$u->bind_param('i',$uid);$u->execute();if(!$u->get_result()->fetch_assoc())out(404,false,'Pengguna tidak ditemukan atau tidak aktif.');
try{
 $conn->begin_transaction();$details=[];$total=0;
 foreach($normalized as $pid=>$qty){$s=$conn->prepare("SELECT id,name,price,stock FROM products WHERE id=? AND status='active' FOR UPDATE");$s->bind_param('i',$pid);$s->execute();$p=$s->get_result()->fetch_assoc();if(!$p)throw new RuntimeException("Produk ID $pid tidak ditemukan atau tidak aktif.");if((int)$p['stock']<$qty)throw new RuntimeException("Stok {$p['name']} tidak mencukupi.");$price=(float)$p['price'];$sub=$price*$qty;$total+=$sub;$details[]=['product_id'=>(int)$p['id'],'product_name'=>$p['name'],'price'=>$price,'quantity'=>$qty,'subtotal'=>$sub];}
 $s=$conn->prepare("INSERT INTO orders(user_id,total_amount,address,phone,notes,status) VALUES(?,?,?,?,?,'pending')");$s->bind_param('idsss',$uid,$total,$address,$phone,$notes);$s->execute();$orderId=$conn->insert_id;
 foreach($details as $d){$s=$conn->prepare("INSERT INTO order_items(order_id,product_id,product_name,price,quantity,subtotal) VALUES(?,?,?,?,?,?)");$s->bind_param('iisdid',$orderId,$d['product_id'],$d['product_name'],$d['price'],$d['quantity'],$d['subtotal']);$s->execute();$s=$conn->prepare("UPDATE products SET stock=stock-? WHERE id=? AND stock>=?");$s->bind_param('iii',$d['quantity'],$d['product_id'],$d['quantity']);$s->execute();if($s->affected_rows!==1)throw new RuntimeException('Gagal memperbarui stok.');}
 $conn->commit();out(201,true,'Pesanan berhasil dibuat.',['order_id'=>$orderId,'user_id'=>$uid,'total_amount'=>$total,'status'=>'pending','items'=>$details]);
}catch(Throwable $e){$conn->rollback();$code=$e instanceof RuntimeException?422:500;out($code,false,$code===422?$e->getMessage():'Terjadi kesalahan pada server.');}
