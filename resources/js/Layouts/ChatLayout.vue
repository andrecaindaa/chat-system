<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()

defineProps({
  currentRoomId: Number,
})
</script>

<template>
  <div class="h-screen flex bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r flex flex-col">
      <div class="p-4 font-bold text-lg border-b">
        Chat
      </div>

      <div class="flex-1 overflow-y-auto p-3 space-y-6">
        <!-- Salas -->
        <div>
          <h2 class="text-xs uppercase text-gray-500 mb-2">
            Salas
          </h2>

          <ul class="space-y-1">
            <li
              v-for="room in page.props.rooms.filter(r => r.type === 'group')"
              :key="room.id"
            >
              <a
                :href="route('rooms.show', room.id)"
                class="block px-3 py-2 rounded text-sm"
                :class="room.id === currentRoomId
                  ? 'bg-black text-white'
                  : 'hover:bg-gray-100'"
              >
                <div class="flex items-center gap-2">
                <span># {{ room.display_name }}</span>

                <span
                    v-if="room.unread_count > 0"
                    class="ml-auto text-xs bg-red-500 text-white px-2 rounded-full"
                >
                    {{ room.unread_count }}
                </span>
                </div>

              </a>
            </li>
          </ul>
        </div>

        <!-- DMs -->
        <div>
          <h2 class="text-xs uppercase text-gray-500 mb-2">
            Mensagens diretas
          </h2>

          <ul class="space-y-1">
            <li
              v-for="room in page.props.rooms.filter(r => r.type === 'direct')"
              :key="room.id"
            >
              <a
                :href="route('rooms.show', room.id)"
                class="block px-3 py-2 rounded text-sm"
                :class="room.id === currentRoomId
                  ? 'bg-black text-white'
                  : 'hover:bg-gray-100'"
              >
                <div class="flex items-center gap-2">
                <span>{{ room.display_name }}</span>

                <span
                    v-if="room.unread_count > 0"
                    class="ml-auto text-xs bg-red-500 text-white px-2 rounded-full"
                >
                    {{ room.unread_count }}
                </span>
                </div>

              </a>
            </li>
          </ul>
        </div>
      </div>
    </aside>

    <!-- Conteúdo -->
    <main class="flex-1 overflow-hidden">
      <slot />
    </main>
  </div>
</template>
