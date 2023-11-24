<script setup lang="ts">
import dayjs from "dayjs"
import { Modal } from 'ant-design-vue';
import { PlusOutlined, DeleteOutlined, EditOutlined, SearchOutlined } from '@ant-design/icons-vue'
import useEmployeeStore from "../../stores/employee";
import useNationStore from "../../stores/nation";
const router = useRouter();
const employeeStore = useEmployeeStore();
const nationStore = useNationStore();
const { getWorker } = storeToRefs(employeeStore)
const { getPrefecture, getWorkplace } = storeToRefs(nationStore)
const state = reactive({
    searchText: '',
    searchedColumn: '',
});

const searchInput = ref();
const loading = ref(false)

const columns = [
    {
        title: '#',
        key: 'custom_id',
        fixed: 'left',
        width: 50
    },
    {
        title: '写真',
        key: 'picture',
        fixed: 'left',
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
        fixed: 'left',
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
        fixed: 'left',
    },
    {
        title: '終了日',
        key: 'pos_date',
        fixed: 'left',
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
        title: '電話番号',
        key: 'phone_number',
    },
    {
        title: '都道府県',
        key: 'prefecture',
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
        title: '在留カード番号',
        key: 'res_card_number',
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
        title: '運転免許',
        key: 'driver_license',
        width: 200
    },
    {
        title: '登録日',
        key: 'registred_day',
    },
    {
        title: '業務開始日',
        key: 'start_date',
    },
    {
        title: '現場名',
        key: 'work_place',
        width: 300
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
        title: '緊急連絡先',
        key: 'urgent',
    },
    {
        title: '緊急連絡先名',
        key: 'emergency_contact_name',
    },
    {
        title: '',
        key: 'action',
        width: 75,
    },
];

const pgn = ref({})
const search_value = ref("")

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
    loading.value = true
    const pag = await employeeStore.fetchWorkerList(filters, pagination);
    pgn.value = { ...pag, ...{ pageSize: 20 } }
    loading.value = false
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

const onSearch = async () => {
    fetchWorkerList({ search: search_value.value }, null)
}

onMounted(async () => {
    fetchWorkerList(null, null)
})
</script>
<template>
    <div>
        <a-page-header class="demo-page-header" title="GVデータ" @back="() => $router.go(-1)">
            <template #extra>
                <a-input-search size="small" v-model:value="search_value" placeholder="Search..." style="width: 200px"
                    @search="onSearch" />
                <a-button size="small" key="3" @click="() => $router.push('/workers/add')">
                    <PlusOutlined #icon />
                </a-button>
            </template>
        </a-page-header>
        <a-table :loading="loading" :dataSource="getWorker" :columns="columns" size="small" bordered :pagination="pgn"
            :scroll="{ x: 3000, y: 1000 }" @change="handleTableChange">
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


                <template v-else-if="column.key === 'prefecture'">
                    {{ record.prefecture_id ? getPrefecture.find(i => i.id == record.prefecture_id).name : '' }}
                </template>
                <template v-else-if="column.key === 'work_place'">
                    {{ record.work_place_id ? getWorkplace.find(i => i.id == record.work_place_id).name : '' }}
                </template>
                <template v-else-if="column.key === 'res_card_number'">
                    {{ record.resisdence_card_number }}
                </template>
                <template v-else-if="column.key === 'registred_day'">
                    {{ record.registred_day }}
                </template>
                <template v-else-if="column.key === 'start_date'">
                    {{ record.start_date }}
                </template>
                <template v-else-if="column.key === 'emergency_contact_name'">
                    {{ record.emergency_contact_name }}
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
                <template v-else-if="column.key === 'phone_number'">
                    {{ record.phone_number }}
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

