<template>
    <AppLayout>
        <template #header>
            <div class="flex justify-between">
                <h1 class="font-extrabold text-lg">Edit/Prices</h1>
                <Link :href="route('prices.index')" class="bg-emerald-400 py-2 rounded-md text-gray-50 px-8">List</Link>
            </div>
        </template>
        <div class="max-w-7xl mx-auto p-4">
            <!-- {{  price  }} -->
            <form @submit.prevent="update" class="flex flex-col gap-4">
                <div>
                    <input class="w-full rounded-md" type="text" v-model="form.month">
                </div>
                <div>
                    <input class="w-full  rounded-md" type="text" v-model="form.year">
                </div>
                <div>
                    <input class="w-full rounded-md" type="text" v-model="form.ago">
                </div>
                <div>
                    <input class="w-full rounded-md" type="text" v-model="form.pms">
                </div>
                <div class="flex justify-end items-center">
                    <button type="submit" class="px-8 py-2 bg-emerald-400 text-gray-100 rounded-md">Update</button>
                </div>
            </form>
        </div>
    </AppLayout>

</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

import { useToast } from 'primevue/usetoast';

const toast = useToast();

const props = defineProps({
    price: Object
})

const form = useForm({
    month: props.price.month || null,
    year: props.price.year || null,
    ago: props.price.ago || null,
    pms: props.price.pms || null,
})


function update() {
    form.post(route('prices.update', props.price), {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => {

        },
        onSuccess: (data) => {
            toast.add({ severity: 'success', summary: 'Update Success', detail: 'Price Updated Successfully', life: 3000 });

        },
        onError: (error) => {

        }

    })
}
</script>