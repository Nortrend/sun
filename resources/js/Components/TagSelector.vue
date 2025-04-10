<template>
    <div>
        <div class="flex flex-wrap gap-2 mb-2">
      <span
          v-for="(tag, index) in model"
          :key="index"
          class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded-full flex items-center gap-1"
      >
        {{ tag.title }}
        <button @click="remove(index)" class="text-blue-800 hover:text-red-500">×</button>
      </span>
        </div>
        <input
            v-model="search"
            @input="fetchTags"
            @keydown.enter.prevent="addFromInput"
            type="text"
            placeholder="Введите тег..."
            class="w-full px-4 py-2 rounded-md bg-gray-800 border border-gray-600 text-white placeholder-gray-400"
        />
        <ul v-if="suggestions.length" class="bg-white border border-gray-200 mt-2 rounded-md shadow">
            <li
                v-for="tag in suggestions"
                :key="tag.id"
                class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                @click="add(tag)"
            >
                {{ tag.title }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'

const props = defineProps({ modelValue: Array })
const emit = defineEmits(['update:modelValue'])

const model = ref([...props.modelValue])
const search = ref('')
const suggestions = ref([])

watch(model, () => emit('update:modelValue', model.value))

const fetchTags = async () => {
    const res = await axios.get(route('admin.tags.list'), {
        params: { search: search.value }
    })
    suggestions.value = res.data.filter(
        tag => !model.value.some(t => t.title === tag.title)
    )
}

const add = (tag) => {
    model.value.push(tag)
    search.value = ''
    suggestions.value = []
}

const addFromInput = () => {
    const exists = model.value.some(t => t.title === search.value.trim())
    if (!exists && search.value.trim()) {
        model.value.push({ id: null, title: search.value.trim() })
    }
    search.value = ''
    suggestions.value = []
}

const remove = (index) => {
    model.value.splice(index, 1)
}
</script>
