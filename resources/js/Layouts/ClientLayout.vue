<template>
    <div class="min-h-screen bg-gray-50 text-gray-900">
        <header class="bg-white shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">MyApp</h1>
                <nav class="space-x-4">
                    <RouterLink to="/" class="hover:text-indigo-600 transition">Home</RouterLink>
                    <RouterLink to="/about" class="hover:text-indigo-600 transition">About</RouterLink>
                    <RouterLink to="/contact" class="hover:text-indigo-600 transition">Contact</RouterLink>
                </nav>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <RouterView />
        </main>

        <footer class="bg-white border-t mt-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm text-gray-500">
                © {{ new Date().getFullYear() }} MyApp. All rights reserved.
            </div>
        </footer>
    </div>
</template>

<script setup>
import { RouterView, RouterLink } from 'vue-router'
</script>

<style scoped>
</style>
