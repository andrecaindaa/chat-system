<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

defineProps({
  user: Object,
  rooms: Array,
})
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Bem-vindo, {{ user.name }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto space-y-6">

        <!-- Hero -->
        <div class="bg-white shadow rounded-lg p-6 text-center">
          <h3 class="text-2xl font-semibold mb-2">
            💬 Chat Interno
          </h3>

          <p class="text-gray-600 mb-6">
            Entra numa sala ou cria uma nova conversa.
          </p>

          <Link
            :href="route('rooms.index')"
            class="inline-block bg-black text-white px-6 py-3 rounded text-lg"
          >
            Entrar nas salas
          </Link>
        </div>

        <!-- Salas recentes -->
        <div
          v-if="rooms.length"
          class="bg-white shadow rounded-lg p-6"
        >
          <h4 class="font-semibold mb-4">
            Salas recentes
          </h4>

          <ul class="space-y-2">
            <li
              v-for="room in rooms"
              :key="room.id"
            >
              <Link
                :href="route('rooms.show', room.id)"
                class="text-blue-600 hover:underline"
              >
                {{ room.name }}
              </Link>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </AppLayout>
</template>
