<script setup>
import { router, usePage } from '@inertiajs/vue3'
import {reactive, ref} from 'vue'
import Pagination from '@/Components/Molecule/Pagination.vue'
import SortIcon from '@/Components/Molecule/SortIcon.vue'
import MainLayout from '@/Layouts/MainLayout.vue'
import ModalAuthorCreate from "@/Components/Organism/ModalAuthorCreate.vue";
import ModalAuthorEdit from "@/Components/Organism/ModalAuthorEdit.vue";
import ModalConfirmDelete from "@/Components/Organism/ModalConfirmDelete.vue";
defineOptions({ layout: MainLayout })


const props = defineProps({
    authors: Object,
    filters: Object,
    sort: Object
})

const showModal = ref(false)
const editingAuthor = ref(null)
const deletingAuthor = ref(null)
const filters = reactive({
    name: props.filters.name || '',
    surname: props.filters.surname || ''
})

const sortState = reactive({
    by: props.sort.sort_by || 'id',
    dir: props.sort.sort_dir || 'desc'
})

function filterAuthors() {
    router.get(route('authors.index'), {
        ...filters,
        sort_by: sortState.by,
        sort_dir: sortState.dir
    }, {
        preserveState: true,
        preserveScroll: true
    })
}

function resetFilters() {
    filters.name = ''
    filters.surname = ''
    filterAuthors()
}

function sort(field) {
    if (sortState.by === field) {
        sortState.dir = sortState.dir === 'asc' ? 'desc' : 'asc'
    } else {
        sortState.by = field
        sortState.dir = 'asc'
    }
    filterAuthors()
}

function openModal() {
    showModal.value = true
}

function openEditModal(author) {
    editingAuthor.value = author
}

function openDeleteModal(author) {
    deletingAuthor.value = author
}

</script>

<template>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Zoznam autorov</h1>
            <button class="btn btn-success" @click="openModal">
                + Pridať autora
            </button>
        </div>

        <form @submit.prevent="filterAuthors" class="row g-3 mb-3">
            <div class="col-md-4">
                <input v-model="filters.name" type="text" class="form-control" placeholder="Meno" />
            </div>
            <div class="col-md-4">
                <input v-model="filters.surname" type="text" class="form-control" placeholder="Priezvisko" />
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">Filtrovať</button>
                <button type="button" class="btn btn-outline-secondary" @click="resetFilters">Reset</button>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                <tr>
                    <th @click="sort('name')" class="cursor-pointer">Meno <SortIcon :field="'name'" :sort="sort" /></th>
                    <th @click="sort('surname')" class="cursor-pointer">Priezvisko <SortIcon :field="'surname'" :sort="sort" /></th>
                    <th>Počet kníh</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="author in authors.data" :key="author.id">
                    <td>{{ author.name }}</td>
                    <td>{{ author.surname }}</td>
                    <td>{{ author.booksCount }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning" @click="openEditModal(author)">Upraviť</button>
                            <button class="btn btn-sm btn-danger" @click="openDeleteModal(author)">Vymazať</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <Pagination :links="authors.links" />
    </div>

    <ModalAuthorCreate :show="showModal" @close="showModal = false" />
    <ModalAuthorEdit :author="editingAuthor" @close="editingAuthor = null" />
    <ModalConfirmDelete :author="deletingAuthor" @close="deletingAuthor = null" />
</template>
