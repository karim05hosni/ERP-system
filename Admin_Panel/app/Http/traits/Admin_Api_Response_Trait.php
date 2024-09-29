<?php 

namespace App\Http\traits;

use App\Http\Resources\AdminResource;
use App\Http\Resources\UserResource;

trait Admin_Api_Response_Trait {
public function Api_Response($status = 200, $message=null, $errors=null, $data=null){
    $array = [
        'status' => $status,
        'message' => $message,
    ];
    if (is_null($errors) && !is_null($data)){
        $array['data'] = $data;
    } elseif (!is_null($errors) && is_null($data)){
        $array['errors']= $errors;
    } else {
        $array['data'] = $data;
        $array['errors']=$errors;
    } 
    return new AdminResource($array, 200);
}
}