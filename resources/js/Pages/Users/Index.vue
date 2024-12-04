<template>
    <AppLayout>
        <template #header>
           
            <div class="flex justify-between items-center">
                <h1>Users</h1>
                <Link class="px-8 py-2 rounded-md bg-emerald-400 text-gray-50">Create</Link>
            </div>
        </template>
    </AppLayout>

</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>