<script setup>
defineProps({
  modelValue: {
    type: String,
    default: '',
  },
  rows: {
    type: Number,
    default: 3,
  },
})

defineEmits(['update:modelValue'])
</script>

<template>
  <textarea
    :rows="rows"
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>
