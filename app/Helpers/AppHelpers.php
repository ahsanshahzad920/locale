<?php

namespace App\Helpers;


use Illuminate\Http\Request;


class AppHelpers
{
    //

    public static function getFileIcon($file_name){
        $fileParts = explode('.', $file_name);
        $extension = end($fileParts);  
        
        if($extension == "pdf"){
            return "<i class='fa fa-file-pdf-o'></i>";
        }
       else if(in_array($extension,['doc','docx'])){
            return "<i class='fa fa-file-word-o'></i>";
        }
        else if(in_array($extension,['xls','xlsx'])){
            return "<i class='fa fa-file-excel-o'></i>";
        }
       else  if(in_array($extension,['png','jpg','bmp','jpeg','PNG','JPG','JPEG','GIF','gif'])){
            return "<i class='fa fa-picture-o'></i>";
        }
        else{
            return "<i class='fa fa-file-o'></i>";
        }
    }
}
