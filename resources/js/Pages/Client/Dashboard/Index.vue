<script>
import ClientLayout from "@/Layouts/ClientLayout.vue";
import {Link} from "@inertiajs/vue3";

export default {
    name: "Index",

    components: {Link},

    layout: ClientLayout,

    props: {
        posts: Array,
    },

    data() {
        return {
            postsData: this.posts,
        }
    },

    methods: {
        async toggleLike(post) {
            try {
                const response = await axios.post(route('client.posts.toggle-like', post.id));
                post.liked = response.data.liked;
                post.likes_count = response.data.likes_count;
            } catch (e) {
                console.error("Ошибка при переключении лайка", e);
            }
        }
    }

}
</script>

<template>

    <div>
        <div class="mt-10">
            <div
                v-for="post in posts"
                :key="post.id"
                class="mb-6 p-5 border rounded-2xl shadow-sm bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 transition-colors"
            >
                <div class="flex flex-col gap-2">
                    <!-- Заголовок -->
                    <Link
                        :href="route('posts.show', post.id)"
                        class="text-xl font-semibold text-indigo-600 hover:underline dark:text-indigo-400"
                    >
                        {{ post.title }}
                    </Link>

                    <!-- Контент -->
                    <p
                        v-if="post.content"
                        class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3"
                    >
                        {{ post.content }}
                    </p>

                    <!-- Изображение -->
                    <img
                        v-if="post.image_url"
                        :src="post.image_url"
                        alt=""
                        class="w-full h-auto max-h-[500px] object-contain"
                    />

                    <!-- Айди поста и его лайки. Вместе, что бы связать их и опустить вниз плашки -->
                    <div
                        class="flex justify-between items-center text-xs text-gray-400 dark:text-gray-500 mt-2"
                    >
                        <span>
                            ID: {{ post.id }}
                        </span>

                        <button
                            @click="toggleLike(post)"
                            class="text-lg px-2 py-1 rounded transition-all duration-200 flex items-center gap-1 group"
                        >
                            <span
                                :class="[ 'transition-transform duration-300',
                                post.liked ? 'text-red-500 scale-110' : 'text-gray-400 group-hover:scale-110'
                              ]"
                            >
                              <span
                                  v-if="post.liked"
                                  class="text-indigo-400"
                              >
                                  💜
                              </span>
                              <span
                                  v-else
                              >
                                  🤍
                              </span>
                            </span>
                            <span
                                class="text-sm text-gray-500 dark:text-gray-400 transition-opacity duration-200"
                            >
                              {{ post.likes_count }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
