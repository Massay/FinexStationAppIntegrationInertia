<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

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
                                    <tr v-for="(row,index) in items.data" :key="index">
                                        <td class="border">{{  row.type }}</td>
                                        <td class="border">{{  row.sale_id }}</td>
                                        <td class="border">{{  row.station ? row.station.name : '-'  }}</td>
                                        <td class="border">{{  row.reference }}</td>
                                        <td class="border">{{  row.date }}</td>
                                        <td class="border">{{  row.user.email }}</td>
                                        <td class="border">{{  row.created_at }}</td>
                                    </tr>
                                  </tbody>
                            </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
