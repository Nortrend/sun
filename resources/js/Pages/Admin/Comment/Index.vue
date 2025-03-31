<template>
    <div>
        <Link
            :href="route('admin.comments.create')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            Добавить
        </Link>
        <div class="mt-10"></div>
        <ul>
            <li
                v-for="comment in comments"
                :key="comment.id"
                class="border-b py-2"
            >
                <Link :href="route('admin.comments.show', comment.id)">
                    Комментарий #{{ comment.id }}
                </Link>
            </li>
        </ul>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    components: {
        Head,
        Link
    },
    props: {
        comments: {
            type: Array,
            required: true
        }
    },
    layout:AdminLayout
}



</script>
