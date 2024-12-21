<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    items: Array
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <table class="w-full text-center">
                        <thead class="w-full">
                            <tr>
                                <th class="border">Type</th>
                                <th class="border">Sale Id</th>
                                <th class="border">Station</th>
                                <th class="border">Reference</th>
                                <th class="border">Date</th>
                                <th class="border">User</th>
                                <th class="border">Created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in items.data" :key="index">
                                <td class="border">{{ row.type }}</td>
                                <td class="border">{{ row.sale_id }}</td>
                                <td class="border">{{ row.station ? row.station.name : '-' }}</td>
                                <td class="border">{{ row.reference }}</td>
                                <td class="border">{{ row.date }}</td>
                                <td class="border">{{ row.user.email }}</td>
                                <td class="border">{{ row.created_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- {{ items.links}} -->
                    <div class="flex  justify-center gap-2 items-center p-2">
                        <template v-for="(link, index) in items.links" :key="index">
                            <span v-if="link.url == null" class="rounded-md p-2 font-extrabold" :class="{'bg-gray-900 text-gray-100': link.active,'bg-gray-300 ': !link.active}">
                                <span v-html="link.label"/>
                            </span>
                            <Link  v-else  :href="link.url" class=" text-gray-50 text-center p-2 rounded-md font-extrabold" :class="{'bg-gray-900 px-3 text-gray-100': link.active,'bg-gray-500': !link.active}">
                                    <span v-html="link.label"/>
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
