<template>
    <AppLayout>
        <template #header>

            <div class="flex justify-between items-center">
                <h1>User update</h1>
                <Link :href="route('users.index')" class="px-8 py-2 rounded-md bg-emerald-400 text-gray-50">List of
                Users</Link>
            </div>
        </template>
        <div>
            <!-- {{ form }} -->
            <form @submit.prevent="update" id="CreateUser" class="max-w-3xl mx-auto gap-4 flex flex-col py-4">
                <div>
                    <input type="text" v-model="form.name" class="w-full rounded-md" placeholder="Name">
                    <div v-if="form.errors">
                        <p class="text-red-400">{{ form.errors.name }}</p>
                    </div>
                </div>
                <div>
                    <input type="text" v-model="form.email" id="MyEmail" class="w-full rounded-md" placeholder="Email">
                    <div v-if="form.errors">
                        <p class="text-red-400">{{ form.errors.email }}</p>
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
                    <button class="bg-emerald-300 px-8 py-2 rounded-md text-gray-100" type="submit">Update</button>
                </div>
            </form>
        </div>
    </AppLayout>

</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Checkbox from 'primevue/checkbox';

const props = defineProps({
    user: Object
})

const form = useForm({
    name: props.user.name || null,
    email: props.user.email || null,
    is_admin: props.user.is_admin || false,
    is_siv: props.user.is_siv || false,
    is_jv: props.user.is_jv || false
})

function update() {
    form.post(route('users.update',props.user), {

    })
}
</script>