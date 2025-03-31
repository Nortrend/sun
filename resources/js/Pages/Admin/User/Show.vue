<template>
    <div>
        <h1>User Details</h1>
        <p><strong>Login:</strong> {{ user.login }}</p>
        <p><strong>Email:</strong> {{ user.email }}</p>
        <div class="mt-6">
        <Link
            :href="route('admin.users.index')"
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
        user: Object,
    },
    components: {
        Link,
    },

    layout: AdminLayout,
}
</script>
