<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Toast from "primevue/toast";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import TextInput from "@/Components/TextInput.vue";
import { FilterMatchMode } from "primevue/api";
import { reactive } from "vue";
import { useConfirm } from "primevue/useconfirm";
import { useToast } from "primevue/usetoast";
import { ToastSeverity } from "primevue/api";
import ConfirmDialog from "primevue/confirmdialog";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({cars: { type: Array, required: true }})

const filters = reactive({
    global: { value: "", matchMode: FilterMatchMode.CONTAINS },
    nama: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    model: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    merek: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
})

const form = useForm({id: ''})

const confirm = useConfirm()

const toast = useToast()

const handleConfirm = (id) => {
    confirm.require({
        message: "Apakah anda yakin ingin menghapus data ini ?" + id,
        header: "Confirmation",
        accept: () => {
            form.delete(route("car.delete", id), {
                onSuccess: () => {
                    toast.add({
                        severity: ToastSeverity.SUCCESS,
                        summary: "Success",
                        detail: "Data Mobil berhasil dihapus",
                        life: 2000,
                    });
                },
            });
        },
        reject: () => {
            toast.add({
                severity: ToastSeverity.INFO,
                summary: "Cancelled",
                detail: "Data Mobil tidak jadi dihapus",
                life: 2000,
            });
        },
    });
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <Toast />
        
        <ConfirmDialog>
            <template #container="{ message, acceptCallback, rejectCallback }">
                <div class="bg-white p-5 rounded-lg text-gray-700">
                    <div class="flex flex-row justify-between items-center">
                        <span class="font-bold text-2xl block">{{
                            message.header
                        }}</span>
                        <button class="p-4" @click="rejectCallback">
                            <span class="pi pi-times"></span>
                        </button>
                    </div>
                    <p class="py-4">{{ message.message }}</p>
                    <div class="flex justify-end gap-2 py-4">
                        <PrimaryButton @click="acceptCallback"
                            >Submit</PrimaryButton
                        >
                        <SecondaryButton @click="rejectCallback"
                            >Cancel</SecondaryButton
                        >
                    </div>
                </div>
            </template>
        </ConfirmDialog>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <Link class="px-4 py-2 rounded-md bg-gray-800 text-white text-medium" :href="route('car.create')">Buat Data Mobil</Link>


                    <div class="mt-6">
                        <DataTable
                            v-model:filters="filters"
                            :value="cars"
                            paginator
                            :rows="10"
                            :globalFilterFields="['nama', 'model', 'merek']">
                            <template #header>
                                <div class="flex justify-content-end">
                                    <TextInput
                                        type="text"
                                        class="mt-1 block w-1/2"
                                        v-model="filters.global.value"
                                        placeholder="Nama Model Merek Mobil" />
                                </div>
                            </template>
                            <template #empty> No Project found. </template>
                            <Column
                                field="nama"
                                sortable
                                header="Nama Mobil" />
                            
                            <Column
                                field="model"
                                sortable
                                header="Model Mobil" />
                            <Column
                                field="merek"
                                sortable
                                header="Merek Mobil" />
                            <Column
                                field="harga_sewa"
                                sortable
                                header="Harga Sewa Mobil" />
                            <Column
                                field="ketersediaan"
                                sortable
                                header="Jumlah Ketersediaan Mobil" />
                            <Column header="Actions">
                                <template #body="{ data }">
                                    <div class="flex flex-row gap-4">
                                        <Link
                                            :href="route('car.edit', data.id)"
                                            as="button"
                                            type="button"
                                            class="bg-yellow-400 text-white px-4 py-2 rounded-md">
                                            Edit
                                        </Link>

                                        <div>
                                            <button
                                                @click="handleConfirm(data.id)"
                                                class="bg-red-500 text-white px-4 py-2 rounded-md">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </Column>
                        </DataTable>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
