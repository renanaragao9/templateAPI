<script setup>
import Button from 'primevue/button';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Tag from 'primevue/tag';

defineProps({
    orders: Array,
    formatCurrency: Function,
    getOrderSeverity: Function
});
</script>

<template>
    <div class="p-4">
        <h5>Detalhes do Pedido</h5>
        <DataTable :value="orders">
            <Column field="id" header="Id" sortable></Column>
            <Column field="customer" header="Cliente" sortable></Column>
            <Column field="date" header="Data" sortable></Column>
            <Column field="amount" header="Valor" sortable>
                <template #body="slotProps">
                    {{ formatCurrency(slotProps.data.amount) }}
                </template>
            </Column>
            <Column field="status" header="Status" sortable>
                <template #body="slotProps">
                    <Tag :value="slotProps.data.status.toLowerCase()" :severity="getOrderSeverity(slotProps.data)" />
                </template>
            </Column>
            <Column headerStyle="width:4rem">
                <template #body>
                    <Button icon="pi pi-search" />
                </template>
            </Column>
        </DataTable>
    </div>
</template>

<style scoped>
:deep(.p-datatable-frozen-tbody) {
    font-weight: bold;
}
</style>
