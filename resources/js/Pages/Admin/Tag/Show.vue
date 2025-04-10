<template>
    <div class="p-6">
        <div class="bg-gray-800 text-white p-4 rounded shadow max-w-xl">
            <p class="mb-2">
                <span class="font-semibold">Название:</span> {{ tag.title }}
            </p>
        </div>
        <div class="mt-6">
            <Link
                :href="route('admin.tags.index')"
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
        tag: Object
    },
    layout:AdminLayout
};
</script>
