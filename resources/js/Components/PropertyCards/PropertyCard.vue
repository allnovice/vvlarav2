<script setup>
defineProps({
    card: Object,
})

defineEmits([
    'edit',
])

function formatDate(date) {
    if (!date) return ''

    return new Date(date).toLocaleDateString('en-US', {
        month: '2-digit',
        day: '2-digit',
        year: '2-digit',
    })
}
</script>

<template>

<div class="relative w-[92mm] h-[32mm] border border-black bg-white p-1 font-serif text-black text-[9px] leading-tight box-border flex flex-col">
<img
    src="/images/logo.png"
    class="absolute top-1 left-1 w-10 z-50 opacity-90 pointer-events-none"
    alt=""
/>
    <!-- Header Section -->
    <div class="flex justify-between items-start">
        <div class="flex-1 text-center">
            <div class="text-[8px] italic">Office of the President</div>
            <div class="font-bold text-[11px] uppercase tracking-wide">NATIONAL YOUTH COMMISSION</div>
            <div class="text-[9px] italic">Property, Plant & Equipment</div>
        </div>

<div
    class="absolute top-1 right-1 z-10 w-14 h-14 border border-black bg-white p-[1px] flex items-center justify-center"
    v-html="card.qr"
></div>


    </div>

    <!-- Main Table Layout -->
    <table class="w-full border-collapse border border-black text-center mt-1">
        <tbody>
            <!-- Property No Row -->

<tr class="border-b border-black">
    <td colspan="5" class="px-1 py-[2px] text-left">
        <span class="font-normal">Property No.:</span>
        <span class="font-bold text-[10px] ml-1">{{ card.property_number }}</span>
    </td>
</tr>

<tr class="border-b border-black">
    <td colspan="5" class="px-1 py-[2px] text-left">
        <span class="font-normal">Item Description:</span>
        <span class="ml-1">{{ card.description }}</span>
    </td>
</tr>

            <!-- Table Headers -->
            <tr class="border-b border-black text-[8px] bg-gray-50">
                <th class="border-r border-black font-normal w-[10%] py-[1px]">Date</th>
                <th class="border-r border-black font-normal w-[30%] py-[1px]">COA Rep</th>
                <th class="border-r border-black font-normal w-[30%] py-[1px]">Inventory Ofcr.</th>
                <th class="border-r border-black font-normal w-[10%] py-[1px]">Location</th>
                <th class="font-normal w-[20%] py-[1px]">Phy. Condition</th>
            </tr>

            <!-- Data Row 1 (Active) -->
            <tr class="border-b border-black h-7">
                <td class="border-r border-black align-middle">{{ formatDate(card.print?.date) }}</td>
                <td class="border-r border-black align-middle">{{ card.print?.coaRepresentative }}</td>
                <td class="border-r border-black align-middle leading-tight">
                    {{ card.print?.inventoryOfficer }}
                </td>
                <td class="border-r border-black align-middle leading-tight">{{ card.print?.location }}</td>
                <td class="align-middle leading-tight">{{ card.print?.physicalCondition }}</td>
            </tr>

            <!-- Blank Rows to match official template grid -->
  
        </tbody>
    </table>

    <!-- Action Button -->
   
    <button
        @click="$emit('edit', card)"
        class="absolute -top-3 -right-3 rounded bg-blue-600 px-2 py-1 text-xs text-white shadow print:hidden"
    >
        Edit
    </button>

</div>
</template>
