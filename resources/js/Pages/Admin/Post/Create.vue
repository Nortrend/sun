<template>
    <div>
        <div>
            <Link
                :href="route('admin.posts.index')"
                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
            >
                ← Назад
            </Link>
            <div class="mt-10"></div>
        </div>
        <form @submit.prevent="submit">
            <div class="mb-4">
                <label class="block">Заголовок</label>
                <div class="mb-4">
                    <input
                        v-model="form.title"
                        type="text"
                        class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                    >
                </div>
            </div>
            <div class="mb-4">
                <label class="block">Контент</label>
                <div class="mb-4">
                    <input
                        v-model="form.content"
                        type="text"
                        class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                    >
                </div>
            </div>
            <label class="block">Категория</label>
            <div class="mb-4">
                <select
                    v-model="form.category_id"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                >
                    <option
                        :value="null" disabled selected
                    >
                        Выберите категорию
                    </option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.title }}
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Дата публикации</label>
                <input v-model="form.published_at" type="datetime-local" class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                />
            </div>

            <div class="mb-4">
                <label class="block">Изображение</label>
                <input type="file" @change="onImageChange" />
            </div>

            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import axios from 'axios'
import {Link} from "@inertiajs/vue3";


export default {
    components: {Link},
    layout: AdminLayout,
    props: {
        categories: Array,
    },
    data() {
        return {
            form: {
                title: '',
                content: '',
                category_id: null,
                published_at: '',
                tags: [],
            },
            imageFile: null,
        }
    },
    methods: {
        async submit() {
            const formData = new FormData()
            formData.append('title', this.form.title)
            formData.append('content', this.form.content)
            formData.append('category_id', this.form.category_id)
            formData.append('published_at', this.form.published_at)
            if (this.imageFile) {
                formData.append('image', this.imageFile)
            }

            this.form.tags.forEach(tag => {
                formData.append('tags[]', tag)
            })

            await axios.post(route('admin.posts.store'), formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
        },
        onImageChange(e) {
            this.imageFile = e.target.files[0]
        },
    },
}
</script>
