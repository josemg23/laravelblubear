<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import vueTailwindPaginationUmd from '@ocrv/vue-tailwind-pagination';
import { Head, useForm } from '@inertiajs/vue3';
import { nextTick, ref, onMounted } from 'vue';

const nameInput = ref(null);
const modal = ref(false);
const title = ref();
const id = ref('');

const props = defineProps({
    digimonslist: { type: Object },
    paginacion: { type: Object },
})

const formPage = useForm({});
const onPageClik = (event) => {
    formPage.get(route('digimon.view', { page: event }))
}

const openModal = (item) => {
    if (nameInput.value) {
        nextTick(() => nameInput.value.focus());
    }
    modal.value = true;
    id.value = item.ids;
    title.value = item.name;

};
const closeModal = () => {
    modal.value = false;
};

</script>
<script>
export default {
    data() {
        return {
            digimons: [],
        };
    },
    mounted() {
        this.getDigimonsList();
    },
    methods: {
        getDigimonsList() {
            let self = this;
            self.digimons = this.digimonslist.data;
        },

        selectItemsContratos(id) {
            const response = axios.get(this.form.get(route('digimons.detail.list', { id: id })));
            console.log(response);
        }
    },
}
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
                        <div class="rejilla-digimon grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div v-for="(item, i) in digimonslist" :key="i"
                                class="tarjeta-digimon bg-white rounded-lg shadow-md overflow-hidden">
                                <img :src="item.image" alt="Imagen" @click="openModal(item)"
                                    class="w-full h-48 object-cover" />
                                <div class="nombre-digimon px-4 py-2 text-center text-lg font-bold text-gray-800">
                                    {{ item.name }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="bg-white grid v-screen place-items-center">
                    <vueTailwindPaginationUmd :current="paginacion.currentPage" :total="paginacion.totalPages"
                        :per-page="paginacion.elementsOnPage" @page-changed="onPageClik($event)">
                    </vueTailwindPaginationUmd>
                </div>
            </div>
        </div>
        <Modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.mediun text-hray-900">{{ title }}</h2>
            <div class="col-md-12 text-center">
                <!-- <img :url="image" alt="Imagen" class="w-full h-48 object-cover" style="width:200px; height:200px" /> -->
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