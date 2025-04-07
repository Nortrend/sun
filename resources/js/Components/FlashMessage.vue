<template>
    <transition name="fade">
        <div
            v-if="visible"
            class="p-3 mb-4 rounded bg-green-100 text-green-800 border border-green-300"
        >
            {{ message }}
        </div>
    </transition>
</template>

<script>
export default {
    data() {
        return {
            message: null,
            visible: false,
        }
    },
    watch: {
        '$page.props.flash.success': {
            immediate: true,
            handler(val) {
                if (val) {
                    this.message = val
                    this.visible = true

                    setTimeout(() => {
                        this.visible = false
                        this.message = null
                    }, 3000)
                }
            }
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.4s;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
