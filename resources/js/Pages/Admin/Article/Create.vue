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
            article: {
                category_id: null,
            }
        }
    },

    methods: {
        storeArticle() {
            console.log("Отправляем статью:", this.article);
            axios.post(route('admin.articles.store'), this.article)
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
            :href="route('admin.articles.index')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            ← Назад
        </Link>
        <div class="mt-10"></div>
    </div>
    <div>
        <div class="mb-4">
            <input
                v-model="article.title"
                type="text"
                placeholder="title"
                class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
            >
        </div>
        <div class="mb-4">
            <textarea
                v-model="article.content"
                placeholder="content"
                class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2"
            ></textarea>
        </div>
        <div class="mb-4">
            <select
                v-model="article.category_id"
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
            <a @click.prevent="storeArticle" href="#" class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"> Создать </a>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
