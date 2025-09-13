<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MessageReply extends Model implements HasMedia
{
    use InteractsWithMedia;
    public $guarded = [];
    public function messages()
    {
        return  $this->belongsTo(Message::class);
    }
    protected function imageUrl() : Attribute
    {
        return Attribute::make(
            get: function (){
                $postImage = $this->getFirstMedia('chats');
                if($postImage){
                    return $postImage->getUrl();
                }
                return null;
            }
        );
    }
}
