<template>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Order Management</h1>

    <!-- Create Order -->
    <div class="mb-6 border p-4 rounded-lg shadow">
      <h2 class="mb-3 text-lg font-semibold">Create New Order</h2>
      <form @submit.prevent="createOrder" class="space-y-3">
        <input v-model="newOrder.customer_name" type="text" placeholder="Customer Name"
          class="border p-2 w-full rounded" required />

        <input v-model="newOrder.item_name" type="text" placeholder="Item Name"
          class="border p-2 w-full rounded" required />

        <input v-model.number="newOrder.price" type="number" placeholder="Price"
          class="border p-2 w-full rounded" required />

        <select v-model="newOrder.status" class="border p-2 w-full rounded">
          <option value="pending">Pending</option>
          <option value="paid">Paid</option>
          <option value="cancelled">Cancelled</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded" :disabled="loadingCreate">
          <span v-if="loadingCreate">Creating...</span>
          <span v-else>Create</span>
        </button>
      </form>
    </div>

    <!-- Orders List -->
    <div class="border p-4 rounded-lg shadow">
      <h2 class="mb-3 text-lg font-semibold">All Orders</h2>

      <div v-if="loadingFetch" class="text-gray-500 p-3">Loading orders...</div>

      <table v-else class="w-full border-collapse border">
        <thead>
          <tr class="bg-gray-100">
            <th class="border p-2">Customer</th>
            <th class="border p-2">Item</th>
            <th class="border p-2">Price</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id" class="text-center">
            <td class="border p-2">{{ order.customer_name }}</td>
            <td class="border p-2">{{ order.item_name }}</td>
            <td class="border p-2">${{ order.price }}</td>
            <td class="border p-2">
              <span :class="statusClass(order.status)">{{ order.status }}</span>
            </td>
            <td class="border p-2">
              <select v-model="order.status" @change="updateOrder(order)"
                class="border p-1 rounded" :disabled="loadingUpdateId === order.id">
                <option value="">Select Status</option>
                <option value="paid">Paid</option>
                <option value="cancelled">Cancelled</option>
              </select>
              <span v-if="loadingUpdateId === order.id" class="ml-2 text-sm text-gray-500">Updating...</span>
            </td>
          </tr>
          <tr v-if="orders.length === 0">
            <td colspan="5" class="p-3 text-gray-500">No orders yet.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useToast } from "@/composables/useToast"
const { success, error } = useToast()
const config = useRuntimeConfig()
const baseURL = config.public.apiBase as string || "http://127.0.0.1:8000/api";
const orders = ref<any[]>([])
const newOrder = ref({
  customer_name: "",
  item_name: "",
  price: 0,
  status: "pending",
})

const loadingFetch = ref(false)
const loadingCreate = ref(false)
const loadingUpdateId = ref<number | null>(null)

const fetchOrders = async () => {
  try {
    loadingFetch.value = true
    orders.value = await $fetch("/orders", { baseURL: baseURL })
  } catch (err: any) {
    error("Failed to fetch orders")
  } finally {
    loadingFetch.value = false
  }
}

const createOrder = async () => {
  try {
    loadingCreate.value = true
    await $fetch("/orders", {
      method: "POST",
      body: newOrder.value,
      baseURL: baseURL,
    })
    newOrder.value = { customer_name: "", item_name: "", price: 0, status: "pending" }
    await fetchOrders()
    success("Order created successfully")
  } catch (err: any) {
    if (err?.response?.status === 422) {
      error(err.response._data?.message || "Please fix the input errors")
    } else {
      error("Failed to create order")
    }
  } finally {
    loadingCreate.value = false
  }
}

const updateOrder = async (order: any) => {
  try {
    loadingUpdateId.value = order.id
    await $fetch(`/orders/${order.id}`, {
      method: "PATCH",
      body: { status: order.status },
      baseURL: baseURL,
    })
    await fetchOrders()
    success("Order updated")
  } catch (err: any) {
   if (err?.response?.status === 422) {
      error(err.response._data?.message || "Please fix the input errors")
    } else {
      error("Failed to update order")
    }
  } finally {
    loadingUpdateId.value = null
  }
}

const statusClass = (status: string) => {
  return status === "paid"
    ? "text-green-600 font-bold"
    : status === "cancelled"
    ? "text-red-600 font-bold"
    : "text-gray-600"
}

onMounted(fetchOrders)
</script>
