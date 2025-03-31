<template>
    <div>
        <Link
            :href="route('admin.articles.create')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            Добавить
        </Link>
        <div class="mt-10"></div>
        <div>
            <div v-for="article in articles" :key="article.id" class="mb-4 pb-4 border-b border-gray-200 rounded-lg shadow-sm">
                <Link :href="route('admin.articles.show', article.id)">{{ article.title }}</Link>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {

    name: "Index",

    props: {
        articles: Array,
    },

    components: {
        Link,
    },

    layout: AdminLayout,
};
</script>

<style scoped></style>
