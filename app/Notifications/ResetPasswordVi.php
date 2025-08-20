<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordVi extends Notification
{
	public string $token;

	public function __construct(string $token)
	{
		$this->token = $token;
	}

	public function via(object $notifiable): array
	{
		return ['mail'];
	}

	public function toMail(object $notifiable): MailMessage
	{
		$resetUrl = route('password.reset', [
			'token' => $this->token,
			'email' => $notifiable->getEmailForPasswordReset(),
		]);

		return (new MailMessage)
			->subject('Đặt lại mật khẩu tài khoản')
			->view('emails.reset-password-vi', [
				'resetUrl' => $resetUrl,
				'email' => $notifiable->getEmailForPasswordReset(),
				'appName' => config('app.name', 'F1GENZ Shoes'),
			]);
	}
} 