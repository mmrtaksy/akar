<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MailService
{
	public function new_password($email)
    {


        try {

            if(!$email){
                return false;
            }

            $token = Str::random(60);
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]);

            // Şifre sıfırlama bağlantısı oluştur
            $resetLink = url('/password-reset', ['token' => $token, 'email' => $email]);

            // Mail gönder
            Mail::send('emails.password_new', ['resetLink' => $resetLink], function ($message) use ($email) {
                $message->to($email);
                $message->subject('Yeni Şifre Oluştur');
            });

        } catch (\Throwable $th) {
            throw $th;
        }

        return true;
    }



    
	public function verify($email)
    {


        try {

            if(!$email){
                return false;
            }

            $token = Str::random(60);
            DB::table('email_verifications')->insert([
                'email' => $email,
                'token' => Hash::make($token),
                'created_at' => now(),
            ]);
    
            $verificationLink = url('/email-verify', ['token' => $token, 'email' => $email]);
    
            Mail::send('emails.email_verify', ['verificationLink' => $verificationLink], function ($message) use ($email) {
                $message->to($email);
                $message->subject('E-posta Doğrulama Talebi');
            });
            

        } catch (\Throwable $th) {
            throw $th;
        }

        return true;
    }

}
