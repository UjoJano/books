<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    links: Array
})

function navigate(url) {
    if (url) router.visit(url, { preserveState: true, preserveScroll: true })
}
</script>

<template>
    <nav v-if="links.length > 3">
        <ul class="pagination">
            <li v-for="link in links" :key="link.label" class="page-item" :class="{ active: link.active, disabled: !link.url }">
                <a class="page-link" v-html="link.label" @click.prevent="navigate(link.url)" href="#"></a>
            </li>
        </ul>
    </nav>
</template>
