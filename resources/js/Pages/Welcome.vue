<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    appName:{
        type: String,
    },
    phpVersion: {
        type: String,
        required: true,
    }
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 h-screen">
        <div class="h-full flex flex-col  items-center w-full selection:bg-[#FF2D20] selection:text-white">
            <header class="w-full p-2 bg-gray-100">
                    <nav v-if="canLogin" class="flex  justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-gray-50 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md  py-2 bg-emerald-500 px-8 text-gray-50 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 bg-yellow-500 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
            </header>
                <div class="flex justify-center items-center flex-col h-full bg-gray-200 w-full">
                        <Link class="bg-emerald-500 px-8 py-2 text-gray-100" v-if="$page.props.auth && $page.props.auth.user" :href="route('dashboard')">Dashboard</Link>
                        <div v-if="$page.props.auth && $page.props.auth.user">
                            Logged in as {{ $page.props.auth.user.email }}
                        </div>
                        <img src="/images/gnpc.jpg" alt="" class="h-72 w-auto mt-4 rounded-md p-2">
                        <h1 class="font-extrabold sm:text-2xl md:text-3xl text-lg text-green-600 font-mono">{{  appName || 'My App' }}</h1>
                    
                </div>
        </div>
    </div>
</template>

