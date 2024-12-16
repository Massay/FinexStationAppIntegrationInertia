<template>

    <AppLayout>
        <template #header>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Siv
            </h2>
        </template>
        <div>
            <div>
                <form @submit.prevent="submit" class="flex items-center justify-center gap-4 py-8">
                    <div>
                        <DatePicker v-model="form.date" placeholder="Pick a Date" showIcon fluid iconDisplay="input"
                            showButtonBar dateFormat="dd/mm/yy" />
                    </div>
                    <div>
                        <Select v-model="form.station_id" :options="stations" optionLabel="name"
                            optionValue="station_id" placeholder="Select a Station" class="w-full md:w-56" />
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
            </div>


            <div class="p-4" v-if="!form.processing && data && data['sales'] != null">
                <div class="my-2 max-w-6xl mx-auto">
                    <!-- {{ data['sale_info']['id']}} -->
                    <h1 class="text-center text-lg font-medium p-2 leading-8">Summary Information of Data</h1>
                    <div class="grid grid-cols-2 md:grid-cols-3 items-center justify-center gap-3">
                        <div class="text-center bg-sky-700 p-4 rounded-md text-gray-100 md:text-lg">
                            <h1>Coupon Sale</h1>
                            <!-- <h2>{{ data['sales']['coupon_sales'] }}</h2> -->
                            <CurrencyFormat :value="data['sales']['coupon_sales']" />

                        </div>
                        <div class="text-center bg-sky-700 p-4  rounded-md text-gray-100 md:text-lg">
                            <h1>Cash Sale</h1>
                            <!-- <h2>{{ data['sales']['cash_sales'] }}</h2> -->
                            <CurrencyFormat :value="data['sales']['cash_sales']" />

                        </div>
                        <div class="text-center bg-sky-700 p-4 rounded-md text-gray-100 md:text-lg">
                            <h1>Cheque Sale</h1>
                            <!-- <h2>{{ data['sales']['checks'] }}</h2> -->
                            <CurrencyFormat :value="data['sales']['checks']" />

                        </div>

                        <div class="text-center bg-sky-700 p-4 rounded-md text-gray-100 md:text-lg">
                            <h1>Generator Sale</h1>
                            <!-- <h2>{{ data['sales']['generators'] }}</h2> -->
                            <CurrencyFormat :value="data['sales']['generators']" />
                        </div>
                        <div class="text-center bg-sky-700 p-4 rounded-md text-gray-100 md:text-lg">
                            <h1>Vehicle(s)</h1>
                            <!-- <h2>{{ data['sales']['vehicles'] }}</h2> -->
                            <CurrencyFormat :value="data['sales']['vehicles']" />
                        </div>
                        <div class="text-center bg-sky-700 p-4 rounded-md text-gray-100 md:text-lg">
                            <h1>Expenses</h1>
                            <!-- <h2>{{ data['sales']['expenses'] }}</h2> -->
                            <CurrencyFormat :value="data['sales']['expenses']" />
                        </div>
                    </div>
                </div>
                <!-- {{ fuelPrice }} -->
                <div v-if="postForm.errors && Object.keys(postForm.errors).length" class="py-4 border bg-red-500 px-2">
                    <p class="text-gray-100 font-extralight">{{ postForm.errors.batchNumber }}</p>
                    <p class="text-gray-100 font-extralight">{{ postForm.errors.project_id }}</p>
                    <p class="text-gray-100 font-extralight">{{ postForm.errors.description }}</p>
                    <p class="text-gray-100 font-extralight">{{ postForm.errors.date }}</p>
                    <p class="text-gray-100 font-extralight">{{ postForm.errors.year }}</p>
                </div>
                <form @submit.prevent="finalSubmit" class="flex flex-col gap-4 max-w-[90%] mx-auto text-sm">
                    <div class="flex gap-2">
                        <div class="w-full">
                            <label for="">Batch Number</label>
                            <input type="text" required class="w-full rounded-md" v-model="postForm.batchNumber"
                                placeholder="Batch Number">
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.batchNumber }}</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="">Project</label>
                            <Select v-model="postForm.project_id" :options="projects" optionLabel="Name"
                                optionValue="Id" placeholder="Select a Project" class="w-full rounded-md" />
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.project_id }}</p>
                            </div>
                        </div>

                        <div class="w-full">
                            <label for="">Branch</label>
                            <Select v-model="postForm.branch_id" :options="branches" optionLabel="Name" optionValue="Id"
                                placeholder="Select a Project" class="w-full rounded-md" />
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.branch_id }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <div class="w-full">
                            <label for="">Date</label>
                            <DatePicker placeholder="Select Date" v-model="postForm.date" showIcon fluid
                                iconDisplay="input" showButtonBar dateFormat="dd/mm/yy" />
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.date }}</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="">Year</label>
                            <input type="text" required placeholder="year" class="w-full rounded-md"
                                v-model="postForm.year">
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.year }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-full">
                            <label for="">Unit Price AGO</label>
                            <input type="number" step="0.01" disabled v-model="postForm.unitPriceAgo"
                                placeholder="Unit Price" class="w-full rounded-md">
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.unitPriceAgo }}</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="">Unit Price PMS</label>
                            <input type="number" step="0.01" disabled v-model="postForm.unitPricePms"
                                placeholder="Unit Price" class="w-full rounded-md">
                            <div v-if="postForm.errors">
                                <p class="text-red-900">{{ postForm.errors.unitPricePms }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <textarea class="w-full rounded-md" rows="5" name="description" v-model="postForm.description"
                            id="" placeholder="Description"></textarea>
                        <div v-if="postForm.errors">
                            <p class="text-red-900">{{ postForm.errors.description }}</p>
                        </div>
                    </div>
                    <div class="w-full" v-if="!postForm.processing">
                        <table class="w-full">
                            <thead class="bg-emerald-500 text-gray-50">
                                <tr>
                                    <th class="border py-1">Name</th>
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
                                        <input type="text" class="border-0" disabled v-model="row.Name">
                                    </td>
                                    <td>
                                        <input type="text" class="border-0" disabled v-model="row.amount">
                                    </td>
                                    <td>

                                        <!-- {{  row.total_account_id }} -->
                                        <Select v-model="row.total_account_id" selected="true" :options="accounts"
                                            filter optionLabel="full_name" optionValue="Id" placeholder="Select Account"
                                            class="w-full text-sm">
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
                                        <input type="text" class="border-0" disabled v-model="row.pms_amount">
                                    </td>
                                    <td>


                                        <Select v-model="row.pms_account_id" :options="accounts" filter :key="index"
                                            optionLabel="full_name" optionValue="Id" placeholder="Select a Account"
                                            class="w-full text-sm">
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
                                        <input type="text" class="border-0" disabled v-model="row.ago_amount">
                                    </td>
                                    <td>

                                        <!-- {{ row.ago_account_id }} -->
                                        <Select v-model="row.ago_account_id" :options="accounts" filter optionValue="Id"
                                            optionLabel="full_name" placeholder="Select a Account"
                                            class="w-full text-sm">
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
                        <button type="submit" :disabled="postForm.processing"
                            class="bg-emerald-700 text-gray-100 font-extrabold px-8 py-2">
                            {{ postForm.processing ?
                                'Loading' : 'Submit' }}
                        </button>
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
import { onMounted, getCurrentInstance } from 'vue';
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
    year: String,
    fuelPrice: Object,
    branches: Array,
    selectedStation: Object
})

