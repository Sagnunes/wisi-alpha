<script setup lang="ts">
import Dialog from '@/components/Dialog.vue';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { show } from '@/routes/role-permission';
import { Role } from '@/types/rbac';
import { router, useForm } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
const { role } = defineProps<{ role: Role }>();

const form = useForm({});

function copy(id: number) {
    navigator.clipboard.writeText(id.toString());
}

const goToEditPermissionPage = () => {
    router.get(route('roles.edit', role.id));
};

const goToEditRolePermissionPage = () => {
    router.get(show.url({ role: role.slug }));
};

const isOpen = ref(false);

function openDialog() {
    isOpen.value = true;
}

function submitDelete() {
    form.delete(route('roles.destroy', role.id), {
        onSuccess: (e: object) => {
            isOpen.value = false;
            toast.success(e.props.flash.status);
        },
        preserveScroll: true,
        preserveState: true,
    });
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="h-8 w-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="h-4 w-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuItem @click="copy(role.id)"> Copy ID</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="goToEditPermissionPage"
                >Edit Role</DropdownMenuItem
            >
            <DropdownMenuItem @click="openDialog">Delete Role</DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem @click="goToEditRolePermissionPage"
                >Assign Permission</DropdownMenuItem
            >
        </DropdownMenuContent>
    </DropdownMenu>

    <Dialog
        v-model="isOpen"
        title="Eliminar uma nova permissão"
        description="Tem certeza que deseja deseja eliminar a permissão. Este processo não pode ser desfeito. "
    >
        <template #submitButton>
            <Button type="submit" @click="submitDelete" variant="destructive"
                >Apagar</Button
            >
        </template>
    </Dialog>
</template>
