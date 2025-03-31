<template>
    <div>
        <div>
            <Link
                :href="route('admin.articles.index')"
                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
            >
                ← Назад
            </Link>
            <div class="mt-10"></div>
        </div>

        <form @submit.prevent="submit">
            <div class="mb-4">
                <label class="block font-medium mb-1">Имя профиля</label>
                <input
                    v-model="form.name"
                    type="text"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"

                />
                <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
            </div>

            <div class="mb-4 relative">
                <label class="block font-medium mb-1">Пользователь (email)</label>
                <input
                    v-model="search"
                    @input="fetchUsers"
                    type="text"
                    placeholder="Введите email"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"

                />
                <ul
                    v-if="search.length > 1 && filteredUsers.length > 0"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                >
                    <li
                        v-for="user in filteredUsers"
                        :key="user.id"
                        @click="selectUser(user)"
                        class="bg-gray-800 cursor-pointer text-white placeholder-gray-400 border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"


                    >
                        {{ user.email }}
                    </li>
                </ul>
                <div v-if="form.errors.user_id" class="text-red-500 text-sm">{{ form.errors.user_id }}</div>
            </div>

            <button
                type="submit"
                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block">
                Создать</button>
        </form>
    </div>
</template>

<script>
import {Link, useForm} from '@inertiajs/vue3'
import axios from 'axios'
import AdminLayout from "@/Layouts/AdminLayout.vue";


export default {
    components: {Link},
    data() {
        return {
            form: useForm({
                name: '',
                user_id: '',
            }),
            search: '',
            filteredUsers: []
        }
    },

    layout: AdminLayout,

    methods: {
        fetchUsers() {
            if (this.search.length < 2) {
                this.filteredUsers = []
                return
            }

            axios.get('/admin/users/list', {
                params: { search: this.search }
            }).then(response => {
                this.filteredUsers = response.data
            })
        },

        selectUser(user) {
            this.form.user_id = user.id
            this.search = user.email
            this.filteredUsers = [] // скрываем список
        },

        submit() {
            this.form.post('/admin/profiles')
        }
    }
}
</script>
