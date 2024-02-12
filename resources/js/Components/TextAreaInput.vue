<script setup>
import { stringify } from 'postcss';
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: true,
    },
    rows: {
        type: Number,
        default: 1,
    },
    additionalClass: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <textarea
        :class="['border border-inherit focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm', additionalClass]"
        :value="modelValue" :placeholder="placeholder" @input="$emit('update:modelValue', $event.target.value)" ref="input"
        :rows="rows" />
</template>
