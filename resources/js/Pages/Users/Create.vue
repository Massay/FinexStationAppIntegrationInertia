<template>
    <AppLayout>
        <template #header>

            <div class="flex justify-between items-center">
                <h1>User Create</h1>
                <Link :href="route('users.index')" class="px-8 py-2 rounded-md bg-emerald-400 text-gray-50">List of
                Users</Link>
            </div>
        </template>
        <div>
            <!-- {{ form }} -->
            <form @submit.prevent="create" autocomplete="off" id="CreateUser" class="max-w-3xl mx-auto gap-4 flex flex-col py-4">
                <div>
                    <input type="text" v-model="form.name" class="w-full rounded-md" placeholder="Name" autocomplete="off">
                    <div v-if="form.errors">
                        <p class="text-red-400">{{ form.errors.name }}</p>
                    </div>
                </div>
                <div>
                    <input type="text" v-model="form.email" id="MyEmail" class="w-full rounded-md" placeholder="Email" autocomplete="off">
                    <div v-if="form.errors">
                        <p class="text-red-400">{{ form.errors.email }}</p>
                    </div>
                </div>
                <div>
                    <input type="password" v-model="form.password" id="MyPassword" class="w-full rounded-md"
                    autocomplete="new-password"
                        placeholder="Password">
                    <div v-if="form.errors">
                        <p class="text-red-400">{{ form.errors.password }}</p>
                    </div>
                </div>
                <div>
                    <input type="password" v-model="form.password_confirmation" autocomplete="off"  class="w-full rounded-md"
                        placeholder="Password Confirmation">
                    <div v-if="form.errors">
                        <p class="text-red-400">{{ form.errors.password_confirmation }}</p>
                    </div>
                </div>
                <div class="card flex flex-wrap justify-center gap-4">
                    <div class="flex items-center gap-2">
                        <Checkbox v-model="form.is_admin"  binary />

                        <label for="is_admin">Is Admin</label>
                    </div>
                    <div class="flex items-center gap-2">
                        
                        <Checkbox v-model="form.is_siv"  binary />
                        <label for="is_siv">Access SIV </label>
                    </div>
                    <div class="flex items-center gap-2">
                        <Checkbox v-model="form.is_jv"  binary/>
                        <label for="is_jv">Access JV </label>
                    </div>
                    
                </div>

                <div class="flex justify-end">
                    <button class="bg-emerald-300 px-8 py-2 rounded-md text-gray-100" type="submit">Create</button>
                </div>
            </form>
        </div>
    </AppLayout>

</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Checkbox from 'primevue/checkbox';

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    is_admin: false,
    is_siv: false,
    is_jv: false
})

function create() {
    form.post(route('users.store'), {

    })
}
</script>