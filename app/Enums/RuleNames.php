<?php
namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;

enum RuleNames:string {
    use InteractWithEnum;
    case Admin='مدير';
    case Technician='فني';
    case Client='عميل';
    case Delivery='عامل توصيل';
}
