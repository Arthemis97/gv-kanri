<script setup lang="ts">
import { PlusOutlined, DeleteOutlined } from '@ant-design/icons-vue'
import useEmployeeStore from "../../stores/employee";

const employeeStore = useEmployeeStore();
const { getList } = storeToRefs(employeeStore)
const columns = [
    {
        title: '#',
        key: 'id',
        width: 50
    },
    {
        title: '氏名',
        key: 'name',
    },
    {
        title: 'フリガナ',
        key: 'furigana',
    },
    {
        title: '誕生日',
        key: 'dob',
    },
    {
        title: '性別',
        key: 'gender',
    },
    {
        title: '住所',
        key: 'address',
    },
    {
        title: '在留期間',
        key: 'pos',
    },
    {
        title: '終了日',
        key: 'pos_date',
    },
    {
        title: '運転免許',
        key: 'driver_license',
    },
    {
        title: '職場名',
        key: 'working_place',
    },
    {
        title: '働く期間（プラン）',
        key: 'working_plan',
    },
    {
        title: '自己PR',
        key: 'introduce',
    },
    {
        title: '',
        key: 'action',
        width: 50
    },
];

onMounted(async () => {
    await employeeStore.fetchList();
})
</script>
<template>
    <div>
        <a-page-header class="demo-page-header" title="Workers" @back="() => $router.go(-1)">
            <template #extra>
                <a-button size="small" key="3">
                    <PlusOutlined #icon @click="() => $router.push('/workers/add')" />
                </a-button>
            </template>
        </a-page-header>
        <a-table :dataSource="getList" :columns="columns" size="small" bordered>
            <template #bodyCell="{ column, record }">
                <template v-if="column.key === 'id'">
                    {{ record.id }}
                </template>
                <template v-else-if="column.key === 'name'">
                    {{ record.name }}
                </template>
                <template v-else-if="column.key === 'furigana'">
                    {{ record.furigana }}
                </template>
                <template v-else-if="column.key === 'dob'">
                    {{ record.dob }}
                </template>
                <template v-else-if="column.key === 'gender'">
                    {{ record.gender ? '男' : '女' }}
                </template>
                <template v-else-if="column.key === 'address'">
                    <a-typography-text :style="{ width: '100px' }"
                        :ellipsis="{ tooltip: record.address ? record.address : '' }" :content="record.address" />
                </template>
                <template v-else-if="column.key === 'pos'">
                    {{ record.pos }}
                </template>
                <template v-else-if="column.key === 'pos_date'">
                    {{ record.pos_date }}
                </template>
                <template v-else-if="column.key === 'driver_license'">
                    {{ record.driver_license_value }}
                </template>
                <template v-else-if="column.key === 'working_place'">
                    {{ record.working_place_value }}
                </template>
                <template v-else-if="column.key === 'working_plan'">
                    {{ record.working_plan_value }}
                </template>
                <template v-else-if="column.key === 'introduce'">
                    {{ record.introduce }}
                </template>
                <template v-else-if="column.key === 'action'">
                    <a-button danger>
                        <DeleteOutlined #icon />
                    </a-button>
                </template>
            </template>
        </a-table>
    </div>
</template>

