<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {

    name: "Create",

    props: {
        categories: Array,
    },

    data() {
        return {
            post: {
                category_id: null,
            }
        }
    },

    methods: {
        storePost() {
            console.log("Отправляем пост:", this.post);
            axios.post(route('admin.posts.store'), this.post)
                .then(res =>  {
                    console.log(res);
                })
                .catch(err => console.log(err));
        }
    },


    components: {
        Link,
    },

    layout: AdminLayout,
}
</script>

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
    <div>
        <div class="mb-4">
            <input
                v-model="post.title"
                type="text"
                placeholder="title"
                class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
            >
        </div>
        <div class="mb-4">
            <textarea
                v-model="post.content"
                placeholder="content"
                class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
            ></textarea>
        </div>
        <div class="mb-4">
            <input
                v-model="post.published_at"
                type="date"
                class="bg-gray-800 text-white border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
            >
        </div>
        <div class="mb-4">
            <select
                v-model="post.category_id"
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
            <a @click.prevent="storePost" href="#" class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"> Создать </a>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
