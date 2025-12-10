<script setup lang="ts" generic="TData, TValue">
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { valueUpdater } from '@/lib/utils';
import type { ColumnDef, ColumnFiltersState, SortingState } from '@tanstack/vue-table';
import { FlexRender, getCoreRowModel, getFilteredRowModel, getSortedRowModel, useVueTable, getPaginationRowModel } from '@tanstack/vue-table';
import { computed, ref } from 'vue';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
}>();

const sorting = ref<SortingState>([]);
const columnFilters = ref<ColumnFiltersState>([]);

const table = useVueTable({
    get data() {
        return props.data;
    },
    get columns() {
        return props.columns;
    },
    getCoreRowModel: getCoreRowModel(),
    getSortedRowModel: getSortedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) => valueUpdater(updaterOrValue, columnFilters),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    state: {
        get sorting() {
            return sorting.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
    },
});

const defaultFilterColumn = computed(() => {
    // Find the column marked as default filter
    const col = props.columns.find((col) => (col as any).isDefaultFilter);
    // Fallback: use the first column with accessorKey
    return col?.accessorKey || props.columns.find((col) => col.accessorKey)?.accessorKey;
});
</script>

<template>
    <div class="border rounded-md">
        <div class="flex items-center justify-between px-2 py-4">
            <Input
                class="max-w-sm"
                placeholder="Filtrar"
                :model-value="table.getColumn(defaultFilterColumn)?.getFilterValue() as string"
                @update:model-value="table.getColumn(defaultFilterColumn)?.setFilterValue($event)"
            />
            <slot name="create" />
        </div>
        <div class="overflow-auto border-t">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead v-for="header in headerGroup.headers" :key="header.id">
                            <FlexRender :render="header.column.columnDef.header" :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="row in table.getRowModel().rows" :key="row.id">
                        <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                            <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <div class="flex items-center justify-end py-4 space-x-2">
            <Button
                variant="outline"
                size="sm"
                :disabled="!table.getCanPreviousPage()"
                @click="table.previousPage()"
            >
                Previous
            </Button>
            <Button
                variant="outline"
                size="sm"
                :disabled="!table.getCanNextPage()"
                @click="table.nextPage()"
            >
                Next
            </Button>
        </div>
    </div>
</template>
