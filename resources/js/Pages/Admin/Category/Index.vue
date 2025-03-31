<template>
    <div>
        <FlashMessage v-if="$page.props.success" :message="$page.props.success" />
        <Link
            :href="route('admin.categories.create')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            Добавить
        </Link>
        <div class="mt-10"></div>
        <div v-for="category in categories" :key="category.id" class="mb-4 pb-4 border-b border-gray-200 rounded-lg shadow-sm">
            <Link :href="route('admin.categories.show', category.id)">{{ category.title }}</Link>
        </div>
    </div>
</template>

<script>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from '@inertiajs/vue3'

export default {
    props: {
        categories: Array
    },
    components: {
        FlashMessage,
        Link,
    },
    layout:AdminLayout
};
</script>
