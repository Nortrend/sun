<template>
    <div class="pl-4 border-l border-gray-300 mt-4" v-for="comment in comments" :key="comment.id">
        <p class="text-sm text-gray-100">{{ comment.content }}</p>
        <span class="text-xs text-gray-400">{{ comment.published_date }}</span>

        <div class="mt-1 mb-2 flex items-center gap-3">
            <a
                href="#"
                class="text-xs text-blue-400 hover:underline"
                @click.prevent="toggleReply(comment.id)"
            >
                Ответить
            </a>
            <button
                @click="toggleLike(comment)"
                class="text-xs text-indigo-500"
            >
                {{ comment.liked ? '💜' : '🤍' }} {{ comment.likes_count }}
            </button>
        </div>

        <!-- Форма ответа -->
        <div v-if="replyingToId === comment.id" class="mb-3">
            <textarea
                v-model="replyContent"
                class="w-full p-2 text-sm rounded bg-gray-700 border border-gray-600 text-white"
                placeholder="Введите ответ..."
            />
            <button
                @click="submitReply(comment.id)"
                class="mt-2 px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs"
            >
                Отправить
            </button>
        </div>

        <!-- Рекурсивный вызов для вложенных комментариев -->
        <CommentTree
            v-if="comment.children && comment.children.length"
            :comments="comment.children"
            @reply-added="onReplyAdded"
        />
    </div>
</template>

<script>
export default {
    name: "CommentTree",
    props: {
        comments: Array
    },

    data() {
        return {
            replyingToId: null,
            replyContent: ''
        }
    },

    methods: {
        toggleReply(id) {
            this.replyingToId = this.replyingToId === id ? null : id;
            this.replyContent = '';
        },

        async toggleLike(comment) {
            const response = await axios.post(route('client.comments.toggle-like', comment.id));
            comment.liked = response.data.liked;
            comment.likes_count = response.data.likes_count;
        },

        async submitReply(parentId) {
            try {
                const response = await axios.post(route('posts.comments.store', this.$page.props.post.id), {
                    content: this.replyContent,
                    parent_id: parentId
                });

                this.$emit('reply-added', {parentId, comment: response.data});

                this.replyingToId = null;
                this.replyContent = '';
            } catch (error) {
                console.error("Ошибка при отправке ответа", error);
            }
        },

        onReplyAdded({parentId, comment}) {
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
