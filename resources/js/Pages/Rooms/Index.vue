<script setup>
import ChatLayout from '@/Layouts/ChatLayout.vue'
import { useForm } from '@inertiajs/vue3'



defineProps({
  rooms: Array,
})

const form = useForm({
  name: '',
})

function createRoom() {
  form.post(route('rooms.store'), {
    onSuccess: () => form.reset(),
  })
}
</script>

<template>
  <ChatLayout :currentRoomId="null">
    <div class="p-6 max-w-2xl">
      <h1 class="text-xl font-semibold mb-6">Salas</h1>

      <!-- Criar sala -->
      <form @submit.prevent="createRoom" class="mb-6 flex gap-2">
        <input
          v-model="form.name"
          type="text"
          placeholder="Nome da sala"
          class="border rounded px-3 py-2 w-full"
        />
        <button
          type="submit"
          class="bg-black text-white px-4 py-2 rounded"
          :disabled="form.processing"
        >
          Criar
        </button>
      </form>

      <!-- Lista de salas -->
      <ul class="space-y-2">
        <li
          v-for="room in rooms"
          :key="room.id"
          class="p-3 bg-white rounded hover:bg-gray-50"
        >
          <a
            :href="route('rooms.show', room.id)"
            class="font-medium text-gray-800"
          >
            # {{ room.name }}
          </a>
        </li>
      </ul>
    </div>
  </ChatLayout>
</template>

