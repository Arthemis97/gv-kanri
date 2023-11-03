const useEmployeeStore = defineStore('employee', {
    state: () => ({
        list: [],
        worker: [],
        pagination: {},
        errors: null
    }),
    getters: {
        getList: (state) => state.list,
        getPagination: (state) => state.pagination,
        getErrors: (state) => state.errors,
        getWorker: (state) => state.worker
    },
    actions: {
        async fetchList(fltr, pgn) {
            let url = '/employee?per_page=20'
            if (fltr) {
                url += `&${objectToQueryString(fltr)}`
            }
            if (pgn) {
                url += `&page=${pgn.current}`
            }
            const resp = await useRequest.get(url);
            if (resp.data.data) {
                this.list = resp.data.data;
                return {
                    current_page: resp.data.current_page,
                    total: resp.data.total,
                    per_page: resp.data.per_page,
                }
            }
        },
        async fetchWorkerList(fltr, pgn) {
            let url = '/worker?per_page=1'
            if (fltr) {
                url += `&${objectToQueryString(fltr)}`
            }
            if (pgn) {
                url += `&page=${pgn.current}`
            }
            const resp = await useRequest.get(url);
            if (resp.data.data) {
                this.worker = resp.data.data;
                return {
                    current_page: resp.data.current_page,
                    total: resp.data.total,
                    per_page: resp.data.per_page,
                }
            }
        },
        async fetchOne(id) {
            const resp = await useRequest.get(`/employee/${id}`);
            return resp.data
        },
        async deleteUser(id) {
            const resp = await useRequest.del(`/employee/${id}`);
            this.list = this.list.filter(i => i.id !== id)
            return resp.data
        },
        async deleteWorker(id) {
            const resp = await useRequest.del(`/employee/${id}`);
            this.worker = this.worker.filter(i => i.id !== id)
            return resp.data
        },
        async store(data) {
            const resp = await useRequest.post('/employee', data);
            if (resp.resp.status == 422) {
                this.errors = resp.data
            }
        },
        async storeWorker(data) {
            const resp = await useRequest.post('/worker', data);
            if (resp.resp.status == 422) {
                this.errors = resp.data
            }
        },
        async update(id, data) {
            const resp = await useRequest.put(`/employee/${id}`, data);
            if (resp.resp.status == 422) {
                this.errors = resp.data
            }
        }
    },
});
export default useEmployeeStore
