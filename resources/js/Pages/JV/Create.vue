<template>

    <AppLayout>
        <template #header>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Voucher
            </h2>
        </template>
        <div class="max-w-[87%] mx-auto py-8">
            <!-- {{  selectedStation  }} -->
            <!-- {{  selectedStation }} -->
            <!-- {{ postForm }} -->
              <!-- {{  year }} -->
            <form @submit.prevent.stop="submit" class="flex items-center justify-center gap-4 py-8">
                <div>
                    <DatePicker v-model="form.date" placeholder="Pick a Date" showIcon fluid iconDisplay="input"
                        showButtonBar dateFormat="dd/mm/yy" />
                </div>
                <div>
                    <Select v-model="form.station_id" :options="stations" optionLabel="name" optionValue="station_id"
                        placeholder="Select a Station" class="w-full md:w-56" />
                </div>
                <div class="">
                    <button :disabled="form.processing"
                        class="bg-emerald-600 text-gray-50 px-2 py-2 rounded-md">Retrieve
                        Data</button>
                </div>
            </form>
            <div class="grid place-content-center">
                <ProgressSpinner v-if="form.processing" />
            </div>
            <CardSkeleton v-if="form.processing" />

            <div class="p-4" v-if="!form.processing && data && data['sales'] != null">

                <div class="my-2">
                    <h1 class="text-center">Summary Information of Data</h1>
                    <div class="grid grid-cols-3 items-center justify-center gap-3">
                        <div class="text-center bg-emerald-700 p-4 rounded-md text-gray-100 md:text-lg">
                            <h1>Coupon Sale</h1>

                            <CurrencyFormat :value="data['sales']['coupon_sales']" />

                        </div>
                        <div class="text-center bg-emerald-700 p-4  rounded-md text-gray-100 md:text-lg">
                            <h1>Cash Sale</h1>

                            <CurrencyFormat :value="data['sales']['cash_sales']" />
                        </div>
                        <div class="text-center bg-emerald-700 p-4 rounded-md text-gray-100 md:text-lg">
                            <h1>Cheque Sale</h1>

                            <CurrencyFormat :value="data['sales']['checks']" />
                        </div>
                    </div>
                </div>

                <form @submit.prevent.stop="finalSubmit" class="flex flex-col gap-4">
                    <div class="flex gap-2">
                        <div class="w-full">
                            <input type="text" required class="w-full rounded-md" v-model="postForm.batchNumber"
                                placeholder="Batch Number">
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.batchNumber }}</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <Select v-model="postForm.project_id" :options="projects" optionLabel="Name"
                                optionValue="Id" placeholder="Select a Project" class="w-full rounded-md" />
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.project_id }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <div class="w-full">
                            <DatePicker placeholder="Select Date" v-model="postForm.date" showIcon fluid
                                iconDisplay="input" showButtonBar dateFormat="dd/mm/yy" />
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.date }}</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <input type="text" required placeholder="year" class="w-full rounded-md"
                                v-model="postForm.year">
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.year }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <textarea class="w-full rounded-md" rows="5" name="description" v-model="postForm.description"
                            id="" placeholder="Enter refs here"></textarea>
                        <div v-if="postForm.errors">
                            <p class="text-red-900">{{ postForm.errors.description }}</p>
                        </div>
                    </div>
                    <div class="w-full">
                        <table class="w-full">
                            <thead class="bg-emerald-600 text-gray-50">
                                <tr>
                                    <th class="border">Name</th>
                                    <th class="border">Amount</th>
                                    <th class="border">Total Account</th>
                                    <th class="border">PMS</th>
                                    <th class="border">PMS Account</th>
                                    <th class="border">AGO</th>
                                    <th class="border">AGO Account</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in postForm.postings" :key="row.id" class="text-center">
                                    <td>
                                        <input type="text" disabled v-model="row.Name">
                                    </td>
                                    <td>
                                        <input type="text" disabled v-model="row.amount">
                                    </td>
                                    <td>

                                        <!-- {{  row.total_account_id }} -->
                                        <Select v-model="row.total_account_id" selected="true" :options="accounts"
                                            filter optionLabel="full_name" optionValue="Id" placeholder="Select Account"
                                            class="w-full">
                                            <template #value="slotProps">
                                                <div v-if="slotProps.Id" class="flex items-center">
                                                    <div>{{ slotProps.Id }}</div>
                                                </div>
                                            </template>
                                            <template #option="slotProps">
                                                <div class="flex items-center">
                                                    <div>{{ slotProps.option.full_name }}</div>
                                                </div>
                                            </template>
                                        </Select>
                                    </td>
                                    <td>
                                        <input type="text" disabled v-model="row.pms_amount">
                                    </td>
                                    <td>


                                        <Select v-model="row.pms_account_id" :options="accounts" filter :key="index"
                                            optionLabel="full_name" optionValue="Id" placeholder="Select a Account"
                                            class="w-full">
                                            <template #value="slotProps">
                                                <div v-if="slotProps.Id" class="flex items-center">
                                                    <div>{{ slotProps.Id }}</div>
                                                </div>

                                            </template>
                                            <template #option="slotProps">
                                                <div class="flex items-center">
                                                    <div>{{ slotProps.option.full_name }}</div>
                                                </div>
                                            </template>
                                        </Select>
                                    </td>
                                    <td>
                                        <input type="text" disabled v-model="row.ago_amount">
                                    </td>
                                    <td>

                                        <!-- {{ row.ago_account_id }} -->
                                        <Select v-model="row.ago_account_id" :options="accounts" filter optionValue="Id"
                                            optionLabel="full_name" placeholder="Select a Account" class="w-full">
                                            <template #value="slotProps">
                                                <div v-if="slotProps.Id" class="flex items-center">
                                                    <div>{{ slotProps.Id }}</div>
                                                </div>

                                            </template>
                                            <template #option="slotProps">
                                                <div class="flex items-center">
                                                    <div>{{ slotProps.option.full_name }}</div>
                                                </div>
                                            </template>
                                        </Select>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end">
                        <button :disabled="postForm.processing" class=" text-gray-100 font-extrabold px-8 py-2"
                            :class="{ 'bg-sky-700 text-gray-100': postForm.processing, 'bg-emerald-700': !postForm.processing }">{{
                                postForm.processing ? 'Loading':'Submit' }}</button>
                    </div>
                    <ProgressSpinner v-if="postForm.processing" />

                </form>
            </div>
        </div>
    </AppLayout>

