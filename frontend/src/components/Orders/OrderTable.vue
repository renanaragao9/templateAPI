<script setup>
import { ProductService } from '@/service/ProductService';
import Button from 'primevue/button';
import Calendar from 'primevue/calendar';
import Column from 'primevue/column';
import DataTable from 'primevue/datatable';
import Dropdown from 'primevue/dropdown';
import InputNumber from 'primevue/inputnumber';
import Rating from 'primevue/rating';
import Tag from 'primevue/tag';
import Toolbar from 'primevue/toolbar';
import { onBeforeMount, ref } from 'vue';

const products = ref(null);
const expandedRows = ref([]);
const startDateFilter = ref(null);
const endDateFilter = ref(null);
const amountFilter = ref(null);

const statusOptions = [
    { label: 'Disponível', value: 'AVAILABLE' },
    { label: 'Reservado', value: 'RESERVED' },
    { label: 'Ocupado', value: 'OCCUPIED' },
    { label: 'Manutenção', value: 'MAINTENANCE' }
];

function getOrderSeverity(order) {
    switch (order.status) {
        case 'AVAILABLE':
            return 'success';

        case 'RESERVED':
            return 'warning';

        case 'OCCUPIED':
            return 'danger';

        case 'MAINTENANCE':
            return 'info';

        default:
            return null;
    }
}

function getStockSeverity(product) {
    switch (product.inventoryStatus) {
        case 'INSTOCK':
            return 'success';

        case 'LOWSTOCK':
            return 'warning';

        case 'OUTOFSTOCK':
            return 'danger';

        default:
            return null;
    }
}

onBeforeMount(() => {
    ProductService.getProductsWithOrdersSmall().then((data) => (products.value = data));
});

function expandAll() {
    expandedRows.value = products.value.reduce((acc, p) => (acc[p.id] = true) && acc, {});
}

function collapseAll() {
    expandedRows.value = null;
}

function formatCurrency(value) {
    return value.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

// function formatDate(value) {
//     return value.toLocaleDateString('pt-BR', {
//         day: '2-digit',
//         month: '2-digit',
//         year: 'numeric'
//     });
// }

function filterProducts() {
    let filteredProducts = products.value;
    if (startDateFilter.value) {
        filteredProducts = filteredProducts.filter((product) => new Date(product.date) >= new Date(startDateFilter.value));
    }
    if (endDateFilter.value) {
        filteredProducts = filteredProducts.filter((product) => new Date(product.date) <= new Date(endDateFilter.value));
    }
    if (amountFilter.value) {
        filteredProducts = filteredProducts.filter((product) => product.amount >= amountFilter.value);
    }
    return filteredProducts;
}

function updateOrderStatus(order, status) {
    order.status = status;
}

function openNew() {
    // Implementar lógica para abrir novo item
}

function confirmDeleteSelected() {
    // Implementar lógica para confirmar exclusão dos itens selecionados
}

function exportCSV() {
    // Implementar lógica para exportar dados em CSV
}
</script>

<template>
    <div>
        <Toolbar class="mb-6">
            <template #start>
                <Button label="Novo" icon="pi pi-plus" severity="secondary" class="mr-2" @click="openNew" />
                <Button label="Deletar" icon="pi pi-trash" severity="secondary" @click="confirmDeleteSelected" :disabled="!selectedProducts || !selectedProducts.length" />
            </template>

            <template #end>
                <Button label="Exportar" icon="pi pi-upload" severity="secondary" @click="exportCSV($event)" />
            </template>
        </Toolbar>

        <div class="flex flex-wrap gap-2 mb-4">
            <Calendar v-model="startDateFilter" placeholder="Data Inicial" />
            <Calendar v-model="endDateFilter" placeholder="Data Final" />
            <InputNumber v-model="amountFilter" placeholder="Filtrar por Valor" mode="currency" currency="BRL" locale="pt-BR" />
        </div>

        <DataTable v-model:expandedRows="expandedRows" :value="filterProducts()" dataKey="id" tableStyle="min-width: 60rem">
            <template #header>
                <div class="flex flex-wrap justify-end gap-2">
                    <Button text icon="pi pi-plus" label="Expandir Tudo" @click="expandAll" />
                    <Button text icon="pi pi-minus" label="Colapsar Tudo" @click="collapseAll" />
                </div>
            </template>
            <Column expander style="width: 5rem" />
            <Column field="name" header="Nome do Campo"></Column>
            <Column header="Imagem">
                <template #body="slotProps">
                    <img :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.data.image}`" :alt="slotProps.data.image" class="shadow-lg" width="64" />
                </template>
            </Column>
            <Column field="price" header="Preço por Hora">
                <template #body="slotProps">
                    {{ formatCurrency(slotProps.data.price) }}
                </template>
            </Column>
            <Column field="category" header="Categoria"></Column>
            <Column field="rating" header="Avaliações">
                <template #body="slotProps">
                    <Rating :modelValue="slotProps.data.rating" readonly />
                </template>
            </Column>
            <Column header="Status">
                <template #body="slotProps">
                    <Tag :value="slotProps.data.inventoryStatus" :severity="getStockSeverity(slotProps.data)" />
                </template>
            </Column>
            <Column header="Ações">
                <template #body="slotProps">
                    <Dropdown :options="statusOptions" v-model="slotProps.data.status" optionLabel="label" @change="updateOrderStatus(slotProps.data, $event.value)" placeholder="Alterar Status" />
                </template>
            </Column>
            <template #expansion="slotProps">
                <OrderDetail :orders="slotProps.data.orders" :formatCurrency="formatCurrency" :getOrderSeverity="getOrderSeverity" />
            </template>
        </DataTable>
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
