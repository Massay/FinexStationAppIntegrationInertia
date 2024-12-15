<template>
    <AppLayout>
        <template #header>

            <div class="flex justify-between items-center">
                <h1>User Station</h1>
                <Link :href="route('stations.index')" class="px-8 py-2 rounded-md bg-emerald-400 text-gray-50">List of
                Stations</Link>
            </div>
        </template>
        <div>
            <!-- {{ form }} -->
              <!-- {{ projects }} -->
            <form @submit.prevent="update" id="CreateUser" class="max-w-3xl mx-auto gap-4 flex flex-col py-4">
                <div>
                    <input type="text" v-model="form.name" class="w-full rounded-md" placeholder="Name">
                    <div v-if="form.errors">
                        <p class="text-red-400">{{ form.errors.name }}</p>
                    </div>
                </div>

                <div>
                    <input type="text" v-model="form.station_id" class="w-full rounded-md" placeholder="station Id">
                    <div v-if="form.errors">
                        <p class="text-red-400">{{ form.errors.station_id }}</p>
                    </div>
                </div>

                <div class="w-full">
                    <label for="">Project</label>
                        <Select v-model="form.project_id" :options="projects" optionLabel="Name" optionValue="Id"
                            placeholder="Select a Project" class="w-full rounded-md" />
                   
                </div>

                <div class="w-full">
                    <label for="">Branch</label>
                    <Select v-model="form.branch_id" :options="branches" optionLabel="Name" optionValue="Id"
                        placeholder="Select a Project" class="w-full rounded-md" />
                    <div v-if="form.errors">
                        <p class="text-red-900">{{ form.errors.branch_id }}</p>
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
import Select from 'primevue/select';

const props = defineProps({
    station: Object,
    projects: Array,
    branches: Array
})

const form = useForm({
    name: props.station.name || null,
    station_id: props.station.station_id || null,
    branch_id: props.station.branch_id || null,
    project_id: props.station.project_id || null
})

function update() {
    form.post(route('stations.update', props.station), {

    })
}
</script>