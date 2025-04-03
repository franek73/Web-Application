<?php

require '../../vendor/autoload.php';
use MongoDB\BSON\ObjectID;

function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}

function AddNewImage($name, $title, $author, $typeofimage){
	$db=get_db();
	$result=$db->images->insertOne([ 'name' => $name, 'title' => $title, 'author' => $author, 'typeofimage'=> $typeofimage]);
	return $result;
	}

function AddNewUser($log, $pass, $email, $rule){
	$db=get_db();
	$wynik =$db->users->insertOne([ 'login' => $log, 'password' => $pass, 'email' => $email,'rule'=>$rule ]);
	return $wynik;
	}
	

function LoginExist($log){
	$db=get_db();
	$query = ['login' => $log];
	$user = $db->users->findOne($query);
	if ($user) {return true; }
	 else { return false;}
}

function AllImages(){
	$db=get_db();
	if ($db->images->count()>0) {
	  return $db->images->find();
	}
	else return false;
}

function AllUsers(){
	$db=get_db();
	if ($db->users->count()>0) {
	  return $db->users->find();
	}
	else return false;
}

function DeleteUser($idU){
 try{
	$db = get_db();
    $db->users->deleteOne(['_id' => new ObjectID($idU)]);
	return true;
 }
 catch( Exception $e) { return $e; }
}

function DeleteImage($idU){
	try{
	   $db = get_db();
	   $db->images->deleteOne(['_id' => new ObjectID($idU)]);
	   return true;
	}
	catch( Exception $e) { return $e; }
   }

function ReadUser($login, $password){
	try {
	$db = get_db();
	$user = $db->users->findOne(['login' => $login]);
	if($user !== null && password_verify($password,
	$user['password'])){
	session_regenerate_id();
	$_SESSION['user_id'] = $user['_id'];
	$_SESSION['rule'] = $user['rule'];
	return true;
	}
	else { return false; }
	}
	catch( Exception $e) { return $e; }
	}

function FindUser($id){
	$db = get_db();
	$result = $db->users->findOne(['_id' =>$_SESSION['user_id']]);
		return $result;
    }

function FindImages($page, $pageSize){
    
	$opts = [
    'skip' => ($page - 1) * $pageSize,
    'limit' => $pageSize
    ];

    $db=get_db();
    $result = $db->images->find(['$or'=>[['typeofimage' => 'public'],['typeofimage' => $_SESSION['user_id']]]], $opts); 
		
	return $result;
	}
	
function CountImages (){

	$db=get_db();
	$result=$db->images->count(['$or'=>[['typeofimage' => 'public'],['typeofimage' => $_SESSION['user_id']]]]);
	return $result;
}
