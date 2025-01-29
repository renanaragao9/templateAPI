<script setup>
import { Button, InputText } from 'primevue';
</script>

<template>
    <div class="card p-4">
        <div class="font-semibold text-xl mb-4">Redes Sociais</div>
        <div class="text-sm text-gray-600 mb-4">Preencha os campos abaixo com os links das suas redes sociais.</div>
        <div class="flex flex-col gap-2">
            <label for="facebook">Facebook</label>
            <InputText id="facebook" type="text" placeholder="https://www.facebook.com/seuPerfil" />
            <small class="text-gray-500">Insira o link completo do seu perfil no Facebook.</small>
        </div>
        <div class="flex flex-col gap-2">
            <label for="instagram">Instagram</label>
            <InputText id="instagram" type="text" placeholder="https://www.instagram.com/seuPerfil" />
            <small class="text-gray-500">Insira o link completo do seu perfil no Instagram.</small>
        </div>
        <div class="flex flex-col gap-2">
            <label for="twitter">Twitter</label>
            <InputText id="twitter" type="text" placeholder="https://www.twitter.com/seuPerfil" />
            <small class="text-gray-500">Insira o link completo do seu perfil no Twitter.</small>
        </div>
        <div class="col-span-12 flex justify-between mt-4">
            <Button label="Voltar" @click="$emit('previous')" />
            <Button label="Finalizar" @click="$emit('finish')" />
        </div>
    </div>
</template>
