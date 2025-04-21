<template>
    <div class="min-h-screen bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
        <!-- Header -->
        <header class="bg-gray-50 dark:bg-gray-800 shadow-md sticky top-0 z-50 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Laravel Sun</h1>

                <nav class="space-x-4">
                    <Link href="/dashboard" class="hover:text-indigo-400 transition">Home</Link>
                    <Link href="/about" class="hover:text-indigo-400 transition">About</Link>
                    <Link href="/contact" class="hover:text-indigo-400 transition">Contact</Link>
                </nav>

                <button
                    @click="toggleDarkMode"
                    class="ml-4 px-3 py-1 rounded text-sm border transition shadow hover:shadow-md
                 bg-white text-gray-800 border-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600"
                >
                    {{ isDarkMode ? '🌙 Dark' : '☀️ Light' }} Mode
                </button>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="border-t mt-10 bg-gray-50 text-gray-500 dark:bg-gray-800 dark:text-gray-400 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-sm">
                © {{ new Date().getFullYear() }} Laravel Sun. All rights reserved.
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const isDarkMode = ref(false)

function applyTheme(theme) {
    const html = document.documentElement
    if (theme === 'dark') {
        html.classList.add('dark')
        html.classList.remove('light')
        isDarkMode.value = true
    } else {
        html.classList.remove('dark')
        html.classList.add('light')
        isDarkMode.value = false
    }
}

function toggleDarkMode() {
    const newTheme = isDarkMode.value ? 'light' : 'dark'
    localStorage.setItem('theme', newTheme)
    applyTheme(newTheme)
}

onMounted(() => {
    const saved = localStorage.getItem('theme') || 'light'
    applyTheme(saved)
})
</script>



<style scoped>
</style>
