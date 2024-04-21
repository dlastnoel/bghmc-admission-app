<template>
  <tr>
    <td
      :colspan="colspan"
      class="text-gray-600 px-4 py-3 text-sm font-medium text-center"
    >
      No Data Available
    </td>
  </tr>
</template>

<script setup>
defineProps({
  colspan: {
    type: Number,
    default: 1
  }
})
</script>