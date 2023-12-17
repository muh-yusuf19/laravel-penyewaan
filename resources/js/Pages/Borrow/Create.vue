<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Dropdown from "primevue/dropdown";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useToast } from "primevue/usetoast";
import { ToastSeverity } from "primevue/api";
import { ref } from 'vue';

const props = defineProps({ cars: { type: Array, required: true } })

const form = useForm({
    tgl_mulai: '',
    tgl_selesai: '',
    car_id: '',
})

const selectedCar = ref()

const toast = useToast()

const submit = () => {
    form.car_id = selectedCar.value?.id

    form.post(route('borrow.store'), {
        onFinish: () => form.reset(),
        onSuccess: () => toast.add({
                severity: ToastSeverity.SUCCESS,
                summary: "Sucess",
                detail: "Data Peminjaman successfully created",
                life: 2000,
            }),
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Data Mobil</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <Link class="px-4 py-2 rounded-md bg-gray-800 text-white" :href="route('car.index')">Kembali</Link>
                    
                    <p>Untuk pengguna yang meminjam berdasarkan user yang sedang login atau authenticated user</p>

                    <form @submit.prevent="submit">
                    
                        <div class="mt-4">
                            <InputLabel for="tgl_mulai" value="Tgl Mulai Pinjam Mobil" />

                            <TextInput
                                id="tgl_mulai"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.tgl_mulai"
                                required
                                autocomplete="tgl_mulai"
                            />

                            <InputError class="mt-2" :message="form.errors.tgl_mulai" />
                        </div>
                        
                        <div class="mt-4">
                            <InputLabel for="tgl_selesai" value="Tgl Selesai Pinjam Mobil" />

                            <TextInput
                                id="tgl_selesai"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.tgl_selesai"
                                required
                                autocomplete="tgl_selesai"
                            />

                            <InputError class="mt-2" :message="form.errors.tgl_selesai" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="car_id" value="Pilih Mobil" />
                            <Dropdown
                                id="car_id"
                                v-model="selectedCar"
                                :options="props.cars"
                                filter
                                optionLabel="nama"
                                placeholder="Pilih Mobil"
                                class="w-full border border-gray-300 md:w-14rem">
                                <template #value="slotProps">
                                    <div
                                        v-if="slotProps.value"
                                        class="flex align-items-center">
                                        <div>{{ slotProps.value.nama }}</div>
                                    </div>
                                    <span v-else>
                                        {{ slotProps.placeholder }}
                                    </span>
                                </template>
                                <template #option="slotProps">
                                    <div class="flex align-items-center">
                                        <div>{{ slotProps.option.nama }} | {{ slotProps.option.model }} | Ketersediaan: {{ slotProps.option.ketersediaan }}</div>
                                    </div>
                                </template>
                            </Dropdown>
                            <InputError
                                class="mt-2"
                                :message="form.errors.project_id" />
                        </div>

                        <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Submit
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
