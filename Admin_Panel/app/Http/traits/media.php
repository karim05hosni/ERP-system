<?php 
// namedMock()

namespace App\Http\traits;
use Illuminate\Support\Facades\DB;
trait media {
    public function UploadPhoto($img, $folder){
        $photo_name = uniqid().'.'.$img->extension();
        $img->move(public_path('dist\\img\\'.$folder), $photo_name);
        return $photo_name;
    }
    public function DelPhoto($id, $folder){
            // dd($old_photo_name);
            $img_name = DB::table('products')->where('id',$id)->select('image')->first()->image;
            // dd($img_name);
            // dd($old_photo_name);
            $photo_path = public_path("dist\\img\\$folder\\$img_name");
            if($img_name){
                // dd(file_exists($photo_path . $img . '.jpg'));
                if(file_exists($photo_path)){
                    // dd($photo_path);
                    $is_deleted =unlink($photo_path);
                    return $is_deleted;
                }
            }
    }
}