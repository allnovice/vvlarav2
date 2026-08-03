<script setup>
defineProps({
    assets: Array,
})

const printLabel = () => {
    window.print()
}
</script>

<template>

<div class="p-6 print:p-0">

    <button
        @click="printLabel"
        class="mb-6 rounded bg-indigo-600 px-4 py-2 text-white print:hidden"
    >
        Print
    </button>

    <div class="label-sheet">

        <div
            v-for="asset in assets"
            :key="asset.id"
            class="label"
        >

            <div
                class="qr"
                v-html="asset.qr"
            ></div>

            <div class="property">
                {{ asset.property_number }}
            </div>

        </div>

    </div>

</div>

</template>

<style scoped>

.label-sheet{

    display:grid;

    grid-template-columns:repeat(auto-fill,1in);

    gap:3mm;

    justify-content:center;

}

.label{

    width:.7in;
    height:.7in;

    border:1px dashed #ccc;

    display:flex;
    flex-direction:column;

    justify-content:space-between;
    align-items:center;

    padding:2mm;

    box-sizing:border-box;

    break-inside:avoid;
    page-break-inside:avoid;

}

.qr{

    flex:1;

    width:100%;

    display:flex;
    justify-content:center;
    align-items:center;

}

.qr :deep(svg){

    width:82%;
    height:auto;

}

.property{

    width:100%;

    text-align:center;

    font-size:4px;
    font-weight:600;

    line-height:1.1;

}

@media print{

    @page{

        margin:10mm;

    }

    body{

        margin:0;

    }

}

</style>
