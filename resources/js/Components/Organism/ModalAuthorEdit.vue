<template>
    <Teleport to="body">
        <div v-if="author" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="submit">
                        <div class="modal-header">
                            <h5 class="modal-title">Upraviť autora</h5>
                            <button type="button" class="btn-close" @click="close" :disabled="form.processing"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">
                                    Meno <span class="text-danger">*</span>
                                </label>
                                <input type="text" v-model.trim="form.name" class="form-control" :class="{ 'is-invalid': form.errors.name }">
                                <div class="invalid-feedback">{{ form.errors.name }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">
                                    Priezvisko <span class="text-danger">*</span>
                                </label>
                                <input type="text" v-model.trim="form.surname" class="form-control" :class="{ 'is-invalid': form.errors.surname }">
                                <div class="invalid-feedback">{{ form.errors.surname }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="close" :disabled="form.processing">Zavrieť</button>
                            <button type="submit" class="btn btn-primary" :disabled="!isFormValid || form.processing">
                                <span v-if="form.processing" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
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

<script setup>
import { computed, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    author: Object
})

const emit = defineEmits(['close'])

const form = useForm({
    name: '',
    surname: ''
})

watch(() => props.author, (author) => {
    if (author) {
        form.name = author.name
        form.surname = author.surname
        form.clearErrors()
    }
})

const isFormValid = computed(() => form.name.trim() !== '' && form.surname.trim() !== '')

function submit() {
    if (!props.author) return

    form.put(route('authors.update', props.author.id), {
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
