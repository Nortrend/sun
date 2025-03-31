<template>
    <div>
        <h1 class="text-xl font-semibold mb-4">Комментарий</h1>
        <div class="mb-6">
            <p>
                {{ comment.content }}
            </p>
            Автор:
            <Link :href="route('admin.profiles.show', comment.profile?.id)" class="text-sm text-gray-500 mt-4 hover:underline">
                {{ comment.profile?.name ?? 'Неизвестный' }}
            </Link>
        </div>
        <div class="mt-6">
            <Link
                :href="route('admin.comments.index')"
                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md">
                ← Назад
            </Link>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {

    components: {
        Link
    },

    props: {
        comment: Object,
    },

    layout: AdminLayout,
}
</script>
