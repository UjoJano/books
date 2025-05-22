<script setup>
defineProps({
    field: String,
    sort: Object
})
</script>

<template>
  <span>
    <i v-if="sort.sort_by === field && sort.sort_dir === 'asc'" class="bi bi-chevron-up ms-1"></i>
    <i v-else-if="sort.sort_by === field && sort.sort_dir === 'desc'" class="bi bi-chevron-down ms-1"></i>
  </span>
</template>

