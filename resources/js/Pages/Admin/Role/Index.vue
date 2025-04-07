<template>
    <div>
        <Link
            :href="route('admin.roles.create')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            Добавить
        </Link>
        <div class="mt-10"></div>
        <div>
            <div v-for="role in roles" :key="role.id" class="mb-4 pb-4 border-b border-gray-200 rounded-lg shadow-sm">
                <Link :href="route('admin.roles.show', role.id)">{{ role.title }}</Link>
            </div>
        </div>
    </div>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from '@inertiajs/vue3'

export default {

    name: "Index",

    props: {
        roles: Array
    },
    components: {
        Link,
    },
    layout:AdminLayout
};
</script>
