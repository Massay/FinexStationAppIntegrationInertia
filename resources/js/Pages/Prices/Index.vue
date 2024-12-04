<template>
    <AppLayout>
        <template #header>
            <div class="flex justify-between">
                <h1 class="font-extrabold text-lg">Prices</h1>
                <Link :href="route('prices.create')" class="bg-emerald-400 py-2 rounded-md text-gray-50 px-8">Create</Link>
            </div>
        </template>
        <div class="max-w-7xl mx-auto p-4">
            <table class="w-full text-center">
                <thead>
                    <tr class="bg-emerald-700 text-gray-100">
                        <th>Year</th>
                        <th>Month</th>
                        <th>AGO</th>
                        <th>PMS</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(price, index) in prices" :key="index">
                        <td class="border">{{  price.year }}</td>
                        <td class="border">{{  price.month }}</td>
                        <td class="border">{{  price.ago }}</td>
                        <td class="border">{{  price.pms }}</td>
                        <td class="border">{{  price.created_at }}</td>
                        <td class="flex gap-2 justify-center">
                                <Link :href="route('prices.edit', price)">Edit</Link>
                                <Link>Delete</Link>
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
    prices: Array
})
</script>