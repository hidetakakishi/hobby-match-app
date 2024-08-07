<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    //メール送信で使うビュー、タイトル、ビューに渡す認証用URLを設定
    public function build()
    {
        return $this->view('reset_password_mail')
                    ->subject('【App】パスワードを変更用メール')
                    ->with(['url'=>$this->url]);
    }
}