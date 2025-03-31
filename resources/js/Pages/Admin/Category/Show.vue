<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Категория #{{ category.id }}</h1>

        <div class="bg-gray-800 text-white p-4 rounded shadow max-w-xl">
            <p class="mb-2">
                <span class="font-semibold">Название:</span> {{ category.title }}
            </p>
        </div>
        <div class="mt-6">
            <Link
                :href="route('admin.categories.index')"
                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md">
                ← Назад
            </Link>
        </div>
    </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";

export default {
    components: {Link},
    props: {
        category: Object
    },
    layout:AdminLayout
};
</script>
