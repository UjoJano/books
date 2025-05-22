<script setup>
import { usePage } from '@inertiajs/vue3'
import { ref, watchEffect } from 'vue'

const page = usePage()
const message = ref(null)

watchEffect(() => {
    message.value = page.props.flash?.success || null

    if (message.value) {
        setTimeout(() => message.value = null, 3000)
    }
})
</script>

<template>
    <div v-if="message" class="alert alert-success position-fixed top-0 end-0 m-4 shadow" style="z-index: 9999;">
        {{ message }}
    </div>
</template>
