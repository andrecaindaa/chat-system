<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  room: Object,
})

const form = useForm({
  body: '',
})

function sendMessage() {
  form.post(route('rooms.messages.store', props.room.id), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <div class="h-screen flex flex-col max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="border-b pb-4 mb-4">
      <h1 class="text-xl font-semibold">
        {{ room.name }}
      </h1>
      <p class="text-sm text-gray-500">
        {{ room.users.length }} participantes
      </p>
    </div>

    <!-- Mensagens -->
    <div class="flex-1 space-y-4 overflow-y-auto mb-4">
      <div
        v-for="message in room.messages"
        :key="message.id"
        class="flex gap-3"
      >
        <img
          :src="message.sender.profile_photo_url"
          class="w-8 h-8 rounded-full"
        />

        <div>
          <div class="text-sm font-semibold">
            {{ message.sender.name }}
          </div>
          <div class="text-sm text-gray-800">
            {{ message.body }}
          </div>
        </div>
      </div>
    </div>

    <!-- Input -->
    <form @submit.prevent="sendMessage" class="flex gap-2">
      <input
        v-model="form.body"
        type="text"
        placeholder="Escreve uma mensagem…"
        class="flex-1 border rounded px-3 py-2"
      />
      <button
        type="submit"
        :disabled="form.processing || !form.body"
        class="bg-black text-white px-4 py-2 rounded disabled:opacity-50"
      >
        Enviar
      </button>
    </form>
  </div>
</template>
