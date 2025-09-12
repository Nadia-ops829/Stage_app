
    <h2 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">
        {{ __('Mettre à jour votre mot de passe') }}
    </h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        {{ __('Assurez-vous que votre compte utilise un mot de passe long et sécurisé.') }}
    </p>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <!-- Mot de passe actuel -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Mot de passe actuel')" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="input-blue mt-1 block w-full" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- Nouveau mot de passe -->
        <div>
            <x-input-label for="update_password_password" :value="__('Nouveau mot de passe')" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="input-blue mt-1 block w-full" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirmation -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="input-blue mt-1 block w-full" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Bouton -->
        <div class="mt-4">
            <button type="submit" class="btn-blue">
                {{ __('Sauvegarder') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 mt-2"
                >
                    {{ __('Sauvegardé.') }}
                </p>
            @endif
        </div>
    </form>
</div>

<style>
.btn-blue {
    background: linear-gradient(to right, #667eea, #764ba2);
    color: #fff;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.btn-blue:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

.input-blue {
    border: 1px solid #667eea;
    border-radius: 0.375rem;
    padding: 0.5rem;
    transition: all 0.2s;
}

.input-blue:focus {
    border-color: #764ba2;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
    outline: none;
}
</style>
