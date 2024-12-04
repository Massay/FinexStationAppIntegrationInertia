<template>
    <AppLayout>
        <template #header>
            <div>
                <h1>Add Price</h1>
            </div>
        </template>
        <div>
            <form @submit.prevent="submit" class="max-w-7xl mx-auto flex flex-col">
                <div class="w-full">
                    <label for="">Year</label>
                    <input type="number" v-model="form.year" placeholder="Year" class="w-full rounded-md">
                    <div v-if="form.errors">
                        <p class="text-red-800">{{ form.errors.year }}</p>
                    </div>
                </div>
                <div class="w-full">
                    <label for="">Month</label>
                    <input type="text" v-model="form.month" placeholder="Month" class="w-full  rounded-md">
                    <div v-if="form.errors">
                        <p class="text-red-800">{{ form.errors.month }}</p>
                    </div>
                </div>
                <div class="w-full">
                    <label for="">AGO Price</label>
                    <input type="number" v-model="form.ago" step="0.01" placeholder="AGO Price"
                        class="w-full  rounded-md">
                    <div v-if="form.errors">
                        <p class="text-red-800">{{ form.errors.ago }}</p>
                    </div>
                </div>
                <div class="w-full">
                    <label for="">PMS Price</label>
                    <input type="number" v-model="form.pms" step="0.01" placeholder="PMS Price"
                        class="w-full rounded-md">
                    <div v-if="form.errors">
                        <p class="text-red-800">{{ form.errors.pms }}</p>
                    </div>
                </div>
                <div class="flex justify-end py-2">
                    <button class="bg-emerald-400 text-gray-100 rounded-md py-3 px-8" type="submit">Create
                        Price</button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    year: null,
    month: null,
    ago: null,
    pms: null
})

function submit() {
    form.post(route('prices.store'), {
        preserveScroll: true,
        preserveScroll: true,
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Created', detail: 'Created Successfully', life: 3000 });

        },
        onError: (error) => {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Creating Failed', life: 3000 });
        },
        onFinish: () => {

        },
        onStart: () => {

        }
    })
}

</script>