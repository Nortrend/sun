<template>
    <div>
        <FlashMessage />
        <Link
            :href="route('admin.roles.index')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            ← Назад
        </Link>
        <div class="mt-10"></div>

        <h1 class="text-2xl font-bold mb-6">Создание роли</h1>

        <form @submit.prevent="submit" class="space-y-6 max-w-xl">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-300 mb-1">Название</label>
                <input
                    v-model="form.title"
                    type="text"
                    id="title"
                    name="role_title"
                    placeholder="Введите название роли"
                    autocomplete="off"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                />
                <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-gray-700 text-white rounded-md shadow" :disabled="form.processing">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import {Link, useForm} from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    components: {Link, FlashMessage },
    data() {
        return {
            form: useForm({
                title: ''
            })
        };
    },
    methods: {
        submit() {
            this.form.post(this.route('admin.roles.store'), {
                onSuccess: () => {
                    this.$inertia.reload({ only: ['flash'] })
                }
            })
        }
    },
    layout:AdminLayout,
};
</script>
