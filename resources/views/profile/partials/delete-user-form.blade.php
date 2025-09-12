
    <h2 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">
        {{ __('Supprimer le compte') }}
    </h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
        {{ __("Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, téléchargez toutes les informations que vous souhaitez conserver.") }}
    </p>

    <!-- Bouton Supprimer -->
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn-blue"
    >
        {{ __('Supprimer le compte') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-4">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p class="text-sm text-gray-600">
                {{ __("Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer.") }}
            </p>

            <!-- Mot de passe -->
            <div>
                <x-input-label for="password" value="{{ __('Mot de Passe') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="input-blue mt-1 block w-3/4"
                    placeholder="{{ __('Mot de passe') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 mt-4">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="btn-blue"
                >
                    {{ __('Retour') }}
                </button>

                <button type="submit" class="btn-blue">
                    {{ __('Supprimer le compte') }}
                </button>
            </div>
        </form>
    </x-modal>
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
