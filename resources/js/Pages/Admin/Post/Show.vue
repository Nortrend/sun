<template>
    <div class="relative">
    <div>
        <h3>{{ post.title }}</h3>
    </div>
    <div>
        <img v-if="post.image_url" :src="post.image_url" alt="Post image" class="max-w-full h-auto mb-4 rounded-lg shadow">
    </div>
    <div>
        <p>{{ post.content }}</p>
    </div>
        Автор:
        <Link :href="route('admin.profiles.show', post.profile?.id)" class="text-sm text-gray-500 mt-4 hover:underline">
            {{ post.profile?.name ?? 'Неизвестный' }}
        </Link>
    <div>
        <Link
            :href="route('admin.posts.index')"
            class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 transition shadow-md mt-4 inline-block"
        >
            ← Назад
        </Link>
    </div>
        <div class="absolute bottom-0 right-0 mb-4 mr-4 flex items-center">
            <button @click="toggleLike" class="text-2xl focus:outline-none">
                <span v-if="liked">&#9829;</span>
                <span v-else>&#9825;</span>
            </button>
            <span class="ml-2 text-lg">{{ likesCount }}</span>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    components: { Link },
    props: {
        post: Object
    },

    layout: AdminLayout,

    setup(props) {
        const liked = ref(props.post.liked);
        const likesCount = ref(props.post.likes_count);

        const toggleLike = async () => {
            console.log("Отправляем запрос на лайк:", props.post.id);

            const csrfMetaTag = document.querySelector('meta[name="csrf-token"]');
            if (!csrfMetaTag) {
                console.error("CSRF-токен не найден!");
                return;
            }

            try {
                const response = await fetch(route('admin.posts.toggleLike', props.post.id), {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfMetaTag.getAttribute('content'),
                    }
                });

                if (!response.ok) {
                    throw new Error(`Ошибка запроса: ${response.status}`);
                }

                const data = await response.json();
                console.log("Ответ от сервера:", data);
                liked.value = data.liked;
                likesCount.value = data.likes_count;
            } catch (error) {
                console.error("Ошибка при лайке:", error);
            }
        };

        return { liked, likesCount, toggleLike };
    }
};
</script>
