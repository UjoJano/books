<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({ author: Object })

function confirmDelete() {
    router.delete(route('authors.destroy', props.author.id), {
        onSuccess: () => {},
        onFinish: () => {
            emit('close')
        }
    })
}

const emit = defineEmits(['close'])
</script>

<template>
    <Teleport to="body">
        <div v-if="author" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Potvrdenie vymazania</h5>
                        <button type="button" class="btn-close" @click="$emit('close')"></button>
                    </div>
                    <div class="modal-body">
                        <p>Chceš naozaj vymazať autora <strong>{{ author.name }} {{ author.surname }}</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" @click="$emit('close')">Zrušiť</button>
                        <button class="btn btn-danger" @click="confirmDelete">Vymazať</button>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