</template>

<script setup>

import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Select from 'primevue/select';
import DatePicker from 'primevue/datepicker';
import { getCurrentInstance, onMounted } from 'vue';
import CardSkeleton from '@/Components/Skeleton/CardSkeleton.vue';
import ProgressSpinner from 'primevue/progressspinner';
import { useToast } from 'primevue/usetoast';
import CurrencyFormat from '@/Components/CurrencyFormat.vue';

const toast = useToast();

const props = defineProps({
    stations: Array,
    filters: Object,
    data: Object,
    formData: Array,
    accounts: Array,
    projects: Array,
    year: Number,
    project_id: String,
    selectedStation: Object

})

const form = useForm({
    date: props?.filters?.date || null,
    station_id: props?.filters?.station_id || null,
    partial: props?.filters?.partial || false
})

const { proxy } = getCurrentInstance();


const postForm = useForm({
    batchNumber: proxy.$page.props.auth.user.batchName,
    project_id: props?.project_id,
    date: props?.filters?.date || null,
    year: props.year,
    description: null,
    sale_id: null,
    station_id: null,
    postings: props.formData || []
})





function finalSubmit() {
    form.partial = "Okay Now"
    postForm.post(route('jv.process'), {
        onStart: () => {

        },
        onFinish: () => {

        },
        onSuccess: (data) => {
            toast.add({ severity: 'success', summary: 'JV Created Successfully', detail: 'Successfully Created new Item', life: 3000 });
            props.data = []
            form.reset()
            postForm.reset()
        },
        onError: (error) => {
            console.error('error',error)
            toast.add({ severity: 'error', summary: 'JV Creation Failed', detail: error, life: 3000 });

        },
        preserveScroll: true,
        preserveState: true
    })
}

function submit() {
    postForm.reset();
    const queryParams = new URLSearchParams({ initReq: 'true' });

    const url = `${route('jv')}?${queryParams.toString()}`;

    form.get(url, {
        onSuccess: (data) => {
            postForm.postings = data.props.formData
            postForm.project_id = data.props.project_id
            postForm.date = data.props.filters.date
            postForm.description = ""
            postForm.sale_id = data.props.data.sale_info['id']
            postForm.station_id = data.props.filters['station_id']
            postForm.year = data.props.year;
        },
        onFinish: () => {
            console.log("finish")

        },
        onError: (error) => {
            toast.add({ severity: 'error', summary: 'Error', detail: error['error'], life: 8000 });
            props.data['sales'] = null
            console.log('data',props.data['sales'])
            postForm.reset()

        },
        preserveState: true,
        preserveScroll: true
    })
}
</script>
