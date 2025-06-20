<script setup>
import { ref, onMounted } from 'vue';
import { deleteUser, getUsers, restoreUser } from '@/service/GeneralService';
import { useRouter } from 'vue-router';
import { useConfirm, useToast } from 'primevue';

const router = useRouter();
const toast = useToast();
const confirm = useConfirm();

const users = ref({
    data: [],
    current_page: 1,
    per_page: 10,
    total: 0,
    last_page: 1
});

function fetchUsers(page = 1) {
    getUsers(page, users.value.per_page)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then((data) => {
            users.value = {
                data: data.data,
                current_page: data.current_page,
                per_page: data.per_page,
                total: data.total,
                last_page: data.last_page
            };
        })
        .catch((error) => {
            console.error('Fetch error:', error);
        });
}

function editUser(id) {
    router.push({ name: 'config-general-user-edit', params: { id } });
}

function fetchDeleteUser(event) {
    confirm.require({
        target: event.currentTarget,
        message: 'Are you sure you want to delete this user?',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Delete',
            severity: 'danger',
        },
        accept: () => {
            deleteUser(event)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((data) => {
                    fetchUsers();
                    toast.add({ severity: 'success', summary: 'Success', detail: data.message, life: 3000 });
                })
                .catch((error) => {
                    console.error('Delete error:', error);
                });
        },
    });
}

function fetchRestoreUser(event) {
    confirm.require({
        message: 'Are you sure you want to restore this user?',
        target: event.currentTarget,
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancel',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Restore',
            severity: 'success',
        },
        accept: () => {
            restoreUser(event)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((data) => {
                    fetchUsers();
                    toast.add({ severity: 'success', summary: 'Success', detail: data.message, life: 3000 });
                })
                .catch((error) => {
                    console.error('Restore error:', error);
                });
        },
    });
}

function onPageChange(event) {
    fetchUsers(event.page + 1);
}

onMounted(() => {
    fetchUsers();
});
</script>

<template>
    <ConfirmPopup />
    <DataTable
        :value="users.data"
        paginator
        lazy
        :rows="users.per_page"
        :totalRecords="users.total"
        :first="(users.current_page - 1) * users.per_page"
        @page="onPageChange"
        tableStyle="min-width: 50rem"
        paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
        currentPageReportTemplate="Showing {first} to {last} of {totalRecords} records"
    >
        <template #header>
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">User Management</h3>
                <Button label="Add User" icon="pi pi-plus" @click="$router.push({ name: 'config-general-user-create' })" />
            </div>
        </template>
        <template #empty><div class="text-center">No users found.</div></template>
        <!-- Running Number Column -->
        <Column header="No." style="width: 5%">
            <template #body="{ index }">
                {{ (users.current_page - 1) * users.per_page + index + 1 }}
            </template>
        </Column>

        <Column field="first_name" header="First Name" style="width: 20%"></Column>
        <Column field="last_name" header="Last Name" style="width: 20%"></Column>
        <Column field="email" header="Email" style="width: 20%"></Column>
        <Column field="role" header="Role" style="width: 10%"></Column>
        <Column field="deleted_at" header="Status" style="width: 15%">
            <template #body="{ data }">
                <Tag :value="data.deleted_at === null ? 'Active' : 'Inactive'" :severity="data.deleted_at === null ? 'success' : 'danger'" />
            </template>
        </Column>
        <Column header="Actions" style="width: 10%">
            <template #body="{ data }">
                <div class="flex justify-around">
                    <!-- Show edit button only for active records -->
                    <Button v-if="data.deleted_at === null" icon="pi pi-pencil" class="p-button-text" @click="editUser(data.id)" v-tooltip="'Edit User'" />

                    <!-- Show delete/restore based on status -->
                    <Button
                        :icon="data.deleted_at === null ? 'pi pi-trash' : 'pi pi-replay'"
                        :class="data.deleted_at === null ? 'p-button-text p-button-danger' : 'p-button-text p-button-success'"
                        @click="data.deleted_at === null ? fetchDeleteUser(data.id) : fetchRestoreUser(data.id)"
                        v-tooltip="data.deleted_at === null ? 'Delete User' : 'Restore User'"
                    />
                </div>
            </template>
        </Column>
    </DataTable>
</template>

<style scoped>
/* Add your styles here */
</style>
