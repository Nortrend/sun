<template>
    <div>
        <FlashMessage />

        <div class="mb-4">
            <Link
                :href="route('admin.role_users.create')"
                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
            >
                Добавить
            </Link>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-white text-sm">
                <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="border border-white px-4 py-2 text-left">Пользователь</th>
                    <th class="border border-white px-4 py-2 text-left">Роль</th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="item in rolesUsers"
                    :key="item.id"
                    class="hover:bg-gray-800"
                >
                    <td class="border border-white px-4 py-2">
                        {{ item.user?.data?.login ?? item.user?.data?.email ?? 'ID ' + item.user?.data?.id }}
                    </td>
                    <td class="border border-white px-4 py-2">
                        {{ item.role?.data?.title ?? '—' }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import FlashMessage from '@/Components/FlashMessage.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

export default {
    components: {
        Link,
        FlashMessage
    },
    layout: AdminLayout,
    props: {
        rolesUsers: {
            type: Array,
            required: true
        }
    }
}
</script>
