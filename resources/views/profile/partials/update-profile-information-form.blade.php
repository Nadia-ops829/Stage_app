
    <h2 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">
        {{ __('Votre Profil') }}
    </h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        {{ __("Mettre à jour votre mot de passe et votre adresse email.") }}
    </p>

    <!-- Formulaire de renvoi de vérification email -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Formulaire de mise à jour profil -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <!-- Nom -->
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="input-blue mt-1 block w-full" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="input-blue mt-1 block w-full" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Votre adresse email n’est pas vérifiée.') }}
                        <button form="send-verification" class="btn-blue-underline">
                            {{ __('Cliquez ici pour renvoyer l’email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Un nouveau lien de vérification a été envoyé.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Bouton Sauvegarder -->
        <div class="mt-4">
            <button type="submit" class="btn-blue">
                {{ __('Sauvegarder') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 mt-2 dark:text-green-400"
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

.btn-blue-underline {
    color: #667eea;
    text-decoration: underline;
    font-weight: 500;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
}

.btn-blue-underline:hover {
    color: #764ba2;
}
</style>
