<script setup lang="ts">
import { roleColumns } from '@/components/datatable-columns/rbac/role/columns';
import DataTable from '@/components/DataTable.vue';
import Dialog from '@/components/Dialog.vue';
import InputError from '@/components/InputError.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import { destroy, index, store } from '@/routes/roles';
import { type BreadcrumbItem } from '@/types';
import { Role } from '@/types/rbac';
import { Head, useForm } from '@inertiajs/vue3';
import { PropType, ref } from 'vue';
import { toast } from 'vue-sonner';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: index().url,
    },
];

defineProps({
    roles: {
        type: Object as PropType<Role[]>,
        required: true,
    },
});

const form = useForm({
    name: '',
    description: '',
});

const isOpen = ref(false);

function openDialog() {
    isOpen.value = true;
}

const closeModal = () => {
    form.reset();
    isOpen.value = false;
};

const submit = () => {
    form.post(store.url(), {
        onSuccess: (e: object) => {
            const flash = e.props.flash;
            closeModal();
            toast.success(flash.status, {
                action: {
                    label: 'Undo',
                    onClick: () => {
                        form.delete(destroy(flash.data).url, {
                            onSuccess: (e: object) => {
                                toast.success(e.props.flash.status);
                            },
                            preserveScroll: true,
                            preserveState: true,
                        });
                    },
                },
            });
        },
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Roles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <DataTable :columns="roleColumns" :data="roles">
                    <template #create>
                        <Dialog
                            v-model="isOpen"
                            title="Creating a new role"
                            description="Define the details of the new profile to group permissions and control user access based on their roles."
                        >
                            <template #trigger>
                                <Button @click="openDialog">New</Button>
                            </template>

                            <div class="grid gap-2">
                                <Label>Name</Label>
                                <Input
                                    id="name"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <template #submitButton>
                                <Button type="submit" @click="submit"
                                    >Save</Button
                                >
                            </template>
                        </Dialog>
                    </template>
                </DataTable>
            </div>
        </div>
    </AppLayout>
</template>
