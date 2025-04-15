<template>
    <div>

        <FlashMessage
            :flash="$page.props.flash"
        />

        <Link
            :href="route('admin.posts.index')"
            class="btn-back"
        >
            ← Назад
        </Link>

        <form
            @submit.prevent="submit"
            class="space-y-4 mt-6"
        >
            <!-- Заголовок -->
            <div>
                <label class="block">
                    Заголовок
                </label>
                <input
                    v-model="form.title"
                    type="text"
                    class="input"
                    :class="{ '!border-red-500 ring ring-red-300': form.errors.title }"

                />
                <div
                    v-if="form.errors.title"
                    class="text-red-500"
                >
                    {{ form.errors.title }}
                </div>
            </div>

            <!-- Контент -->
            <div>
                <label class="block">Контент</label>
                <input v-model="form.content" type="text" class="input" />
            </div>

            <!-- Категория -->
            <div>
                <label
                    class="block"
                >
                    Категория
                </label>

                <select
                    v-model="form.category_id"
                    class="input"
                    :class="{ '!border-red-500 ring ring-red-300': form.errors.category_id }"
                >
                    <option
                        :value="null"
                        disabled selected
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
                <div
                    v-if="form.errors.category_id"
                    class="text-red-500"
                >
                    {{ form.errors.category_id }}
                </div>
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
                <input
                    v-model="form.published_at"
                    type="datetime-local"
                    class="input"
                />
            </div>

            <!-- Изображение -->
            <div>
                <label class="block">Изображение</label>
                <input type="file" @change="onImageChange" class="input" />
            </div>

            <!-- Кнопка -->
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Создать
            </button>
        </form>
    </div>
</template>

<script>
import { useForm, Link } from '@inertiajs/vue3'
import FlashMessage from '@/Components/FlashMessage.vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import axios from 'axios'

export default {
    components: { FlashMessage, Link },
    props: {
        categories: Array,
        tags: Array
    },
    layout: AdminLayout,
    data() {
        return {
            tagSearch: '',
            selectedTags: [],
            filteredTags: [],
            form: useForm({
                title: '',
                content: '',
                category_id: null,
                published_at: null,
                image: null,
                tag_ids: []
            }),
            errors: {}
        }
    },
    methods: {
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
                } catch (e) {
                    alert('Ошибка при добавлении тега')
                }
            }

            this.tagSearch = ''
            this.filteredTags = []
        },
        removeTag(tag) {
            this.selectedTags = this.selectedTags.filter(t => t.id !== tag.id)
        },
        onImageChange(e) {
            this.form.image = e.target.files[0]
        },
        submit() {
            this.form.tag_ids = this.selectedTags.map(t => t.id)

            this.form.post(this.route('admin.posts.store'), {
                forceFormData: true,
                onSuccess: () => {
                    this.$inertia.reload({ only: ['flash'] })
                    this.selectedTags = []
                    this.tagSearch = ''
                }
            })
        }
    },
    watch: {
        'form.title'(value) {
            if (value) this.form.clearErrors('title')
        },
        'form.category_id'(value) {
            if (value) this.form.clearErrors('category_id')
        },
        // можешь добавить другие поля по аналогии:
        // 'form.content'(value) {
        //     if (value) this.form.clearErrors('content')
        // },
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
