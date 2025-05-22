<script setup>
import { Link } from '@inertiajs/vue3'
import FlashMessage from "@/Components/Organism/FlashMessage.vue";
</script>

<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">Požičovňa kníh</a>
                <div>
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('authors.index')">Autori</Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('books.index')">Knihy</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container py-4">
            <FlashMessage />
            <slot />
        </main>
    </div>
</template>
