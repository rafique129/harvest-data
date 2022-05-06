<x-center-layout>

<div>
    <div class="flex justify-center">
        <x-logo.app-logo/>
    </div>
    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account
    </h2>

</div>
<form class="mt-8 space-y-4" wire:submit.prevent='attemptLogin'>

    <div>
        <label class="text-gray-600 font-bold">Email</label>
        <input wire:model="email" class="  border-2 border-gray-400 rounded w-full py-3 px-4  leading-tight focus:outline-none focus:bg-white focus:border-purple-500" placeholder="john@gmail.com"/>
        @error('email')
        <span class="text-sm text-red-600">{{$message}}</span>
        @enderror

    </div>

    <div>
        <label class="text-gray-600 font-bold">Password</label>
        <input wire:model="password" type="password" placeholder="***********" class="border-2 border-gray-400 rounded w-full py-3 px-4  leading-tight focus:outline-none focus:bg-white focus:border-purple-500" />
        @error('password')
        <span class="text-sm text-red-600">{{$message}}</span>
        @enderror
    </div>

    <div class="flex items-center justify-between">
        <label for="remember-me" class=" block text-sm text-gray-900"> Not register yet ? <a href="{{route('guest.account.register')}}" class="text-indigo-600 font-medium">Sign Up</a>
        </label>
        <div class="text-sm">
            <a href="{{route('guest.account.forgot-password')}}" class="font-medium text-indigo-600 hover:text-indigo-500"> Forgot your
                password? </a>
        </div>
    </div>

    <div>
        <button type="submit"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <!-- Heroicon name: solid/lock-closed -->
                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            Sign in
        </button>
    </div>
</form>
</x-center-layout>

