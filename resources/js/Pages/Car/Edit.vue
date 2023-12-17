<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useToast } from "primevue/usetoast";
import { ToastSeverity } from "primevue/api";

const props = defineProps({ car: { type: Object, required: true } })

const form = useForm({
    nama: props.car.nama,
    model: props.car.model,
    merek: props.car.merek,
    no_plat: props.car.no_plat,
    harga_sewa: props.car.harga_sewa,
    ketersediaan: props.car.ketersediaan,
})

const toast = useToast()

const submit = () => {
    form.patch(route('car.update', props.car.id), {
        onFinish: () => form.reset(),
        onSuccess: () => toast.add({
                severity: ToastSeverity.SUCCESS,
                summary: "Sucess",
                detail: "Data Mobil successfully edited",
                life: 2000,
            }),
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Mobil</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                    <Link class="px-4 py-2 rounded-md bg-gray-800 text-white uppercase" :href="route('car.index')">Kembali</Link>
                    

                    <form @submit.prevent="submit">
                    
                        <div class="mt-4">
                            <InputLabel for="nama" value="Nama Mobil" />

                            <TextInput
                                id="nama"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.nama"
                                required
                                autocomplete="nama"
                            />

                            <InputError class="mt-2" :message="form.errors.nama" />
                        </div>
                        
                        <div class="mt-4">
                            <InputLabel for="model" value="Model Mobil" />

                            <TextInput
                                id="model"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.model"
                                required
                                autocomplete="model"
                            />

                            <InputError class="mt-2" :message="form.errors.model" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="merek" value="Merek Mobil" />

                            <TextInput
                                id="merek"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.merek"
                                required
                                autocomplete="merek"
                            />

                            <InputError class="mt-2" :message="form.errors.merek" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="no_plat" value="No Plat Mobil" />

                            <TextInput
                                id="no_plat"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.no_plat"
                                required
                                autocomplete="no_plat"
                            />

                            <InputError class="mt-2" :message="form.errors.no_plat" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="harga_sewa" value="Harga Sewa Mobil Per Hari" />

                            <TextInput
                                id="harga_sewa"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.harga_sewa"
                                required
                                autocomplete="harga_sewa"
                            />

                            <InputError class="mt-2" :message="form.errors.harga_sewa" />
                        </div>
                        

                        <div class="mt-4">
                            <InputLabel for="ketersediaan" value="Jumlah Ketersediaan Mobil" />

                            <TextInput
                                id="ketersediaan"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.ketersediaan"
                                required
                                autocomplete="ketersediaan"
                            />

                            <InputError class="mt-2" :message="form.errors.ketersediaan" />
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
