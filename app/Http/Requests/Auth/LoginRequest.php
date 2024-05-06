<?php

namespace App\Http\Requests\Auth;

use App\Models\InternalSystemUser;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'login_intranet' => ['required', 'string'],
            'senha_intranet' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'login_intranet.required' => 'O campo login é obrigatório.',
            'senha_intranet.required' => 'O campo senha é obrigatório.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! $this->existIntranetUser($this->only('login_intranet', 'senha_intranet'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login_intranet' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Check if the user exists in the intranet database.
     *
     * @param  array<string, string>  $credentials
     */
    protected function existIntranetUser(array $credentials): bool
    {
        $user = User::where('login_intranet', $credentials['login_intranet'])->first();

        if (empty($user)) {
            $user = InternalSystemUser::where('login_intranet', $credentials['login_intranet'])->first();

            if (empty($user)) {
                return false;
            }
        }

        if (! password_verify($credentials['senha_intranet'], $user->senha_intranet)) {
            return false;
        }

        if ($user instanceof User) {
            Auth::guard('web')->login($user);
        } else {
            Auth::guard('internal')->login($user);
        }

        return true;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login_intranet' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login_intranet')) . '|' . $this->ip());
    }
}
