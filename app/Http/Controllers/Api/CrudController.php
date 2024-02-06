<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class CrudController extends Controller
{
    public function createFolder(Request $request){
        $request->validate([
            'name' => 'required'
        ]);
        $folder = DB::table('folders')->insert($request->all());
        
        return $folder;
    }

    public function EditFolder($id){
        $folder = DB::table('folders')->where('id',$id)->first();
        return $folder;
     }

    
     public function updateFolder(Request $request, $id){
         // dd($request);
         $request->validate([
             'name' => 'required'
         ]);
         $folder = DB::table('folders')->where('id',$id)->update($request->all());
         
         return $folder;
     }

    //  public function deleteFolder($id){
    //     $files = DB::table('files')->where('folder_id',$id)->get();
    //     foreach($files as $file){
    //         unlink(storage_path('app/public/uploads/'. $file->name));
    //     }
    //      $folder = DB::table('folders')->where('id',$id)->delete();
    //      $files = DB::table('files')->where('folders_id',$id)->delete();
    //     // return $folder;
        
    //  }
    public function deleteFolder($id)
    {

    $files = DB::table('files')->where('folders_id', $id)->get();

        foreach ($files as $file) {

            $filePath = storage_path('app/public/uploads/'.$file->name);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $deletedFolderCount = DB::table('folders')->where('id', $id)->delete();
        $deletedFilesCount = DB::table('files')->where('folders_id', $id)->delete();

        return $deletedFolderCount;
    }

    public function deleteFiles($id){
        $file = DB::table('files')->where('id',$id)->first();
        unlink(storage_path('app/public/uploads/'. $file->name_generate));

        $result = DB::table('files')->where('id',$id)->delete();
        return $result;
    }

    
    
}
