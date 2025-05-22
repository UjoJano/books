<script setup>
defineProps({
    field: String,
    sort: Object
})
</script>

<template>
  <span>
    <i v-if="sort.by === field && sort.dir === 'asc'" class="bi bi-chevron-up ms-1"></i>
    <i v-else-if="sort.by === field && sort.dir === 'desc'" class="bi bi-chevron-down ms-1"></i>
  </span>
</template>

