<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('E-posta adresini doğrula doğrula')
                ->greeting('Hoşgeldiniz!')
                ->line('Doğrulama işlemi için aşağıdaki butona tıklayın')
                ->action('E-posta adresini doğrula', $url)
                ->line('Eğer bu işlemi siz yapmadıysanız, bu e-postayı dikkate almayınız.')
                ->salutation('Teşekkürler, '.config('app.name').'!');
        });
    }
}
