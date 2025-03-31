<template>
    <div>
        <h1>Profile Details</h1>
        <p><strong>Name:</strong> {{ profile.name }}</p>
        <div class="mt-6">
        <Link
            :href="route('admin.profiles.index')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md"
        >
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
        profile: Object,
    },
    components: {
        Link,
    },

    layout:AdminLayout
}
</script>
