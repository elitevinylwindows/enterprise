<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'module',
        'name',
        'subject',
        'message',
        'short_code',
        'enabled_email',
        'enabled_sms',
        'parent_id',
    ];

    static $modules = [
        'reminder' =>
        [
            'module' => 'reminder',
            'name' => 'Reminder',
            'short_code' => ['{company_name}', '{company_email}', '{company_phone_number}', '{company_address}', '{company_currency}', '{new_user_name}', '{app_link}', '{username}', '{password}'],
            'subject' => 'Welcome to {company_name}!',
            'templete' => '
                <p><strong>Dear {customer_name}</strong>,</p><p>&nbsp;</p><blockquote><p>This is a reminder {company_name}! We are excited to have you on board and look forward to providing you with an exceptional experience.</p><p>We hope you enjoy your experience with us. If you have any feedback, feel free to share it with us.</p><p>&nbsp;</p><p>Your account details are as follows:</p><p><strong>App Link:</strong> <a href="{app_link}">{app_link}</a></p><p><strong>Username:</strong> {username}</p><p><strong>Password:</strong> {password}</p><p>&nbsp;</p><p>Thank you for choosing {company_name}!</p></blockquote><p>Best regards,</p><p>{company_name}</p><p>{company_email}</p>
            ',
        ],
        'follow_up' =>
        [
            'name' => 'Follow Up',
            'short_code' => ['{visitor_name}', '{visitor_email}', '{visitor_phone_number}', '{visitor_id}', '{visitor_date}', '{visitor_entry_time}', '{visitor_exit_time}', '{visitor_category}', '{visitor_address}', '{visitor_notes}'],
            'subject' => 'Welcome to {visitor_name}!',
            'templete' => '
            <p><strong>Dear {visitor_name},</strong></p>
            <p>Thank you for registering with us. Here are the details of your visit:</p>
            <p>&nbsp;</p>
            <blockquote>
                <p><strong>Name:</strong> {visitor_name} </p>
                <p><strong>Email:</strong> {visitor_email} </p>
                <p><strong>Phone Number:</strong> {visitor_phone_number} </p>
                <p><strong>Visitor ID:</strong> {visitor_id} </p>
                <p><strong>Visit Date:</strong> {visitor_date} </p>
                <p><strong>Entry Time:</strong> {visitor_entry_time} </p>
                <p><strong>Exit Time:</strong> {visitor_exit_time} </p>
                <p><strong>Category:</strong> {visitor_category} </p>
                <p><strong>Address:</strong> {visitor_address} </p>
                <p><strong>Notes:</strong> {visitor_notes} </p>
            </blockquote>',
        ],
    ];
}
