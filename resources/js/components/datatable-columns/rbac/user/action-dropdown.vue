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
import { router, useForm } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';

import Status from '@/enums/Status';
import { show } from '@/routes/user-role';
import { update } from '@/routes/user-status';
import { destroy } from '@/routes/users';
import { User } from '@/types';
const { user } = defineProps<{ user: User }>();

const form = useForm({});

function copy(id: number) {
    navigator.clipboard.writeText(id.toString());
}
const isOpen = ref(false);

function openDialog() {
    isOpen.value = true;
}

function submitDelete() {
    form.delete(destroy(user).url, {
        onSuccess: (e: object) => {
            isOpen.value = false;
            toast.success(e.props.flash.status);
        },
        preserveScroll: true,
        preserveState: true,
    });
}

function goToUpdateUserRolePage() {
    router.get(show.url({ user }));
}

function updateUserStatus() {
    form.patch(update.url(user), {
        onSuccess: (e: object) => {
            toast.success(e.props.flash.status);
        },
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
            <DropdownMenuItem @click="copy(user.id)"> Copy ID</DropdownMenuItem>
            <DropdownMenuSeparator
                v-if="Object.values(user.can).some(Boolean)"
            />
            <DropdownMenuItem
                v-if="user.can.validate && user.status.id !== Status.ACTIVE"
                @click="updateUserStatus"
                >Validate User</DropdownMenuItem
            >
            <DropdownMenuItem @click="goToUpdateUserRolePage"
                >Assign Role</DropdownMenuItem
            >

            <DropdownMenuItem @click="openDialog" v-if="user.can.delete"
                >Delete User</DropdownMenuItem
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
