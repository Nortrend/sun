<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Создание комментария</h1>

        <form @submit.prevent="submit" class="space-y-6 max-w-xl">
            <div>
                <label for="content" class="block text-sm font-medium text-gray-300 mb-1">Текст комментария</label>
                <textarea
                    v-model="form.content"
                    id="content"
                    name="comment_content"
                    placeholder="Введите комментарий"
                    class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
                />
                <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">{{ form.errors.content }}</div>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Выберите сущность</label>
                <select
                    v-model="form.commentable_id"
                    :disabled="!!form.parent_id"
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600">
                    <option value="">-- Выберите --</option>
                    <option
                        v-for="item in commentables"

                        :key="item.type + '-' + item.id"
                        :value="item.id"
                    >
                        {{ item.type === 'Post' ? 'Пост' : 'Статья' }} - {{ item.title }}
                    </option>
                </select>
            </div>


            <div>
                <label for="parent_id" class="block text-sm font-medium text-gray-300 mb-1">Ответ на комментарий</label>
                <select
                    v-model="form.parent_id"
                    :disabled="!!form.commentable_id"
                    id="parent_id"
                    class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600"
                >
                    <option :value="null">-- Без родителя --</option>
                    <option
                        v-for="comment in comments"
                        :key="comment.id"
                        :value="comment.id"
                    >
                        #{{ comment.id }} — {{ comment.content.slice(0, 50) }}...
                    </option>
                </select>
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
    data() {
        return {
            form: useForm({
                content: '',
                commentable_type: '',
                commentable_id: '',
                parent_id: null
            })
        };
    },

    props: {
        types: Array,
        commentables: Array,
        comments: Array,
    },

    computed: {
        filteredCommentables() {
            if (!this.form.commentable_type) return [];
            return this.commentables
                .filter(item => item.type === this.form.commentable_type)
                .map(item => ({
                    id: item.id,
                    label: `${item.title} (ID: ${item.id})`,
                }));
        },
    },

    methods: {
        submit() {
            this.form.post(route('admin.comments.store'));
        }
    },

    components: {
        Link,
    },

    layout: AdminLayout,
};
</script>
