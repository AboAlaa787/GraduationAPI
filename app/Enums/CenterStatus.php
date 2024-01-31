<?php
namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;
enum  CenterStatus:string {
    use InteractWithEnum;
    case Active='مفتوح';
    case InActive='مغلق';
}
