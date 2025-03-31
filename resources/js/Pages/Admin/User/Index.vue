<template>
    <div>
        <Link
            :href="route('admin.users.create')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            Добавить
        </Link>
        <div class="mt-10"></div>
        <div v-for="user in users" :key="user.id" class="mb-4 pb-4 border-b border-gray-200 rounded-lg shadow-sm">
            <Link :href="route('admin.users.show', user.id)">{{ user.login }}</Link>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Index",
    props: {
        users: Array,
    },
    components: {
        Link,
    },

    layout: AdminLayout,
}
</script>
