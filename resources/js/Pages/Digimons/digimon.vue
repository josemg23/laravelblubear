<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import VueTailwindPagination from '@ocrv/vue-tailwind-pagination'
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import '@ocrv/vue-tailwind-pagination/styles'
import axios from 'axios';

const nameInput = ref(null);
const modal = ref(false);
const image = ref('');
const detalle = ref({});


const props = defineProps({
    digimonslist: { type: Object },
    paginacion: { type: Object },
    detalle: { type: Object },
})

const formPage = useForm({});
const onPageClik = (event) => {
    formPage.get(route('digimon.view', { page: event }))
}

const openModal = async (item) => {

    if (nameInput.value) {
        nextTick(() => nameInput.value.focus());
    }
    modal.value = true;
    image.value = item.image;
    detalle.value = await getData(item.id);

};

const getData = async (id) => {
    const response = await axios.get(route('digimons.detail.list', { id }));
    // const response = await axios.get(`https://www.digi-api.com/api/v1/digimon/` + id);
    return response.data
};

const closeModal = () => {
    modal.value = false;
};
</script>
<template>

    <Head title="Digimons" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Digimons</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white grid v-screen place-items-center">
                    <div class="p-6 text-gray-900">
                        <div class="rejilla-digimon grid gap-4">
                            <div v-for="(item, i) in digimonslist" :key="i"
                                class="tarjeta-digimon bg-white rounded-lg shadow-md overflow-hidden sm:w-full md:w-1/2 lg:w-1/3">
                                <img :src="item.image" alt="Imagen" @click="$event => openModal(item)"
                                    class="w-full h-48 object-cover" />
                                <div class="nombre-digimon px-4 py-2 text-center text-lg font-bold text-gray-800">
                                    {{ item.name }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex justify-center items-center gap-2">
                            <VueTailwindPagination :current="paginacion.currentPage" :total="paginacion.totalPages"
                                :per-page="paginacion.elementsOnPage" @page-changed="onPageClik($event)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <div class="flex flex-col items-center p-3 bg-white rounded shadow-md max-w-2xl sm:w-full">
                <h2 class="p-3 text-lg font.mediun text-hray-900">{{ detalle.id }}</h2>
                <h2 class="p-3 text-lg font.mediun text-hray-900">{{ detalle.name }}</h2>
                <div class="w-full flex flex-col items-center">
                    <img :src="image" alt="Imagen" style="width:200px; height:200px" class="w-full h-48 object-cover" />
                </div>
                <div class="flex flex-wrap justify-center gap-0">
                    <div class="w-full md:w-1/2 text-center">
                        <h3 class="p-3 text-lg font.mediun text-hray-900">Level</h3>
                        <div v-for="(value, i) in detalle.levels" :key="i">
                            <p class="text-sm mb-0">{{ value.level }}</p>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 text-center">
                        <h3 class="p-3 text-lg font.mediun text-hray-900">Attribute</h3>
                        <div v-for="(value, i) in detalle.attributes" :key="i">
                            <p class="text-sm mb-0">{{ value.attribute }}</p>
                        </div>
                        <br />
                    </div>
                    <div class="w-full md:w-1/2 text-center">
                        <h3 class="p-3 text-lg font.mediun text-hray-900">Type</h3>
                        <div v-for="(value, i) in detalle.types" :key="i">
                            <p class="text-sm mb-2">{{ value.type }}</p>
                        </div>
                    </div>

                    <div class="w-full text-center">
                        <h3 class="p-3 text-lg font.mediun text-hray-900">Fields</h3>
                        <div v-for="(value, i) in detalle.fields" :key="i">
                            <img :src="value.image" fluid alt="Responsive image"
                                class="mx-auto h-20 w-20 rounded-full" />
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
<style>
.content {
    /* Estilos para el contenido */
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 20px;
}

.rejilla-digimon {
    display: flex;
    flex-wrap: wrap;
    /* Permite que los items se acomoden en varias líneas si es necesario */
    justify-content: space-around;
    /* Distribuye los items uniformemente con algo de espacio */
}

.tarjeta-digimon {
    width: 200px;
    /* Ajusta el ancho como desees */
    text-align: justify;
    /* Centra el texto dentro de las tarjetas */
    margin: 10px;
    /* Agrega espacio entre tarjetas */
    border: 1px solid #ddd;
    /* Agrega un borde sutil para mejor separación */
    border-radius: 5px;
    /* Agrega esquinas redondeadas para una apariencia más atractiva */
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    /* Sombra sutil para profundidad */
}

.nombre-digimon {
    margin-top: 5px;
    /* Agrega espacio entre la imagen y el nombre */
    margin-bottom: 10px;
    /** agrega un espacio en la parte inferior */
    text-align: center;
    /** Centra los nombres de los items  */
}

.button-container {
    display: flex;
    /* Enable flexbox layout */
    justify-content: flex-end;
    /* Align items to the right */
}

.right-aligned-button {
    float: right;
    /* Float the button to the right */
}
</style>