<script>
import ClientLayout from "@/Layouts/ClientLayout.vue";
import {Link} from "@inertiajs/vue3";
import CommentTree from "@/Components/CommentTree.vue";

export default {
    name: "Index",

    components: {Link,
        CommentTree},

    layout: ClientLayout,

    mounted() {
        this.getComments()
    },

    data () {
        return {
            comment: {},
            comments: [],
        }
    },

    props: {
        post: Object,
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
        },

        storeComment() {
            axios.post(route('posts.comments.store', this.post.id), this.comment)
                .then(res => {
                    const newComment = res.data;

                    // если комментарий без родителя — просто вставляем в корень
                    if (!newComment.parent_id) {
                        this.comments.unshift(newComment);
                    } else {
                        // если с parent_id — передаём его вниз в CommentTree
                        this.addReplyToTree({ parentId: newComment.parent_id, comment: newComment });
                    }

                    this.comment.content = '';
                });
        },

        getComments() {
            axios.get(route('posts.comments.index', this.post.id))
                .then( res => {
                    this.comments = res.data;
                })
        },

        addReplyToTree({ parentId, comment }) {
            const target = this.findCommentById(this.comments, parentId);
            if (target) {
                if (!target.children) target.children = [];
                target.children.unshift(comment);
            }
        },

        findCommentById(comments, id) {
            for (let comment of comments) {
                if (comment.id === id) return comment;
                if (comment.children) {
                    const result = this.findCommentById(comment.children, id);
                    if (result) return result;
                }
            }
            return null;
        }

    }

}
</script>

<template>

    <div>
        <div class="mt-10">
            <div
                class="mb-6 p-5 border rounded-2xl shadow-sm bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 transition-colors"
            >
                <div class="flex flex-col gap-2">
                    <!-- Заголовок -->
                    <p
                        class="text-xl font-semibold text-indigo-600 hover:underline dark:text-indigo-400"
                    >
                        {{ post.title }}
                    </p>

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
            <div
                class="mb-6 p-5 border rounded-2xl shadow-sm bg-white border-gray-200 dark:bg-gray-800 dark:border-gray-700 transition-colors"
            >
                <div
                class="mb-4"
                >
                    <textarea
                        v-model="comment.content"
                        class="bg-gray-800 text-white placeholder-gray-400 border border-gray-600 focus:ring focus:ring-blue-500 focus:border-blue-500 rounded-md w-full px-4 py-2 resize-none"
                        placeholder="Введите комментарий..."
                    >
                    </textarea>
                </div>
                <div>
                    <a
                        @click.prevent="storeComment"
                        href="#"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Отправить
                    </a>
                </div>
            </div>
            <CommentTree :comments="comments" @reply-added="addReplyToTree" />


        </div>
    </div>
</template>

<style scoped>

</style>
