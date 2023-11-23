<script lang="ts" setup>
import gender from "../components/gender.vue"
import nation from "../components/nation.vue"
import visa from "../components/visa.vue"
import jpn from "../components/jpn.vue"
import prefecture from "../components/prefecture.vue"
const data = ref({})
onMounted(async () => {
    const resp = await useRequest.get('/stats')
    data.value = resp.data;
})
</script>
<template>
    <div v-if="Object.keys(data).length > 0" class="tw-grid tw-grid-cols-5 tw-gap-4">
        <a-card size="small">
            <gender :data="data.gender" />
        </a-card>
        <a-card size="small">
            <prefecture :data="data.prefecture" />
        </a-card>
        <a-card size="small">
            <nation :data="data.nation" />
        </a-card>
        <a-card size="small">
            <visa :data="data.visa" />
        </a-card>
        <a-card size="small">
            <jpn :data="data.jpn" />
        </a-card>
    </div>
</template>
