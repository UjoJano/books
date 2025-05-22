<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed, watch } from 'vue'

const props = defineProps({
    book: Object,
    authors: Array
})

const emit = defineEmits(['close'])

const form = useForm({
    title: '',
    author_id: '',
    is_borrowed: false
})

watch(() => props.book, (book) => {
    if (book) {
        form.title = book.title
        form.author_id = book.author.id
        form.is_borrowed = Boolean(book.is_borrowed)
        form.clearErrors()
    }
})

const isFormValid = computed(() =>
    form.title.trim() !== '' && form.author_id !== ''
)

function submit() {
    if (!props.book) return

    form.put(route('books.update', props.book.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('close')
            form.reset()
        }
    })
}

function close() {
    emit('close')
    form.reset()
}
</script>

<template>
    <Teleport to="body">
        <div v-if="book" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="submit">
                        <div class="modal-header">
                            <h5 class="modal-title">Upraviť knihu</h5>
                            <button type="button" class="btn-close" @click="close" :disabled="form.processing"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    Názov knihy <span class="text-danger">*</span>
                                </label>
                                <input v-model.trim="form.title" type="text" class="form-control" :class="{ 'is-invalid': form.errors.title }" />
                                <div class="invalid-feedback">{{ form.errors.title }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Autor <span class="text-danger">*</span>
                                </label>
                                <select v-model="form.author_id" class="form-select" :class="{ 'is-invalid': form.errors.author_id }">
                                    <option value="">-- Vyber autora --</option>
                                    <option v-for="author in authors" :value="author.id" :key="author.id">
                                        {{ author.name }} {{ author.surname }}
                                    </option>
                                </select>
                                <div class="invalid-feedback">{{ form.errors.author_id }}</div>
                            </div>

                            <div class="form-check mb-3">
                                <input v-model="form.is_borrowed" class="form-check-input" type="checkbox" id="isBorrowedEdit" />
                                <label class="form-check-label" for="isBorrowedEdit">
                                    Kniha je požičaná
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="close" :disabled="form.processing">Zavrieť</button>
                            <button type="submit" class="btn btn-primary" :disabled="!isFormValid || form.processing">
                                <span v-if="form.processing" class="spinner-border spinner-border-sm me-1" role="status"></span>
                                <span v-if="form.processing">Ukladám...</span>
                                <span v-else>Uložiť</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Teleport>
</template>
