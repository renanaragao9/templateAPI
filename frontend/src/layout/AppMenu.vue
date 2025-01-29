<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Inicio',
        items: [
            { label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/' },
            { label: 'PDV', icon: 'pi pi-fw pi-desktop', to: '/pdv' },
            { label: 'Configuração', icon: 'pi pi-fw pi-cog', to: '/configuracao' },
            { label: 'Espaços', icon: 'pi pi-fw pi-map', to: '/espacos' },
            { label: 'Produtos', icon: 'pi pi-fw pi-box', to: '/produtos' },
            { label: 'Mensagens', icon: 'pi pi-fw pi-inbox', to: '/mensagens' },
            { label: 'Categorias de Produtos', icon: 'pi pi-fw pi-tags', to: 'categorias-de-produtos' }
        ]
    }
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
