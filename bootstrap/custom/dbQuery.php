<?php 

use Illuminate\Support\Facades\DB;
    function uniqueNess($tbl,$key,$val){
        $query = DB::select("SELECT {$key} FROM {$tbl} WHERE {$key} = '$val' ");
        if($query){
            return $val .' exists in the table';
        }
        return null;
    }