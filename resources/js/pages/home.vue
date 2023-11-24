<script lang="ts" setup>
import { ArrowUpOutlined } from '@ant-design/icons-vue';
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
    <a-row class="tw-mb-4" :gutter="16">
        <a-col :span="4">
            <a-card>
                <a-statistic title="全ワーカー" :value="data.workers" :value-style="{ color: '#3f8600' }"
                    style="margin-right: 50px">
                    <template #prefix>
                        <arrow-up-outlined />
                    </template>
                </a-statistic>
            </a-card>
        </a-col>
        <a-col :span="4">
            <a-card>
                <a-statistic title="全社員" :value="data.employee" :value-style="{ color: '#3f8600' }">
                    <template #prefix>
                        <arrow-up-outlined />
                    </template>
                </a-statistic>
            </a-card>
        </a-col>
    </a-row>
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
