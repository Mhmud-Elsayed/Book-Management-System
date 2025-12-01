<?php

namespace App\Services;

use Illuminate\Http\Request;


class LanguageService
{
    private $supportedLanguages = ['en', 'ar'];
   public function detectLanguage(Request $request){
    if($request->has("lang"))
        {
            $language = $request->query("lang");
            if(in_array($language, $this->supportedLanguages)){
                return $language;

        }
   } 
   if($request->hasHeader("Accept-Language")){
        $language = $request->header("Accept-Language");
        if(in_array($language, $this->supportedLanguages)){
            return $language;
        }
   }
   return 'en'; 
}
}