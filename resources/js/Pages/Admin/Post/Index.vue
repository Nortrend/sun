<template>
    <div>
        <div>
            <Link
                :href="route('admin.posts.create')"
                class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
            >
                Добавить
            </Link>
        </div>

        <div class="mt-10"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <input
                v-model="filter.title"
                type="text"
                placeholder="title"
                class="w-full bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md p-2"
            >

            <input
                v-model="filter.views_from"
                type="number"
                placeholder="views"
                class="w-full bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md p-2"
            >

            <input
                v-model="filter.published_at_from"
                type="date"
                placeholder="published at"
                class="w-full bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md p-2"
            >
        </div>

        <div class="mt-10">
            <div
                v-for="post in postsData.data"
                :key="post.id"
                class="mb-4 pb-4 border-b border-gray-200 rounded-lg shadow-sm"
            >
                <div class="flex justify-between items-center">
                    <Link :href="route('admin.posts.show', post.id)">
                        {{ post.title }}
                    </Link>
                    <div class="flex items-center gap-4">
                        <a
                            @click.prevent="deletePost(post)"
                            href="#"
                            class="text-red-400 hover:text-red-600"
                        >
                            Удалить
                        </a>
                        <Link
                            :href="route('admin.posts.edit', post.id)"
                            class="text-blue-400 hover:text-blue-600"
                        >
                            Редактировать
                        </Link>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-2">
            <a
                v-for="(page, index) in postsData.meta.links"
                :key="index"
                :href="page.url || '#'"
                v-html="page.label"
                @click.prevent="filter.page = page.label"
                :class="[
            'px-3 py-1 rounded-md text-sm transition',
            page.active
                ? 'bg-blue-600 text-white font-semibold'
                : 'bg-gray-700 text-white hover:bg-gray-600',
            !page.url && 'opacity-50 cursor-not-allowed pointer-events-none'
        ]"
            />
        </div>

    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import debounce from 'lodash/debounce';

export default {
    name: "Index",
    layout: AdminLayout,

    props: {
        posts: Object,
    },

    components: {
        Link,
    },

    data() {
        return {
            filter: {
                title: '',
                views_from: '',
                published_at_from: '',
            },
            postsData: this.posts,
        };
    },

    watch: {
        filter: {
            handler: debounce(function () {
                this.getPosts();
            }, 400),
            deep: true,
        }
    },

    methods: {
        getPosts() {
            axios.get(route('admin.posts.index'), {
                params: this.filter
            })
                .then(res => {
                    this.postsData = res.data;
                })
        },

        deletePost(post) {
            axios.delete(route('admin.posts.destroy', post.id))
                .then(() => {
                    this.getPosts()
                })
        }


    },
};
</script>


<style scoped></style>
