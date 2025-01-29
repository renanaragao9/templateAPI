<script setup>
import OrderInfoBussines from '@/components/Orders/OrderInfoBussines.vue';
import OrderTable from '@/components/Orders/OrderTable.vue';
</script>

<template>
    <div class="mb-8">
        <Panel :toggleable="true">
            <OrderInfoBussines />
        </Panel>
    </div>
    <div class="grid grid-cols-12 gap-8">
        <OrderStatsWidget />
    </div>
    <div class="card mt-8">
        <div class="font-semibold text-xl mb-4">PDV - Aluguel de Campos de Futebol</div>
        <OrderTable />
    </div>
</template>

<style scoped lang="scss">
:deep(.p-datatable-frozen-tbody) {
    font-weight: bold;
}

:deep(.p-datatable-scrollable .p-frozen-column) {
    font-weight: bold;
}
</style>
