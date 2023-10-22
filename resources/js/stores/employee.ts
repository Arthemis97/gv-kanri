const useEmployeeStore = defineStore('employee', {
    state: () => ({
        list: [],
        pagination: {},
        errors: null
    }),
    getters: {
        getList: (state) => state.list,
        getPagination: (state) => state.pagination,
        getErrors: (state) => state.errors,
    },
    actions: {
        async fetchList() {
            const resp = await useRequest.get('/employee');
            if (resp.data.data) {
                this.list = resp.data.data;
            }
        },
        async store(data) {
            const resp = await useRequest.post('/employee', data);
            if (resp.resp.status == 422) {
                this.errors = resp.data
            }
        }
    },
});
export default useEmployeeStore
