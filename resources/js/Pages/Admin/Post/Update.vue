<template>
    <div>
        <FlashMessage :flash="$page.props.flash" />

        <Link :href="route('admin.posts.index')" class="btn-back">← Назад</Link>

        <form @submit.prevent="submit" class="space-y-4 mt-6">
            <!-- Заголовок -->
            <div>
                <label class="block">Заголовок</label>
                <input v-model="form.title" type="text" class="input" />
                <div v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</div>
            </div>

            <!-- Контент -->
            <div>
                <label class="block">Контент</label>
                <input v-model="form.content" type="text" class="input" />
            </div>

            <!-- Категория -->
            <div>
                <label class="block">Категория</label>
                <select v-model="form.category_id" class="input">
                    <option :value="null" disabled>Выберите категорию</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.title }}
                    </option>
                </select>
                <div v-if="form.errors.category_id" class="text-red-500">{{ form.errors.category_id }}</div>
            </div>

            <!-- Теги -->
            <div class="relative">
                <label class="block">Теги</label>
                <input
                    v-model="tagSearch"
                    @input="filterTags"
                    @keydown.enter.prevent="addTag(tagSearch)"
                    placeholder="Введите тег"
                    class="input"
                />

                <ul
                    v-if="filteredTags.length > 0 && tagSearch.length > 0"
                    class="absolute z-10 bg-gray-800 border border-gray-600 mt-1 rounded w-full max-h-40 overflow-y-auto"
                >
                    <li
                        v-for="tag in filteredTags"
                        :key="tag.id"
                        @click="addTag(tag.title)"
                        class="px-4 py-2 hover:bg-gray-700 cursor-pointer"
                    >
                        {{ tag.title }}
                    </li>
                </ul>

                <div class="flex gap-2 mt-2 flex-wrap">
        <span
            v-for="tag in selectedTags"
            :key="tag.id"
            class="bg-blue-700 text-white px-3 py-1 rounded flex items-center gap-1"
        >
            {{ tag.title }}
            <button @click="removeTag(tag)" class="text-white">&times;</button>
        </span>
                </div>
            </div>


            <!-- Дата публикации -->
            <div>
                <label class="block">Дата публикации</label>
                <input v-model="form.published_at" type="datetime-local" class="input" />
            </div>

            <!-- Текущее изображение -->
            <div v-if="post.image_url">
                <label class="block">Текущее изображение</label>
                <img :src="post.image_url" alt="Image" class="w-64 rounded border mb-2" />
            </div>

            <!-- Новое изображение -->
            <div>
                <label class="block">Загрузить новое изображение</label>
                <input type="file" @change="handleFileChange" class="input" />
            </div>

            <!-- Кнопка -->
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Обновить
            </button>
        </form>
    </div>
</template>

<script>
import { useForm, Link } from '@inertiajs/vue3'
import FlashMessage from '@/Components/FlashMessage.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

export default {
    components: { FlashMessage, Link },
    props: {
        post: Object,
        categories: Array,
        tags: Array
    },
    layout: AdminLayout,
    data() {
        return {
            tagSearch: '',
            selectedTags: [...(this.post.tags || [])],
            filteredTags: [],
            form: useForm({
                title: this.post.title ?? '',
                content: this.post.content ?? '',
                category_id: this.post.category?.id ?? null,
                published_at: this.post.published_at ?? '',
                tag_ids: this.post.tags?.map(t => t.id) ?? [],
                image: null,
            })
        }
    },

    methods: {
        handleFileChange(e) {
            this.form.image = e.target.files[0]
        },
        toggleTag(tagId) {
            if (this.form.tag_ids.includes(tagId)) {
                this.form.tag_ids = this.form.tag_ids.filter(id => id !== tagId)
            } else {
                this.form.tag_ids.push(tagId)
            }
        },

        filterTags() {
            const s = this.tagSearch.toLowerCase()
            this.filteredTags = this.tags.filter(
                tag => tag.title.toLowerCase().includes(s) &&
                    !this.selectedTags.find(t => t.id === tag.id)
            )
        },
        async addTag(title) {
            if (!title.trim()) return

            const existing = this.tags.find(t => t.title.toLowerCase() === title.toLowerCase())
            if (existing && !this.selectedTags.find(t => t.id === existing.id)) {
                this.selectedTags.push(existing)
            } else if (!existing) {
                try {
                    const { data } = await axios.post('/admin/tags', { title })
                    this.tags.push(data)
                    this.selectedTags.push(data)
                } catch {
                    alert('Ошибка при добавлении тега')
                }
            }

            this.tagSearch = ''
            this.filteredTags = []
        },
        removeTag(tag) {
            this.selectedTags = this.selectedTags.filter(t => t.id !== tag.id)
        },

        submit() {
            this.form.tag_ids = this.selectedTags.map(t => t.id)

            const data = new FormData()
            data.append('title', this.form.title || '')
            data.append('content', this.form.content || '')
            data.append('category_id', this.form.category_id || '')
            data.append('published_at', this.form.published_at || '')

            if (this.form.image) {
                data.append('image', this.form.image)
            }

            this.form.tag_ids.forEach((tagId, index) => {
                data.append(`tag_ids[${index}]`, tagId)
            })

            this.$inertia.post(this.route('admin.posts.update', this.post.id), data, {
                method: 'post', // Laravel сам определит, что это PUT
                headers: {
                    'X-HTTP-Method-Override': 'PUT'
                },
                onSuccess: () => {
                    this.$inertia.visit(this.route('admin.posts.show', this.post.id))
                }
            })
        }
    }
}
</script>

<style scoped>
.input {
    @apply bg-gray-800 text-white border border-gray-600 rounded-md px-4 py-2 w-full;
}
.btn-back {
    @apply px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block;
}
</style>
