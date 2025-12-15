<script setup lang="ts">
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import AppLayout from '@/layouts/AppLayout.vue';
import { update } from '@/routes/role-permission';
import { index as indexRole } from '@/routes/roles';
import { type BreadcrumbItem } from '@/types';
import { Permission, Role } from '@/types/rbac';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, type PropType, ref } from 'vue';
import { toast } from 'vue-sonner';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles',
        href: indexRole.url(),
    },
    {
        title: 'Assigning permission',
        href: '',
    },
];

const props = defineProps({
    permissions: {
        type: Array as PropType<Permission[]>,
        required: true,
    },
    role: {
        type: Object as PropType<Role>,
        required: true,
    },
});

const permissions = ref(
    props.permissions.map((permission) => ({
        ...permission,
        selected: props.role.permissions?.some((p) => p.id === permission.id),
    })),
);

const form = useForm({
    selectedPermissions: permissions.value
        .filter((p) => p.selected)
        .map((p) => p.id),
});

function onToggle(id: number, value: boolean) {
    const permission = permissions.value.find((p) => p.id === id);
    if (permission) permission.selected = value;

    if (value) {
        if (!form.selectedPermissions.includes(id)) {
            form.selectedPermissions.push(id);
        }
    } else {
        form.selectedPermissions = form.selectedPermissions.filter(
            (pid) => pid !== id,
        );
    }
}

const selectedPermissionsError = computed(() => {
    return (
        form.errors.selectedPermissions ||
        Object.entries(form.errors)
            .filter(([key]) => key.startsWith('selectedPermissions.'))
            .map(([, message]) => message)
            .join(', ') ||
        null
    );
});

function clearAllPermissions() {
    permissions.value.forEach((permission) => {
        permission.selected = false;
    });
    form.selectedPermissions = [];
}
// props.role.id
function submit() {
    form.patch(update(props.role).url, {
        preserveScroll: true,
        onSuccess: (e: object) => {
            const flash = e.props.flash;
            form.reset();
            toast.success(flash.status);
        },
    });
}
</script>

<template>
    <Head title="Atribuir Permissões" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="flex flex-row items-end justify-between gap-4">
                <HeadingSmall
                    title="Gestão de Permissões do Perfil"
                    description="Gerir as permissões associadas a este perfil para controlar o acesso a funcionalidades do sistema."
                />
            </div>
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
                <div class="flex flex-col space-y-6 px-4 py-6">
                    <form @submit.prevent="submit">
                        <fieldset class="flex flex-col space-y-4">
                            <legend class="sr-only">Permissions</legend>
                            <div
                                class="flex flex-row items-end justify-between gap-4"
                            >
                                <p
                                    class="text-base font-semibold text-foreground"
                                >
                                    Permissions
                                </p>
                                <InputError
                                    class="mt-2"
                                    :message="selectedPermissionsError"
                                />
                                <div
                                    class="mt-6 flex flex-row items-center justify-center gap-4"
                                    v-if="permissions.length"
                                >
                                    <Button
                                        type="submit"
                                        :disabled="form.processing"
                                    >
                                        Save
                                    </Button>
                                    <Button
                                        variant="outline"
                                        type="button"
                                        @click="clearAllPermissions"
                                        :disabled="
                                            form.processing ||
                                            !form.selectedPermissions.length
                                        "
                                    >
                                        Clear
                                    </Button>
                                </div>
                            </div>
                            <div
                                v-if="permissions.length"
                                class="mt-4 grid grid-cols-1 gap-x-6 gap-y-4 divide-y-0 rounded-md border border-border bg-muted/50 p-4 md:grid-cols-5"
                            >
                                <div
                                    v-for="permission in permissions"
                                    :key="permission.id"
                                    class="flex flex-col justify-between gap-3 rounded-sm border border-border/50 bg-background px-4 py-3"
                                >
                                    <div class="space-y-1">
                                        <label
                                            :for="`permission-${permission.id}`"
                                            class="block cursor-pointer text-sm leading-snug font-medium text-foreground"
                                        >
                                            {{ permission.name }}
                                        </label>
                                    </div>
                                    <div class="self-end">
                                        <Checkbox
                                            :id="`permission-${permission.id}`"
                                            :model-value="permission.selected"
                                            @update:model-value="
                                                (val) =>
                                                    onToggle(permission.id, val)
                                            "
                                        />
                                    </div>
                                </div>
                            </div>

                            <div
                                v-else
                                class="mt-4 flex items-center justify-center rounded border border-dashed border-border bg-muted/40 p-6 text-sm text-muted-foreground"
                            >
                                No permission created
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
