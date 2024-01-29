<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    tenants: {
        type: Array,
    },
});

const form = useForm({
    subdomain: null,
});

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
                        

                        <form @submit.prevent="form.post(route('create.tenant'))" class="mt-6 space-y-6">
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

                                <InputError class="mt-2" :message="form.errors.subdomain" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Guardar</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                                </Transition>
                            </div>
                        </form>

                        <br>
                        <hr>
                        <br>

                        <table class="table-auto">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in tenants">
                                    <td>
                                        {{ row.id }}
                                    </td>
                                    <td>
                                        {{  row.tenancy_db_name }}
                                    </td>
                                    <td>
                                        
                                        <form @submit.prevent="form.delete(route('delete.tenant'), row.id)" class="mt-6 space-y-6">

                                            <div class="flex items-center gap-4">
                                                <PrimaryButton :disabled="form.processing">Eliminar</PrimaryButton>

                                                <Transition
                                                    enter-active-class="transition ease-in-out"
                                                    enter-from-class="opacity-0"
                                                    leave-active-class="transition ease-in-out"
                                                    leave-to-class="opacity-0"
                                                >
                                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Eliminar.</p>
                                                </Transition>
                                            </div>
                                        </form>
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
