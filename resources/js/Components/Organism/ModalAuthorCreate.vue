<template>
    <Teleport to="body">
        <div v-if="show" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form @submit.prevent="submit">
                        <div class="modal-header">
                            <h5 class="modal-title">Pridať autora</h5>
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
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ show: Boolean })
const emit = defineEmits(['close'])

const form = useForm({
    name: '',
    surname: ''
})

const isFormValid = computed(() => form.name.trim().length > 0 && form.surname.trim().length > 0)

function submit() {
    if (!isFormValid.value) return

    form.post(route('authors.store'), {
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
