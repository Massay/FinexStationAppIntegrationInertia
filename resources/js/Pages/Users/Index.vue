<template>
    <AppLayout>
        <template #header>
           
            <div class="flex justify-between items-center">
                <h1>Users</h1>
                <Link :href="route('users.create')" class="px-8 py-2 rounded-md bg-emerald-400 text-gray-50">Create</Link>
            </div>
        </template>

        <div class="w-[80%] mx-auto py-4">
           
            <table class="w-full text-center">
                <thead>
                    <tr>
                        <th class="border">Name</th>
                        <th class="border">Email</th>
                        <th class="border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users">
                        <td class="border">{{  user.name }}</td>
                        <td class="border">{{  user.email  }}</td>
                        <td class="border">
                            <div class="flex justify-center items-center gap-3">
                                <Link href="#">Roles</Link>
                                <Link href="#">Edit</Link>
                                <Link href="#">Delete</Link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>

</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    users: Array
})
</script>