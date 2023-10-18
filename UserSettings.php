<?php

//псведокод
    class UserSettingsController extends Controller
    {
        
        public function update(Request $request): void
        {
            $user = Auth::user();
            $code = random_int(1,9); //условно, можно использовать библиотеки для генерации кодов 

            $verificationCode = VericationCode::create([
                'user_id'=> $user->id,
                'code'=> $code,
                'method' => $request->method,
            ]);

            //далее нужно отправить код пользователю через notification
            
         
        }

        public function updateSettingsValidated(Request $request)
        {
            $user = Auth::user();
            if($this->verificationCode($user) == $request->code) {
                $user->updateSettingsValidated($request->validated());
            } else {
                return false;
            }
        }

        public function verificationCode(): string
        {
            $user = Auth::user();

            $code = VericationCode::query()
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [Carbon::now()->subMinutes(3), Carbon::now()])
            ->orderBy('id','desc')
            ->first();

            return $code?->code ?? false;
        }
    }
?>
