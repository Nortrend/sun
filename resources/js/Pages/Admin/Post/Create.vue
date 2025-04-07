<template>
    <div>
        <h1 class="text-xl font-bold mb-4">Создать пост</h1>
        <form @submit.prevent="submit">
            <div class="mb-4">
                <label class="block">Заголовок</label>
                <input v-model="form.title" type="text" class="w-full" />
            </div>

            <div class="mb-4">
                <label class="block">Контент</label>
                <textarea v-model="form.content" class="w-full"></textarea>
            </div>

            <div class="mb-4">
                <label class="block">Категория</label>
                <select v-model="form.category_id" class="w-full">
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block">Дата публикации</label>
                <input v-model="form.published_at" type="datetime-local" class="w-full" />
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

export default {
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
