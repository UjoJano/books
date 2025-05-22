<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    model: Object,
    routeName: String,
    title: String,
    description: String
})

const emit = defineEmits(['close'])

function confirmDelete() {
    router.delete(route(props.routeName, props.model.id), {
        onSuccess: () => {},
        onFinish: () => emit('close')
    })
}
</script>

<template>
    <Teleport to="body">
        <div v-if="model" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ title }}</h5>
                        <button type="button" class="btn-close" @click="$emit('close')"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ description }}</p>
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

