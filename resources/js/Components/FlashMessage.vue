<template>
    <transition name="fade">
        <div
            v-if="visible"
            class="mb-4 px-4 py-2 rounded bg-green-600 text-white shadow max-w-xl"
        >
            {{ message }}
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        },
        duration: {
            type: Number,
            default: 3000
        }
    },
    data() {
        return {
            visible: true
        };
    },
    mounted() {
        setTimeout(() => {
            this.visible = false;
        }, this.duration);
    }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
