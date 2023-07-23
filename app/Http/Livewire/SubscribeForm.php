<?php

namespace App\Http\Livewire;

use App\Models\Subscriber;
use App\Models\User;
use Livewire\Component;

class SubscribeForm extends Component
{
    public string $email;

    public function submit()
    {
        $validated = $this->validate([
            'email' => 'required|email',
        ],
        [
            'email.unique' => 'Эта почта уже подписана на рассылку!',
            'email.email' => 'Введите корректную почту!'
        ]);
       // dd($validated);

        // Сохранение подписчика в базу данных
        $user = User::where('email', $this->email)->first();

        //TODO if !user - create User - send_mail credentials and verification link

        if (auth()->user() && auth()->user()->id != $user?->id) {
            session()->flash('warning', 'Для управления подпиской, перейдите в ваш профиль.');
        } else {
            $subscriber = Subscriber::updateOrCreate(
                ['email' => $this->email],
                [
                    'user_id' => $user?->id ?? null,
                    'send_mail' => true
                ]
            );
            if ($subscriber){
                session()->flash('success', 'Вы успешно подписались на рассылку!');
                $this->email = ''; // Очистка поля email после успешной подписки
            }
        }
    }

    public function render()
    {
        return view('livewire.subscribe-form');
    }
}
