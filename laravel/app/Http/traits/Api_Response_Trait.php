<?php 

namespace App\Http\traits;

use App\Http\Resources\EcommerceResource;

trait Api_Response_Trait {
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
    return new EcommerceResource($array, 200);
}
}