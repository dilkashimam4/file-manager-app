<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function getData(){
        $folders = DB::table('folders')->get();
        $files = DB::table('files')->orderBy('id','desc')->get();
        return [
            'folders' => $folders,
            'files' =>$files
        ];
    }

    public function getFiles($foldersId){
    //    $files = DB::table('files')->orderBy('id','desc')->get();
       $files = DB::table('files')->where('folders_id',$foldersId)->orderBy('id','desc')->get();

       return $files;
    }

    public function getFolderName($id)
    {
        // dd($id);
        try {
            $folder = DB::table('folders')->where('id', $id)->first();
            if (!$folder) {
                return response()->json(['message' => 'Folder not found'], 404);
            }
            return response()->json(['name' => $folder->name]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching folder name'], 500);
        }
    }
    public function uploadFiles($id, Request $request){
        $request->validate([
            'file' =>'required|mimes:jpg,png,pdf,html,svg,|max:3062'
        ]);
        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('uploads',$filename,'public');

        DB::table('files')->insert([
            'name' => $file->getClientOriginalName(),
            'name_generate' =>$filename,
            'type' =>$file->guessExtension(),
            'size' => $file->getSize(),
            'folders_id' => $id
        ]);
    }
    public function downloadFiles($id){
        // return dd($id);
        $file = DB::table('files')->where('id',$id)->first();
        $path = storage_path('app/public/uploads/'.$file->name_generate);

        return response()->download($path);
    }
    
}
