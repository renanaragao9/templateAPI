<script setup lang="ts">
import Button from 'primevue/button';
import { usePrimeVue } from 'primevue/config';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Message from 'primevue/message'; // Removed as it does not exist
import { ref } from 'vue';

interface Message {
    id: number;
    sender: string;
    text: string;
    timestamp: string;
}

const contacts = ref([
    { id: 1, name: 'João Silva', lastMessage: 'Oi, tudo bem?' },
    { id: 2, name: 'Maria Oliveira', lastMessage: 'Vamos nos encontrar?' },
    { id: 3, name: 'Pedro Santos', lastMessage: 'Até mais tarde.' }
]);

const selectedContact = ref(contacts.value[0]);
const messages = ref<Message[]>([
    { id: 1, sender: 'João Silva', text: 'Oi, tudo bem?', timestamp: '10:15' },
    { id: 2, sender: 'Você', text: 'Tudo ótimo, e você?', timestamp: '10:16' },
    { id: 3, sender: 'João Silva', text: 'Tranquilo! Precisamos conversar depois.', timestamp: '10:17' }
]);

const newMessage = ref<string>('');
const isModalOpen = ref(false);

const primevue = usePrimeVue();

function sendMessage() {
    if (newMessage.value.trim()) {
        messages.value.push({
            id: Date.now(),
            sender: 'Você',
            text: newMessage.value.trim(),
            timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        });
        newMessage.value = '';
        scrollToBottom();
    }
}

function receiveMessage(sender: string, text: string) {
    messages.value.push({
        id: Date.now(),
        sender,
        text,
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    });
    scrollToBottom();
}

function selectContact(contact: (typeof contacts.value)[0]) {
    selectedContact.value = contact;
    messages.value = []; // Simula troca de conversa
    if (window.innerWidth < 768) {
        // Verifica se a largura da janela é menor que 768px (mobile)
        isModalOpen.value = true;
    }
}

function scrollToBottom() {
    const chatArea = document.getElementById('chat-area');
    if (chatArea) {
        chatArea.scrollTop = chatArea.scrollHeight;
    }
}
</script>

<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-full md:w-1/3 bg-white border-r border-gray-300 flex flex-col">
            <div class="p-4 border-b border-gray-300">
                <h1 class="text-xl font-semibold text-gray-800">Contatos</h1>
            </div>
            <div class="flex-1 overflow-y-auto">
                <div v-for="contact in contacts" :key="contact.id" @click="selectContact(contact)" class="p-4 hover:bg-gray-200 cursor-pointer flex justify-between items-center border-b border-gray-300 w-full">
                    <div>
                        <h2 class="text-gray-800 font-semibold">{{ contact.name }}</h2>
                        <p class="text-gray-600 text-sm">{{ contact.lastMessage }}</p>
                    </div>
                    <span class="text-xs text-gray-500">Agora</span>
                </div>
            </div>
        </div>

        <!-- Chat Area (hidden on mobile) -->
        <div class="hidden md:flex w-full md:w-2/3 flex-col">
            <!-- Chat Header -->
            <div class="p-2 border-b border-gray-300 bg-white flex justify-between items-center">
                <div>
                    <h2 class="text-gray-800 font-semibold">{{ selectedContact.name }}</h2>
                    <p class="text-sm text-gray-500">Online</p>
                </div>
            </div>

            <!-- Messages -->
            <div id="chat-area" class="flex-1 overflow-y-auto p-4 bg-gray-50">
                <div v-for="message in messages" :key="message.id" :class="[message.sender === 'Você' ? 'self-end bg-blue-500 text-white' : 'self-start bg-green-500 text-white', 'rounded-lg p-3 mb-2 max-w-xs relative']">
                    <p class="text-sm font-semibold" v-if="message.sender !== 'Você'">{{ message.sender }}</p>
                    <p>{{ message.text }}</p>
                    <p class="text-xs font-semibold text-yellow-300 text-right">{{ message.timestamp }}</p>
                    <div :class="[message.sender === 'Você' ? 'arrow-right' : 'arrow-left']"></div>
                </div>
            </div>

            <!-- Message Input -->
            <div class="p-4 bg-white border-t border-gray-300 flex items-center gap-2">
                <InputText v-model="newMessage" placeholder="Digite sua mensagem..." class="flex-1" @keyup.enter="sendMessage" />
                <Button icon="pi pi-send" @click="sendMessage" class="p-button-primary" />
            </div>
        </div>
    </div>

    <!-- Modal for Mobile -->
    <Dialog v-model:visible="isModalOpen" :modal="true" :style="{ width: '90vw' }" :breakpoints="{ '960px': '75vw', '640px': '100vw' }">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-gray-800 font-semibold">{{ selectedContact.name }}</h2>
                <Button icon="pi pi-times" @click="isModalOpen = false" class="p-button-text" />
            </div>
        </template>
        <div id="chat-area" class="flex-1 overflow-y-auto p-4 bg-gray-50">
            <div v-for="message in messages" :key="message.id" :class="[message.sender === 'Você' ? 'self-end bg-blue-500 text-white' : 'self-start bg-green-500 text-white', 'rounded-lg p-3 mb-2 max-w-xs relative']">
                <p class="text-sm font-semibold" v-if="message.sender !== 'Você'">{{ message.sender }}</p>
                <p>{{ message.text }}</p>
                <p class="text-xs font-semibold text-yellow-300 text-right">{{ message.timestamp }}</p>
            </div>
        </div>
        <template #footer>
            <div class="p-4 bg-white border-t border-gray-300 flex items-center gap-2 w-full">
                <InputText v-model="newMessage" placeholder="Digite sua mensagem..." class="flex-1" @keyup.enter="sendMessage" />
                <Button icon="pi pi-send" @click="sendMessage" class="p-button-primary" />
            </div>
        </template>
    </Dialog>
</template>

<style scoped>
.arrow-left {
    position: absolute;
    top: 10px;
    left: -10px;
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-right: 10px solid var(--primary-color); /* Cor da mensagem recebida */
}

.arrow-right {
    position: absolute;
    top: 10px;
    right: -10px;
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 10px solid var(--primary-color); /* Cor da mensagem enviada */
}

.self-end {
    align-self: flex-end;
    margin-left: auto; /* Alinha à direita */
}

.self-start {
    align-self: flex-start;
    margin-right: auto; /* Alinha à esquerda */
}

.bg-blue-500 {
    background-color: var(--primary-color); /* Cor da mensagem enviada */
}

.bg-green-500 {
    background-color: var(--primary-color); /* Cor da mensagem recebida */
}

.text-white {
    color: #fff;
}

.text-yellow-300 {
    color: #000;
}

.rounded-lg {
    border-radius: 0.5rem;
}

.p-3 {
    padding: 0.75rem;
}

.mb-2 {
    margin-bottom: 0.5rem;
}

.max-w-xs {
    max-width: 20rem;
}

.relative {
    position: relative;
}
</style>
