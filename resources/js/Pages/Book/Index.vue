<script setup>
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Pagination from '@/Components/Molecule/Pagination.vue'
import SortIcon from '@/Components/Molecule/SortIcon.vue'
import ModalBookCreate from '@/Components/Organism/ModalBookCreate.vue'
import ModalConfirmDelete from "@/Components/Organism/ModalConfirmDelete.vue";
import ModalBookEdit from "@/Components/Organism/ModalBookEdit.vue";

defineOptions({ layout: MainLayout })

const props = defineProps({
    books: Object,
    filters: Object,
    sort: Object,
    authors: Array
})

const filters = reactive({
    title: props.filters.title || '',
    author_id: props.filters.author_id || '',
    is_borrowed: props.filters.is_borrowed ?? ''
})

const sortState = reactive({
    sort_by: props.sort.sort_by || 'id',
    sort_dir: props.sort.sort_dir || 'desc'
})

function filterBooks() {
    router.get(route('books.index'), {
        ...filters,
        sort_by: sortState.sort_by,
        sort_dir: sortState.sort_dir
    }, {
        preserveState: true,
        preserveScroll: true
    })
}

function resetFilters() {
    filters.title = ''
    filters.author_id = ''
    filters.is_borrowed = ''
    filterBooks()
}

function sort(field) {
    if (sortState.sort_by === field) {
        sortState.sort_dir = sortState.sort_dir === 'asc' ? 'desc' : 'asc'
    } else {
        sortState.sort_by = field
        sortState.sort_dir = 'asc'
    }
    filterBooks()
}

const showModal = ref(false)
const editingBook = ref(null)
const deletingBook = ref(null)
function openModal() {
    showModal.value = true
}

function openEditModal(book) {
    editingBook.value = book
}

function openDeleteModal(book) {
    deletingBook.value = book
}

function toggleBorrowed(id) {
    router.patch(route('books.toggle', id), {}, {
        preserveScroll: true,
    })
}
</script>

<template>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Zoznam kníh</h1>
            <button class="btn btn-success" @click="openModal">+ Pridať knihu</button>
        </div>

        <form @submit.prevent="filterBooks" class="row g-3 mb-3">
            <div class="col-md-4">
                <input v-model="filters.title" class="form-control" placeholder="Názov knihy" />
            </div>
            <div class="col-md-4">
                <select v-model="filters.author_id" class="form-select">
                    <option value="">-- Všetci autori --</option>
                    <option v-for="author in authors" :value="author.id" :key="author.id">
                        {{ author.name }} {{ author.surname }}
                    </option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <select v-model="filters.is_borrowed" class="form-select">
                    <option value="">-- Stav --</option>
                    <option value="1">Požičaná</option>
                    <option value="0">Dostupná</option>
                </select>
                <button type="submit" class="btn btn-primary">Filtrovať</button>
                <button type="button" class="btn btn-outline-secondary" @click="resetFilters">Reset</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                <tr>
                    <th @click="sort('title')" class="cursor-pointer">Názov <SortIcon :field="'title'" :sort="sortState" /></th>
                    <th>Autor</th>
                    <th @click="sort('is_borrowed')" class="cursor-pointer">Stav <SortIcon :field="'is_borrowed'" :sort="sortState" /></th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <tr v-for="book in books.data" :key="book.id">
                    <td>{{ book.title }}</td>
                    <td>{{ book.author.name }} {{ book.author.surname }}</td>
                    <td>
                      <span :class="book.is_borrowed ? 'text-danger' : 'text-success'">
                        {{ book.is_borrowed ? 'Požičaná' : 'Dostupná' }}
                      </span>
                        <i class="bi bi-arrow-repeat fs-5 text-muted ms-2" style="cursor: pointer;" @click="toggleBorrowed(book.id)"></i>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning" @click="openEditModal(book)">Upraviť</button>
                            <button class="btn btn-sm btn-danger" @click="openDeleteModal(book)">Vymazať</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <Pagination :links="books.links" />

        <ModalBookCreate :show="showModal" :authors="authors" @close="showModal = false" />
        <ModalBookEdit :book="editingBook" :authors="authors" @close="editingBook = null" />
        <ModalConfirmDelete
            :model="deletingBook"
            routeName="books.destroy"
            title="Vymazanie knihy"
            :description="`Chceš naozaj vymazať knihu s názvom '${deletingBook?.title}'?`"
            @close="deletingBook = null"
        />
    </div>
</template>
