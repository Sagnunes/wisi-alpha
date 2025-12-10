import ActionDropdown from '@/components/datatable-columns/rbac/permission/action-dropdown.vue';
import { Button } from '@/components/ui/button';
import { Permission } from '@/types/rbac';
import type { ColumnDef } from '@tanstack/vue-table';
import { ArrowUpDown } from 'lucide-vue-next';
import { h } from 'vue';

export const permissionColumns: ColumnDef<Permission>[] = [
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Nome', h(ArrowUpDown, { class: 'ml-2 h-4 w-4 cursor-pointer' })],
            );
        },
        cell: ({ row }) => h('div', row.getValue('name')),
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-expect-error
        isDefaultFilter: true,
    },
    {
        accessorKey: 'created_at',
        header: 'Criado em',
        cell: ({ row }) => row.original.created_at,
    },
    {
        id: 'actions',
        header: '',
        enableHiding: false,
        cell: ({ row }) => h(ActionDropdown, { permission: row.original }),
    },
];
