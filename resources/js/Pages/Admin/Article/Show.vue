<template>
    <div>
            <div class="relative">
                <h2>{{ article.title }}</h2>
                <p>{{ article.content }}</p>
                Автор:
                <Link :href="route('admin.profiles.show', article.profile?.id)" class="text-sm text-gray-500 mt-4 hover:underline">
                    {{ article.profile?.name ?? 'Неизвестный' }}
                </Link>
        </div>
        <div class="mt-6">
            <Link
                :href="route('admin.articles.index')"
                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md">
                ← Назад
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {

    name: "Show",

    props: {
        article: Object,
    },

    components: {
        Link,
    },

    layout: AdminLayout,
};
</script>

<style scoped></style>
