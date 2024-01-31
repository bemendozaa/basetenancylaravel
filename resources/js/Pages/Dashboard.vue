<script setup>

    import { Head } from '@inertiajs/vue3'
    import { reactive, ref } from 'vue'
    import { FwbAlert, FwbButton } from 'flowbite-vue'
    
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
    import InputError from '@/Components/InputError.vue'
    import InputLabel from '@/Components/InputLabel.vue'
    import PrimaryButton from '@/Components/PrimaryButton.vue'
    import TextInput from '@/Components/TextInput.vue'
    import TenantForm from '@/Pages/Central/Tenants/Form.vue'

    import { useTenants } from '@/composables/central/tenants'

    const { getRecords, records, store, deleteTenant } = useTenants()

    const showModal = ref(false)
    const recordId = ref(null)

    const clickNewRecord = (id = null) => {
        recordId.value = id
        showModal.value = true
    }

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

                        <fwb-alert icon type="success" class="mt-3 mb-3">
                            <p class="alert-message">You're logged in!</p>
                        </fwb-alert>

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
                            <!-- <PrimaryButton :disabled="form.processing" @click.prevent="store(form)">Registrar</PrimaryButton> -->
                            <PrimaryButton @click="clickNewRecord()">Nuevo</PrimaryButton>
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
                                        
                                        <fwb-button color="default" size="sm" class="mx-2" @click="clickNewRecord(row.id)">Actualizar</fwb-button>

                                        <fwb-button color="red" size="sm" @click="deleteTenant(row.id)">Eliminar</fwb-button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <tenant-form 
            v-model:showModal="showModal"
            :recordId="recordId"
        >
        </tenant-form>

    </AuthenticatedLayout>
</template>
