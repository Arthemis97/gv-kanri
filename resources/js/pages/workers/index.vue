<script setup lang="ts">
import dayjs from "dayjs"
import { Modal } from 'ant-design-vue';
import { PlusOutlined, DeleteOutlined, EditOutlined, SearchOutlined } from '@ant-design/icons-vue'
import useEmployeeStore from "../../stores/employee";
const router = useRouter();
const employeeStore = useEmployeeStore();
const { getWorker } = storeToRefs(employeeStore)
const state = reactive({
    searchText: '',
    searchedColumn: '',
});

const searchInput = ref();

const columns = [
    {
        title: '#',
        key: 'custom_id',
        width: 50
    },
    {
        title: '写真',
        key: 'picture',
        width: 40
    },
    {
        title: '氏名',
        key: 'name',
        customFilterDropdown: true,
        onFilterDropdownOpenChange: visible => {
            if (visible) {
                setTimeout(() => {
                    searchInput.value.focus();
                }, 100);
            }
        },
    },
    {
        title: 'フリガナ',
        key: 'furigana',
        customFilterDropdown: true,
        onFilterDropdownOpenChange: visible => {
            if (visible) {
                setTimeout(() => {
                    searchInput.value.focus();
                }, 100);
            }
        },
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
        title: '国籍',
        key: 'nationality',
    },
    {
        title: '在留資格',
        key: 'visatype',
    },
    {
        title: '就労制限',
        key: 'workres',
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
        title: '就職 / 進学',
        key: 'advancement',
    },
    {
        title: '日本語レベル',
        key: 'jpnlvl',
    },
    {
        title: '急遽連絡先',
        key: 'urgent',
    },
    {
        title: '',
        key: 'action',
        width: 75
    },
];

const pgn = ref({})

const edit = (id) => {
    router.push(`/workers/${id}`)
}

const showModal = (data) => {
    useEvent.emit('modal:profile:open', data)
}

const handleSearch = (selectedKeys, confirm, dataIndex) => {
    confirm();
    state.searchText = selectedKeys[0];
    state.searchedColumn = dataIndex;
};

const handleReset = (clearFilters, key) => {
    clearFilters({ confirm: true });
    state.searchText = '';
};

const fetchWorkerList = async (filters, pagination) => {
    const pag = await employeeStore.fetchWorkerList(filters, pagination);
    pgn.value = { ...pag, ...{ pageSize: 20 } }
}

const handleTableChange = (pagination, filters, sorter, { currentDataSource }) => {
    fetchWorkerList(filters, pagination)
}


const deleteuser = (id) => {
    Modal.confirm({
        title: '消してもよろしいですか',
        async onOk() {
            await employeeStore.deleteWorker(id)
        },
        onCancel() { },
    });
}

const dateCalc = (date) => {
    const currentDateTime = dayjs();
    const pos = dayjs(date);
    const futureDateTime = currentDateTime.add(3, 'month');
    if (futureDateTime.isBefore(pos)) {
        return 'tw-text-green-500 tw-border tw-border-green-500 tw-border-solid'
    } else if (currentDateTime.isBefore(pos) && futureDateTime.isAfter(pos)) {
        return 'tw-text-yellow-500 tw-border tw-border-yellow-500 tw-border-solid'
    } else if (currentDateTime.isAfter(pos) || currentDateTime.isSame(pos)) {
        return 'tw-text-red-500 tw-border tw-border-red-500 tw-border-solid'
    }
}

onMounted(async () => {
    fetchWorkerList(null, null)
})
</script>
<template>
    <div>
        <a-page-header class="demo-page-header" title="GVデータ" @back="() => $router.go(-1)">
            <template #extra>
                <a-button size="small" key="3">
                    <PlusOutlined #icon @click="() => $router.push('/workers/add')" />
                </a-button>
            </template>
        </a-page-header>
        <a-table :dataSource="getWorker" :columns="columns" size="small" bordered :pagination="pgn"
            @change="handleTableChange">
            <template #customFilterDropdown="{ setSelectedKeys, selectedKeys, confirm, clearFilters, column }">
                <div style="padding: 8px">
                    <a-input ref="searchInput" :placeholder="`${column.title}`" :value="selectedKeys[0]"
                        style="width: 188px; margin-bottom: 8px; display: block"
                        @change="e => setSelectedKeys(e.target.value ? e.target.value : '')"
                        @pressEnter="handleSearch(selectedKeys, confirm, column.key)" />
                    <a-button type="primary" size="small" style="width: 90px; margin-right: 8px"
                        @click="handleSearch(selectedKeys, confirm, column.key)">
                        <template #icon>
                            <SearchOutlined />
                        </template>
                        Search
                    </a-button>
                    <a-button size="small" style="width: 90px" @click="handleReset(clearFilters, column.key)">
                        Reset
                    </a-button>
                </div>
            </template>
            <template #customFilterIcon="{ filtered }">
                <search-outlined :style="{ color: filtered ? '#108ee9' : undefined }" />
            </template>
            <template #bodyCell="{ column, record }">
                <template v-if="column.key === 'custom_id'">
                    {{ record.custom_id }}
                </template>
                <template v-if="column.key === 'picture'">
                    <a-avatar @click="showModal(record)" v-if="record.picture" :size="32" :src="record.picture">
                    </a-avatar>
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
                    {{ record.pos_value }}
                </template>
                <template v-else-if="column.key === 'pos_date'">
                    <a-button type="text" :class="dateCalc(record.pos_date)" size="small">{{ record.pos_date }}</a-button>
                </template>
                <template v-else-if="column.key === 'driver_license'">
                    {{ record.driver_license_value }}
                </template>
                <template v-else-if="column.key === 'nationality'">
                    {{ record.national ? record.national.name_jp : '' }}
                </template>
                <template v-else-if="column.key === 'visatype'">
                    {{ record.visa_type_value }}
                </template>
                <template v-else-if="column.key === 'workres'">
                    {{ record.work_restrictions ? 'Yes' : 'No' }}
                </template>
                <template v-else-if="column.key === 'advancement'">
                    {{ record.advancement_value }}
                </template>
                <template v-else-if="column.key === 'jpnlvl'">
                    {{ record.japanese_level_value }}
                </template>
                <template v-else-if="column.key === 'urgent'">
                    {{ record.urgent_contact }}
                </template>
                <template v-else-if="column.key === 'action'">
                    <a-button @click="edit(record.id)" size="small" class="tw-mr-1">
                        <EditOutlined #icon />
                    </a-button>
                    <a-button size="small" danger @click="deleteuser(record.id)">
                        <DeleteOutlined #icon />
                    </a-button>
                </template>
            </template>
        </a-table>
    </div>
</template>

