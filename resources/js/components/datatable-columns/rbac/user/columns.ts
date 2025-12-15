import ActionDropdown from '@/components/datatable-columns/rbac/user/action-dropdown.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { User } from '@/types';
import { Role } from '@/types/rbac';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown } from 'lucide-vue-next';
import { h } from 'vue';

export const userColumns: ColumnDef<User>[] = [
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => [
                    'Name',
                    h(ArrowUpDown, { class: 'ml-2 h-4 w-4 cursor-pointer' }),
                ],
            );
        },
        cell: ({ row }) => h('div', row.getValue('name')),
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
        isDefaultFilter: true,
    },
    {
        accessorKey: 'created_at',
        header: 'Registered at',
        cell: ({ row }) => row.original.created_at,
    },
    {
        accessorKey: 'roles',
        header: () => h('span', { class: 'block' }, 'Roles'),
        cell: ({ row }) => {
            const roles = row.original.roles;
            // Check if permissions is empty or undefined
            if (!roles || roles.length === 0) {
                return h(
                    'div',
                    { class: 'text-sm text-muted-foreground' },
                    'No Roles Assign',
                );
            }
            return h(
                'div',
                {
                    class: 'flex flex-wrap gap-2 justify-start items-center',
                },
                roles.map((role: Role) =>
                    h(
                        Badge,
                        {
                            class: 'text-xs',
                            key: role.id,
                        },
                        () => role.name,
                    ),
                ),
            );
        },
    },
    {
        id: 'status',
        header: 'Status',
        cell: ({ row }) => row.original.status.name,
    },
    {
        id: 'actions',
        header: '',
        enableHiding: false,
        cell: ({ row }) => h(ActionDropdown, { user: row.original }),
    },
];
