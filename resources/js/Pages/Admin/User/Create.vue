<template>
    <div>
        <Link
            :href="route('admin.users.index')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            ← Назад
        </Link>
        <div class="mt-10"></div>
        <form @submit.prevent="submit" autocomplete="off" class="space-y-6 max-w-xl">
            <div>
                <label for="login" class="block text-sm font-medium text-gray-300 mb-1">Логин</label>
                <input
                    v-model="form.login"
                    name="new_user_login"
                    autocomplete="off"
                    type="text"
                    id="login"
                    placeholder="login"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                />
                <div v-if="form.errors.login" class="text-red-500 text-sm mt-1">{{ form.errors.login }}</div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                <input
                    v-model="form.email"
                    name="new_user_email"
                    autocomplete="off"
                    type="email"
                    id="email"
                    placeholder="email"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                />
                <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Пароль</label>
                <input
                    v-model="form.password"
                    name="new_user_password"
                    autocomplete="new-password"
                    type="password"
                    id="password"
                    placeholder="password"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                />
                <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">{{ form.errors.password }}</div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-md shadow" :disabled="form.processing">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import {Link, useForm} from '@inertiajs/vue3';
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    components: {Link},
    layout: AdminLayout,
    data() {
        return {
            form: useForm({
                login: '',
                email: '',
                password: ''
            })
        };
    },
    methods: {
        submit() {
            this.form.post(route('admin.users.store'));
        }
    }
};
</script>
