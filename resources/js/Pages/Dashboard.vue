<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage, router  } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

import { useGeneralFunction } from '@/composables/main/useGeneralFunction';
// import { useTenants } from '@/composables/main/tenant/tenants';
import { useTenants } from '../composables/tenant/tenants';

const { showNProgress, hideNProgress } = useGeneralFunction()
const { getRecords, records, store, deleteTenant } = useTenants()


const form = reactive({
    subdomain: '',
})


getRecords()

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        You're logged in!

                        <div>
                            <InputLabel for="subdomain" value="Subdominio" />

                            <TextInput
                                id="subdomain"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.subdomain"
                                required
                                autofocus
                                autocomplete="subdomain"
                            />

                            <!-- <InputError class="mt-2" :message="form.errors.subdomain" /> -->
                        </div>

                        <div class="flex items-center gap-4 mt-3">
                            <PrimaryButton :disabled="form.processing" @click.prevent="store(form)">Registrar</PrimaryButton>
                        </div>

                        <br>
                        <hr>
                        <br>

                        <table class="border-collapse border border-slate-400" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="border border-slate-300 py-2">id</th>
                                    <th class="border border-slate-300 py-2">name</th>
                                    <th class="border border-slate-300 py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in records">
                                    <td class="border border-slate-300 px-3">
                                        {{ row.id }}
                                    </td>
                                    <td class="border border-slate-300 px-3">
                                        {{  row.tenancy_db_name }}
                                    </td>
                                    <td class="border border-slate-300 px-4 py-2">
                                        
                                        <!-- <form @submit.prevent="router.delete(route('tenant.delete', row.id))" > -->
                                            <PrimaryButton :disabled="form.processing" @click.prevent="deleteTenant(row.id)">Eliminar</PrimaryButton>
                                        <!-- </form> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
