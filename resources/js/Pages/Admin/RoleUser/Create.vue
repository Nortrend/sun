<template>
    <div>
        <Link
            :href="route('admin.role_users.index')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            ← Назад
        </Link>
        <div class="mt-10"></div>

        <form @submit.prevent="submit" class="space-y-6 max-w-xl">
            <!-- Пользователь -->
            <div>
                <label class="block mb-1 font-medium">Пользователь</label>
                <select v-model="form.user_id" class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600">
                    <option value="">-- Выберите пользователя --</option>
                    <option v-for="user in users" :key="user.id" :value="user.id">
                        {{ user.login ?? user.email ?? 'ID ' + user.id }}
                    </option>
                </select>
                <p v-if="form.errors.user_id" class="text-red-500 text-sm mt-1">{{ form.errors.user_id }}</p>
            </div>

            <!-- Роль -->
            <div>
                <label class="block mb-1 font-medium">Роль</label>
                <select v-model="form.role_id" class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600">
                    <option value="">-- Выберите роль --</option>
                    <option v-for="role in roles" :key="role.id" :value="role.id">
                        {{ role.title }}
                    </option>
                </select>
                <p v-if="form.errors.role_id" class="text-red-500 text-sm mt-1">{{ form.errors.role_id }}</p>
            </div>

            <!-- Кнопка -->
            <div>
                <button
                    type="submit"
                    class="px-4 py-2 bg-gray-700 text-white rounded-md shadow" :disabled="form.processing"
                >
                    Назначить
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import {Link, useForm} from '@inertiajs/vue3'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import FlashMessage from '@/Components/FlashMessage.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

export default {
    components: {
        Link,
        FlashMessage
    },
    layout: AdminLayout,
    props: {
        roles: Array
    },
    setup() {
        const users = ref([])

        const form = useForm({
            user_id: '',
            role_id: ''
        })

        const submit = () => {
            form.post(route('admin.role_users.store'))
        }

        onMounted(async () => {
            try {
                const { data } = await axios.get('/admin/users/list')
                users.value = data
            } catch (e) {
                console.error('Ошибка загрузки пользователей', e)
            }
        })

        return {
            users,
            form,
            submit
        }
    }
}
</script>