const form = useForm({
    date: props.filters.date || null,
    station_id: props.filters.station_id || null
})


const { proxy } = getCurrentInstance();


const postForm = useForm({
    batchNumber: proxy.$page.props.auth.user.batchName,
    project_id: null,
    branch_id: null,
    date: props.filters.date || null,
    year: props.year || null,
    description: null,
    sale_id: null,
    station_id: null,
    unitPriceAgo: props.fuelPrice?.ago || 0,
    unitPricePms: props.fuelPrice?.pms || 0,
    postings: props.formData || []
})


onMounted(() => {

})




function finalSubmit() {
    postForm.post(route('siv.process'), {
        onStart: () => {

        },
        onFinish: () => {

        },
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success Created', detail: 'SIV Created Successfully', life: 3000 });
            props.data = null
            form.reset()
            postForm.reset();
            postForm.postings = []
        },
        onError: (error) => {

        },
        preserveScroll: true,
        preserveState: true
    })
}


function submit() {


    const queryParams = new URLSearchParams({ initReq: 'true' });

    const url = `${route('siv')}?${queryParams.toString()}`;

    form.get(url, {
        onSuccess: (data) => {
            console.info("data", data)
            postForm.postings = data.props.formData
            postForm.unitPriceAgo = data.props.fuelPrice?.ago || 0
            postForm.unitPricePms = data.props.fuelPrice?.pms || 0
            postForm.project_id = data.props.selectedStation['project_id']
            postForm.branch_id = data.props.selectedStation['branch_id']
            postForm.date = data.props.filters.date
            postForm.description = "Sales transaction"
            postForm.sale_id = data.props.data.sale_info['id']
            postForm.station_id = data.props.filters['station_id']
            // postForm.station_id = data.props.filters.department_id
            // data.data = null

        },
        onFinish: () => {
            console.log("finish")

        },
        onError: (error) => {
            console.error('error', error)

        },
        preserveState: true,
        preserveScroll: true
    })

}
</script>