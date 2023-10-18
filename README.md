Описание решения:

слой нотификации (в нем будет три варианта- почта, sms, email) 

public function via($notifiable)
{
    return $notifiable->prefers_sms ? ['smsСервис'] : ['mail', 'database'];
}

