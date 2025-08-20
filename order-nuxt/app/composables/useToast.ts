// composables/useToast.ts
import { ref } from "vue"

interface ToastMessage {
  id: number
  type: "success" | "error"
  text: string
}

const toasts = ref<ToastMessage[]>([])

export function useToast() {
  const add = (type: "success" | "error", text: string) => {
    const id = Date.now()
    toasts.value.push({ id, type, text })
    setTimeout(() => {
      toasts.value = toasts.value.filter(t => t.id !== id)
    }, 3000)
  }

  return {
    toasts,
    success: (text: string) => add("success", text),
    error: (text: string) => add("error", text),
  }
}
