<script setup lang="ts">
import { PhotoIcon } from '@heroicons/vue/24/outline';

const emit = defineEmits(['update:modelValue']);

const handleChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    emit('update:modelValue', target.files);
}

</script>
<template>
    <input type="file" hidden id="postImage" @change="handleChange" multiple accept="image/*">
    <label for="postImage" class="flex p-2">
        <PhotoIcon class="h-6 w-6 hover:text-indigo-500" />
    </label>
</template>