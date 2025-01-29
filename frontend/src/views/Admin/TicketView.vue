<script setup>
import { ref } from 'vue';

const events = ref([
    {
        status: 'Chamado Aberto',
        date: '15/10/2023 10:30',
        icon: 'pi pi-ticket',
        color: '#9C27B0',
        image: 'chamado-aberto.jpg',
        sender: 'João Silva',
        receiver: 'Maria Oliveira'
    },
    {
        status: 'Em Análise',
        date: '15/10/2023 14:00',
        icon: 'pi pi-search',
        color: '#673AB7',
        sender: 'Maria Oliveira',
        receiver: 'Carlos Souza'
    },
    {
        status: 'Em Resolução',
        date: '15/10/2023 16:15',
        icon: 'pi pi-cog',
        color: '#FF9800',
        sender: 'Carlos Souza',
        receiver: 'Ana Lima'
    },
    {
        status: 'Chamado Fechado',
        date: '16/10/2023 10:00',
        icon: 'pi pi-check',
        color: '#607D8B',
        sender: 'Ana Lima',
        receiver: 'João Silva'
    }
]);

const ticketInfo = ref({
    ticket: '12345',
    dataAbertura: '15/10/2023 10:30',
    criadoPor: 'João Silva',
    tipos: 'Incidente',
    status: 'Aberto',
    urgencia: 'Alta',
    origem: 'Email',
    impacto: 'Alto',
    prioridade: 'Alta',
    localizacao: 'São Paulo',
    aprovacao: 'Aprovado',
    requerente: 'João Silva',
    observador: 'Maria Oliveira',
    atribuidoPara: 'Carlos Souza'
});

const response = ref('');
const additionalInfo = ref('');
const newUrgency = ref(ticketInfo.value.urgencia);
const acceptCall = ref(false);
</script>

<template>
    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="card p-4">
                <div class="font-semibold text-xl mb-4">Informações do Chamado</div>
                <p><strong>Ticket:</strong> {{ ticketInfo.ticket }}</p>
                <p><strong>Data da Abertura:</strong> {{ ticketInfo.dataAbertura }}</p>
                <p><strong>Criado por:</strong> {{ ticketInfo.criadoPor }}</p>
                <p><strong>Tipos:</strong> {{ ticketInfo.tipos }}</p>
                <p><strong>Status:</strong> {{ ticketInfo.status }}</p>
                <p><strong>Urgência:</strong> {{ ticketInfo.urgencia }}</p>
                <p><strong>Origem:</strong> {{ ticketInfo.origem }}</p>
                <p><strong>Impacto:</strong> {{ ticketInfo.impacto }}</p>
                <p><strong>Prioridade:</strong> {{ ticketInfo.prioridade }}</p>
                <p><strong>Localização:</strong> {{ ticketInfo.localizacao }}</p>
                <p><strong>Aprovação:</strong> {{ ticketInfo.aprovacao }}</p>
                <p><strong>Requerente:</strong> {{ ticketInfo.requerente }}</p>
                <p><strong>Observador:</strong> {{ ticketInfo.observador }}</p>
                <p><strong>Atribuído para:</strong> {{ ticketInfo.atribuidoPara }}</p>
            </div>
            <div class="card p-4">
                <div class="font-semibold text-xl mb-4">Responder Chamado</div>
                <div class="flex flex-col gap-4">
                    <Textarea v-model="response" placeholder="Digite sua resposta" rows="5" cols="30" />
                    <InputText v-model="additionalInfo" placeholder="Informações adicionais" />
                    <div class="flex items-center gap-2">
                        <label for="acceptCall" class="mr-2">Aceitar Chamado:</label>
                        <Checkbox id="acceptCall" v-model="acceptCall" />
                    </div>
                    <div class="flex items-center gap-2">
                        <label for="newUrgency" class="mr-2">Modificar Urgência:</label>
                        <Dropdown id="newUrgency" v-model="newUrgency" :options="['Baixa', 'Média', 'Alta']" placeholder="Selecione a urgência" />
                    </div>
                    <Button label="Enviar Resposta" class="mt-2" />
                </div>
            </div>
        </div>
        <div class="card p-4">
            <div class="font-semibold text-xl mb-4">Chamados</div>
            <Timeline :value="events" align="alternate" class="customized-timeline">
                <template #marker="slotProps">
                    <span class="flex w-8 h-8 items-center justify-center text-white rounded-full z-10 shadow-sm" :style="{ backgroundColor: slotProps.item.color }">
                        <i :class="slotProps.item.icon"></i>
                    </span>
                </template>
                <template #content="slotProps">
                    <Card class="mt-4">
                        <template #title>
                            {{ slotProps.item.status }}
                        </template>
                        <template #subtitle>
                            {{ slotProps.item.date }}
                        </template>
                        <template #content>
                            <img v-if="slotProps.item.image" :src="`https://primefaces.org/cdn/primevue/images/product/${slotProps.item.image}`" :alt="slotProps.item.status" width="200" class="shadow-sm" />
                            <p>
                                <strong>Enviado por:</strong> {{ slotProps.item.sender }}<br />
                                <strong>Recebido por:</strong> {{ slotProps.item.receiver }}
                            </p>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore sed consequuntur error repudiandae numquam deserunt quisquam repellat libero asperiores earum nam nobis, culpa ratione quam perferendis esse,
                                cupiditate neque quas!
                            </p>
                            <Button label="Leia mais" text></Button>
                        </template>
                    </Card>
                </template>
            </Timeline>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@media screen and (max-width: 960px) {
    ::v-deep(.customized-timeline) {
        .p-timeline-event:nth-child(even) {
            flex-direction: row !important;

            .p-timeline-event-content {
                text-align: left !important;
            }
        }

        .p-timeline-event-opposite {
            flex: 0;
        }

        .p-card {
            margin-top: 1rem;
        }
    }
}
</style>
