<?php
namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;
enum  DeviceStatus:string {
    use InteractWithEnum;
    case Ready='جاهز';
    case NotRedy='غير جاهز';
    case NotMaintainable='لا يصلح';
    case InProgress='قيد العمل';
    case NotStarted='لم يتم بدء العمل فيه';
    case NotAgree='لم يوافق على العمل به';
}
