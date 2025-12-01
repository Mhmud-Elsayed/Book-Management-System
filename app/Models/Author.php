<?php

namespace App\Models;

use App\Mail\AuthorWelcomeEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class Author extends Model
{
    use Notifiable;
    protected $fillable = [
        "email",
        "name_en",
        "name_ar",
        "bio_en",
        "bio_ar",
        
    ] ;
   public function books()
   {
       return $this->hasMany(Book::class);
   }
   static public function boot()
   {
       parent::boot();

       static::created(function ($author) {
           Mail::to($author->email)->send(new AuthorWelcomeEmail($author));
           Log::info('Welcome email sent to ' . $author->email);
       });

   }
}
